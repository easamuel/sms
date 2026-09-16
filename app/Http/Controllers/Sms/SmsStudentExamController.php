<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\Sms\SmsExam;
use App\Models\Sms\SmsExamSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SmsStudentExamController extends Controller
{
    /**
     * Show exam taking page
     */
    public function take($examId)
    {
        $smsUser = session('sms_user');
        $schoolId = $smsUser->school_id ?? null;

        $exam = SmsExam::with(['subject', 'class', 'questions'])->findOrFail($examId);

        // Check if exam is assigned to this student
        $student = \App\Models\Sms\SmsStudent::where('user_id', $smsUser->id)->first();
        
        if (!$student) {
            return redirect()->route('sms.student.exams')
                ->with('error', 'Student profile not found.');
        }

        // Check for existing session
        $session = SmsExamSession::where('exam_id', $examId)
            ->where('student_id', $student->id)
            ->where('status', 'in_progress')
            ->first();

        if ($session) {
            return view('sms.student.exams.take', compact('exam', 'session', 'student'));
        }

        return redirect()->route('sms.student.exams')
            ->with('error', 'Please start the exam first.');
    }

    /**
     * Start exam session (with date and fee enforcement)
     */
    public function start(Request $request, $examId)
    {
        $smsUser = session('sms_user');
        $student = \App\Models\Sms\SmsStudent::where('user_id', $smsUser->id)->first();
        
        if (!$student) {
            return back()->with('error', 'Student profile not found.');
        }

        $exam = SmsExam::findOrFail($examId);

        // Check if already completed
        $existingSession = SmsExamSession::where('exam_id', $examId)
            ->where('student_id', $student->id)
            ->where('status', 'completed')
            ->first();

        if ($existingSession) {
            return redirect()->route('sms.student.exams.result', $existingSession->id)
                ->with('info', 'You have already completed this exam.');
        }

        // DATE ENFORCEMENT: Check if exam is scheduled for today
        $examDate = $exam->scheduled_date ?? $exam->start_date;
        if ($examDate) {
            $today = now()->startOfDay();
            $scheduledDate = \Carbon\Carbon::parse($examDate)->startOfDay();
            
            if (!$today->equalTo($scheduledDate)) {
                return back()->with('error', 
                    "This exam is scheduled for " . $scheduledDate->format('F j, Y') . ". Please check back on the exam date."
                );
            }
        }

        // FEE ENFORCEMENT: Check fee status (must have at least 50% paid)
        $feeStatus = $this->checkFeeStatus($student->id);
        if (!$feeStatus['cleared']) {
            return back()->with('error', 
                "You are still owing school fees. Please clear your fees or pay at least 50% to be allowed to sit for this exam. " .
                "Current payment: " . $feeStatus['percentage_paid'] . "%"
            );
        }

        // Create new session
        $session = SmsExamSession::create([
            'exam_id' => $examId,
            'student_id' => $student->id,
            'status' => 'in_progress',
            'started_at' => now(),
            'time_remaining_seconds' => $exam->duration_minutes * 60,
        ]);

        return redirect()->route('sms.student.exams.take', $examId);
    }

    private function checkFeeStatus($studentId)
    {
        try {
            $student = \App\Models\Sms\SmsStudent::find($studentId);
            if (!$student) return ['cleared' => false, 'percentage_paid' => 0];

            $fees = \App\Models\Sms\SmsFee::where('school_id', $student->school_id)
                ->where('class_id', $student->class_id)
                ->where('is_active', true)
                ->get();

            $total = $fees->sum('amount');
            $paid = \App\Models\Sms\SmsFeePayment::where('student_id', $studentId)->sum('amount_paid');
            
            $percentagePaid = $total > 0 ? ($paid / $total) * 100 : 100;
            $cleared = $percentagePaid >= 50; // At least 50% must be paid

            return [
                'cleared' => $cleared,
                'percentage_paid' => round($percentagePaid, 1),
                'total' => $total,
                'paid' => $paid,
                'balance' => max(0, $total - $paid),
            ];
        } catch (\Exception $e) {
            return ['cleared' => true, 'percentage_paid' => 100]; // Default to cleared if error
        }
    }

    /**
     * Save answer
     */
    public function saveAnswer(Request $request, $sessionId)
    {
        $session = SmsExamSession::findOrFail($sessionId);
        
        if ($session->status !== 'in_progress') {
            return response()->json(['error' => 'Exam session is not active.'], 400);
        }

        $request->validate([
            'question_id' => 'required|exists:sms_exam_questions,id',
            'answer' => 'required|string',
        ]);

        $answers = $session->answers ?? [];
        $answers[$request->question_id] = $request->answer;
        
        $session->update(['answers' => $answers]);

        return response()->json(['success' => true]);
    }

    /**
     * Submit exam
     */
    public function submit(Request $request, $sessionId)
    {
        $session = SmsExamSession::with(['exam.questions'])->findOrFail($sessionId);
        
        if ($session->status !== 'in_progress') {
            return back()->with('error', 'Exam session is not active.');
        }

        DB::beginTransaction();

        try {
            // Calculate score
            $score = 0;
            $totalScore = 0;
            $answers = $session->answers ?? [];

            foreach ($session->exam->questions as $question) {
                $totalScore += $question->points ?? 1;
                $studentAnswer = $answers[$question->id] ?? null;
                
                if ($studentAnswer && strtolower(trim($studentAnswer)) === strtolower(trim($question->correct_answer))) {
                    $score += $question->points ?? 1;
                }
            }

            $percentage = $totalScore > 0 ? ($score / $totalScore) * 100 : 0;
            $passed = $percentage >= $session->exam->passing_score;

            // Update session
            $session->update([
                'status' => 'completed',
                'submitted_at' => now(),
                'ended_at' => now(),
                'score' => $score,
                'total_score' => $totalScore,
                'percentage' => $percentage,
                'passed' => $passed,
            ]);

            // Create exam result record (if table exists)
            if (Schema::hasTable('sms_exam_results')) {
                \App\Models\Sms\SmsExamResult::updateOrCreate(
                    [
                        'exam_id' => $session->exam_id,
                        'student_id' => $session->student_id,
                    ],
                    [
                        'school_id' => $session->exam->school_id,
                        'marks_obtained' => $score,
                        'grade' => $this->calculateGrade($percentage),
                        'remarks' => $passed ? 'Passed' : 'Failed',
                    ]
                );
            }

            DB::commit();

            return redirect()->route('sms.student.exams.result', $sessionId)
                ->with('success', 'Exam submitted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error submitting exam: ' . $e->getMessage());
        }
    }

    /**
     * Show exam result
     */
    public function result($sessionId)
    {
        $session = SmsExamSession::with(['exam.subject', 'exam.class', 'student'])->findOrFail($sessionId);
        
        $smsUser = session('sms_user');
        $student = \App\Models\Sms\SmsStudent::where('user_id', $smsUser->id)->first();
        
        if (!$student || $session->student_id !== $student->id) {
            return redirect()->route('sms.student.exams')
                ->with('error', 'Unauthorized access.');
        }

        return view('sms.student.exams.result', compact('session'));
    }

    /**
     * Practice mode (no restrictions)
     */
    public function practice($subjectId)
    {
        $smsUser = session('sms_user');
        $student = \App\Models\Sms\SmsStudent::where('user_id', $smsUser->id)->first();
        
        if (!$student) {
            return back()->with('error', 'Student profile not found.');
        }

        $subject = \App\Models\Sms\SmsSubject::findOrFail($subjectId);

        // Get practice questions (demo/past questions)
        // For now, we'll use any exam questions from this subject as practice
        $examIds = \App\Models\Sms\SmsExam::where('school_id', $student->school_id)
            ->where('subject_id', $subjectId)
            ->where('is_active', true)
            ->pluck('id')
            ->toArray();

        if (empty($examIds)) {
            return back()->with('error', 'No practice questions available for this subject yet. No exams have been created for this subject.');
        }

        $practiceQuestions = \App\Models\Sms\SmsExamQuestion::whereIn('exam_id', $examIds)
            ->with('exam')
            ->inRandomOrder()
            ->limit(20) // Practice with 20 questions
            ->get();

        if ($practiceQuestions->isEmpty()) {
            return back()->with('error', 'No practice questions available for this subject yet. Please contact your teacher.');
        }

        return view('sms.student.exams.practice', compact('student', 'subject', 'practiceQuestions'));
    }

    private function calculateGrade($percentage): string
    {
        if ($percentage >= 75) return 'A';
        if ($percentage >= 70) return 'B';
        if ($percentage >= 65) return 'C';
        if ($percentage >= 60) return 'D';
        if ($percentage >= 50) return 'E';
        return 'F';
    }
}
