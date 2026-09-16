<?php

namespace App\Http\Controllers\School;

use App\Models\Sms\SmsTeacher;
use Illuminate\Http\Request;

class StaffController extends BaseSchoolController
{
    public function index(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $schoolId = $school->id;

        $query = SmsTeacher::where('school_id', $schoolId)
            ->with(['user', 'school']);

        // Optional filters for a more modern, usable staff list
        $search = $request->input('q');
        $teacherType = $request->input('teacher_type');
        $status = $request->input('status');

        if (!empty($search)) {
            $query->where(function ($builder) use ($search) {
                $builder->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                })->orWhere('employee_id', 'like', '%' . $search . '%');
            });
        }

        if (!empty($teacherType) && in_array($teacherType, ['primary', 'secondary'], true)) {
            $query->where('teacher_type', $teacherType);
        }

        if (!empty($status) && in_array($status, ['active', 'inactive', 'suspended'], true)) {
            $query->where('status', $status);
        }

        $teachers = $query
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends($request->query());
        
        $totalStaff = SmsTeacher::where('school_id', $schoolId)->count();
        $activeStaff = SmsTeacher::where('school_id', $schoolId)->where('status', 'active')->count();
        $inactiveStaff = SmsTeacher::where('school_id', $schoolId)->where('status', 'inactive')->count();
        $suspendedStaff = SmsTeacher::where('school_id', $schoolId)->where('status', 'suspended')->count();

        return view('school.staff.index', compact(
            'teachers',
            'search',
            'teacherType',
            'status',
            'totalStaff',
            'activeStaff',
            'inactiveStaff',
            'suspendedStaff'
        ));
    }

    public function create()
    {
        return view('school.staff.create');
    }

    public function store(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $schoolId = $school->id;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'teacher_type' => 'required|in:primary,secondary',
            'phone' => 'nullable|string',
            'qualification' => 'nullable|string',
            'specialization' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'salary' => 'nullable|numeric',
        ]);

        // Generate unique email (not used for login, but required for user model)
        $baseEmail = strtolower(str_replace(' ', '.', $validated['name'])) . '@teacher.' . strtolower(str_replace(' ', '', $school->name)) . '.com';
        $email = $baseEmail;
        $counter = 1;
        
        // Ensure email is unique
        while (\App\Models\Sms\SmsUser::where('email', $email)->exists()) {
            $email = str_replace('@', $counter . '@', $baseEmail);
            $counter++;
        }

        // Generate Employee ID: TCH-YYYY-XXXX format
        $currentYear = date('Y');
        $lastTeacher = SmsTeacher::where('school_id', $schoolId)
            ->where('employee_id', 'like', 'TCH-' . $currentYear . '-%')
            ->orderBy('employee_id', 'desc')
            ->first();
        
        if ($lastTeacher && preg_match('/TCH-' . $currentYear . '-(\d+)/', $lastTeacher->employee_id, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }
        
        $employeeId = 'TCH-' . $currentYear . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Create SMS user
        $user = \App\Models\Sms\SmsUser::create([
            'name' => $validated['name'],
            'email' => $email,
            'phone' => $validated['phone'] ?? null,
            'password' => bcrypt('password123'), // Default password
            'role' => 'teacher',
            'school_id' => $schoolId,
            'is_active' => true,
        ]);

        // Create teacher profile
        SmsTeacher::create([
            'school_id' => $schoolId,
            'user_id' => $user->id,
            'employee_id' => $employeeId,
            'teacher_type' => $validated['teacher_type'],
            'qualification' => $validated['qualification'] ?? null,
            'specialization' => $validated['specialization'] ?? null,
            'hire_date' => $validated['hire_date'] ?? now(),
            'salary' => $validated['salary'] ?? null,
            'status' => 'active',
        ]);

        return redirect()->route('school.staff.index')
            ->with('success', "Teacher added successfully. Employee ID: <strong>{$employeeId}</strong> | Password: <strong>password123</strong>");
    }

    public function show($id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $teacher = SmsTeacher::where('school_id', $school->id)
            ->where('id', $id)
            ->with(['user', 'subjects', 'classes'])
            ->firstOrFail();

        // Get assigned subjects
        $assignedSubjects = $teacher->subjects;
        
        // Get assigned classes
        $assignedClasses = $teacher->classes;

        // Get all available subjects for this teacher type
        if ($teacher->teacher_type === 'primary') {
            // Primary teachers can teach all subjects (Basic 1-6 subjects)
            $availableSubjects = \App\Models\Sms\SmsSubject::where('school_id', $school->id)
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        } else {
            // Secondary teachers can teach JSS1-SS3 subjects
            $availableSubjects = \App\Models\Sms\SmsSubject::where('school_id', $school->id)
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        }

        // Get available classes based on teacher type
        if ($teacher->teacher_type === 'primary') {
            $availableClasses = \App\Models\Sms\SmsClass::where('school_id', $school->id)
                ->whereIn('name', ['Basic 1', 'Basic 2', 'Basic 3', 'Basic 4', 'Basic 5', 'Basic 6'])
                ->orderBy('name')
                ->get();
        } else {
            $availableClasses = \App\Models\Sms\SmsClass::where('school_id', $school->id)
                ->whereIn('name', ['JSS1', 'JSS2', 'JSS3', 'SS1', 'SS2', 'SS3'])
                ->orderBy('name')
                ->get();
        }

        return view('school.staff.show', compact('teacher', 'assignedSubjects', 'assignedClasses', 'availableSubjects', 'availableClasses'));
    }

    public function edit($id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $teacher = SmsTeacher::where('school_id', $school->id)
            ->where('id', $id)
            ->with('user')
            ->firstOrFail();

        return view('school.staff.edit', compact('teacher'));
    }

    public function update(Request $request, $id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $teacher = SmsTeacher::where('school_id', $school->id)
            ->where('id', $id)
            ->with('user')
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'teacher_type' => 'required|in:primary,secondary',
            'phone' => 'nullable|string',
            'qualification' => 'nullable|string',
            'specialization' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'salary' => 'nullable|numeric',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        // Update user
        $teacher->user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
        ]);

        // Update teacher profile
        $teacher->update([
            'teacher_type' => $validated['teacher_type'],
            'qualification' => $validated['qualification'] ?? null,
            'specialization' => $validated['specialization'] ?? null,
            'hire_date' => $validated['hire_date'] ?? $teacher->hire_date,
            'salary' => $validated['salary'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('school.staff.show', $teacher->id)
            ->with('success', 'Teacher updated successfully.');
    }

    public function assignSubjects(Request $request, $id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $teacher = SmsTeacher::where('school_id', $school->id)
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'subject_ids' => 'nullable|array',
            'subject_ids.*' => 'exists:sms_subjects,id',
        ]);

        // Get the subject IDs from the request (can be empty array)
        $subjectIds = $request->input('subject_ids', []);

        // Validate that all subject IDs belong to the school
        if (!empty($subjectIds)) {
            $validSubjectIds = \App\Models\Sms\SmsSubject::where('school_id', $school->id)
                ->whereIn('id', $subjectIds)
                ->pluck('id')
                ->toArray();
            
            if (count($validSubjectIds) !== count($subjectIds)) {
                return back()->withErrors([
                    'subject_ids' => 'Some selected subjects are invalid or do not belong to this school.',
                ])->withInput();
            }
            
            $subjectIds = $validSubjectIds;
        }

        // Sync subjects (replace existing assignments)
        // If subject_ids is empty array, it will remove all assignments
        try {
            $teacher->subjects()->sync($subjectIds);
            
            $message = count($subjectIds) > 0 
                ? 'Subjects assigned successfully. (' . count($subjectIds) . ' subject(s))'
                : 'All subject assignments removed.';
            
            return redirect()->route('school.staff.show', $teacher->id)
                ->with('success', $message);
        } catch (\Exception $e) {
            \Log::error('Error assigning subjects to teacher: ' . $e->getMessage());
            return back()->withErrors([
                'subject_ids' => 'Error assigning subjects. Please try again.',
            ])->withInput();
        }
    }

    public function removeSubject(Request $request, $id, $subjectId)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $teacher = SmsTeacher::where('school_id', $school->id)
            ->where('id', $id)
            ->firstOrFail();

        // Detach the specific subject
        $teacher->subjects()->detach($subjectId);

        return redirect()->route('school.staff.show', $teacher->id)
            ->with('success', 'Subject removed successfully.');
    }

    public function assignClasses(Request $request, $id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $teacher = SmsTeacher::where('school_id', $school->id)
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'class_ids' => 'nullable|array',
            'class_ids.*' => 'exists:sms_classes,id',
        ]);

        // Sync classes (replace existing assignments)
        // If class_ids is null or empty, it will remove all assignments
        $teacher->classes()->sync($request->class_ids ?? []);

        return redirect()->route('school.staff.show', $teacher->id)
            ->with('success', 'Classes assigned successfully.');
    }

    public function removeClass(Request $request, $id, $classId)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $teacher = SmsTeacher::where('school_id', $school->id)
            ->where('id', $id)
            ->firstOrFail();

        // Detach the specific class
        $teacher->classes()->detach($classId);

        return redirect()->route('school.staff.show', $teacher->id)
            ->with('success', 'Class removed successfully.');
    }

}
