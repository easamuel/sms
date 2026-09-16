<?php

namespace App\Http\Controllers\School;

use App\Models\Sms\Result;
use App\Models\Sms\SmsClass;
use App\Models\Sms\SmsSubject;
use App\Models\Sms\SmsStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends BaseSchoolController
{
    /**
     * Display results management page
     */
    public function index()
    {
        $school = $this->getSchool();

        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $currentYear = date('Y');
        $currentTerm = 'First Term';

        $classes = SmsClass::where('school_id', $school->id)->get();
        $subjects = SmsSubject::where('school_id', $school->id)->get();

        $results = Result::where('school_id', $school->id)
            ->where('academic_year', $currentYear)
            ->where('term', $currentTerm)
            ->with(['student', 'class', 'subject', 'teacher'])
            ->orderBy('class_id')
            ->orderBy('student_id')
            ->orderBy('subject_id')
            ->get();

        // Group by class and student
        $resultsByClass = $results->groupBy('class_id');
        $resultsByStudent = $results->groupBy('student_id');

        return view('school.results.index', compact('classes', 'subjects', 'resultsByClass', 'resultsByStudent', 'currentYear', 'currentTerm'));
    }

    /**
     * Store result (manual entry)
     */
    public function store(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $request->validate([
            'student_id' => 'required|exists:sms_students,id',
            'class_id' => 'required|exists:sms_classes,id',
            'subject_id' => 'required|exists:sms_subjects,id',
            'teacher_id' => 'required|exists:sms_teachers,id',
            'academic_year' => 'required|string',
            'term' => 'required|string',
            'exam_type' => 'required|in:CA1,CA2,Test,Exam',
            'ca_score' => 'nullable|numeric|min:0|max:100',
            'exam_score' => 'nullable|numeric|min:0|max:100',
        ]);

        $totalScore = ($request->ca_score ?? 0) + ($request->exam_score ?? 0);

        $result = Result::updateOrCreate(
            [
                'school_id' => $school->id,
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'academic_year' => $request->academic_year,
                'term' => $request->term,
                'exam_type' => $request->exam_type,
            ],
            [
                'class_id' => $request->class_id,
                'teacher_id' => $request->teacher_id,
                'ca_score' => $request->ca_score ?? 0,
                'exam_score' => $request->exam_score ?? 0,
                'total_score' => $totalScore,
                'grade' => $this->calculateGrade($totalScore),
                'remark' => $this->calculateRemark($totalScore),
            ]
        );

        // Update position in class for this subject
        $this->updatePosition($result);

        return redirect()->route('school.results.index')
            ->with('success', 'Result saved successfully.');
    }

    /**
     * Upload results from Excel
     */
    public function uploadExcel(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'class_id' => 'required|exists:sms_classes,id',
            'subject_id' => 'required|exists:sms_subjects,id',
            'academic_year' => 'required|string',
            'term' => 'required|string',
            'exam_type' => 'required|in:CA1,CA2,Test,Exam',
        ]);

        try {
            $data = Excel::toArray([], $request->file('file'))[0];
            
            // Skip header row
            array_shift($data);

            DB::beginTransaction();

            foreach ($data as $row) {
                if (empty($row[0])) continue; // Skip empty rows

                $studentIdNumber = $row[0]; // First column: Student ID
                $caScore = $row[1] ?? 0;
                $examScore = $row[2] ?? 0;

                $student = SmsStudent::where('school_id', $school->id)
                    ->where('student_id_number', $studentIdNumber)
                    ->first();

                if (!$student) continue;

                $totalScore = $caScore + $examScore;

                Result::updateOrCreate(
                    [
                        'school_id' => $school->id,
                        'student_id' => $student->id,
                        'subject_id' => $request->subject_id,
                        'academic_year' => $request->academic_year,
                        'term' => $request->term,
                        'exam_type' => $request->exam_type,
                    ],
                    [
                        'class_id' => $request->class_id,
                        'teacher_id' => $request->teacher_id ?? 1, // Default teacher
                        'ca_score' => $caScore,
                        'exam_score' => $examScore,
                        'total_score' => $totalScore,
                        'grade' => $this->calculateGrade($totalScore),
                        'remark' => $this->calculateRemark($totalScore),
                    ]
                );
            }

            DB::commit();

            return redirect()->route('school.results.index')
                ->with('success', 'Results uploaded successfully from Excel.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('school.results.index')
                ->with('error', 'Error uploading Excel: ' . $e->getMessage());
        }
    }

    /**
     * Export results to Excel
     */
    public function exportExcel(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $request->validate([
            'class_id' => 'required|exists:sms_classes,id',
            'academic_year' => 'required|string',
            'term' => 'required|string',
        ]);

        $results = Result::where('school_id', $school->id)
            ->where('class_id', $request->class_id)
            ->where('academic_year', $request->academic_year)
            ->where('term', $request->term)
            ->with(['student', 'subject'])
            ->get();

        // Group by student and compile all subjects
        $compiledResults = $results->groupBy('student_id')->map(function ($studentResults) {
            $student = $studentResults->first()->student;
            $subjects = $studentResults->keyBy('subject_id');
            
            return [
                'student' => $student,
                'subjects' => $subjects,
                'total_score' => $subjects->sum('total_score'),
                'average' => $subjects->avg('total_score'),
            ];
        });

        // Generate Excel export
        $filename = 'results_' . $request->class_id . '_' . $request->academic_year . '_' . $request->term . '.xlsx';
        
        // For now, return view with download link
        // Full Excel export can be implemented with Maatwebsite\Excel
        return view('school.results.export', compact('compiledResults', 'filename'));
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

    private function updatePosition(Result $result): void
    {
        // Get all results for same class, subject, term, exam_type
        $allResults = Result::where('school_id', $result->school_id)
            ->where('class_id', $result->class_id)
            ->where('subject_id', $result->subject_id)
            ->where('academic_year', $result->academic_year)
            ->where('term', $result->term)
            ->where('exam_type', $result->exam_type)
            ->orderBy('total_score', 'desc')
            ->get();

        $position = 1;
        foreach ($allResults as $res) {
            $res->update(['position' => $position]);
            $position++;
        }
    }

    /**
     * Generate result slip for a student
     */
    public function generateResultSlip(Request $request, $studentId)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $student = SmsStudent::where('school_id', $school->id)
            ->with(['class', 'user'])
            ->findOrFail($studentId);

        $academicYear = $request->get('academic_year', date('Y') . '/' . (date('Y') + 1));
        $term = $request->get('term', 'First Term');

        // Get all results for the student for all terms in the academic year
        $results = Result::where('school_id', $school->id)
            ->where('student_id', $student->id)
            ->where('academic_year', $academicYear)
            ->with(['subject', 'class'])
            ->get();

        // Group by term
        $resultsByTerm = $results->groupBy('term');

        // Calculate overall statistics
        $allScores = $results->pluck('total_score')->filter();
        $totalScore = $allScores->sum();
        $average = $allScores->avg() ?? 0;
        
        // Get class size for position calculation
        $classSize = SmsStudent::where('school_id', $school->id)
            ->where('class_id', $student->class_id)
            ->count();

        // Calculate position (simplified - based on average)
        $position = 1;
        $classStudents = SmsStudent::where('school_id', $school->id)
            ->where('class_id', $student->class_id)
            ->get();
        
        foreach ($classStudents as $classStudent) {
            $studentAvg = Result::where('school_id', $school->id)
                ->where('student_id', $classStudent->id)
                ->where('academic_year', $academicYear)
                ->avg('total_score') ?? 0;
            
            if ($studentAvg > $average) {
                $position++;
            }
        }

        return view('school.results.slip', compact(
            'school', 
            'student', 
            'resultsByTerm', 
            'results',
            'academicYear',
            'term',
            'totalScore',
            'average',
            'position',
            'classSize'
        ));
    }
}
