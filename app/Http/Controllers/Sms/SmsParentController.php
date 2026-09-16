<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\Sms\SmsParent;
use App\Models\Sms\SmsStudent;
use App\Models\Sms\SmsAttendance;
use App\Models\Sms\SmsExamResult;
use App\Models\Sms\SmsFee;
use App\Models\Sms\SmsFeePayment;
use App\Models\Sms\SmsNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmsParentController extends Controller
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
        
        // CRITICAL: Verify session role matches user's actual role in database
        $sessionRole = session('sms_role');
        if ($sessionRole && $sessionRole !== $user->role) {
            \Log::warning('Session role mismatch with database role in parent dashboard', [
                'user_id' => $user->id,
                'session_role' => $sessionRole,
                'database_role' => $user->role,
            ]);
            
            // Update session to match database role
            session(['sms_role' => $user->role]);
        }
        
        // CRITICAL: Verify user is actually a parent before creating parent profile
        if ($user->role !== 'parent') {
            \Log::warning('Non-parent user attempted to access parent dashboard', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_email' => $user->email,
                'session_role' => session('sms_role'),
            ]);
            
            // Clear session and redirect to login
            session()->forget(['sms_user_id', 'sms_role', 'sms_user', 'parent_viewing', 'parent_session_info']);
            
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Access denied. Your account is not registered as a parent.');
        }
        
        // CRITICAL: Verify user role in database matches 'parent' BEFORE any profile operations
        // Refresh user from database to ensure we have latest role
        $user->refresh();
        
        // CRITICAL: If user has a student profile but wrong role, fix the role automatically
        if ($user->studentProfile && $user->role !== 'student') {
            \Log::error('CRITICAL: User has student profile but wrong role - fixing automatically', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'current_role' => $user->role,
                'student_id' => $user->studentProfile->id,
                'should_be_role' => 'student',
            ]);
            
            // Fix the role
            $user->update(['role' => 'student']);
            $user->refresh();
            
            // Clear session and redirect to student dashboard
            session()->forget(['sms_user_id', 'sms_role', 'sms_user', 'parent_viewing', 'parent_session_info']);
            return redirect()->route('sms.student.dashboard')
                ->with('error', 'Your account has been corrected. You are registered as a student, not a parent.');
        }
        
        // CRITICAL: Double-check database role - NEVER create parent profile if role is not 'parent'
        if ($user->role !== 'parent') {
            \Log::error('CRITICAL: Non-parent user attempted to access parent dashboard - preventing parent profile creation', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'database_role' => $user->role,
                'session_role' => session('sms_role'),
                'parent_viewing' => session('parent_viewing'),
                'has_student_profile' => $user->studentProfile ? 'yes' : 'no',
                'has_parent_profile' => $user->parentProfile ? 'yes' : 'no',
            ]);
            
            // If this user has a student profile, they might be a child being incorrectly accessed
            if ($user->studentProfile) {
                \Log::error('CRITICAL: Student account attempted to access parent dashboard - possible session corruption', [
                    'user_id' => $user->id,
                    'student_id' => $user->studentProfile->id,
                ]);
            }
            
            // Clear session and redirect
            session()->forget(['sms_user_id', 'sms_role', 'sms_user', 'parent_viewing', 'parent_session_info']);
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Access denied. Your account is not registered as a parent.');
        }
        
        // Get parent profile
        $parent = SmsParent::where('user_id', $user->id)->first();
        
        if (!$parent) {
            // CRITICAL: Triple-check role before creating parent profile
            // Refresh user again to be absolutely sure
            $user->refresh();
            if ($user->role !== 'parent') {
                \Log::error('CRITICAL: Role changed between checks - preventing parent profile creation', [
                    'user_id' => $user->id,
                    'user_role' => $user->role,
                ]);
                return redirect()->route('school-management.demo-login')
                    ->with('error', 'Parent profile not found. Please contact administrator.');
            }
            
            // Only create demo parent if user role is actually 'parent' (verified multiple times)
            \Log::info('Creating demo parent profile for verified parent user', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $user->role,
            ]);
            $parent = $this->createDemoParent($user);
        }

        // Get children (students) - both old parent_id and new many-to-many
        // CRITICAL: Only get children actually assigned to THIS parent (MAX 2)
        $childrenOld = SmsStudent::where('parent_id', $parent->id)
            ->where('school_id', $parent->school_id)
            ->with(['user', 'class.classTeacher.user'])
            ->limit(2)
            ->get();
        
        // Get children via many-to-many relationship (admin-assigned only)
        $childrenLinked = $parent->linkedStudents()
            ->where('sms_students.school_id', $parent->school_id)
            ->with(['user', 'class.classTeacher.user'])
            ->limit(2)
            ->get();
        
        // Merge and get unique students - ONLY children assigned to this parent
        $children = $childrenOld->merge($childrenLinked)->unique('id');
        
        // CRITICAL: Enforce 2-child maximum on dashboard
        $children = $children->take(2);
        
        // For demo: If no children, create ONE demo child (not multiple)
        if ($children->isEmpty()) {
            $demoChild = $this->createDemoChild($parent);
            $children = collect([$demoChild]);
        }

        // Calculate statistics
        $stats = [
            'children_count' => $children->count(),
            'attendance_rate' => $this->getChildrenAttendanceRate($children->pluck('id')->toArray()),
            'pending_fees' => $this->getChildrenPendingFees($children->pluck('id')->toArray()),
            // Removed 'upcoming_exams' - replaced with Notice Board
        ];

        // Get fee summary for children
        $feeSummary = $this->getChildrenFeeSummary($children->pluck('id')->toArray());

        // Get recent results
        $recentResults = SmsExamResult::whereIn('student_id', $children->pluck('id')->toArray())
            ->with(['student.user', 'exam.subject'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get notices
        $notices = SmsNotice::where('school_id', $parent->school_id)
            ->where(function($query) {
                $query->where('target_audience', 'all')
                      ->orWhere('target_audience', 'parents');
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

        return view('sms.parent.dashboard', compact('parent', 'children', 'stats', 'recentResults', 'notices', 'feeSummary'));
    }

    private function getChildrenAttendanceRate($studentIds)
    {
        if (empty($studentIds)) return 0;
        
        try {
            $total = SmsAttendance::whereIn('student_id', $studentIds)
                ->whereMonth('date', now()->month)
                ->count();
            
            if ($total == 0) return 0;

            $present = SmsAttendance::whereIn('student_id', $studentIds)
                ->whereMonth('date', now()->month)
                ->where('status', 'present')
                ->count();

            return round(($present / $total) * 100, 1);
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getChildrenPendingFees($studentIds)
    {
        if (empty($studentIds)) return 0;
        
        try {
            // Get fee summary which handles both StudentFee table and SmsFee table
            $feeSummary = $this->getChildrenFeeSummary($studentIds);
            return $feeSummary['balance'];
        } catch (\Exception $e) {
            \Log::error('Error calculating pending fees', ['error' => $e->getMessage(), 'student_ids' => $studentIds]);
            return 0;
        }
    }

    private function getChildrenUpcomingExams($studentIds)
    {
        if (empty($studentIds)) return 0;
        
        try {
            $students = SmsStudent::whereIn('id', $studentIds)->get();
            $count = 0;
            
            foreach ($students as $student) {
                $count += \App\Models\Sms\SmsExam::where('school_id', $student->school_id)
                    ->where('class_id', $student->class_id)
                    ->where('is_active', true)
                    ->where('start_date', '>=', now())
                    ->count();
            }
            
            return $count;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getChildrenFeeSummary($studentIds)
    {
        if (empty($studentIds)) return ['total' => 0, 'paid' => 0, 'balance' => 0];
        
        try {
            // Get students with their classes
            $students = SmsStudent::whereIn('id', $studentIds)
                ->with('class')
                ->get();
            
            $total = 0;
            $paid = 0;
            $balance = 0;
            
            foreach ($students as $student) {
                // First, try to get fees from StudentFee table (if fees have been assigned)
                $studentFees = \App\Models\Sms\StudentFee::where('student_id', $student->id)->get();
                
                if ($studentFees->count() > 0) {
                    // Fees exist in StudentFee table - use them
                    $total += $studentFees->sum('amount');
                    $paid += $studentFees->sum('paid_amount');
                    $balance += $studentFees->sum(function($fee) {
                        $calculatedBalance = $fee->amount - $fee->paid_amount;
                        return max(0, $calculatedBalance);
                    });
                } else {
                    // No fees in StudentFee table - calculate from SmsFee table based on class
                    if ($student->class_id) {
                        $classFees = SmsFee::where('class_id', $student->class_id)
                            ->where('school_id', $student->school_id)
                            ->where('is_active', true)
                            ->get();
                        
                        foreach ($classFees as $fee) {
                            $total += $fee->amount;
                            
                            // Get payments for this fee
                            $payments = SmsFeePayment::where('student_id', $student->id)
                                ->where('fee_id', $fee->id)
                                ->where('payment_status', 'completed')
                                ->sum('amount_paid');
                            
                            $paid += $payments;
                            $balance += max(0, $fee->amount - $payments);
                        }
                    }
                }
            }
            
            return [
                'total' => $total,
                'paid' => $paid,
                'balance' => $balance,
            ];
        } catch (\Exception $e) {
            \Log::error('Error calculating fee summary', [
                'error' => $e->getMessage(), 
                'trace' => $e->getTraceAsString(),
                'student_ids' => $studentIds
            ]);
            return ['total' => 0, 'paid' => 0, 'balance' => 0];
        }
    }

    private function createDemoParent($user)
    {
        // CRITICAL: Refresh user from database to ensure we have latest role
        $user->refresh();
        
        // CRITICAL: Triple-check user role before creating parent profile
        if ($user->role !== 'parent') {
            \Log::error('CRITICAL: Attempted to create parent profile for non-parent user - BLOCKED', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_email' => $user->email,
                'has_student_profile' => $user->studentProfile ? 'yes' : 'no',
                'has_teacher_profile' => $user->teacherProfile ? 'yes' : 'no',
                'stack_trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5),
            ]);
            throw new \Exception('CRITICAL: Cannot create parent profile for user with role: ' . $user->role . '. This user may be a student or teacher.');
        }
        
        // CRITICAL: Check if user already has a student or teacher profile - if so, DO NOT create parent profile
        if ($user->studentProfile) {
            \Log::error('CRITICAL: Attempted to create parent profile for user who already has student profile - BLOCKED', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'student_id' => $user->studentProfile->id,
            ]);
            throw new \Exception('CRITICAL: Cannot create parent profile for user who already has a student profile. User ID: ' . $user->id);
        }
        
        if ($user->teacherProfile) {
            \Log::error('CRITICAL: Attempted to create parent profile for user who already has teacher profile - BLOCKED', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'teacher_id' => $user->teacherProfile->id,
            ]);
            throw new \Exception('CRITICAL: Cannot create parent profile for user who already has a teacher profile. User ID: ' . $user->id);
        }
        
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

        $parent = SmsParent::create([
            'school_id' => $school->id,
            'user_id' => $user->id,
            'occupation' => 'Business',
            'relationship' => 'parent',
        ]);

        return $parent;
    }
    
    private function createDemoChild($parent)
    {
        // Get or create a demo student for this parent
        $school = \App\Models\Sms\SmsSchool::first();
        $class = \App\Models\Sms\SmsClass::where('school_id', $school->id)->first();
        
        if (!$class) {
            $class = \App\Models\Sms\SmsClass::create([
                'school_id' => $school->id,
                'name' => 'JSS1',
                'level' => 'junior',
                'is_active' => true,
            ]);
        }
        
        // Create demo user for child
        $childUser = \App\Models\Sms\SmsUser::firstOrCreate(
            ['email' => 'demo.student@school.com'],
            [
                'name' => 'Demo Student',
                'role' => 'student',
                'password' => bcrypt('demo123'),
                'school_id' => $school->id,
            ]
        );
        
        // Create or get student
        $student = SmsStudent::firstOrCreate(
            ['user_id' => $childUser->id],
            [
                'school_id' => $school->id,
                'class_id' => $class->id,
                'parent_id' => $parent->id,
                'student_id_number' => 'STU-' . str_pad(rand(1, 999), 5, '0', STR_PAD_LEFT),
                'status' => 'active',
            ]
        );
        
        return $student->load(['user', 'class']);
    }
    
    /**
     * Switch to child dashboard view
     */
    public function viewChild($childId)
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
        
        // CRITICAL: Verify user is actually a parent
        if ($user->role !== 'parent') {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Access denied. Only parents can view child accounts.');
        }
        
        $parent = SmsParent::where('user_id', $user->id)->first();
        
        if (!$parent) {
            return redirect()->route('sms.parent.dashboard')
                ->with('error', 'Parent profile not found.');
        }
        
        // CRITICAL: Verify child exists and belongs to the same school
        $child = SmsStudent::where('id', $childId)
            ->where('school_id', $parent->school_id)
            ->with('user')
            ->first();
        
        if (!$child) {
            \Log::warning('Parent attempted to access child not in same school', [
                'parent_id' => $parent->id,
                'parent_user_id' => $user->id,
                'parent_school_id' => $parent->school_id,
                'requested_child_id' => $childId,
            ]);
            return redirect()->route('sms.parent.dashboard')
                ->with('error', 'Child not found or access denied.');
        }
        
        // CRITICAL: Verify child has a valid user account
        if (!$child->user || !$child->user_id) {
            \Log::warning('Child has no user account', [
                'parent_id' => $parent->id,
                'child_id' => $childId,
            ]);
            return redirect()->route('sms.parent.dashboard')
                ->with('error', 'Child account is not properly set up.');
        }
        
        // CRITICAL: Verify child is linked to THIS specific parent
        $isLinkedViaParentId = ($child->parent_id == $parent->id);
        
        $isLinkedViaPivot = DB::table('parent_student')
            ->where('parent_id', $parent->id)
            ->where('student_id', $childId)
            ->exists();
        
        if (!$isLinkedViaParentId && !$isLinkedViaPivot) {
            \Log::warning('Parent attempted to access unlinked child', [
                'parent_id' => $parent->id,
                'parent_user_id' => $user->id,
                'child_id' => $childId,
                'child_parent_id' => $child->parent_id,
                'pivot_exists' => $isLinkedViaPivot,
            ]);
            return redirect()->route('sms.parent.dashboard')
                ->with('error', 'Access denied. This child is not linked to your account.');
        }
        
        // CRITICAL: Store parent session info BEFORE switching (for returning to parent view)
        $parentSessionInfo = [
            'parent_user_id' => $user->id,
            'parent_id' => $parent->id,
            'parent_role' => 'parent',
        ];
        
        // CRITICAL: Verify child's user account exists and is active
        $childUser = \App\Models\Sms\SmsUser::find($child->user_id);
        if (!$childUser) {
            \Log::error('Child user account does not exist', [
                'parent_id' => $parent->id,
                'child_id' => $childId,
                'child_user_id' => $child->user_id,
            ]);
            return redirect()->route('sms.parent.dashboard')
                ->with('error', 'Child account error. Please contact administrator.');
        }
        
        // CRITICAL: Refresh child user from database to ensure we have latest data
        $childUser->refresh();
        
        // CRITICAL: Verify child user role is 'student' - if not, fix it
        if ($childUser->role !== 'student') {
            \Log::error('CRITICAL: Child user has wrong role - attempting to fix', [
                'parent_id' => $parent->id,
                'child_id' => $childId,
                'child_user_id' => $child->user_id,
                'child_user_role' => $childUser->role,
                'expected_role' => 'student',
                'has_parent_profile' => $childUser->parentProfile ? 'yes' : 'no',
                'has_student_profile' => $childUser->studentProfile ? 'yes' : 'no',
            ]);
            
            // CRITICAL: If child has parent profile, this is a serious data corruption issue
            if ($childUser->parentProfile) {
                \Log::error('CRITICAL: Child user has parent profile - data corruption detected', [
                    'child_user_id' => $childUser->id,
                    'child_student_id' => $childId,
                    'parent_profile_id' => $childUser->parentProfile->id,
                ]);
                return redirect()->route('sms.parent.dashboard')
                    ->with('error', 'CRITICAL: Child account has incorrect profile type. Please contact administrator immediately.');
            }
            
            // Attempt to fix the role if it's wrong
            if ($childUser->role !== 'student') {
                \Log::warning('Fixing child user role from ' . $childUser->role . ' to student', [
                    'child_user_id' => $childUser->id,
                ]);
                $childUser->update(['role' => 'student']);
                $childUser->refresh();
            }
            
            // Double-check after fix
            if ($childUser->role !== 'student') {
                return redirect()->route('sms.parent.dashboard')
                    ->with('error', 'Invalid child account type. Child account must be registered as a student.');
            }
        }
        
        // CRITICAL: Refresh child user from database to ensure we have latest data
        $childUser->refresh();
        
        // CRITICAL: Switch session to child's user - use EXACT child user_id from verified child
        session([
            'sms_user_id' => $child->user_id, // Use the verified child's user_id
            'sms_role' => 'student', // Must match childUser->role
            'sms_user' => $childUser, // Use the verified child user object
            'parent_viewing' => true, // Flag to show "Back to Parent View" button
            'parent_session_info' => $parentSessionInfo, // Store parent info for returning
        ]);
        
        // CRITICAL: Verify session was set correctly
        if (session('sms_user_id') !== $child->user_id || session('sms_role') !== 'student') {
            \Log::error('Session switch verification failed', [
                'expected_user_id' => $child->user_id,
                'actual_user_id' => session('sms_user_id'),
                'expected_role' => 'student',
                'actual_role' => session('sms_role'),
            ]);
            // Restore parent session
            session([
                'sms_user_id' => $parentSessionInfo['parent_user_id'],
                'sms_role' => 'parent',
                'sms_user' => $user,
                'parent_viewing' => false,
                'parent_session_info' => null,
            ]);
            return redirect()->route('sms.parent.dashboard')
                ->with('error', 'Session switch failed. Please try again.');
        }
        
        \Log::info('Parent switched to child view', [
            'parent_id' => $parent->id,
            'parent_user_id' => $user->id,
            'child_id' => $childId,
            'child_user_id' => $child->user_id,
            'child_name' => $childUser->name,
        ]);
        
        return redirect()->route('sms.student.dashboard')
            ->with('success', 'Viewing as ' . $childUser->name);
    }
    
    /**
     * Restore parent session when returning from child view
     */
    public function restoreParentSession()
    {
        $parentInfo = session('parent_session_info');
        
        if (!$parentInfo) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'No parent session found. Please login again.');
        }
        
        $parentUser = \App\Models\Sms\SmsUser::find($parentInfo['parent_user_id']);
        
        if (!$parentUser) {
            \Log::error('Parent user not found when restoring session', [
                'parent_user_id' => $parentInfo['parent_user_id'],
                'parent_id' => $parentInfo['parent_id'] ?? null,
            ]);
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Parent account not found. Please login again.');
        }
        
        // CRITICAL: Verify user is actually a parent
        if ($parentUser->role !== 'parent') {
            \Log::error('Attempted to restore non-parent session', [
                'user_id' => $parentUser->id,
                'user_role' => $parentUser->role,
                'expected_role' => 'parent',
                'parent_info' => $parentInfo,
            ]);
            
            // Clear all session data
            session()->forget(['sms_user_id', 'sms_role', 'sms_user', 'parent_viewing', 'parent_session_info']);
            
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Invalid session. Please login again.');
        }
        
        // CRITICAL: Verify parent profile exists
        $parent = SmsParent::where('user_id', $parentUser->id)->first();
        if (!$parent) {
            \Log::error('Parent profile not found when restoring session', [
                'parent_user_id' => $parentUser->id,
                'parent_id_from_info' => $parentInfo['parent_id'] ?? null,
            ]);
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Parent profile not found. Please login again.');
        }
        
        // CRITICAL: Verify parent_id matches
        if ($parent->id != ($parentInfo['parent_id'] ?? null)) {
            \Log::warning('Parent ID mismatch when restoring session', [
                'parent_user_id' => $parentUser->id,
                'session_parent_id' => $parentInfo['parent_id'] ?? null,
                'database_parent_id' => $parent->id,
            ]);
        }
        
        // Restore parent session
        session([
            'sms_user_id' => $parentInfo['parent_user_id'],
            'sms_role' => 'parent', // Must match parentUser->role
            'sms_user' => $parentUser,
            'parent_viewing' => false,
            'parent_session_info' => null, // Clear parent session info
        ]);
        
        // CRITICAL: Verify session was restored correctly
        if (session('sms_user_id') !== $parentInfo['parent_user_id'] || session('sms_role') !== 'parent') {
            \Log::error('Session restoration verification failed', [
                'expected_user_id' => $parentInfo['parent_user_id'],
                'actual_user_id' => session('sms_user_id'),
                'expected_role' => 'parent',
                'actual_role' => session('sms_role'),
            ]);
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Session restoration failed. Please login again.');
        }
        
        return redirect()->route('sms.parent.dashboard')
            ->with('success', 'Returned to parent dashboard.');
    }

    /**
     * Show all notices for parents
     */
    public function notices()
    {
        $smsUserId = session('sms_user_id');
        $user = \App\Models\Sms\SmsUser::findOrFail($smsUserId);
        $parent = SmsParent::where('user_id', $user->id)->firstOrFail();

        $notices = SmsNotice::where('school_id', $parent->school_id)
            ->where(function($query) {
                $query->where('target_audience', 'all')
                      ->orWhere('target_audience', 'parents');
            })
            ->where('is_active', true)
            ->where('published_at', '<=', now())
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now());
            })
            ->orderBy('published_at', 'desc')
            ->paginate(20);

        return view('sms.parent.notices', compact('parent', 'notices'));
    }
}

