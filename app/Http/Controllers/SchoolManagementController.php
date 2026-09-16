<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SchoolManagementController extends Controller
{
    /**
     * Show the SMS landing/presentation page
     */
    public function index()
    {
        return view('landing');
    }

    /**
     * Show SMS authorized login page (for students, teachers, parents)
     */
    public function showAuthorizedLogin()
    {
        return view('school-management.authorized-login');
    }

    /**
     * Handle SMS authorized login (students, teachers, parents)
     */
    public function authorizedLogin(Request $request)
    {
        // Get role from request (try both 'role' and 'role_fallback')
        $role = $request->input('role') ?? $request->input('role_fallback');
        
        // Debug: Log the request data
        \Log::info('Login attempt', [
            'role' => $role,
            'role_from_request' => $request->input('role'),
            'role_fallback' => $request->input('role_fallback'),
            'identifier' => $request->input('identifier'),
            'has_password' => !empty($request->input('password')),
            'all_input' => $request->all()
        ]);

        // Manually validate role if not present
        if (empty($role)) {
            return back()->withErrors([
                'role' => 'Please select your role (Student, Teacher, or Parent).',
            ])->withInput();
        }

        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        // Validate role value
        if (!in_array($role, ['admin', 'student', 'teacher', 'parent'])) {
            return back()->withErrors([
                'role' => 'Invalid role selected.',
            ])->withInput();
        }

        $identifier = $request->input('identifier');
        $password = $request->input('password');

        $user = null;
        $profile = null;

        // Find user based on role
        if ($role === 'admin') {
            $user = \App\Models\Sms\SmsUser::where('role', 'admin')
                ->where(function($query) use ($identifier) {
                    $query->where('email', $identifier)
                          ->orWhere('phone', $identifier);
                })
                ->first();
        } elseif ($role === 'student') {
            // Find student by student_id_number (trim whitespace and case-insensitive)
            $identifier = trim($identifier);
            $student = \App\Models\Sms\SmsStudent::whereRaw('LOWER(TRIM(student_id_number)) = ?', [strtolower($identifier)])
                ->with('user')
                ->first();
            
            // If not found, try exact match (for backward compatibility)
            if (!$student) {
                $student = \App\Models\Sms\SmsStudent::where('student_id_number', $identifier)
                    ->with('user')
                    ->first();
            }
            
            if ($student && $student->user) {
                $user = $student->user;
                $profile = $student;
            }
        } elseif ($role === 'teacher') {
            // Find teacher by employee_id or email
            $teacher = \App\Models\Sms\SmsTeacher::where('employee_id', $identifier)
                ->orWhereHas('user', function($query) use ($identifier) {
                    $query->where('email', $identifier);
                })
                ->with('user')
                ->first();
            
            if ($teacher && $teacher->user) {
                $user = $teacher->user;
                $profile = $teacher;
            }
        } elseif ($role === 'parent') {
            // Find parent by email or phone (check user table first)
            $user = \App\Models\Sms\SmsUser::where('role', 'parent')
                ->where(function($query) use ($identifier) {
                    $query->where('email', $identifier)
                          ->orWhere('phone', $identifier);
                })
                ->first();
            
            // If not found by user phone, check parent table phone as fallback
            if (!$user) {
                $parent = \App\Models\Sms\SmsParent::where('phone', $identifier)
                    ->with('user')
                    ->first();
                if ($parent && $parent->user) {
                    $user = $parent->user;
                    $profile = $parent;
                }
            } else {
                $profile = \App\Models\Sms\SmsParent::where('user_id', $user->id)->first();
            }
        }

        if (!$user) {
            $roleLabel = match($role) {
                'admin' => 'Admin Email',
                'student' => 'Student ID',
                'teacher' => 'Employee ID or Email',
                'parent' => 'Email or Phone',
                default => 'Identifier'
            };
            $errorMessage = 'Invalid credentials. Please check your ' . $roleLabel . ' and try again.';
            
            // For students, provide more helpful error message
            if ($role === 'student') {
                $errorMessage .= ' Make sure you are using your Student ID (e.g., STU-2026-0001) exactly as shown when your account was created.';
            }
            
            return back()->withErrors([
                'identifier' => $errorMessage,
            ])->withInput();
        }

        // Verify password
        if (!Hash::check($password, $user->password)) {
            return back()->withErrors([
                'password' => 'Invalid password. Please try again.',
            ])->withInput();
        }

        // Check if user is active
        if (!$user->is_active) {
            return back()->withErrors([
                'identifier' => 'Your account has been deactivated. Please contact the school administrator.',
            ])->withInput();
        }

        // Verify role matches
        if ($user->role !== $role) {
            return back()->withErrors([
                'role' => 'Invalid role selected. Your account is registered as ' . ucfirst($user->role) . ', but you selected ' . ucfirst($role) . '. Please select the correct role.',
            ])->withInput();
        }

        // Store SMS user in session
        session([
            'sms_user_id' => $user->id,
            'sms_role' => $role,
            'sms_user' => $user,
        ]);

        // Redirect based on role
        $redirectRoutes = [
            'admin' => 'school.dashboard',
            'student' => 'sms.student.dashboard',
            'teacher' => 'sms.teacher.dashboard',
            'parent' => 'sms.parent.dashboard',
        ];

        $redirectRoute = $redirectRoutes[$role] ?? 'school.dashboard';

        return redirect()->route($redirectRoute)
            ->with('success', 'Welcome back, ' . $user->name . '!');
    }

    /**
     * Show the SMS demo login page
     */
    public function showDemoLogin(Request $request)
    {
        // Pre-select role if provided in query string
        $preselectedRole = $request->query('role');
        
        // Return the view
        return view('school-management.demo-login', compact('preselectedRole'));
    }

    /**
     * Handle SMS demo login
     */
    public function demoLogin(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,teacher,student,parent,accountant',
        ]);

        $roleName = $request->role;

                // Map demo roles to actual role names in SMS database
                $roleMapping = [
                    'admin' => 'admin',        // School Admin - manages entire school
                    'teacher' => 'teacher',   // Teacher uses teacher role in SMS (NOT tutor)
                    'student' => 'student',
                    'parent' => 'parent',
                    'accountant' => 'admin',   // Accountant uses admin role with fee access
                ];

        $actualRoleName = $roleMapping[$roleName] ?? $roleName;

        // Find or create demo user for this role
        $demoUser = $this->getOrCreateDemoUser($actualRoleName, $roleName);

        if (!$demoUser) {
            return back()->withErrors([
                'role' => 'Demo user could not be created. Please contact support.',
            ]);
        }

        // Store SMS user in session (separate from LearnersCom auth)
        session([
            'sms_user_id' => $demoUser->id,
            'sms_role' => $roleName,
            'sms_user' => $demoUser, // Store full user object
        ]);

        // Redirect based on role to SMS-specific routes (NEVER LearnersCom routes)
        $redirectRoutes = [
            'admin' => 'school.dashboard', // School Admin - manages entire school system
            'teacher' => 'sms.teacher.dashboard', // Teachers use SMS teacher dashboard
            'student' => 'sms.student.dashboard',
            'parent' => 'sms.parent.dashboard',
            'accountant' => 'school.dashboard', // Accountant uses school dashboard with fee access
        ];

        $redirectRoute = $redirectRoutes[$roleName] ?? 'school.dashboard';

        return redirect()->route($redirectRoute)
            ->with('success', 'Welcome to the School Management System demo!');
    }

    /**
     * Get or create a demo user for the specified role
     * Uses SMS-specific models, NOT LearnersCom models
     */
    private function getOrCreateDemoUser($roleName, $demoRoleName)
    {
        // Use SMS User model, NOT LearnersCom User
        // Try to use seeded users first
        $seededEmails = [
            'admin' => 'admin@demo.com',
            'teacher' => 'teacher@demo.com',
            'student' => 'ade.adebayo@student.demo.com', // Use first seeded student
            'parent' => 'parent@demo.com',
            'accountant' => 'admin@demo.com', // Accountant uses admin account
        ];

        $demoEmail = $seededEmails[$demoRoleName] ?? "demo-{$demoRoleName}@school-demo.com";

        // Find or create SMS demo user
        $user = \App\Models\Sms\SmsUser::firstOrCreate(
            ['email' => $demoEmail],
            [
                'name' => ucfirst(str_replace('-', ' ', $demoRoleName)) . ' Demo',
                'password' => bcrypt('demo123'), // Demo password
                'role' => $roleName, // Direct role field in SMS
                'is_active' => true,
            ]
        );

        // ALWAYS ensure user has a school_id (CRITICAL for admin)
        if (!$user->school_id) {
            // Try to get seeded school first
            $school = \App\Models\Sms\SmsSchool::where('name', 'Excellence Secondary School')->first();
            
            if (!$school) {
                // Create demo school if doesn't exist
                $school = \App\Models\Sms\SmsSchool::firstOrCreate(
                    ['name' => 'Excellence Secondary School'],
                    [
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
                    ]
                );
            }
            
            // Update user with school_id
            $user->update(['school_id' => $school->id]);
            $user->refresh(); // Refresh to get updated school_id
        }

        // For student role, ensure student profile exists
        if ($roleName === 'student' && !$user->studentProfile) {
            $this->createDemoStudentProfile($user);
        }

        // For teacher role, ensure teacher profile exists
        if ($roleName === 'teacher' && !$user->teacherProfile) {
            $this->createDemoTeacherProfile($user);
        }

        // For parent role, ensure parent profile exists
        // CRITICAL: Only create if role is actually 'parent' and user doesn't have student/teacher profile
        if ($roleName === 'parent' && !$user->parentProfile) {
            // CRITICAL: Refresh user to ensure we have latest data
            $user->refresh();
            
            // CRITICAL: Verify role is still 'parent' after refresh
            if ($user->role !== 'parent') {
                \Log::error('CRITICAL: Role mismatch when creating parent profile in SchoolManagementController', [
                    'user_id' => $user->id,
                    'expected_role' => 'parent',
                    'actual_role' => $user->role,
                ]);
                return null; // Don't create profile if role doesn't match
            }
            
            // CRITICAL: Check if user already has student or teacher profile - if so, DO NOT create parent profile
            if ($user->studentProfile) {
                \Log::error('CRITICAL: Attempted to create parent profile for user with student profile in SchoolManagementController', [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'student_id' => $user->studentProfile->id,
                ]);
                return null; // Don't create parent profile for students
            }
            
            if ($user->teacherProfile) {
                \Log::error('CRITICAL: Attempted to create parent profile for user with teacher profile in SchoolManagementController', [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'teacher_id' => $user->teacherProfile->id,
                ]);
                return null; // Don't create parent profile for teachers
            }
            
            $this->createDemoParentProfile($user);
        }

        return $user;
    }

    private function createDemoStudentProfile($user)
    {
        // Use seeded school (Excellence Secondary School)
        $school = \App\Models\Sms\SmsSchool::where('name', 'Excellence Secondary School')->first();
        
        if (!$school) {
            // Fallback to creating demo school if seeder hasn't run
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
        }

        // Update user with school_id
        $user->update(['school_id' => $school->id]);

        // Get a random class from seeded data
        $class = \App\Models\Sms\SmsClass::where('school_id', $school->id)->inRandomOrder()->first();
        
        if (!$class) {
            // Fallback to creating demo class (NO SECTIONS)
            $class = \App\Models\Sms\SmsClass::firstOrCreate(
                [
                    'school_id' => $school->id,
                    'name' => 'Basic 1',
                ],
                [
                    'academic_year' => date('Y'),
                    'capacity' => 40,
                ]
            );
        }

        // Create student profile
        \App\Models\Sms\SmsStudent::firstOrCreate(
            ['user_id' => $user->id],
            [
                'school_id' => $school->id,
                'student_id_number' => 'STU-' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
                'class_id' => $class->id,
                'admission_date' => now(),
                'date_of_birth' => now()->subYears(15),
                'gender' => 'male',
                'status' => 'active',
            ]
        );
    }

    private function createDemoTeacherProfile($user)
    {
        // Use seeded school
        $school = \App\Models\Sms\SmsSchool::where('name', 'Excellence Secondary School')->first();
        
        if (!$school) {
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
        }

        $user->update(['school_id' => $school->id]);

        \App\Models\Sms\SmsTeacher::firstOrCreate(
            ['user_id' => $user->id],
            [
                'school_id' => $school->id,
                'employee_id' => 'TCH-' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
                'qualification' => 'B.Ed',
                'specialization' => 'Mathematics',
                'hire_date' => now()->subMonths(6),
                'status' => 'active',
            ]
        );
    }

    private function createDemoParentProfile($user)
    {
        // CRITICAL: Refresh user from database to ensure we have latest role
        $user->refresh();
        
        // CRITICAL: Verify user role is 'parent' before creating profile
        if ($user->role !== 'parent') {
            \Log::error('CRITICAL: Attempted to create parent profile for non-parent user in SchoolManagementController', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_email' => $user->email,
            ]);
            throw new \Exception('Cannot create parent profile for user with role: ' . $user->role);
        }
        
        // CRITICAL: Check if user already has student or teacher profile
        if ($user->studentProfile) {
            \Log::error('CRITICAL: Attempted to create parent profile for user with existing student profile', [
                'user_id' => $user->id,
                'student_id' => $user->studentProfile->id,
            ]);
            throw new \Exception('Cannot create parent profile for user who already has a student profile');
        }
        
        if ($user->teacherProfile) {
            \Log::error('CRITICAL: Attempted to create parent profile for user with existing teacher profile', [
                'user_id' => $user->id,
                'teacher_id' => $user->teacherProfile->id,
            ]);
            throw new \Exception('Cannot create parent profile for user who already has a teacher profile');
        }
        
        // Use seeded school
        $school = \App\Models\Sms\SmsSchool::where('name', 'Excellence Secondary School')->first();
        
        if (!$school) {
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
        }

        $user->update(['school_id' => $school->id]);

        \Log::info('Creating parent profile for verified parent user', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_role' => $user->role,
        ]);

        $parent = \App\Models\Sms\SmsParent::firstOrCreate(
            ['user_id' => $user->id],
            [
                'school_id' => $school->id,
                'occupation' => 'Business',
                'relationship' => 'parent',
            ]
        );

        // Link to existing students if available (MAX 2 children)
        $existingChildrenCount = \Illuminate\Support\Facades\DB::table('parent_student')
            ->where('parent_id', $parent->id)
            ->count();
        
        $oldParentIdCount = \App\Models\Sms\SmsStudent::where('parent_id', $parent->id)
            ->where('school_id', $school->id)
            ->count();
        
        $totalChildren = $existingChildrenCount + $oldParentIdCount;
        $remainingSlots = max(0, 2 - $totalChildren);
        
        if ($remainingSlots > 0) {
            $students = \App\Models\Sms\SmsStudent::where('school_id', $school->id)
                ->whereNull('parent_id')
                ->limit($remainingSlots)
                ->get();
            
            foreach ($students as $student) {
                // Use pivot table instead of direct parent_id
                \Illuminate\Support\Facades\DB::table('parent_student')->insert([
                    'parent_id' => $parent->id,
                    'student_id' => $student->id,
                    'relationship' => 'father',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

