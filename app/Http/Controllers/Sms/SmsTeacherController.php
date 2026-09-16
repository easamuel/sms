<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\Sms\SmsTeacher;
use App\Models\Sms\SmsClass;
use App\Models\Sms\SmsSubject;
use App\Models\Sms\SmsAttendance;
use App\Models\Sms\SmsExam;
use App\Models\Sms\SmsExamQuestion;
use App\Models\Sms\SmsNotice;
use App\Models\Sms\Result;
use App\Models\Sms\Timetable;
use App\Models\Sms\SmsAssignment;
use App\Models\Sms\SmsAssignmentQuestion;
use App\Models\Sms\SmsPracticeSession;
use App\Models\Sms\SmsPracticeQuestion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SmsTeacherController extends Controller
{
    public function dashboard()
    {
        $smsUserId = session('sms_user_id');
        
        if (!$smsUserId) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Please login to access the School Management System.');
        }

        $user = \App\Models\Sms\SmsUser::find($smsUserId);
        
        if (!$user) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Invalid session. Please login again.');
        }
        
        // Get teacher profile
        $teacher = SmsTeacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            $teacher = $this->createDemoTeacher($user);
        }

        // Get assigned classes (via class_teacher_id, timetable, or fallback)
        $timetableClassIds = Timetable::where('teacher_id', $teacher->id)
            ->pluck('class_id')
            ->toArray();

        $assignedClasses = SmsClass::where('school_id', $teacher->school_id)
            ->where(function($query) use ($teacher, $timetableClassIds) {
                $query->where('class_teacher_id', $teacher->id);
                if (!empty($timetableClassIds)) {
                    $query->orWhereIn('id', $timetableClassIds);
                }
            })
            ->with('students')
            ->get();

        // Ensure teacher demo always has classes populated
        if ($assignedClasses->isEmpty()) {
            $assignedClasses = SmsClass::where('school_id', $teacher->school_id)
                ->with('students')
                ->limit(2)
                ->get();
            foreach ($assignedClasses as $cls) {
                $cls->update(['class_teacher_id' => $teacher->id]);
            }
        }

        // Get assigned subjects (via pivot or timetable)
        $assignedSubjects = $teacher->subjects()->where('is_active', true)->get();
        
        if ($assignedSubjects->isEmpty()) {
            $timetableSubjects = Timetable::where('school_id', $teacher->school_id)
                ->where('teacher_id', $teacher->id)
                ->where('is_active', true)
                ->with('subject')
                ->get()
                ->pluck('subject')
                ->unique('id')
                ->filter()
                ->values();
            
            $assignedSubjects = $timetableSubjects;
        }

        // Ensure teacher demo always has subjects populated
        if ($assignedSubjects->isEmpty()) {
            $assignedSubjects = SmsSubject::where('school_id', $teacher->school_id)
                ->where('is_active', true)
                ->limit(2)
                ->get();
            foreach ($assignedSubjects as $subj) {
                $teacher->subjects()->syncWithoutDetaching([$subj->id]);
            }
        }

        // Get upcoming classes from timetable
        $today = now();
        $currentDay = strtolower($today->format('l'));
        
        $upcomingClasses = Timetable::where('school_id', $teacher->school_id)
            ->where('teacher_id', $teacher->id)
            ->where('is_active', true)
            ->where('day', $currentDay)
            ->with(['class', 'subject'])
            ->orderBy('start_time')
            ->get();

        // If today has no classes (e.g. night or weekend), show regular schedule
        if ($upcomingClasses->isEmpty()) {
            $upcomingClasses = Timetable::where('school_id', $teacher->school_id)
                ->where('teacher_id', $teacher->id)
                ->where('is_active', true)
                ->with(['class', 'subject'])
                ->orderBy('start_time')
                ->limit(6)
                ->get();
        }

        if ($upcomingClasses->isEmpty()) {
            $upcomingClasses = Timetable::where('school_id', $teacher->school_id)
                ->where('is_active', true)
                ->with(['class', 'subject'])
                ->orderBy('start_time')
                ->limit(5)
                ->get();
        }

        // Calculate statistics
        $stats = [
            'total_classes' => $assignedClasses->count(),
            'total_students' => $assignedClasses->sum(function($class) {
                return $class->students->count();
            }),
            'total_subjects' => $assignedSubjects->count(),
            'attendance_today' => $this->getTodayAttendance($teacher->school_id),
            'upcoming_classes' => $upcomingClasses->count(),
        ];

        // Get recent attendance records
        $recentAttendance = SmsAttendance::where('school_id', $teacher->school_id)
            ->whereIn('class_id', $assignedClasses->pluck('id')->toArray())
            ->with(['student.user', 'class'])
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        // Get notices
        $notices = SmsNotice::where('school_id', $teacher->school_id)
            ->where(function($query) {
                $query->where('target_audience', 'all')
                      ->orWhere('target_audience', 'teachers');
            })
            ->where('is_active', true)
            ->where('published_at', '<=', now())
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now());
            })
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        // Onest Schooled KPI Metrics
        $totalStudentsCount = \App\Models\Sms\SmsStudent::where('school_id', $teacher->school_id)->count();
        if ($totalStudentsCount === 0) $totalStudentsCount = 84;

        $totalParentsCount = \App\Models\Sms\SmsParent::where('school_id', $teacher->school_id)->count();
        if ($totalParentsCount === 0) $totalParentsCount = 10;

        $totalTeachersCount = \App\Models\Sms\SmsTeacher::where('school_id', $teacher->school_id)->count();
        if ($totalTeachersCount === 0) $totalTeachersCount = 14;

        $totalSessionsCount = \App\Models\Sms\SmsClass::where('school_id', $teacher->school_id)->distinct('academic_year')->count();
        if ($totalSessionsCount === 0) $totalSessionsCount = 3;

        return view('sms.teacher.dashboard', compact(
            'teacher', 
            'assignedClasses', 
            'assignedSubjects', 
            'upcomingClasses',
            'stats', 
            'recentAttendance', 
            'notices',
            'totalStudentsCount',
            'totalParentsCount',
            'totalTeachersCount',
            'totalSessionsCount'
        ));
    }

    public function exams()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $exams = SmsExam::where('school_id', $teacher->school_id)
            ->where('teacher_id', $teacher->id)
            ->with(['subject', 'class'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Filter classes based on teacher type
        if ($teacher->teacher_type === 'primary') {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['Basic 1', 'Basic 2', 'Basic 3', 'Basic 4', 'Basic 5', 'Basic 6'])
                ->get();
        } else {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['JSS1', 'JSS2', 'JSS3', 'SS1', 'SS2', 'SS3'])
                ->get();
        }

        // Only show assigned subjects
        $subjects = $teacher->subjects()->where('is_active', true)->get();

        return view('sms.teacher.exams', compact('teacher', 'exams', 'classes', 'subjects'));
    }

    public function createExam()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $classes = SmsClass::where('school_id', $teacher->school_id)->get();
        $subjects = $teacher->subjects()->where('is_active', true)->get();

        return view('sms.teacher.exams.create', compact('teacher', 'classes', 'subjects'));
    }

    public function storeExam(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        // Validate subject belongs to teacher
        $assignedSubjectIds = $teacher->subjects()->pluck('sms_subjects.id')->toArray();
        
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:sms_subjects,id|in:' . implode(',', $assignedSubjectIds),
            'class_id' => 'required|exists:sms_classes,id',
            'exam_type' => 'required|in:CA1,CA2,CA3,Test,Exam',
            'exam_mode' => 'required|in:online,offline,both',
            'duration_minutes' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'scheduled_date' => 'nullable|date',
            'scheduled_time' => 'nullable|date_format:H:i',
            'allow_manual_grading' => 'boolean',
        ], [
            'subject_id.in' => 'You can only create exams for subjects assigned to you. Please contact administrator to assign subjects.',
        ]);

        $exam = SmsExam::create([
            'school_id' => $teacher->school_id,
            'teacher_id' => $teacher->id,
            'subject_id' => $request->subject_id,
            'class_id' => $request->class_id,
            'title' => $request->title,
            'name' => $request->title,
            'description' => $request->description ?? null,
            'exam_type' => $request->exam_type,
            'exam_mode' => $request->exam_mode,
            'allow_manual_grading' => $request->boolean('allow_manual_grading', $request->exam_mode !== 'online'),
            'duration_minutes' => $request->duration_minutes,
            'passing_score' => $request->passing_score,
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'is_active' => true,
        ]);

        // If online exam, redirect to add questions
        if ($request->exam_mode === 'online' || $request->exam_mode === 'both') {
            return redirect()->route('sms.teacher.exams.questions.create', $exam->id)
                ->with('success', 'Exam created successfully. Now add questions.');
        }

        // If offline, redirect to manual result upload
        return redirect()->route('sms.teacher.results.upload', ['exam_id' => $exam->id])
            ->with('success', 'Offline exam created. You can now upload results manually.');
    }

    public function results()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        // Filter classes based on teacher type
        if ($teacher->teacher_type === 'primary') {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['Basic 1', 'Basic 2', 'Basic 3', 'Basic 4', 'Basic 5', 'Basic 6'])
                ->get();
        } else {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['JSS1', 'JSS2', 'JSS3', 'SS1', 'SS2', 'SS3'])
                ->get();
        }

        // Only show assigned subjects
        $subjects = $teacher->subjects()->where('is_active', true)->get();

        $results = Result::where('school_id', $teacher->school_id)
            ->where('teacher_id', $teacher->id)
            ->with(['student', 'class', 'subject'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('sms.teacher.results', compact('teacher', 'results', 'classes', 'subjects'));
    }

    public function uploadResults(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'class_id' => 'required|exists:sms_classes,id',
            'subject_id' => 'required|exists:sms_subjects,id',
            'academic_year' => 'required|string',
            'term' => 'required|string',
            'results' => 'required|array',
            'results.*.student_id' => 'required|exists:sms_students,id',
            'results.*.ca1_score' => 'nullable|numeric|min:0|max:100',
            'results.*.ca2_score' => 'nullable|numeric|min:0|max:100',
            'results.*.ca3_score' => 'nullable|numeric|min:0|max:100',
            'results.*.exam_score' => 'nullable|numeric|min:0|max:100',
        ]);
        
        // Determine exam_type - use 'Exam' as default since we're uploading all CA scores
        $examType = 'Exam';

        foreach ($request->results as $resultData) {
            $ca1Score = $resultData['ca1_score'] ?? 0;
            $ca2Score = $resultData['ca2_score'] ?? 0;
            $ca3Score = $resultData['ca3_score'] ?? 0;
            $examScore = $resultData['exam_score'] ?? 0;
            
            // Calculate total CA (average of CA1, CA2, CA3)
            $caTotal = ($ca1Score + $ca2Score + $ca3Score) / 3;
            $caScore = round($caTotal, 2);
            
            // Total score = CA + Exam
            $totalScore = $caScore + $examScore;

            Result::updateOrCreate(
                [
                    'school_id' => $teacher->school_id,
                    'student_id' => $resultData['student_id'],
                    'subject_id' => $request->subject_id,
                    'academic_year' => $request->academic_year,
                    'term' => $request->term,
                    'exam_type' => $examType,
                ],
                [
                    'class_id' => $request->class_id,
                    'teacher_id' => $teacher->id,
                    'ca1_score' => $ca1Score,
                    'ca2_score' => $ca2Score,
                    'ca3_score' => $ca3Score,
                    'ca_score' => $caScore,
                    'exam_score' => $examScore,
                    'total_score' => $totalScore,
                    'grade' => $this->calculateGrade($totalScore),
                    'remark' => $this->calculateRemark($totalScore),
                ]
            );
        }

        return redirect()->route('sms.teacher.results')
            ->with('success', 'Results uploaded successfully.');
    }

    public function downloadResultsTemplate(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $classId = $request->get('class_id');
        $subjectId = $request->get('subject_id');

        if (!$classId) {
            return redirect()->back()->with('error', 'Please select a class first.');
        }

        $class = SmsClass::where('school_id', $teacher->school_id)
            ->where('id', $classId)
            ->firstOrFail();

        $students = $class->students()->with('user')->orderBy('student_id_number')->get();

        // Get subject information if provided
        $subject = null;
        $subjectName = '';
        if ($subjectId) {
            $subject = \App\Models\Sms\SmsSubject::where('school_id', $teacher->school_id)
                ->where('id', $subjectId)
                ->first();
            if ($subject) {
                $subjectName = $subject->name;
            }
        }

        $filename = 'results_template_' . $class->name . ($subjectName ? '_' . $subjectName : '') . '_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($students, $subjectName) {
            $file = fopen('php://output', 'w');
            
            // Header row - include subject column
            fputcsv($file, ['admission_number', 'student_name', 'subject', 'ca1', 'ca2', 'ca3', 'exam']);
            
            // Student rows
            foreach ($students as $student) {
                fputcsv($file, [
                    $student->student_id_number ?? '',
                    $student->user->name ?? '',
                    $subjectName, // Subject name for reference
                    '0',
                    '0',
                    '0',
                    '0',
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function uploadResultsCsv(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
            'class_id' => 'required|exists:sms_classes,id',
            'subject_id' => 'required|exists:sms_subjects,id',
            'academic_year' => 'required|string',
            'term' => 'required|string',
        ]);

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file->getRealPath()));
        
        if (empty($data)) {
            return redirect()->back()
                ->with('error', 'The CSV file is empty. Please check your file and try again.');
        }
        
        // Skip header row
        $header = array_shift($data);
        
        // Validate header format - check for both old format (6 columns) and new format (7 columns with subject)
        $hasSubjectColumn = false;
        if (count($header) >= 7) {
            $hasSubjectColumn = true;
        } elseif (count($header) < 6) {
            return redirect()->back()
                ->with('error', 'Invalid CSV format. Expected columns: admission_number, student_name, subject (optional), ca1, ca2, ca3, exam');
        }

        $resultsUploaded = 0;
        $errors = [];
        $rowNumber = 2; // Start from row 2 (after header)
        
        foreach ($data as $row) {
            // Check minimum required columns (6 without subject, 7 with subject)
            $minColumns = $hasSubjectColumn ? 7 : 6;
            if (count($row) < $minColumns) {
                $errors[] = "Row {$rowNumber}: Insufficient columns (expected {$minColumns}, got " . count($row) . ")";
                $rowNumber++;
                continue;
            }
            
            $admissionNumber = trim($row[0] ?? '');
            $studentName = trim($row[1] ?? '');
            
            // If subject column exists, it's at index 2, and scores start at index 3
            // If no subject column, scores start at index 2
            $scoreStartIndex = $hasSubjectColumn ? 3 : 2;
            
            $ca1Score = (float)($row[$scoreStartIndex] ?? 0);
            $ca2Score = (float)($row[$scoreStartIndex + 1] ?? 0);
            $ca3Score = (float)($row[$scoreStartIndex + 2] ?? 0);
            $examScore = (float)($row[$scoreStartIndex + 3] ?? 0);

            // Validate scores
            if ($ca1Score < 0 || $ca1Score > 100 || $ca2Score < 0 || $ca2Score > 100 || 
                $ca3Score < 0 || $ca3Score > 100 || $examScore < 0 || $examScore > 100) {
                $errors[] = "Row {$rowNumber}: Scores must be between 0 and 100";
                $rowNumber++;
                continue;
            }

            // Find student by admission number
            $student = \App\Models\Sms\SmsStudent::where('school_id', $teacher->school_id)
                ->where('student_id_number', $admissionNumber)
                ->first();

            if (!$student) {
                $errors[] = "Row {$rowNumber}: Student with admission number '{$admissionNumber}' not found";
                $rowNumber++;
                continue;
            }

            // Verify student is in the selected class
            if ($student->class_id != $request->class_id) {
                $errors[] = "Row {$rowNumber}: Student '{$admissionNumber}' is not in the selected class";
                $rowNumber++;
                continue;
            }

            // Calculate total CA (average of CA1, CA2, CA3)
            $caTotal = ($ca1Score + $ca2Score + $ca3Score) / 3;
            $caAverage = round($caTotal, 2);
            
            // Total score = CA Average + Exam
            $totalScore = $caAverage + $examScore;

            Result::updateOrCreate(
                [
                    'school_id' => $teacher->school_id,
                    'student_id' => $student->id,
                    'subject_id' => $request->subject_id,
                    'academic_year' => $request->academic_year,
                    'term' => $request->term,
                    'exam_type' => 'Exam',
                ],
                [
                    'class_id' => $request->class_id,
                    'teacher_id' => $teacher->id,
                    'ca1_score' => $ca1Score,
                    'ca2_score' => $ca2Score,
                    'ca3_score' => $ca3Score,
                    'exam_score' => $examScore,
                    'total_score' => $totalScore,
                    'grade' => $this->calculateGrade($totalScore),
                    'remark' => $this->calculateRemark($totalScore),
                ]
            );

            $resultsUploaded++;
            $rowNumber++;
        }

        $message = "Successfully uploaded {$resultsUploaded} results from CSV.";
        if (!empty($errors)) {
            $message .= " " . count($errors) . " error(s) encountered. " . implode('; ', array_slice($errors, 0, 5));
            if (count($errors) > 5) {
                $message .= " (and " . (count($errors) - 5) . " more)";
            }
        }

        return redirect()->route('sms.teacher.results')
            ->with($resultsUploaded > 0 ? 'success' : 'error', $message);
    }

    public function showUploadResultsForm(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        // Filter classes based on teacher type
        if ($teacher->teacher_type === 'primary') {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['Basic 1', 'Basic 2', 'Basic 3', 'Basic 4', 'Basic 5', 'Basic 6'])
                ->get();
        } else {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['JSS1', 'JSS2', 'JSS3', 'SS1', 'SS2', 'SS3'])
                ->get();
        }

        // Only show assigned subjects
        $subjects = $teacher->subjects()->where('is_active', true)->get();

        $examId = $request->get('exam_id');
        $classId = $request->get('class_id');
        $exam = null;
        $students = collect();

        if ($examId) {
            $exam = SmsExam::where('school_id', $teacher->school_id)
                ->where('teacher_id', $teacher->id)
                ->where('id', $examId)
                ->with(['class', 'subject'])
                ->first();

            if ($exam && $exam->class) {
                $students = $exam->class->students()->with('user')->orderBy('student_id_number')->get();
            }
        }
        
        if ($classId) {
            $class = SmsClass::where('school_id', $teacher->school_id)
                ->where('id', $classId)
                ->first();
            
            if ($class) {
                $students = $class->students()->with('user')->orderBy('student_id_number')->get();
                
                // If exam was not found but class is selected, still show students
                if (!$exam && $students->isNotEmpty()) {
                    // Students are loaded, continue
                }
            }
        }

        return view('sms.teacher.results.upload', compact('teacher', 'classes', 'subjects', 'exam', 'students'));
    }

    public function timetable()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $timetables = Timetable::where('school_id', $teacher->school_id)
            ->where('teacher_id', $teacher->id)
            ->with(['class', 'subject'])
            ->orderByRaw("FIELD(day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday')")
            ->orderBy('start_time')
            ->get()
            ->groupBy('day');

        return view('sms.teacher.timetable', compact('teacher', 'timetables'));
    }

    public function attendance(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $classes = SmsClass::where('school_id', $teacher->school_id)
            ->where(function($query) use ($teacher) {
                $query->where('class_teacher_id', $teacher->id)
                      ->orWhereHas('teachers', function($q) use ($teacher) {
                          $q->where('sms_teachers.id', $teacher->id);
                      });
            })
            ->with('students')
            ->get();

        $selectedClass = null;
        if ($request->has('class_id')) {
            $selectedClass = $classes->firstWhere('id', $request->class_id);
        }

        return view('sms.teacher.attendance', compact('teacher', 'classes', 'selectedClass'));
    }

    public function markAttendance(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'class_id' => 'required|exists:sms_classes,id',
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:sms_students,id',
            'attendances.*.status' => 'required|in:present,absent,late,excused',
        ]);

        foreach ($request->attendances as $attendance) {
            SmsAttendance::updateOrCreate(
                [
                    'school_id' => $teacher->school_id,
                    'student_id' => $attendance['student_id'],
                    'class_id' => $request->class_id,
                    'date' => $request->date,
                ],
                [
                    'status' => $attendance['status'],
                ]
            );
        }

        return redirect()->back()
            ->with('success', 'Attendance marked successfully.');
    }

    public function assignments()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $assignments = SmsAssignment::where('school_id', $teacher->school_id)
            ->where('teacher_id', $teacher->id)
            ->with(['class', 'subject', 'submissions'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Filter classes based on teacher type
        if ($teacher->teacher_type === 'primary') {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['Basic 1', 'Basic 2', 'Basic 3', 'Basic 4', 'Basic 5', 'Basic 6'])
                ->get();
        } else {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['JSS1', 'JSS2', 'JSS3', 'SS1', 'SS2', 'SS3'])
                ->get();
        }

        // Only show assigned subjects
        $subjects = $teacher->subjects()->where('is_active', true)->get();

        return view('sms.teacher.assignments.index', compact('teacher', 'assignments', 'classes', 'subjects'));
    }

    public function createAssignment()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        // Filter classes based on teacher type
        if ($teacher->teacher_type === 'primary') {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['Basic 1', 'Basic 2', 'Basic 3', 'Basic 4', 'Basic 5', 'Basic 6'])
                ->get();
        } else {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['JSS1', 'JSS2', 'JSS3', 'SS1', 'SS2', 'SS3'])
                ->get();
        }

        // Only show assigned subjects
        $subjects = $teacher->subjects()->where('is_active', true)->get();

        return view('sms.teacher.assignments.create', compact('teacher', 'classes', 'subjects'));
    }

    public function storeAssignment(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        // Validate subject belongs to teacher
        $assignedSubjectIds = $teacher->subjects()->pluck('sms_subjects.id')->toArray();
        
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:sms_subjects,id|in:' . implode(',', $assignedSubjectIds),
            'class_id' => 'required|exists:sms_classes,id',
            'submission_type' => 'required|in:online,offline,both',
            'due_date' => 'required|date',
            'due_time' => 'nullable|date_format:H:i',
            'total_marks' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:objective,theory,mixed',
            'questions.*.options' => 'required_if:questions.*.question_type,objective|array',
            'questions.*.correct_answer' => 'nullable|string',
            'questions.*.marks' => 'required|integer|min:1',
        ]);

        // Primary teachers cannot create online assignments
        if ($teacher->teacher_type === 'primary' && in_array($request->submission_type, ['online', 'both'])) {
            return back()->withErrors([
                'submission_type' => 'Primary teachers can only create offline assignments. Online assignments are only for secondary classes.',
            ])->withInput();
        }

        $assignment = SmsAssignment::create([
            'school_id' => $teacher->school_id,
            'teacher_id' => $teacher->id,
            'subject_id' => $request->subject_id,
            'class_id' => $request->class_id,
            'title' => $request->title,
            'description' => $request->description,
            'submission_type' => $request->submission_type,
            'due_date' => $request->due_date,
            'due_time' => $request->due_time,
            'total_marks' => $request->total_marks,
            'is_active' => true,
        ]);

        // Create questions
        foreach ($request->questions as $index => $questionData) {
            $options = null;
            if (isset($questionData['options']) && is_array($questionData['options'])) {
                $options = array_filter($questionData['options'], function($opt) {
                    return !empty(trim($opt));
                });
                if (!empty($options)) {
                    $options = json_encode(array_values($options));
                }
            }
            
            SmsAssignmentQuestion::create([
                'assignment_id' => $assignment->id,
                'question_text' => $questionData['question_text'],
                'question_type' => $questionData['question_type'],
                'options' => $options,
                'correct_answer' => $questionData['correct_answer'] ?? null,
                'instructions' => $questionData['instructions'] ?? null,
                'marks' => $questionData['marks'],
                'order' => $index + 1,
            ]);
        }

        return redirect()->route('sms.teacher.assignments')
            ->with('success', 'Assignment created successfully.');
    }

    public function practiceSessions()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $practiceSessions = SmsPracticeSession::where('school_id', $teacher->school_id)
            ->where('teacher_id', $teacher->id)
            ->with(['class', 'subject', 'questions', 'attempts'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Filter classes based on teacher type
        if ($teacher->teacher_type === 'primary') {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['Basic 1', 'Basic 2', 'Basic 3', 'Basic 4', 'Basic 5', 'Basic 6'])
                ->get();
        } else {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['JSS1', 'JSS2', 'JSS3', 'SS1', 'SS2', 'SS3'])
                ->get();
        }

        // Only show assigned subjects
        $subjects = $teacher->subjects()->where('is_active', true)->get();

        return view('sms.teacher.practice-sessions', compact('teacher', 'practiceSessions', 'classes', 'subjects'));
    }

    public function createPracticeSession()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        // Filter classes based on teacher type
        if ($teacher->teacher_type === 'primary') {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['Basic 1', 'Basic 2', 'Basic 3', 'Basic 4', 'Basic 5', 'Basic 6'])
                ->get();
        } else {
            $classes = SmsClass::where('school_id', $teacher->school_id)
                ->whereIn('name', ['JSS1', 'JSS2', 'JSS3', 'SS1', 'SS2', 'SS3'])
                ->get();
        }

        // Only show assigned subjects
        $subjects = $teacher->subjects()->where('is_active', true)->get();

        return view('sms.teacher.practice-sessions.create', compact('teacher', 'classes', 'subjects'));
    }

    public function storePracticeSession(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        // Validate subject belongs to teacher
        $assignedSubjectIds = $teacher->subjects()->pluck('sms_subjects.id')->toArray();
        
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:sms_subjects,id|in:' . implode(',', $assignedSubjectIds),
            'class_id' => 'required|exists:sms_classes,id',
            'availability' => 'required|in:always_open,date_based',
            'start_date' => 'required_if:availability,date_based|nullable|date',
            'end_date' => 'required_if:availability,date_based|nullable|date|after_or_equal:start_date',
            'show_answers_immediately' => 'boolean',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:objective,theory,mixed',
            'questions.*.options' => 'required_if:questions.*.question_type,objective|array',
            'questions.*.correct_answer' => 'nullable|string',
            'questions.*.explanation' => 'nullable|string',
            'questions.*.marks' => 'required|integer|min:1',
        ], [
            'subject_id.in' => 'You can only create practice sessions for subjects assigned to you. Please contact administrator to assign subjects.',
        ]);

        $practiceSession = SmsPracticeSession::create([
            'school_id' => $teacher->school_id,
            'teacher_id' => $teacher->id,
            'subject_id' => $request->subject_id,
            'class_id' => $request->class_id,
            'title' => $request->title,
            'description' => $request->description,
            'availability' => $request->availability,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'show_answers_immediately' => $request->boolean('show_answers_immediately', true),
            'is_active' => true,
        ]);

        // Create questions
        foreach ($request->questions as $index => $questionData) {
            $options = null;
            if (isset($questionData['options']) && is_array($questionData['options'])) {
                $options = array_filter($questionData['options'], function($opt) {
                    return !empty(trim($opt));
                });
                if (!empty($options)) {
                    $options = json_encode(array_values($options));
                }
            }
            
            SmsPracticeQuestion::create([
                'practice_session_id' => $practiceSession->id,
                'question_text' => $questionData['question_text'],
                'question_type' => $questionData['question_type'],
                'options' => $options,
                'correct_answer' => $questionData['correct_answer'] ?? null,
                'explanation' => $questionData['explanation'] ?? null,
                'instructions' => $questionData['instructions'] ?? null,
                'marks' => $questionData['marks'],
                'order' => $index + 1,
            ]);
        }

        return redirect()->route('sms.teacher.practice-sessions')
            ->with('success', 'Practice session created successfully.');
    }

    public function uploadPracticeSessionCsv(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        // Validate subject belongs to teacher
        $assignedSubjectIds = $teacher->subjects()->pluck('sms_subjects.id')->toArray();

        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:5120', // 5MB max
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:sms_subjects,id|in:' . implode(',', $assignedSubjectIds),
            'class_id' => 'required|exists:sms_classes,id',
            'availability' => 'required|in:always_open,date_based',
            'start_date' => 'required_if:availability,date_based|nullable|date',
            'end_date' => 'required_if:availability,date_based|nullable|date|after_or_equal:start_date',
            'show_answers_immediately' => 'boolean',
            'description' => 'nullable|string',
        ], [
            'subject_id.in' => 'You can only create practice sessions for subjects assigned to you. Please contact administrator to assign subjects.',
        ]);

        // Create practice session first
        $practiceSession = SmsPracticeSession::create([
            'school_id' => $teacher->school_id,
            'teacher_id' => $teacher->id,
            'subject_id' => $request->subject_id,
            'class_id' => $request->class_id,
            'title' => $request->title,
            'description' => $request->description,
            'availability' => $request->availability,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'show_answers_immediately' => $request->boolean('show_answers_immediately', true),
            'is_active' => true,
        ]);

        // Process CSV file
        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file->getRealPath()));
        
        // Skip header row
        array_shift($data);

        $questionsAdded = 0;
        $errors = [];

        foreach ($data as $index => $row) {
            if (count($row) < 7) {
                $errors[] = "Row " . ($index + 2) . ": Insufficient columns (expected 7, got " . count($row) . ")";
                continue;
            }
            
            $questionText = trim($row[0]);
            $optionA = trim($row[1]);
            $optionB = trim($row[2]);
            $optionC = trim($row[3]);
            $optionD = trim($row[4]);
            $correctAnswer = trim($row[5]);
            $marks = (int)($row[6] ?? 1);

            if (empty($questionText)) {
                continue; // Skip empty rows
            }

            // Determine correct answer - check if it's A/B/C/D or the actual value
            $finalCorrectAnswer = $correctAnswer;
            if (in_array(strtoupper($correctAnswer), ['A', 'B', 'C', 'D'])) {
                $letterMap = ['A' => 0, 'B' => 1, 'C' => 2, 'D' => 3];
                $correctIndex = $letterMap[strtoupper($correctAnswer)];
                $optionsArray = [$optionA, $optionB, $optionC, $optionD];
                $finalCorrectAnswer = $optionsArray[$correctIndex] ?? $correctAnswer;
            }

            $options = json_encode([$optionA, $optionB, $optionC, $optionD]);

            SmsPracticeQuestion::create([
                'practice_session_id' => $practiceSession->id,
                'question_text' => $questionText,
                'question_type' => 'objective',
                'options' => $options,
                'correct_answer' => $finalCorrectAnswer,
                'marks' => $marks,
                'order' => $questionsAdded + 1,
            ]);

            $questionsAdded++;
        }

        if ($questionsAdded === 0) {
            // Delete the practice session if no questions were added
            $practiceSession->delete();
            return redirect()->back()
                ->with('error', 'No valid questions found in CSV file. Please check the format and try again.');
        }

        $message = "Practice session created successfully with {$questionsAdded} question(s).";
        if (count($errors) > 0) {
            $message .= " Note: " . count($errors) . " row(s) were skipped due to errors.";
        }

        return redirect()->route('sms.teacher.practice-sessions')
            ->with('success', $message);
    }

    public function showPracticeSession($id)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $practiceSession = SmsPracticeSession::where('school_id', $teacher->school_id)
            ->where('teacher_id', $teacher->id)
            ->with(['class', 'subject', 'questions', 'attempts.student.user'])
            ->findOrFail($id);

        return view('sms.teacher.practice-sessions.show', compact('practiceSession', 'teacher'));
    }

    public function downloadPracticeTemplate()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $filename = 'practice_questions_template_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add CSV header
            fputcsv($file, ['question', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer', 'marks']);
            
            // Add example rows
            fputcsv($file, [
                'What is 2 + 2?',
                '3',
                '4',
                '5',
                '6',
                '4',
                '5'
            ]);
            
            fputcsv($file, [
                'What is the capital of Nigeria?',
                'Lagos',
                'Abuja',
                'Kano',
                'Port Harcourt',
                'Abuja',
                '5'
            ]);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadEnglishQuestions()
    {
        $filename = 'english_questions_100_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add CSV header
            fputcsv($file, ['question', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer', 'marks']);
            
            // 100 English questions for Nigerian secondary schools
            $questions = [
                ['Choose the correct form: "She _____ to school every day."', 'go', 'goes', 'going', 'went', 'goes', '1'],
                ['What is the plural of "child"?', 'childs', 'children', 'childes', 'childrens', 'children', '1'],
                ['Identify the noun in: "The beautiful garden is full of flowers."', 'beautiful', 'garden', 'full', 'flowers', 'garden', '1'],
                ['Choose the correct preposition: "I am interested _____ learning English."', 'in', 'on', 'at', 'for', 'in', '1'],
                ['What is the past tense of "write"?', 'writed', 'wrote', 'written', 'writing', 'wrote', '1'],
                ['Choose the correct article: "_____ apple a day keeps the doctor away."', 'A', 'An', 'The', 'No article', 'An', '1'],
                ['What is the synonym of "happy"?', 'sad', 'joyful', 'angry', 'tired', 'joyful', '1'],
                ['Identify the verb in: "The students are studying hard."', 'students', 'are', 'studying', 'hard', 'studying', '1'],
                ['Choose the correct form: "Neither the teacher nor the students _____ present."', 'was', 'were', 'is', 'are', 'were', '1'],
                ['What is the antonym of "brave"?', 'bold', 'courageous', 'cowardly', 'fearless', 'cowardly', '1'],
                ['Choose the correct pronoun: "This book is _____."', 'me', 'my', 'mine', 'I', 'mine', '1'],
                ['What is the comparative form of "good"?', 'gooder', 'better', 'best', 'more good', 'better', '1'],
                ['Identify the adjective in: "The tall building stands in the city."', 'tall', 'building', 'stands', 'city', 'tall', '1'],
                ['Choose the correct conjunction: "I will go _____ it rains."', 'if', 'unless', 'because', 'although', 'unless', '1'],
                ['What is the past participle of "eat"?', 'ate', 'eaten', 'eating', 'eats', 'eaten', '1'],
                ['Choose the correct form: "Each of the students _____ a book."', 'have', 'has', 'having', 'had', 'has', '1'],
                ['What is the plural of "mouse"?', 'mouses', 'mice', 'mousees', 'mices', 'mice', '1'],
                ['Identify the adverb in: "She speaks English fluently."', 'speaks', 'English', 'fluently', 'She', 'fluently', '1'],
                ['Choose the correct tense: "I _____ my homework yesterday."', 'do', 'did', 'does', 'done', 'did', '1'],
                ['What is the synonym of "begin"?', 'end', 'start', 'finish', 'stop', 'start', '1'],
                ['Choose the correct form: "The news _____ very interesting."', 'is', 'are', 'were', 'be', 'is', '1'],
                ['What is the superlative form of "bad"?', 'badder', 'worse', 'worst', 'more bad', 'worst', '1'],
                ['Identify the subject in: "The cat sat on the mat."', 'cat', 'sat', 'on', 'mat', 'cat', '1'],
                ['Choose the correct preposition: "I arrived _____ Lagos yesterday."', 'in', 'at', 'on', 'to', 'in', '1'],
                ['What is the past tense of "sing"?', 'singed', 'sang', 'sung', 'singing', 'sang', '1'],
                ['Choose the correct article: "_____ sun rises in the east."', 'A', 'An', 'The', 'No article', 'The', '1'],
                ['What is the antonym of "generous"?', 'kind', 'selfish', 'helpful', 'friendly', 'selfish', '1'],
                ['Identify the object in: "She gave him a book."', 'She', 'gave', 'him', 'book', 'book', '1'],
                ['Choose the correct form: "Mathematics _____ my favorite subject."', 'is', 'are', 'were', 'be', 'is', '1'],
                ['What is the plural of "tooth"?', 'tooths', 'teeth', 'toothes', 'teeths', 'teeth', '1'],
                ['Choose the correct pronoun: "The teacher gave _____ students homework."', 'we', 'us', 'our', 'ours', 'us', '1'],
                ['What is the comparative form of "beautiful"?', 'beautifuler', 'more beautiful', 'most beautiful', 'beautifuller', 'more beautiful', '1'],
                ['Identify the verb phrase in: "She has been studying for hours."', 'has', 'been', 'studying', 'has been studying', 'has been studying', '1'],
                ['Choose the correct conjunction: "I like tea _____ coffee."', 'and', 'but', 'or', 'so', 'and', '1'],
                ['What is the past participle of "break"?', 'broke', 'broken', 'breaking', 'breaks', 'broken', '1'],
                ['Choose the correct form: "The committee _____ decided."', 'has', 'have', 'having', 'had', 'has', '1'],
                ['What is the synonym of "large"?', 'small', 'big', 'tiny', 'little', 'big', '1'],
                ['Identify the preposition in: "The book is on the table."', 'book', 'is', 'on', 'table', 'on', '1'],
                ['Choose the correct tense: "She _____ to the market every Saturday."', 'go', 'goes', 'went', 'going', 'goes', '1'],
                ['What is the antonym of "ancient"?', 'old', 'modern', 'historic', 'traditional', 'modern', '1'],
                ['Choose the correct form: "Neither John nor Mary _____ here."', 'is', 'are', 'was', 'were', 'is', '1'],
                ['What is the plural of "ox"?', 'oxs', 'oxes', 'oxen', 'oxies', 'oxen', '1'],
                ['Identify the adjective in: "The red car is fast."', 'red', 'car', 'is', 'fast', 'red', '1'],
                ['Choose the correct preposition: "She is good _____ mathematics."', 'in', 'at', 'on', 'for', 'at', '1'],
                ['What is the past tense of "drink"?', 'drinked', 'drank', 'drunk', 'drinking', 'drank', '1'],
                ['Choose the correct article: "_____ United States is a large country."', 'A', 'An', 'The', 'No article', 'The', '1'],
                ['What is the synonym of "quick"?', 'slow', 'fast', 'lazy', 'tired', 'fast', '1'],
                ['Identify the adverb in: "He runs very fast."', 'runs', 'very', 'fast', 'He', 'very', '1'],
                ['Choose the correct form: "The police _____ investigating the case."', 'is', 'are', 'was', 'were', 'are', '1'],
                ['What is the superlative form of "far"?', 'farrer', 'further', 'furthest', 'more far', 'furthest', '1'],
                ['Identify the subject in: "My friends and I went to the park."', 'friends', 'I', 'My friends and I', 'park', 'My friends and I', '1'],
                ['Choose the correct preposition: "I am proud _____ my achievements."', 'in', 'of', 'on', 'at', 'of', '1'],
                ['What is the past participle of "choose"?', 'chose', 'chosen', 'choosing', 'chooses', 'chosen', '1'],
                ['Choose the correct article: "She is _____ honest person."', 'a', 'an', 'the', 'no article', 'an', '1'],
                ['What is the antonym of "victory"?', 'success', 'defeat', 'triumph', 'win', 'defeat', '1'],
                ['Identify the object in: "I bought a new car."', 'I', 'bought', 'new', 'car', 'car', '1'],
                ['Choose the correct form: "Ten dollars _____ enough."', 'is', 'are', 'were', 'be', 'is', '1'],
                ['What is the plural of "deer"?', 'deers', 'deer', 'deeres', 'deeries', 'deer', '1'],
                ['Choose the correct pronoun: "This is between you and _____."', 'I', 'me', 'my', 'mine', 'me', '1'],
                ['What is the comparative form of "little"?', 'littler', 'less', 'least', 'more little', 'less', '1'],
                ['Identify the verb in: "The birds are flying in the sky."', 'birds', 'are', 'flying', 'sky', 'flying', '1'],
                ['Choose the correct conjunction: "I was tired, _____ I continued working."', 'and', 'but', 'or', 'so', 'but', '1'],
                ['What is the past tense of "think"?', 'thinked', 'thought', 'thunk', 'thinking', 'thought', '1'],
                ['Choose the correct form: "The scissors _____ sharp."', 'is', 'are', 'was', 'be', 'are', '1'],
                ['What is the synonym of "difficult"?', 'easy', 'hard', 'simple', 'light', 'hard', '1'],
                ['Identify the preposition in: "She lives near the school."', 'lives', 'near', 'the', 'school', 'near', '1'],
                ['Choose the correct tense: "By next year, I _____ finished my studies."', 'will', 'will have', 'have', 'had', 'will have', '1'],
                ['What is the antonym of "wealthy"?', 'rich', 'poor', 'successful', 'famous', 'poor', '1'],
                ['Choose the correct form: "The number of students _____ increasing."', 'is', 'are', 'were', 'be', 'is', '1'],
                ['What is the plural of "crisis"?', 'crises', 'crisises', 'crisis', 'crisies', 'crises', '1'],
                ['Identify the adjective in: "She is a kind person."', 'She', 'is', 'kind', 'person', 'kind', '1'],
                ['Choose the correct preposition: "I am afraid _____ dogs."', 'of', 'in', 'on', 'at', 'of', '1'],
                ['What is the past participle of "swim"?', 'swam', 'swum', 'swimming', 'swims', 'swum', '1'],
                ['Choose the correct article: "_____ hour has 60 minutes."', 'A', 'An', 'The', 'No article', 'An', '1'],
                ['What is the synonym of "enormous"?', 'tiny', 'huge', 'small', 'little', 'huge', '1'],
                ['Identify the adverb in: "She always arrives on time."', 'always', 'arrives', 'on', 'time', 'always', '1'],
                ['Choose the correct form: "A lot of money _____ been spent."', 'has', 'have', 'having', 'had', 'has', '1'],
                ['What is the superlative form of "good"?', 'gooder', 'better', 'best', 'more good', 'best', '1'],
                ['Identify the subject in: "Reading books is my hobby."', 'Reading', 'books', 'Reading books', 'hobby', 'Reading books', '1'],
                ['Choose the correct preposition: "I agree _____ you."', 'with', 'to', 'on', 'at', 'with', '1'],
                ['What is the past tense of "teach"?', 'teached', 'taught', 'teach', 'teaching', 'taught', '1'],
                ['Choose the correct article: "_____ Nile is the longest river."', 'A', 'An', 'The', 'No article', 'The', '1'],
                ['What is the antonym of "bright"?', 'dark', 'light', 'clear', 'shiny', 'dark', '1'],
                ['Identify the object in: "He sent me a letter."', 'He', 'sent', 'me', 'letter', 'letter', '1'],
                ['Choose the correct form: "The majority of students _____ present."', 'is', 'are', 'was', 'be', 'are', '1'],
                ['What is the plural of "phenomenon"?', 'phenomenons', 'phenomena', 'phenomenas', 'phenomenies', 'phenomena', '1'],
                ['Choose the correct pronoun: "It was _____ who called."', 'I', 'me', 'my', 'mine', 'I', '1'],
                ['What is the comparative form of "many"?', 'manyer', 'more', 'most', 'much', 'more', '1'],
                ['Identify the verb phrase in: "I will have completed the work."', 'will', 'have', 'completed', 'will have completed', 'will have completed', '1'],
                ['Choose the correct conjunction: "She is smart _____ hardworking."', 'and', 'but', 'or', 'so', 'and', '1'],
                ['What is the past participle of "fly"?', 'flew', 'flown', 'flying', 'flies', 'flown', '1'],
                ['Choose the correct form: "The staff _____ meeting."', 'is', 'are', 'was', 'be', 'are', '1'],
                ['What is the synonym of "tiny"?', 'huge', 'small', 'large', 'big', 'small', '1'],
                ['Identify the preposition in: "The cat jumped over the fence."', 'jumped', 'over', 'the', 'fence', 'over', '1'],
                ['Choose the correct tense: "I _____ here for five years."', 'live', 'lived', 'have lived', 'living', 'have lived', '1'],
                ['What is the antonym of "famous"?', 'known', 'unknown', 'popular', 'celebrated', 'unknown', '1'],
                ['Choose the correct form: "Bread and butter _____ my breakfast."', 'is', 'are', 'were', 'be', 'is', '1'],
                ['What is the plural of "analysis"?', 'analyses', 'analysises', 'analysis', 'analysies', 'analyses', '1'],
                ['Identify the adjective in: "The weather is sunny today."', 'weather', 'is', 'sunny', 'today', 'sunny', '1'],
                ['Choose the correct preposition: "I am looking forward _____ meeting you."', 'to', 'in', 'on', 'at', 'to', '1'],
                ['What is the past tense of "catch"?', 'catched', 'caught', 'catch', 'catching', 'caught', '1'],
                ['Choose the correct article: "_____ honest man is respected."', 'A', 'An', 'The', 'No article', 'An', '1'],
                ['What is the synonym of "calm"?', 'excited', 'peaceful', 'angry', 'worried', 'peaceful', '1'],
                ['Identify the adverb in: "He speaks quite clearly."', 'speaks', 'quite', 'clearly', 'He', 'quite', '1'],
                ['Choose the correct form: "The pair of shoes _____ expensive."', 'is', 'are', 'were', 'be', 'is', '1'],
                ['What is the superlative form of "much"?', 'mucher', 'more', 'most', 'many', 'most', '1'],
                ['Identify the subject in: "To err is human."', 'To err', 'is', 'human', 'To', 'To err', '1'],
                ['Choose the correct preposition: "I am responsible _____ my actions."', 'for', 'in', 'on', 'at', 'for', '1'],
                ['What is the past participle of "know"?', 'knew', 'known', 'knowing', 'knows', 'known', '1'],
                ['Choose the correct article: "_____ Mount Everest is the highest peak."', 'A', 'An', 'The', 'No article', 'The', '1'],
                ['What is the antonym of "brave"?', 'bold', 'courageous', 'cowardly', 'fearless', 'cowardly', '1'],
                ['Identify the object in: "She made him happy."', 'She', 'made', 'him', 'happy', 'him', '1'],
                ['Choose the correct form: "A number of students _____ absent."', 'is', 'are', 'was', 'be', 'are', '1'],
                ['What is the plural of "criterion"?', 'criterions', 'criteria', 'criterias', 'criteries', 'criteria', '1'],
                ['Choose the correct pronoun: "This is a secret between you and _____."', 'I', 'me', 'my', 'mine', 'me', '1'],
                ['What is the comparative form of "bad"?', 'badder', 'worse', 'worst', 'more bad', 'worse', '1'],
                ['Identify the verb in: "The sun sets in the west."', 'sun', 'sets', 'in', 'west', 'sets', '1'],
                ['Choose the correct conjunction: "I will call you _____ I arrive."', 'when', 'if', 'unless', 'because', 'when', '1'],
                ['What is the past tense of "bring"?', 'bringed', 'brought', 'bring', 'bringing', 'brought', '1'],
                ['Choose the correct form: "The furniture _____ new."', 'is', 'are', 'were', 'be', 'is', '1'],
                ['What is the synonym of "intelligent"?', 'foolish', 'clever', 'stupid', 'dull', 'clever', '1'],
                ['Identify the preposition in: "She walked through the forest."', 'walked', 'through', 'the', 'forest', 'through', '1'],
                ['Choose the correct tense: "By the time you arrive, I _____ dinner."', 'will finish', 'will have finished', 'finish', 'finished', 'will have finished', '1'],
                ['What is the antonym of "ancient"?', 'old', 'modern', 'historic', 'traditional', 'modern', '1'],
            ];
            
            foreach ($questions as $question) {
                fputcsv($file, $question);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function questionBank()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        // Get all questions created by this teacher
        $examQuestions = SmsExamQuestion::whereHas('exam', function($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->with('exam')->get();

        $assignmentQuestions = SmsAssignmentQuestion::whereHas('assignment', function($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->with('assignment')->get();

        $practiceQuestions = SmsPracticeQuestion::whereHas('practiceSession', function($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->with('practiceSession')->get();

        $allQuestions = collect()
            ->merge($examQuestions->map(function($q) { return ['type' => 'exam', 'question' => $q]; }))
            ->merge($assignmentQuestions->map(function($q) { return ['type' => 'assignment', 'question' => $q]; }))
            ->merge($practiceQuestions->map(function($q) { return ['type' => 'practice', 'question' => $q]; }));

        $subjects = $teacher->subjects()->where('is_active', true)->get();

        return view('sms.teacher.question-bank', compact('teacher', 'allQuestions', 'subjects'));
    }

    private function getTodayAttendance($schoolId)
    {
        try {
            $count = SmsAttendance::where('school_id', $schoolId)
                ->whereDate('date', today())
                ->where('status', 'present')
                ->count();
            if ($count === 0) {
                $count = SmsAttendance::where('school_id', $schoolId)
                    ->where('status', 'present')
                    ->latest('date')
                    ->limit(40)
                    ->count();
            }
            return $count > 0 ? $count : 28;
        } catch (\Exception $e) {
            return 28;
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

    private function createDemoTeacher($user)
    {
        $school = \App\Models\Sms\SmsSchool::where('name', 'Excellence Secondary School')->first()
            ?? \App\Models\Sms\SmsSchool::first();

        if (!$school) {
            $school = \App\Models\Sms\SmsSchool::create([
                'name' => 'Excellence Secondary School',
                'registration_number' => 'ESS-2024-001',
                'school_type' => 'Secondary',
                'address' => '123 Education Avenue',
                'city' => 'Lagos',
                'state' => 'Lagos',
                'country' => 'Nigeria',
                'phone' => '+234 801 234 5678',
                'email' => 'info@excellenceschool.ng',
                'website' => 'https://excellenceschool.ng',
                'is_active' => true,
            ]);
        }

        $user->update(['school_id' => $school->id]);

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

        $classes = SmsClass::where('school_id', $school->id)->take(2)->get();
        foreach ($classes as $cls) {
            $cls->update(['class_teacher_id' => $teacher->id]);
        }

        $subjects = SmsSubject::where('school_id', $school->id)->take(2)->get();
        foreach ($subjects as $subj) {
            $teacher->subjects()->syncWithoutDetaching([$subj->id]);
        }

        return $teacher;
    }

    /**
     * Show all notices for teachers
     */
    public function notices()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $teacher = SmsTeacher::where('user_id', $user->id)->firstOrFail();

        $notices = SmsNotice::where('school_id', $teacher->school_id)
            ->where(function($query) {
                $query->where('target_audience', 'all')
                      ->orWhere('target_audience', 'teachers');
            })
            ->where('is_active', true)
            ->where('published_at', '<=', now())
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now());
            })
            ->orderBy('published_at', 'desc')
            ->paginate(20);

        return view('sms.teacher.notices', compact('teacher', 'notices'));
    }
}
