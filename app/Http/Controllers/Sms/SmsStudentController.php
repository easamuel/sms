<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\Sms\SmsStudent;
use App\Models\Sms\SmsAttendance;
use App\Models\Sms\SmsExam;
use App\Models\Sms\SmsExamResult;
use App\Models\Sms\SmsFee;
use App\Models\Sms\SmsFeePayment;
use App\Models\Sms\SmsNotice;
use App\Models\Sms\SmsPracticeSession;
use App\Models\Sms\SmsPracticeAttempt;
use App\Models\Sms\Result;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SmsStudentController extends Controller
{
    public function dashboard()
    {
        // Get SMS user from session (not LearnersCom auth)
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
        
        // CRITICAL: Verify session role matches user's actual role in database
        $sessionRole = session('sms_role');
        if ($sessionRole && $sessionRole !== $user->role) {
            \Log::warning('Session role mismatch with database role in student dashboard', [
                'user_id' => $user->id,
                'session_role' => $sessionRole,
                'database_role' => $user->role,
                'parent_viewing' => session('parent_viewing'),
            ]);
            
            // If viewing as parent, restore parent session
            if (session('parent_viewing')) {
                $parentInfo = session('parent_session_info');
                if ($parentInfo) {
                    $parentUser = \App\Models\Sms\SmsUser::find($parentInfo['parent_user_id']);
                    if ($parentUser && $parentUser->role === 'parent') {
                        session([
                            'sms_user_id' => $parentInfo['parent_user_id'],
                            'sms_role' => 'parent',
                            'sms_user' => $parentUser,
                            'parent_viewing' => false,
                            'parent_session_info' => null,
                        ]);
                        return redirect()->route('sms.parent.dashboard')
                            ->with('error', 'Session verification failed. Redirected to parent dashboard.');
                    }
                }
            }
            
            // Update session to match database role
            session(['sms_role' => $user->role]);
        }
        
        // Get SMS student profile
        $student = SmsStudent::where('user_id', $user->id)->first();
        
        // CRITICAL: If viewing as parent, DO NOT create demo student - return error instead
        if (!$student) {
            if (session('parent_viewing')) {
                // Parent is viewing child - child must exist, don't create demo
                \Log::error('Parent viewing child but student profile not found', [
                    'user_id' => $user->id,
                    'user_role' => $user->role,
                    'parent_session_info' => session('parent_session_info'),
                ]);
                
                // Restore parent session and redirect back
                $parentInfo = session('parent_session_info');
                if ($parentInfo) {
                    $parentUser = \App\Models\Sms\SmsUser::find($parentInfo['parent_user_id']);
                    if ($parentUser) {
                        session([
                            'sms_user_id' => $parentInfo['parent_user_id'],
                            'sms_role' => 'parent',
                            'sms_user' => $parentUser,
                            'parent_viewing' => false,
                        ]);
                        return redirect()->route('sms.parent.dashboard')
                            ->with('error', 'Child account not properly set up. Please contact administrator.');
                    }
                }
                
                return redirect()->route('school-management.demo-login')
                    ->with('error', 'Session error. Please login again.');
            }
            
            // Only create demo student if NOT viewing as parent
            $student = $this->createDemoStudent($user);
        }
        
        // CRITICAL: Verify user role is actually 'student'
        if ($user->role !== 'student') {
            \Log::error('Non-student user attempted to access student dashboard', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'session_role' => session('sms_role'),
                'parent_viewing' => session('parent_viewing'),
            ]);
            
            if (session('parent_viewing')) {
                // Restore parent session
                $parentInfo = session('parent_session_info');
                if ($parentInfo) {
                    $parentUser = \App\Models\Sms\SmsUser::find($parentInfo['parent_user_id']);
                    if ($parentUser && $parentUser->role === 'parent') {
                        session([
                            'sms_user_id' => $parentInfo['parent_user_id'],
                            'sms_role' => 'parent',
                            'sms_user' => $parentUser,
                            'parent_viewing' => false,
                            'parent_session_info' => null,
                        ]);
                        return redirect()->route('sms.parent.dashboard')
                            ->with('error', 'Child account has incorrect role. Redirected to parent dashboard.');
                    }
                }
            }
            
            // Clear session and redirect
            session()->forget(['sms_user_id', 'sms_role', 'sms_user', 'parent_viewing', 'parent_session_info']);
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Access denied. Your account is not registered as a student.');
        }
        
        // CRITICAL: Verify the student's user_id matches the session user_id
        if ($student->user_id !== $user->id) {
            \Log::error('Student user_id mismatch', [
                'session_user_id' => $user->id,
                'student_user_id' => $student->user_id,
                'student_id' => $student->id,
                'parent_viewing' => session('parent_viewing'),
                'parent_session_info' => session('parent_session_info'),
            ]);
            
            if (session('parent_viewing')) {
                // Restore parent session
                $parentInfo = session('parent_session_info');
                if ($parentInfo) {
                    $parentUser = \App\Models\Sms\SmsUser::find($parentInfo['parent_user_id']);
                    if ($parentUser && $parentUser->role === 'parent') {
                        session([
                            'sms_user_id' => $parentInfo['parent_user_id'],
                            'sms_role' => 'parent',
                            'sms_user' => $parentUser,
                            'parent_viewing' => false,
                            'parent_session_info' => null,
                        ]);
                        return redirect()->route('sms.parent.dashboard')
                            ->with('error', 'Account verification failed. Redirected to parent dashboard.');
                    }
                }
            }
            
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Account verification failed. Please login again.');
        }
        
        // CRITICAL: Additional validation - ensure student belongs to correct school if viewing as parent
        if (session('parent_viewing')) {
            $parentInfo = session('parent_session_info');
            if ($parentInfo) {
                $parent = \App\Models\Sms\SmsParent::find($parentInfo['parent_id']);
                if ($parent && $student->school_id !== $parent->school_id) {
                    \Log::error('Student school_id mismatch when viewing as parent', [
                        'parent_id' => $parent->id,
                        'parent_school_id' => $parent->school_id,
                        'student_id' => $student->id,
                        'student_school_id' => $student->school_id,
                    ]);
                    
                    // Restore parent session
                    $parentUser = \App\Models\Sms\SmsUser::find($parentInfo['parent_user_id']);
                    if ($parentUser) {
                        session([
                            'sms_user_id' => $parentInfo['parent_user_id'],
                            'sms_role' => 'parent',
                            'sms_user' => $parentUser,
                            'parent_viewing' => false,
                            'parent_session_info' => null,
                        ]);
                        return redirect()->route('sms.parent.dashboard')
                            ->with('error', 'Security check failed. Redirected to parent dashboard.');
                    }
                }
            }
        }

        $schoolId = $student->school_id;
        $classId = $student->class_id;

        // Get statistics (summary only)
        $attendanceSummary = $this->getAttendanceSummary($student->id);
        $feeStatus = $this->checkFeeStatus($student->id);
        
        $stats = [
            'attendance_rate' => $attendanceSummary['percentage'],
            'pending_fees' => $feeStatus['balance'],
        ];

        // Get club/position (demo data - can be expanded later)
        $clubPosition = $this->getClubPosition($student->id);

        // Get latest notice (single, not list)
        $latestNotice = SmsNotice::where('school_id', $schoolId)
            ->where(function($query) {
                $query->where('target_audience', 'all')
                      ->orWhere('target_audience', 'students');
            })
            ->where('is_active', true)
            ->where('published_at', '<=', now())
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now());
            })
            ->orderBy('published_at', 'desc')
            ->first();

        return view('sms.student.dashboard', compact('student', 'stats', 'attendanceSummary', 'latestNotice', 'clubPosition'));
    }

    public function changePassword(Request $request)
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

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        // Verify current password
        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ])->withInput();
        }

        // Update password
        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->route('sms.student.dashboard')
            ->with('success', 'Password changed successfully.');
    }

    public function attendance()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $student = SmsStudent::where('user_id', $user->id)->firstOrFail();

        $attendances = SmsAttendance::where('student_id', $student->id)
            ->with(['class'])
            ->orderBy('date', 'desc')
            ->paginate(30);

        return view('sms.student.attendance', compact('student', 'attendances'));
    }

    public function exams(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $student = SmsStudent::where('user_id', $user->id)->firstOrFail();

        // Check fee status
        $feeStatus = $this->checkFeeStatus($student->id);

        // Get subjects offered by the student's class
        $subjects = \App\Models\Sms\SmsSubject::where('school_id', $student->school_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        // If subject is selected, show exams for that subject
        $selectedSubjectId = $request->get('subject_id');
        $examsByType = collect();
        $examSessions = collect();

        if ($selectedSubjectId) {
            // Get ONLY Final Examination (Exam type) for this subject and class
            $allExams = SmsExam::where('school_id', $student->school_id)
                ->where('class_id', $student->class_id)
                ->where('subject_id', $selectedSubjectId)
                ->where('exam_type', 'Exam') // Only show Final Examinations
                ->where('is_active', true)
                ->with(['subject', 'class', 'teacher'])
                ->orderBy('scheduled_date', 'asc')
                ->get();

            // Group by exam type (only Exam type now)
            $examsByType = $allExams->groupBy('exam_type');

            // Get exam sessions to check status
            $examSessions = \App\Models\Sms\SmsExamSession::where('student_id', $student->id)
                ->whereIn('exam_id', $allExams->pluck('id'))
                ->get()
                ->keyBy('exam_id');
        }

        return view('sms.student.exams', compact(
            'student', 
            'subjects',
            'selectedSubjectId',
            'examsByType',
            'examSessions', 
            'feeStatus'
        ));
    }

    private function checkFeeStatus($studentId)
    {
        try {
            $student = SmsStudent::find($studentId);
            if (!$student) return ['cleared' => false, 'percentage_paid' => 0];

            $fees = SmsFee::where('school_id', $student->school_id)
                ->where('class_id', $student->class_id)
                ->where('is_active', true)
                ->get();

            $total = $fees->sum('amount');
            $paid = SmsFeePayment::where('student_id', $studentId)->sum('amount_paid');
            
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

    public function results(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $student = SmsStudent::where('user_id', $user->id)->with(['class', 'user', 'school'])->firstOrFail();

        // Ensure demo results exist
        $this->ensureDemoResults($student);

        $academicYear = $request->get('academic_year', date('Y') . '/' . (date('Y') + 1));
        $term = $request->get('term', 'First Term');
        $showReport = $request->has('check_result');

        // Get results from results table
        $results = \App\Models\Sms\Result::where('school_id', $student->school_id)
            ->where('student_id', $student->id)
            ->where('academic_year', $academicYear)
            ->where('term', $term)
            ->with(['subject', 'class'])
            ->get();

        // If showing report, return the report card view
        if ($showReport && $results->count() > 0) {
            // Calculate overall statistics
            $allScores = $results->pluck('total_score')->filter();
            $totalScore = $allScores->sum();
            $average = $allScores->avg() ?? 0;
            
            // Get class size for position calculation
            $classSize = SmsStudent::where('school_id', $student->school_id)
                ->where('class_id', $student->class_id)
                ->count();

            // Calculate position
            $position = 1;
            $classStudents = SmsStudent::where('school_id', $student->school_id)
                ->where('class_id', $student->class_id)
                ->get();
            
            foreach ($classStudents as $classStudent) {
                $studentAvg = \App\Models\Sms\Result::where('school_id', $student->school_id)
                    ->where('student_id', $classStudent->id)
                    ->where('academic_year', $academicYear)
                    ->where('term', $term)
                    ->avg('total_score') ?? 0;
                
                if ($studentAvg > $average) {
                    $position++;
                }
            }

            // Group by term for display
            $resultsByTerm = $results->groupBy('term');

            // Calculate same data for web view
            $totalObtainable = $results->count() * 100;
            $percentage = $totalObtainable > 0 ? ($totalScore / $totalObtainable) * 100 : 0;
            $overallGrade = $this->calculateGradeFromPercentage($percentage);
            $overallRemark = $this->calculateRemarkFromGrade($overallGrade);
            
            $resultsWithClassAvg = $results->map(function($result) use ($student, $academicYear, $term) {
                $classAvg = \App\Models\Sms\Result::where('school_id', $student->school_id)
                    ->where('class_id', $student->class_id)
                    ->where('subject_id', $result->subject_id)
                    ->where('academic_year', $academicYear)
                    ->where('term', $term)
                    ->avg('total_score') ?? 0;
                
                $result->class_average = round($classAvg, 1);
                return $result;
            });

            $termStartDate = $this->getTermStartDate($academicYear, $term);
            $termEndDate = $this->getTermEndDate($academicYear, $term);
            
            $attendances = \App\Models\Sms\SmsAttendance::where('student_id', $student->id)
                ->whereBetween('date', [$termStartDate, $termEndDate])
                ->get();
            
            $totalDays = $attendances->count();
            $presentDays = $attendances->where('status', 'present')->count();
            $absentDays = $totalDays - $presentDays;

            $totalSubjects = $results->count();
            $passedSubjects = $results->filter(function($r) {
                return ($r->total_score ?? 0) >= 50;
            })->count();
            $failedSubjects = $totalSubjects - $passedSubjects;

            $isPdf = false; // Flag for web view
            return view('sms.student.results.report', compact(
                'student', 
                'resultsByTerm', 
                'results',
                'resultsWithClassAvg',
                'academicYear',
                'term',
                'totalScore',
                'totalObtainable',
                'average',
                'percentage',
                'overallGrade',
                'overallRemark',
                'position',
                'classSize',
                'totalDays',
                'presentDays',
                'absentDays',
                'totalSubjects',
                'passedSubjects',
                'failedSubjects',
                'isPdf'
            ));
        }

        // Get available academic years and terms
        $availableYears = \App\Models\Sms\Result::where('school_id', $student->school_id)
            ->where('student_id', $student->id)
            ->distinct()
            ->pluck('academic_year')
            ->sort()
            ->values();

        $availableTerms = \App\Models\Sms\Result::where('school_id', $student->school_id)
            ->where('student_id', $student->id)
            ->distinct()
            ->pluck('term')
            ->sort()
            ->values();

        return view('sms.student.results', compact('student', 'results', 'academicYear', 'term', 'availableYears', 'availableTerms'));
    }

    public function downloadResultPdf(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $student = SmsStudent::where('user_id', $user->id)->with(['class', 'user', 'school'])->firstOrFail();

        $academicYear = $request->get('academic_year', date('Y') . '/' . (date('Y') + 1));
        $term = $request->get('term', 'First Term');

        // Get results
        $results = \App\Models\Sms\Result::where('school_id', $student->school_id)
            ->where('student_id', $student->id)
            ->where('academic_year', $academicYear)
            ->where('term', $term)
            ->with(['subject', 'class'])
            ->get();

        if ($results->isEmpty()) {
            return back()->with('error', 'No results found for the selected year and term.');
        }

        // Calculate statistics
        $allScores = $results->pluck('total_score')->filter();
        $totalScore = $allScores->sum();
        $average = $allScores->avg() ?? 0;
        $totalObtainable = $results->count() * 100; // Assuming 100 is max per subject
        $percentage = $totalObtainable > 0 ? ($totalScore / $totalObtainable) * 100 : 0;
        
        // Calculate grade based on percentage
        $overallGrade = $this->calculateGradeFromPercentage($percentage);
        $overallRemark = $this->calculateRemarkFromGrade($overallGrade);
        
        $classSize = SmsStudent::where('school_id', $student->school_id)
            ->where('class_id', $student->class_id)
            ->count();

        $position = 1;
        $classStudents = SmsStudent::where('school_id', $student->school_id)
            ->where('class_id', $student->class_id)
            ->get();
        
        foreach ($classStudents as $classStudent) {
            $studentAvg = \App\Models\Sms\Result::where('school_id', $student->school_id)
                ->where('student_id', $classStudent->id)
                ->where('academic_year', $academicYear)
                ->where('term', $term)
                ->avg('total_score') ?? 0;
            
            if ($studentAvg > $average) {
                $position++;
            }
        }

        // Calculate class averages for each subject
        $resultsWithClassAvg = $results->map(function($result) use ($student, $academicYear, $term) {
            $classAvg = \App\Models\Sms\Result::where('school_id', $student->school_id)
                ->where('class_id', $student->class_id)
                ->where('subject_id', $result->subject_id)
                ->where('academic_year', $academicYear)
                ->where('term', $term)
                ->avg('total_score') ?? 0;
            
            $result->class_average = round($classAvg, 1);
            return $result;
        });

        // Get attendance data for the term
        $termStartDate = $this->getTermStartDate($academicYear, $term);
        $termEndDate = $this->getTermEndDate($academicYear, $term);
        
        $attendances = \App\Models\Sms\SmsAttendance::where('student_id', $student->id)
            ->whereBetween('date', [$termStartDate, $termEndDate])
            ->get();
        
        $totalDays = $attendances->count();
        $presentDays = $attendances->where('status', 'present')->count();
        $absentDays = $totalDays - $presentDays;

        // Grade analysis
        $totalSubjects = $results->count();
        $passedSubjects = $results->filter(function($r) {
            $score = $r->total_score ?? 0;
            return $score >= 50; // Passing score
        })->count();
        $failedSubjects = $totalSubjects - $passedSubjects;

        $resultsByTerm = $results->groupBy('term');

        // Pass pdf flag to view for proper image path handling
        $isPdf = true; // Flag to indicate this is PDF generation
        $pdf = Pdf::loadView('sms.student.results.report', compact(
            'student', 
            'resultsByTerm', 
            'results',
            'resultsWithClassAvg',
            'academicYear',
            'term',
            'totalScore',
            'totalObtainable',
            'average',
            'percentage',
            'overallGrade',
            'overallRemark',
            'position',
            'classSize',
            'totalDays',
            'presentDays',
            'absentDays',
            'totalSubjects',
            'passedSubjects',
            'failedSubjects',
            'isPdf'
        ))->setPaper('a4', 'portrait');

        $filename = 'Result_Slip_' . $student->student_id_number . '_' . str_replace('/', '_', $academicYear) . '_' . str_replace(' ', '_', $term) . '.pdf';

        return $pdf->download($filename);
    }

    private function ensureDemoExamResult($student)
    {
        // Check if demo exam exists
        $demoExam = \App\Models\Sms\SmsExam::where('school_id', $student->school_id)
            ->where('name', 'Demo Exam')
            ->first();

        if (!$demoExam) {
            // Create demo exam
            $mathSubject = \App\Models\Sms\SmsSubject::where('school_id', $student->school_id)
                ->where('name', 'Mathematics')
                ->first();

            if (!$mathSubject) {
                $mathSubject = \App\Models\Sms\SmsSubject::where('school_id', $student->school_id)->first();
            }

            if ($mathSubject) {
                $demoData = [
                    'school_id' => $student->school_id,
                    'class_id' => $student->class_id,
                    'subject_id' => $mathSubject->id,
                    'name' => 'Demo Exam',
                    'exam_type' => 'Exam',
                    'total_marks' => 100,
                    'is_active' => true,
                    'start_date' => now()->subDays(5),
                ];
                
                // Only add columns if they exist in the database
                if (\Schema::hasColumn('sms_exams', 'passing_score')) {
                    $demoData['passing_score'] = 50;
                } elseif (\Schema::hasColumn('sms_exams', 'passing_marks')) {
                    $demoData['passing_marks'] = 50;
                }
                
                if (\Schema::hasColumn('sms_exams', 'duration_minutes')) {
                    $demoData['duration_minutes'] = 60;
                }
                
                if (\Schema::hasColumn('sms_exams', 'scheduled_date')) {
                    $demoData['scheduled_date'] = now()->subDays(5);
                }
                
                $demoExam = \App\Models\Sms\SmsExam::create($demoData);
            }
        }

        if ($demoExam) {
            // Check if demo result exists for this student
            $demoSession = \App\Models\Sms\SmsExamSession::where('student_id', $student->id)
                ->where('exam_id', $demoExam->id)
                ->where('status', 'completed')
                ->first();

            if (!$demoSession) {
                // Create demo exam session with result
                \App\Models\Sms\SmsExamSession::create([
                    'exam_id' => $demoExam->id,
                    'student_id' => $student->id,
                    'status' => 'completed',
                    'started_at' => now()->subDays(5),
                    'ended_at' => now()->subDays(5)->addMinutes(60),
                    'submitted_at' => now()->subDays(5)->addMinutes(60),
                    'score' => 65,
                    'total_score' => 100,
                    'percentage' => 65.00,
                    'passed' => true,
                ]);
            }
        }
    }

    private function ensureDemoResults($student)
    {
        $academicYear = date('Y') . '/' . (date('Y') + 1);
        
        // Check if demo results already exist
        $existingResults = \App\Models\Sms\Result::where('school_id', $student->school_id)
            ->where('student_id', $student->id)
            ->where('academic_year', $academicYear)
            ->count();

        if ($existingResults > 0) {
            return; // Demo results already exist
        }

        // Get subjects for the student's class
        $subjects = \App\Models\Sms\SmsSubject::where('school_id', $student->school_id)->get();
        
        if ($subjects->isEmpty()) {
            return; // No subjects available
        }

        // Get a teacher for the results
        $teacher = \App\Models\Sms\SmsTeacher::where('school_id', $student->school_id)->first();

        // Create demo results for all three terms
        $terms = ['First Term', 'Second Term', 'Third Term'];
        $demoScores = [
            'First Term' => ['ca' => 15, 'exam' => 35], // Total: 50
            'Second Term' => ['ca' => 18, 'exam' => 42], // Total: 60
            'Third Term' => ['ca' => 20, 'exam' => 50], // Total: 70
        ];

        foreach ($terms as $termName) {
            foreach ($subjects as $subject) {
                $caScore = $demoScores[$termName]['ca'] + rand(-3, 3);
                $examScore = $demoScores[$termName]['exam'] + rand(-5, 5);
                $totalScore = $caScore + $examScore;
                
                // Ensure scores are within valid range
                $caScore = max(0, min(30, $caScore));
                $examScore = max(0, min(70, $examScore));
                $totalScore = $caScore + $examScore;

                $grade = $this->calculateGrade($totalScore);
                $remark = $this->calculateRemark($totalScore);

                \App\Models\Sms\Result::firstOrCreate(
                    [
                        'school_id' => $student->school_id,
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'academic_year' => $academicYear,
                        'term' => $termName,
                        'exam_type' => 'Exam',
                    ],
                    [
                        'class_id' => $student->class_id,
                        'teacher_id' => $teacher->id ?? 1,
                        'ca_score' => $caScore,
                        'exam_score' => $examScore,
                        'total_score' => $totalScore,
                        'grade' => $grade,
                        'remark' => $remark,
                        'position' => rand(1, 19), // Random position for demo
                    ]
                );
            }
        }
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

    private function calculateRemark($score): string
    {
        if ($score >= 70) return 'Excellent';
        if ($score >= 55) return 'Credit';
        if ($score >= 40) return 'Pass';
        return 'Fail';
    }

    public function fees()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $student = SmsStudent::where('user_id', $user->id)->firstOrFail();

        $fees = SmsFee::where('school_id', $student->school_id)
            ->where('class_id', $student->class_id)
            ->where('is_active', true)
            ->get();

        $payments = SmsFeePayment::where('student_id', $student->id)
            ->with('fee')
            ->orderBy('payment_date', 'desc')
            ->get();

        return view('sms.student.fees', compact('student', 'fees', 'payments'));
    }

    public function practiceSessions(Request $request)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $student = SmsStudent::where('user_id', $user->id)->firstOrFail();

        $subjectId = $request->get('subject_id');

        // Get practice sessions for student's class
        $query = SmsPracticeSession::where('school_id', $student->school_id)
            ->where('class_id', $student->class_id)
            ->where('is_active', true)
            ->with(['subject', 'class', 'questions', 'attempts' => function($q) use ($student) {
                $q->where('student_id', $student->id);
            }]);

        // Filter by subject if provided
        if ($subjectId) {
            $query->where('subject_id', $subjectId);
        }

        // Check availability dates
        $query->where(function($q) {
            $q->where('availability', 'always_open')
              ->orWhere(function($dateQuery) {
                  $dateQuery->where('availability', 'date_based')
                            ->where('start_date', '<=', now())
                            ->where('end_date', '>=', now());
              });
        });

        $practiceSessions = $query->orderBy('created_at', 'desc')->get();

        // Get all subjects for filter (subjects that have practice sessions for this class)
        $subjectIds = SmsPracticeSession::where('school_id', $student->school_id)
            ->where('class_id', $student->class_id)
            ->where('is_active', true)
            ->pluck('subject_id')
            ->unique()
            ->toArray();
        
        $subjects = \App\Models\Sms\SmsSubject::where('school_id', $student->school_id)
            ->whereIn('id', $subjectIds)
            ->get();

        $selectedSubject = $subjectId ? \App\Models\Sms\SmsSubject::find($subjectId) : null;

        return view('sms.student.practice-sessions', compact('student', 'practiceSessions', 'subjects', 'selectedSubject'));
    }

    public function takePracticeSession(Request $request, $id)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $student = SmsStudent::where('user_id', $user->id)->firstOrFail();

        $practiceSession = SmsPracticeSession::where('school_id', $student->school_id)
            ->where('class_id', $student->class_id)
            ->where('is_active', true)
            ->with(['subject', 'class', 'questions'])
            ->findOrFail($id);

        // Check availability
        if ($practiceSession->availability === 'date_based') {
            $now = now();
            if ($practiceSession->start_date && $now->lt($practiceSession->start_date)) {
                return back()->with('error', 'This practice session is not available yet. It starts on ' . $practiceSession->start_date->format('M j, Y'));
            }
            if ($practiceSession->end_date && $now->gt($practiceSession->end_date)) {
                return back()->with('error', 'This practice session has ended.');
            }
        }

        if ($practiceSession->questions->isEmpty()) {
            return back()->with('error', 'This practice session has no questions yet.');
        }

        // Check if question selection is needed
        $attempt = \App\Models\Sms\SmsPracticeAttempt::where('practice_session_id', $practiceSession->id)
            ->where('student_id', $student->id)
            ->whereNull('completed_at')
            ->first();

        // If no attempt exists or no questions selected, show selection page
        if (!$attempt || !$attempt->selected_question_ids) {
            // If POST request, process question selection
            if ($request->isMethod('post')) {
                $numQuestions = (int) $request->input('num_questions', $practiceSession->questions->count());
                $numQuestions = max(1, min($numQuestions, $practiceSession->questions->count()));
                
                // Randomly select questions
                $selectedQuestions = $practiceSession->questions->shuffle()->take($numQuestions)->pluck('id')->toArray();
                
                if (!$attempt) {
                    $attempt = \App\Models\Sms\SmsPracticeAttempt::create([
                        'practice_session_id' => $practiceSession->id,
                        'student_id' => $student->id,
                        'total_questions' => $numQuestions,
                        'selected_question_ids' => $selectedQuestions,
                        'started_at' => now(),
                        'answers' => [],
                    ]);
                } else {
                    $attempt->update([
                        'total_questions' => $numQuestions,
                        'selected_question_ids' => $selectedQuestions,
                    ]);
                }
                
                return redirect()->route('sms.student.practice-sessions.take', $id);
            }
            
            // Show question selection page
            return view('sms.student.practice-sessions.select-questions', compact('student', 'practiceSession'));
        }

        // Get only selected questions
        $selectedQuestionIds = $attempt->selected_question_ids ?? [];
        $questions = $practiceSession->questions->whereIn('id', $selectedQuestionIds)->values();

        return view('sms.student.practice-sessions.take', compact('student', 'practiceSession', 'attempt', 'questions'));
    }

    public function submitPracticeSession(Request $request, $id)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $student = SmsStudent::where('user_id', $user->id)->firstOrFail();

        $practiceSession = SmsPracticeSession::where('school_id', $student->school_id)
            ->where('class_id', $student->class_id)
            ->where('is_active', true)
            ->with('questions')
            ->findOrFail($id);

        $attempt = \App\Models\Sms\SmsPracticeAttempt::where('practice_session_id', $practiceSession->id)
            ->where('student_id', $student->id)
            ->whereNull('completed_at')
            ->firstOrFail();

        $answers = $request->input('answers', []);
        $score = 0;
        
        // Get only selected questions for this attempt
        $selectedQuestionIds = $attempt->selected_question_ids ?? [];
        $selectedQuestions = $practiceSession->questions->whereIn('id', $selectedQuestionIds);
        $totalMarks = $selectedQuestions->sum('marks');

        foreach ($selectedQuestions as $question) {
            $studentAnswer = $answers[$question->id] ?? null;
            if ($studentAnswer && $studentAnswer === $question->correct_answer) {
                $score += $question->marks;
            }
        }

        $percentage = $totalMarks > 0 ? ($score / $totalMarks) * 100 : 0;

        $attempt->update([
            'answers' => $answers,
            'score' => $score,
            'percentage' => $percentage,
            'completed_at' => now(),
        ]);

        return redirect()->route('sms.student.practice-sessions.result', $attempt->id)
            ->with('success', 'Practice session completed!');
    }

    public function practiceSessionResult($id)
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $student = SmsStudent::where('user_id', $user->id)->firstOrFail();

        $attempt = SmsPracticeAttempt::where('student_id', $student->id)
            ->with(['practiceSession.subject', 'practiceSession.class'])
            ->findOrFail($id);
        
        // Get only selected questions
        $selectedQuestionIds = $attempt->selected_question_ids ?? [];
        $questions = $attempt->practiceSession->questions->whereIn('id', $selectedQuestionIds);
        $attempt->practiceSession->setRelation('questions', $questions);

        return view('sms.student.practice-sessions.result', compact('student', 'attempt'));
    }

    public function assignments()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $student = SmsStudent::where('user_id', $user->id)->firstOrFail();

        // Demo assignments are shown directly in the view
        // In production, this would query from an assignments table
        
        return view('sms.student.assignments', compact('student'));
    }

    public function notices()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $student = SmsStudent::where('user_id', $user->id)->firstOrFail();

        $notices = SmsNotice::where('school_id', $student->school_id)
            ->where(function($query) {
                $query->where('target_audience', 'all')
                      ->orWhere('target_audience', 'students');
            })
            ->where('is_active', true)
            ->where('published_at', '<=', now())
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now());
            })
            ->orderBy('published_at', 'desc')
            ->paginate(20);

        return view('sms.student.notices', compact('student', 'notices'));
    }

    private function getAttendanceRate($studentId)
    {
        try {
            $total = SmsAttendance::where('student_id', $studentId)
                ->whereMonth('date', now()->month)
                ->count();
            
            if ($total == 0) return 0;

            $present = SmsAttendance::where('student_id', $studentId)
                ->whereMonth('date', now()->month)
                ->where('status', 'present')
                ->count();

            return round(($present / $total) * 100, 1);
        } catch (\Exception $e) {
            // If table doesn't exist or no data, return 0
            return 0;
        }
    }

    private function getPendingFees($studentId)
    {
        try {
            $student = SmsStudent::find($studentId);
            if (!$student) return 0;

            $fees = SmsFee::where('school_id', $student->school_id)
                ->where('class_id', $student->class_id)
                ->where('is_active', true)
                ->get();

            $total = $fees->sum('amount');
            $paid = SmsFeePayment::where('student_id', $studentId)->sum('amount_paid');

            return max(0, $total - $paid);
        } catch (\Exception $e) {
            // If tables don't exist or no data, return 0
            return 0;
        }
    }

    private function getAttendanceSummary($studentId)
    {
        try {
            // Get ALL attendance records (not just current month) - Calculate overall percentage
            $allAttendances = SmsAttendance::where('student_id', $studentId)->get();
            
            $total = $allAttendances->count();
            
            if ($total == 0) {
                return [
                    'total' => 0,
                    'present' => 0,
                    'absent' => 0,
                    'percentage' => 0,
                ];
            }

            // Count present and absent correctly (case-insensitive match)
            $present = $allAttendances->filter(function($attendance) {
                return strtolower($attendance->status) === 'present';
            })->count();
            
            $absent = $allAttendances->filter(function($attendance) {
                return strtolower($attendance->status) === 'absent';
            })->count();
            
            // Calculate percentage: (Present Days / Total Days) × 100
            $percentage = $total > 0 ? round(($present / $total) * 100, 1) : 0;

            return [
                'total' => $total,
                'present' => $present,
                'absent' => $absent,
                'percentage' => $percentage,
            ];
        } catch (\Exception $e) {
            return [
                'total' => 0,
                'present' => 0,
                'absent' => 0,
                'percentage' => 0,
            ];
        }
    }

    private function getClubPosition($studentId)
    {
        // Demo data - can be expanded with actual club/position table later
        $clubs = [
            'Press Club – Member',
            'Football Team – Captain',
            'Debate Club – Member',
            'Science Club – Secretary',
            'Music Club – Member',
        ];
        
        // Return a random club for demo (or use student_id to make it consistent)
        $index = $studentId % count($clubs);
        return $clubs[$index];
    }

    private function createDemoStudent($user)
    {
        // CRITICAL: Verify user role is 'student' before creating student profile
        if ($user->role !== 'student') {
            \Log::error('Attempted to create student profile for non-student user', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_email' => $user->email,
            ]);
            throw new \Exception('Cannot create student profile for user with role: ' . $user->role);
        }
        
        // Get or create demo school
        $school = \App\Models\Sms\SmsSchool::firstOrCreate(
            ['name' => 'Demo School'],
            [
                'registration_number' => 'DEMO-001',
                'school_type' => 'Secondary',
                'address' => '123 Demo Street',
                'city' => 'Demo City',
                'country' => 'Demo Country',
                'email' => 'demo@school.com',
                'is_active' => true,
            ]
        );

        // Update user with school_id (only if not already set)
        if (!$user->school_id) {
            $user->update(['school_id' => $school->id]);
        }

        // Get or create demo class (Nigerian format)
        $class = \App\Models\Sms\SmsClass::firstOrCreate(
            [
                'school_id' => $school->id,
                'name' => 'Basic 1',
            ],
            [
                'academic_year' => date('Y'),
                'capacity' => 40,
                'section' => null, // No sections
            ]
        );

        // Create student
        $student = SmsStudent::create([
            'school_id' => $school->id,
            'user_id' => $user->id,
            'student_id_number' => 'STU-' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
            'class_id' => $class->id,
            'admission_date' => now(),
            'date_of_birth' => now()->subYears(15),
            'gender' => 'male',
            'status' => 'active',
        ]);

        return $student;
    }

    private function calculateGradeFromPercentage($percentage): string
    {
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B';
        if ($percentage >= 60) return 'C';
        if ($percentage >= 50) return 'D';
        if ($percentage >= 40) return 'E';
        return 'F';
    }

    private function calculateRemarkFromGrade($grade): string
    {
        return match($grade) {
            'A' => 'EXCELLENT',
            'B' => 'VERY GOOD',
            'C' => 'GOOD',
            'D' => 'PASS',
            'E' => 'POOR',
            default => 'FAIL',
        };
    }

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
}

