<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\Sms\Result;
use App\Models\Sms\SmsClass;
use App\Models\Sms\SmsSubject;
use App\Models\Sms\SmsStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmsTeacherResultController extends Controller
{
    /**
     * Show result upload page for teacher
     */
    public function upload()
    {
        $smsUser = session('sms_user');
        $schoolId = $smsUser->school_id ?? null;

        $teacher = \App\Models\Sms\SmsTeacher::where('user_id', $smsUser->id)->first();
        
        if (!$teacher) {
            return redirect()->route('sms.teacher.dashboard')
                ->with('error', 'Teacher profile not found.');
        }

        // Get subjects this teacher teaches
        $subjects = \App\Models\Sms\SmsSubject::where('school_id', $schoolId)
            ->whereHas('teachers', function($q) use ($teacher) {
                $q->where('sms_teachers.id', $teacher->id);
            })
            ->get();

        // Get classes this teacher teaches
        $classes = SmsClass::where('school_id', $schoolId)
            ->whereHas('teachers', function($q) use ($teacher) {
                $q->where('sms_teachers.id', $teacher->id);
            })
            ->get();

        $currentYear = date('Y');
        $currentTerm = 'First Term';

        return view('sms.teacher.results.upload', compact('subjects', 'classes', 'teacher', 'currentYear', 'currentTerm'));
    }

    /**
     * Store uploaded results
     */
    public function store(Request $request)
    {
        $smsUser = session('sms_user');
        $schoolId = $smsUser->school_id ?? null;

        $request->validate([
            'class_id' => 'required|exists:sms_classes,id',
            'subject_id' => 'required|exists:sms_subjects,id',
            'academic_year' => 'required|string',
            'term' => 'required|string',
            'exam_type' => 'required|in:CA1,CA2,Test,Exam',
            'results' => 'required|array',
            'results.*.student_id' => 'required|exists:sms_students,id',
            'results.*.ca_score' => 'nullable|numeric|min:0|max:100',
            'results.*.exam_score' => 'nullable|numeric|min:0|max:100',
        ]);

        $teacher = \App\Models\Sms\SmsTeacher::where('user_id', $smsUser->id)->first();

        DB::beginTransaction();

        try {
            foreach ($request->results as $resultData) {
                $caScore = $resultData['ca_score'] ?? 0;
                $examScore = $resultData['exam_score'] ?? 0;
                $totalScore = $caScore + $examScore;

                Result::updateOrCreate(
                    [
                        'school_id' => $schoolId,
                        'student_id' => $resultData['student_id'],
                        'subject_id' => $request->subject_id,
                        'academic_year' => $request->academic_year,
                        'term' => $request->term,
                        'exam_type' => $request->exam_type,
                    ],
                    [
                        'class_id' => $request->class_id,
                        'teacher_id' => $teacher->id,
                        'ca_score' => $caScore,
                        'exam_score' => $examScore,
                        'total_score' => $totalScore,
                        'grade' => $this->calculateGrade($totalScore),
                        'remark' => $this->calculateRemark($totalScore),
                    ]
                );
            }

            DB::commit();

            return redirect()->route('sms.teacher.results.upload')
                ->with('success', 'Results uploaded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error uploading results: ' . $e->getMessage());
        }
    }

    private function calculateGrade($score): string
    {
        if ($score >= 75) return 'A';
        if ($score >= 70) return 'B';
        if ($score >= 65) return 'C';
        if ($score >= 60) return 'D';
        if ($score >= 50) return 'E';
        return 'F';
    }

    private function calculateRemark($score): string
    {
        $grade = $this->calculateGrade($score);
        return match($grade) {
            'A' => 'Excellent',
            'B' => 'Very Good',
            'C' => 'Good',
            'D' => 'Credit',
            'E' => 'Pass',
            default => 'Fail',
        };
    }
}
