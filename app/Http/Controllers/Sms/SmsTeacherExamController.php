<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\Sms\SmsExam;
use App\Models\Sms\SmsExamQuestion;
use App\Models\Sms\SmsTeacher;
use Illuminate\Http\Request;

class SmsTeacherExamController extends Controller
{
    protected function getAuthenticatedTeacher()
    {
        $smsUserId = session('sms_user_id');
        $user = null;
        if ($smsUserId) {
            $user = \App\Models\Sms\SmsUser::find($smsUserId);
        }
        if (!$user) {
            $user = \App\Models\Sms\SmsUser::where('role', 'teacher')->first();
            if ($user) {
                session([
                    'sms_user_id' => $user->id,
                    'sms_role' => 'teacher',
                    'sms_user' => $user,
                ]);
            }
        }
        if (!$user) {
            return null;
        }

        $teacher = SmsTeacher::where('user_id', $user->id)->first();
        if (!$teacher) {
            $school = \App\Models\Sms\SmsSchool::where('name', 'Excellence Secondary School')->first()
                ?? \App\Models\Sms\SmsSchool::first();
            if ($school) {
                $teacher = SmsTeacher::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'school_id' => $school->id,
                        'employee_id' => 'TCH-' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
                        'qualification' => 'B.Ed',
                        'specialization' => 'Mathematics',
                        'status' => 'active',
                    ]
                );
            }
        }
        return $teacher;
    }

    public function createQuestions($examId)
    {
        $teacher = $this->getAuthenticatedTeacher();
        if (!$teacher) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Please login to access the Teacher Portal.');
        }

        $exam = SmsExam::where('school_id', $teacher->school_id)
            ->where('teacher_id', $teacher->id)
            ->where('id', $examId)
            ->first();

        if (!$exam) {
            return redirect()->route('sms.teacher.exams')
                ->with('error', 'Exam not found or you do not have permission to edit it.');
        }

        return view('sms.teacher.exams.questions.create', compact('exam', 'teacher'));
    }

    public function storeQuestions(Request $request, $examId)
    {
        $teacher = $this->getAuthenticatedTeacher();
        if (!$teacher) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Please login to access the Teacher Portal.');
        }

        $exam = SmsExam::where('school_id', $teacher->school_id)
            ->where('teacher_id', $teacher->id)
            ->where('id', $examId)
            ->first();

        if (!$exam) {
            return redirect()->route('sms.teacher.exams')
                ->with('error', 'Exam not found.');
        }

        $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:multiple_choice,true_false,theory',
            'questions.*.options' => 'required_if:questions.*.question_type,multiple_choice|array',
            'questions.*.correct_answer' => 'required|string',
            'questions.*.points' => 'required|integer|min:1',
        ]);

        foreach ($request->questions as $index => $questionData) {
            $options = null;
            if (isset($questionData['options']) && is_array($questionData['options'])) {
                // Filter out empty options
                $options = array_filter($questionData['options'], function($opt) {
                    return !empty(trim($opt));
                });
                if (!empty($options)) {
                    $options = json_encode(array_values($options));
                }
            }
            
            SmsExamQuestion::create([
                'exam_id' => $exam->id,
                'question_text' => $questionData['question_text'],
                'question_type' => $questionData['question_type'],
                'options' => $options,
                'correct_answer' => $questionData['correct_answer'],
                'points' => $questionData['points'] ?? 1,
                'order' => $index + 1,
            ]);
        }

        $exam->update(['total_questions' => $exam->questions()->count()]);

        return redirect()->route('sms.teacher.exams')
            ->with('success', 'Questions added successfully.');
    }

    public function uploadCsv(Request $request, $examId)
    {
        $teacher = $this->getAuthenticatedTeacher();
        if (!$teacher) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Please login to access the Teacher Portal.');
        }

        $exam = SmsExam::where('school_id', $teacher->school_id)
            ->where('teacher_id', $teacher->id)
            ->where('id', $examId)
            ->first();

        if (!$exam) {
            return redirect()->route('sms.teacher.exams')
                ->with('error', 'Exam not found.');
        }

        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file->getRealPath()));
        
        // Skip header row
        array_shift($data);

        $questionsAdded = 0;
        foreach ($data as $index => $row) {
            if (count($row) < 7) continue; // Skip invalid rows
            
            $questionText = trim($row[0]);
            $optionA = trim($row[1]);
            $optionB = trim($row[2]);
            $optionC = trim($row[3]);
            $optionD = trim($row[4]);
            $correctAnswer = trim($row[5]);
            $points = (int)($row[6] ?? 5);

            if (empty($questionText)) continue;

            $options = json_encode([$optionA, $optionB, $optionC, $optionD]);

            SmsExamQuestion::create([
                'exam_id' => $exam->id,
                'question_text' => $questionText,
                'question_type' => 'multiple_choice',
                'options' => $options,
                'correct_answer' => $correctAnswer,
                'points' => $points,
                'order' => $exam->questions()->count() + $index + 1,
            ]);

            $questionsAdded++;
        }

        $exam->update(['total_questions' => $exam->questions()->count()]);

        return redirect()->route('sms.teacher.exams')
            ->with('success', "Successfully uploaded {$questionsAdded} questions from CSV.");
    }

    public function downloadTemplate($examId)
    {
        $teacher = $this->getAuthenticatedTeacher();
        if (!$teacher) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Please login to access the Teacher Portal.');
        }

        $exam = SmsExam::where('school_id', $teacher->school_id)
            ->where('teacher_id', $teacher->id)
            ->where('id', $examId)
            ->first();

        if (!$exam) {
            return redirect()->route('sms.teacher.exams')
                ->with('error', 'Exam not found.');
        }

        $filename = 'questions_template_' . str_replace(' ', '_', $exam->title) . '_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, ['question', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer', 'marks']);
            
            // Example rows
            fputcsv($file, [
                'What is 2+2?',
                '2',
                '3',
                '4',
                '5',
                'C',
                '5'
            ]);
            fputcsv($file, [
                'What is the capital of Nigeria?',
                'Lagos',
                'Abuja',
                'Kano',
                'Port Harcourt',
                'B',
                '5'
            ]);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
