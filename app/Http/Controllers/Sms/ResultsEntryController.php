<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\Sms\Result;
use App\Models\Sms\SmsStudent;
use App\Models\Sms\SmsClass;
use App\Models\Sms\SmsSubject;
use App\Models\Sms\SmsTeacher;
use App\Models\Sms\SmsAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResultsEntryController extends Controller
{
    /**
     * Show results entry page
     */
    public function index(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->with('subjects')->firstOrFail();

        // Get assigned subjects
        $subjects = $teacher->subjects()->where('is_active', true)->get();

        // Get classes based on teacher type
        if ($teacher->teacher_type === 'primary') {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['Basic 1', 'Basic 2', 'Basic 3', 'Basic 4', 'Basic 5', 'Basic 6'])
                ->get();
        } else {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['JSS1', 'JSS2', 'JSS3', 'SS1', 'SS2', 'SS3'])
                ->get();
        }

        // Get filter values
        $selectedClassId = $request->get('class_id');
        $selectedSubjectId = $request->get('subject_id');
        $selectedYear = $request->get('academic_year', date('Y') . '/' . (date('Y') + 1));
        $selectedTerm = $request->get('term', 'First Term');
        $selectedExamType = $request->get('exam_type', 'Exam');

        $students = collect();
        $existingResults = collect();
        $existingAssessments = collect();

        if ($selectedClassId) {
            // Get students in the selected class
            $students = SmsStudent::where('school_id', $teacher->school_id)
                ->where('class_id', $selectedClassId)
                ->where('status', 'active')
                ->with('user')
                ->orderBy('student_id_number')
                ->get();

            // Get existing results (if subject is selected)
            if ($selectedSubjectId) {
                $existingResults = Result::where('school_id', $teacher->school_id)
                    ->where('class_id', $selectedClassId)
                    ->where('subject_id', $selectedSubjectId)
                    ->where('academic_year', $selectedYear)
                    ->where('term', $selectedTerm)
                    ->where('exam_type', $selectedExamType)
                    ->where('teacher_id', $teacher->id)
                    ->with('student')
                    ->get()
                    ->keyBy('student_id');
            }

            // Get existing assessments (for psychomotor/affective - no subject needed)
            $existingAssessments = DB::table('sms_student_assessments')
                ->where('school_id', $teacher->school_id)
                ->where('class_id', $selectedClassId)
                ->where('academic_year', $selectedYear)
                ->where('term', $selectedTerm)
                ->get()
                ->keyBy('student_id');
            
            // Get attendance stats for each student in the term using date ranges
            $attendanceStats = [];
            $termStartDate = $this->getTermStartDate($selectedYear, $selectedTerm);
            $termEndDate = $this->getTermEndDate($selectedYear, $selectedTerm);
            
            foreach ($students as $student) {
                $attendances = SmsAttendance::where('student_id', $student->id)
                    ->whereBetween('date', [$termStartDate, $termEndDate])
                    ->get();
                
                $attendanceStats[$student->id] = [
                    'present' => $attendances->where('status', 'present')->count(),
                    'absent' => $attendances->where('status', 'absent')->count(),
                    'late' => $attendances->where('status', 'late')->count(),
                ];
            }
        } else {
            $attendanceStats = [];
        }

        return view('sms.teacher.results-entry.index', compact(
            'teacher',
            'subjects',
            'classes',
            'students',
            'existingResults',
            'existingAssessments',
            'attendanceStats',
            'selectedClassId',
            'selectedSubjectId',
            'selectedYear',
            'selectedTerm',
            'selectedExamType'
        ));
    }

    /**
     * Store results (manual entry)
     */
    public function store(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

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

        DB::beginTransaction();

        try {
            foreach ($request->results as $resultData) {
                if (empty($resultData['student_id'])) continue;

                // Get CA1, CA2, and Exam scores
                $ca1Score = $resultData['ca1_score'] ?? 0;
                $ca2Score = $resultData['ca2_score'] ?? 0;
                $examScore = $resultData['exam_score'] ?? 0;
                
                // Calculate CA score (average of CA1 and CA2, or use provided ca_score)
                $caScore = $resultData['ca_score'] ?? (($ca1Score + $ca2Score) / 2);
                if ($ca1Score > 0 && $ca2Score > 0) {
                    $caScore = ($ca1Score + $ca2Score) / 2;
                }
                
                $totalScore = $caScore + $examScore;

                // Get student to ensure they belong to the class
                $student = SmsStudent::findOrFail($resultData['student_id']);
                
                if ($student->class_id != $request->class_id) {
                    continue; // Skip if student doesn't belong to the class
                }

                $result = Result::updateOrCreate(
                    [
                        'school_id' => $teacher->school_id,
                        'student_id' => $student->id,
                        'subject_id' => $request->subject_id,
                        'academic_year' => $request->academic_year,
                        'term' => $request->term,
                        'exam_type' => $request->exam_type,
                    ],
                    [
                        'class_id' => $request->class_id,
                        'teacher_id' => $teacher->id,
                        'ca1_score' => $ca1Score,
                        'ca2_score' => $ca2Score,
                        'ca_score' => $caScore,
                        'exam_score' => $examScore,
                        'total_score' => $totalScore,
                        'grade' => $this->calculateGrade($totalScore),
                        'remark' => $this->calculateRemark($totalScore),
                    ]
                );

                // Update position in class for this subject
                $this->updatePosition($result);
            }

            DB::commit();

            return redirect()->route('sms.teacher.results-entry.index', [
                'class_id' => $request->class_id,
                'subject_id' => $request->subject_id,
                'academic_year' => $request->academic_year,
                'term' => $request->term,
                'exam_type' => $request->exam_type,
            ])->with('success', 'Results saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving results: ' . $e->getMessage());
            return back()->with('error', 'Error saving results: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Upload results from CSV
     */
    public function uploadCsv(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
            'class_id' => 'required|exists:sms_classes,id',
            'subject_id' => 'required|exists:sms_subjects,id',
            'academic_year' => 'required|string',
            'term' => 'required|string',
            'exam_type' => 'required|in:CA1,CA2,Test,Exam',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        // Skip header row
        $header = fgetcsv($handle);

        DB::beginTransaction();

        try {
            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            while (($row = fgetcsv($handle)) !== false) {
                if (empty($row[0])) continue; // Skip empty rows

                // CSV Format: Student ID, Fullname, Class, Subject, CA1, CA2, Exam
                // We'll use Student ID (index 0) to match, and scores from CA1 (index 4), CA2 (index 5), Exam (index 6)
                $studentIdNumber = trim($row[0]);
                
                // Get scores - handle both old format (2 columns) and new format (7 columns)
                if (count($row) >= 7) {
                    // New format: Student ID, Fullname, Class, Subject, CA1, CA2, Exam
                    $ca1Score = isset($row[4]) && !empty(trim($row[4])) ? (float)trim($row[4]) : 0;
                    $ca2Score = isset($row[5]) && !empty(trim($row[5])) ? (float)trim($row[5]) : 0;
                    $examScore = isset($row[6]) && !empty(trim($row[6])) ? (float)trim($row[6]) : 0;
                    
                    // Calculate CA score as average of CA1 and CA2, or sum if both provided
                    $caScore = ($ca1Score + $ca2Score) / 2;
                } else {
                    // Old format: Student ID, CA Score, Exam Score (backward compatibility)
                    $caScore = isset($row[1]) ? (float)trim($row[1]) : 0;
                    $examScore = isset($row[2]) ? (float)trim($row[2]) : 0;
                    $ca1Score = 0;
                    $ca2Score = 0;
                }

                // Validate scores
                if ($caScore < 0 || $caScore > 100 || $examScore < 0 || $examScore > 100) {
                    $errors[] = "Invalid scores for student {$studentIdNumber}";
                    $errorCount++;
                    continue;
                }

                $student = SmsStudent::where('school_id', $teacher->school_id)
                    ->where('class_id', $request->class_id)
                    ->where('student_id_number', $studentIdNumber)
                    ->first();

                if (!$student) {
                    $errors[] = "Student {$studentIdNumber} not found in class";
                    $errorCount++;
                    continue;
                }

                $totalScore = $caScore + $examScore;

                $result = Result::updateOrCreate(
                    [
                        'school_id' => $teacher->school_id,
                        'student_id' => $student->id,
                        'subject_id' => $request->subject_id,
                        'academic_year' => $request->academic_year,
                        'term' => $request->term,
                        'exam_type' => $request->exam_type,
                    ],
                    [
                        'class_id' => $request->class_id,
                        'teacher_id' => $teacher->id,
                        'ca1_score' => $ca1Score,
                        'ca2_score' => $ca2Score,
                        'ca_score' => $caScore,
                        'exam_score' => $examScore,
                        'total_score' => $totalScore,
                        'grade' => $this->calculateGrade($totalScore),
                        'remark' => $this->calculateRemark($totalScore),
                    ]
                );

                // Update position
                $this->updatePosition($result);
                $successCount++;
            }

            fclose($handle);

            DB::commit();

            $message = "Successfully uploaded {$successCount} results.";
            if ($errorCount > 0) {
                $message .= " {$errorCount} errors occurred.";
            }

            return redirect()->route('sms.teacher.results-entry.index', [
                'class_id' => $request->class_id,
                'subject_id' => $request->subject_id,
                'academic_year' => $request->academic_year,
                'term' => $request->term,
                'exam_type' => $request->exam_type,
            ])->with('success', $message)->with('errors', $errors);
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($handle)) fclose($handle);
            Log::error('Error uploading CSV: ' . $e->getMessage());
            return back()->with('error', 'Error uploading CSV: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Download CSV template for results
     */
    public function downloadTemplate(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:sms_classes,id',
            'subject_id' => 'required|exists:sms_subjects,id',
        ]);

        $students = SmsStudent::where('class_id', $request->class_id)
            ->where('status', 'active')
            ->with('user', 'class')
            ->orderBy('student_id_number')
            ->get();

        $subject = SmsSubject::findOrFail($request->subject_id);
        $class = SmsClass::findOrFail($request->class_id);

        $filename = 'results_template_' . $class->name . '_' . $subject->name . '_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($students, $class, $subject) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, ['Student ID', 'Fullname', 'Class', 'Subject', 'CA1', 'CA2', 'Exam']);
            
            // Student rows
            foreach ($students as $student) {
                fputcsv($file, [
                    $student->student_id_number,
                    $student->user->name ?? 'N/A',
                    $class->name,
                    $subject->name,
                    '', // CA1
                    '', // CA2
                    ''  // Exam
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download CSV template for psychomotor and affective assessments
     */
    public function downloadPsychomotorTemplate(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:sms_classes,id',
            'academic_year' => 'required|string',
            'term' => 'required|string',
        ]);

        $students = SmsStudent::where('class_id', $request->class_id)
            ->where('status', 'active')
            ->with('user', 'class')
            ->orderBy('student_id_number')
            ->get();

        $class = SmsClass::findOrFail($request->class_id);
        $academicYear = $request->academic_year;
        $term = $request->term;

        $filename = 'psychomotor_assessments_' . $class->name . '_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $termStartDate = $this->getTermStartDate($academicYear, $term);
        $termEndDate = $this->getTermEndDate($academicYear, $term);

        $callback = function() use ($students, $class, $termStartDate, $termEndDate) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'Student ID', 'Fullname', 'Class',
                'No of Times Present', 'No of Times Absent', 'No of Times Late',
                'Punctuality (1-4)', 'Honesty (1-4)', 'Neatness (1-4)', 'Politeness (1-4)',
                'Obedience (1-4)', 'Self Control (1-4)', 'Relationship with Others (1-4)',
                'Handling of Tools (1-4)', 'Drawing/Painting (1-4)', 'Handwriting (1-4)',
                'Musical Skill (1-4)', 'Public Speaking (1-4)', 'Sports/Gaming (1-4)',
                'Teacher Remark'
            ]);
            
            // Student rows with default values
            foreach ($students as $student) {
                // Get attendance stats for the term using date range
                $attendances = SmsAttendance::where('student_id', $student->id)
                    ->whereBetween('date', [$termStartDate, $termEndDate])
                    ->get();
                
                $presentCount = $attendances->where('status', 'present')->count();
                $absentCount = $attendances->where('status', 'absent')->count();
                $lateCount = $attendances->where('status', 'late')->count();
                
                fputcsv($file, [
                    $student->student_id_number,
                    $student->user->name ?? 'N/A',
                    $class->name,
                    $presentCount,
                    $absentCount,
                    $lateCount,
                    4, 4, 4, 4, 4, 4, 4, // Affective Domain (default 4)
                    4, 4, 4, 4, 4, 4,   // Psychomotor Skills (default 4)
                    '' // Teacher Remark (empty)
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Upload psychomotor and affective assessments from CSV
     */
    public function uploadPsychomotorCsv(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
            'class_id' => 'required|exists:sms_classes,id',
            'academic_year' => 'required|string',
            'term' => 'required|string',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        // Skip header row
        $header = fgetcsv($handle);

        DB::beginTransaction();

        try {
            $successCount = 0;
            $errors = [];

            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < 20) {
                    continue; // Skip invalid rows (new format has 20 columns)
                }

                $studentIdNumber = trim($row[0]);
                if (empty($studentIdNumber)) {
                    continue;
                }

                $student = SmsStudent::where('student_id_number', $studentIdNumber)
                    ->where('class_id', $request->class_id)
                    ->where('school_id', $teacher->school_id)
                    ->first();

                if (!$student) {
                    $errors[] = "Student with ID {$studentIdNumber} not found in this class.";
                    continue;
                }

                // CSV Format: Student ID, Fullname, Class, No of Times Present, No of Times Absent, No of Times Late,
                // Punctuality, Honesty, Neatness, Politeness, Obedience, Self Control, Relationship with Others,
                // Handling of Tools, Drawing/Painting, Handwriting, Musical Skill, Public Speaking, Sports/Gaming, Teacher Remark
                
                // Attendance stats (indices 3, 4, 5)
                $noOfTimesPresent = isset($row[3]) ? (int)trim($row[3]) : 0;
                $noOfTimesAbsent = isset($row[4]) ? (int)trim($row[4]) : 0;
                $noOfTimesLate = isset($row[5]) ? (int)trim($row[5]) : 0;
                
                // Parse assessment values (1-4 scale) - indices 6-18
                $punctuality = min(4, max(1, (int)($row[6] ?? 4)));
                $honesty = min(4, max(1, (int)($row[7] ?? 4)));
                $neatness = min(4, max(1, (int)($row[8] ?? 4)));
                $politeness = min(4, max(1, (int)($row[9] ?? 4)));
                $obedience = min(4, max(1, (int)($row[10] ?? 4)));
                $selfControl = min(4, max(1, (int)($row[11] ?? 4)));
                $relationshipWithOthers = min(4, max(1, (int)($row[12] ?? 4)));
                $handlingOfTools = min(4, max(1, (int)($row[13] ?? 4)));
                $drawingPainting = min(4, max(1, (int)($row[14] ?? 4)));
                $handwriting = min(4, max(1, (int)($row[15] ?? 4)));
                $musicalSkill = min(4, max(1, (int)($row[16] ?? 4)));
                $publicSpeaking = min(4, max(1, (int)($row[17] ?? 4)));
                $sportsGaming = min(4, max(1, (int)($row[18] ?? 4)));
                
                // Teacher remark (index 19)
                $teacherRemark = isset($row[19]) ? trim($row[19]) : '';

                DB::table('sms_student_assessments')->updateOrInsert(
                    [
                        'student_id' => $student->id,
                        'academic_year' => $request->academic_year,
                        'term' => $request->term,
                    ],
                    [
                        'school_id' => $teacher->school_id,
                        'class_id' => $request->class_id,
                        'teacher_id' => $teacher->id,
                        'no_of_times_present' => $noOfTimesPresent,
                        'no_of_times_absent' => $noOfTimesAbsent,
                        'no_of_times_late' => $noOfTimesLate,
                        'punctuality' => $punctuality,
                        'honesty' => $honesty,
                        'neatness' => $neatness,
                        'politeness' => $politeness,
                        'obedience' => $obedience,
                        'self_control' => $selfControl,
                        'relationship_with_others' => $relationshipWithOthers,
                        'handling_of_tools' => $handlingOfTools,
                        'drawing_painting' => $drawingPainting,
                        'handwriting' => $handwriting,
                        'musical_skill' => $musicalSkill,
                        'public_speaking' => $publicSpeaking,
                        'sports_gaming' => $sportsGaming,
                        'teacher_remark' => $teacherRemark,
                        'updated_at' => now(),
                    ]
                );

                $successCount++;
            }

            fclose($handle);
            DB::commit();

            $message = "Successfully uploaded {$successCount} assessments.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " errors occurred.";
            }

            return redirect()->route('sms.teacher.results-entry.index', [
                'class_id' => $request->class_id,
                'academic_year' => $request->academic_year,
                'term' => $request->term,
            ])->with('success', $message)->with('errors', $errors);
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($handle)) fclose($handle);
            Log::error('Error uploading psychomotor CSV: ' . $e->getMessage());
            return back()->with('error', 'Error uploading CSV: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Store affective domain and psychomotor assessments (bulk)
     */
    public function storeAssessments(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'class_id' => 'required|exists:sms_classes,id',
            'academic_year' => 'required|string',
            'term' => 'required|string',
            'assessments' => 'required|array',
            'assessments.*.student_id' => 'required|exists:sms_students,id',
            'assessments.*.punctuality' => 'required|integer|min:1|max:4',
            'assessments.*.honesty' => 'required|integer|min:1|max:4',
            'assessments.*.neatness' => 'required|integer|min:1|max:4',
            'assessments.*.politeness' => 'required|integer|min:1|max:4',
            'assessments.*.obedience' => 'required|integer|min:1|max:4',
            'assessments.*.self_control' => 'required|integer|min:1|max:4',
            'assessments.*.relationship_with_others' => 'required|integer|min:1|max:4',
            'assessments.*.handling_of_tools' => 'required|integer|min:1|max:4',
            'assessments.*.drawing_painting' => 'required|integer|min:1|max:4',
            'assessments.*.handwriting' => 'required|integer|min:1|max:4',
            'assessments.*.musical_skill' => 'required|integer|min:1|max:4',
            'assessments.*.public_speaking' => 'required|integer|min:1|max:4',
            'assessments.*.sports_gaming' => 'required|integer|min:1|max:4',
        ]);

        DB::beginTransaction();

        try {
            $successCount = 0;

            foreach ($request->assessments as $assessmentData) {
                if (empty($assessmentData['student_id'])) continue;

                $student = SmsStudent::findOrFail($assessmentData['student_id']);

                if ($student->school_id != $teacher->school_id || $student->class_id != $request->class_id) {
                    continue; // Skip if student doesn't belong to the class/school
                }

                DB::table('sms_student_assessments')->updateOrInsert(
                    [
                        'student_id' => $student->id,
                        'academic_year' => $request->academic_year,
                        'term' => $request->term,
                    ],
                    [
                        'school_id' => $teacher->school_id,
                        'class_id' => $request->class_id,
                        'teacher_id' => $teacher->id,
                        'no_of_times_present' => $assessmentData['no_of_times_present'] ?? 0,
                        'no_of_times_absent' => $assessmentData['no_of_times_absent'] ?? 0,
                        'no_of_times_late' => $assessmentData['no_of_times_late'] ?? 0,
                        'punctuality' => $assessmentData['punctuality'],
                        'honesty' => $assessmentData['honesty'],
                        'neatness' => $assessmentData['neatness'],
                        'politeness' => $assessmentData['politeness'],
                        'obedience' => $assessmentData['obedience'],
                        'self_control' => $assessmentData['self_control'],
                        'relationship_with_others' => $assessmentData['relationship_with_others'],
                        'handling_of_tools' => $assessmentData['handling_of_tools'],
                        'drawing_painting' => $assessmentData['drawing_painting'],
                        'handwriting' => $assessmentData['handwriting'],
                        'musical_skill' => $assessmentData['musical_skill'],
                        'public_speaking' => $assessmentData['public_speaking'],
                        'sports_gaming' => $assessmentData['sports_gaming'],
                        'teacher_remark' => $assessmentData['teacher_remark'] ?? null,
                        'updated_at' => now(),
                    ]
                );

                $successCount++;
            }

            DB::commit();

            return redirect()->route('sms.teacher.results-entry.index', [
                'class_id' => $request->class_id,
                'academic_year' => $request->academic_year,
                'term' => $request->term,
            ])->with('success', "Successfully saved assessments for {$successCount} students.");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving assessments: ' . $e->getMessage());
            return back()->with('error', 'Error saving assessments: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Get term start date
     */
    private function getTermStartDate($academicYear, $term): string
    {
        $year = explode('/', $academicYear)[0];
        
        return match($term) {
            'First Term' => $year . '-09-01',
            'Second Term' => $year . '-01-01',
            'Third Term' => $year . '-05-01',
            default => $year . '-09-01',
        };
    }

    /**
     * Get term end date
     */
    private function getTermEndDate($academicYear, $term): string
    {
        $year = explode('/', $academicYear)[0];
        $nextYear = (int)$year + 1;
        
        return match($term) {
            'First Term' => $year . '-12-31',
            'Second Term' => $year . '-04-30',
            'Third Term' => $nextYear . '-08-31',
            default => $year . '-12-31',
        };
    }

    /**
     * Calculate grade from score
     */
    private function calculateGrade($score): string
    {
        if ($score >= 75) return 'A';
        if ($score >= 70) return 'B';
        if ($score >= 65) return 'C';
        if ($score >= 60) return 'D';
        if ($score >= 50) return 'E';
        return 'F';
    }

    /**
     * Calculate remark from score
     */
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

    /**
     * Update position in class for a result
     */
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
}
