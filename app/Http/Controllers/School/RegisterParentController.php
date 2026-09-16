<?php

namespace App\Http\Controllers\School;

use App\Models\Sms\SmsParent;
use App\Models\Sms\SmsStudent;
use App\Models\Sms\SmsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterParentController extends BaseSchoolController
{
    public function index()
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        // Get all students for suggestions - only those with user accounts and names
        $students = SmsStudent::where('school_id', $school->id)
            ->with(['user', 'class'])
            ->whereHas('user', function($query) {
                $query->whereNotNull('name')
                      ->where('name', '!=', '');
            })
            ->orderBy('student_id_number')
            ->get();

        // Prepare students data for JavaScript - filter out any without names
        $studentsData = $students->filter(function($s) {
            return $s->user && !empty(trim($s->user->name ?? ''));
        })->map(function($s) {
            return [
                'id' => $s->id,
                'name' => trim($s->user->name ?? ''),
                'student_id' => $s->student_id_number ?? '',
                'class' => $s->class ? ($s->class->name ?? 'N/A') : 'N/A',
            ];
        })->values()->all();

        return view('school.parents.register', compact('school', 'students', 'studentsData'));
    }

    public function store(Request $request)
    {
        $school = $this->getSchool();
        $smsUser = session('sms_user');

        if (!$school || !$smsUser) {
            return back()->with('error', 'Unauthorized.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:sms_users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'occupation' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:sms_students,id',
            'relationships' => 'nullable|array',
            'relationships.*' => 'in:father,mother,guardian,other',
        ]);

        DB::beginTransaction();
        try {
            // Create user account
            $user = SmsUser::create([
                'school_id' => $school->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'] ?? null, // Store phone in user table for login
                'role' => 'parent',
                'is_active' => true,
            ]);

            // Create parent profile
            $parent = SmsParent::create([
                'user_id' => $user->id,
                'school_id' => $school->id,
                'occupation' => $validated['occupation'] ?? null,
                'relationship' => 'parent',
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
            ]);

            // Link students if provided
            if (!empty($validated['student_ids'])) {
                $studentIds = $validated['student_ids'];

                foreach ($studentIds as $index => $studentId) {
                    // Verify student belongs to school
                    $student = SmsStudent::where('school_id', $school->id)
                        ->where('id', $studentId)
                        ->first();

                    if ($student) {
                        // Create relationship (default to 'guardian' as generic parent relationship)
                        DB::table('parent_student')->insert([
                            'parent_id' => $parent->id,
                            'student_id' => $studentId,
                            'relationship' => 'guardian',
                            'created_by' => $smsUser->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('school.parents.register')
                ->with('success', 'Parent registered successfully' . (!empty($validated['student_ids']) ? ' with ' . count($validated['student_ids']) . ' child(ren) linked.' : '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Parent registration failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Registration failed: ' . $e->getMessage())->withInput();
        }
    }

    public function searchStudents(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return response()->json(['error' => 'School not found'], 404);
        }

        $parentName = $request->input('parent_name', '');
        
        if (empty($parentName)) {
            return response()->json(['students' => []]);
        }

        // Extract first name from parent name (e.g., "John Bola" -> "John")
        $nameParts = explode(' ', trim($parentName));
        $firstName = $nameParts[0] ?? '';
        $lastName = end($nameParts) ?? '';

        // Search students by first name or last name
        $students = SmsStudent::where('school_id', $school->id)
            ->whereHas('user', function($query) use ($firstName, $lastName) {
                $query->where('name', 'LIKE', "%{$firstName}%")
                      ->orWhere('name', 'LIKE', "%{$lastName}%");
            })
            ->with(['user', 'class'])
            ->limit(20)
            ->get()
            ->map(function($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->user->name,
                    'student_id' => $student->student_id_number,
                    'class' => $student->class->name ?? 'N/A',
                ];
            });

        return response()->json(['students' => $students]);
    }
}
