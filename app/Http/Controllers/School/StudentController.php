<?php

namespace App\Http\Controllers\School;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends BaseSchoolController
{

    public function index()
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        // Use SMS models, not LearnersCom models
        $pendingStudents = \App\Models\Sms\SmsStudent::where('school_id', $school->id)
            ->where(function($query) {
                $query->where('status', 'pending')
                      ->orWhereNull('status');
            })
            ->with(['user', 'class'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $approvedStudents = \App\Models\Sms\SmsStudent::where('school_id', $school->id)
            ->where('status', 'active')
            ->with(['user', 'class'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('school.students.index', compact('pendingStudents', 'approvedStudents', 'school'));
    }

    public function show($id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        // First, try to find the student
        $student = \App\Models\Sms\SmsStudent::where('id', $id)
            ->with(['user', 'class', 'school'])
            ->first();

        if (!$student) {
            return redirect()->route('school.students.index')
                ->with('error', 'Student not found.');
        }

        // Verify student belongs to this school
        if ($student->school_id != $school->id) {
            // Check if student has a school assigned
            $studentSchool = $student->school ? $student->school->name : 'Unknown School';
            return redirect()->route('school.students.index')
                ->with('error', "This student belongs to '{$studentSchool}' and cannot be accessed from your school. Student ID: {$student->student_id_number}");
        }

        return view('school.students.show', compact('student', 'school'));
    }

    public function create()
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $classes = \App\Models\Sms\SmsClass::where('school_id', $school->id)
            ->orderBy('name')
            ->get();

        $clubs = \App\Models\Sms\SmsClub::where('school_id', $school->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('school.students.create', compact('school', 'classes', 'clubs'));
    }

    public function addStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:sms_classes,id',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'club_id' => 'nullable|exists:sms_clubs,id',
            'club_position' => 'nullable|string|max:255',
        ], [
            'photo.required' => 'Student passport photograph is required. Please take or upload a photo.',
        ]);

        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        // Generate unique email (not used for login, but required for user model)
        $baseEmail = strtolower(str_replace(' ', '.', $request->name)) . '@student.' . strtolower(str_replace(' ', '', $school->name)) . '.com';
        $email = $baseEmail;
        $counter = 1;
        
        // Ensure email is unique
        while (\App\Models\Sms\SmsUser::where('email', $email)->exists()) {
            $email = str_replace('@', $counter . '@', $baseEmail);
            $counter++;
        }

        // Create SMS user (email is auto-generated, not used for login)
        $userData = [
            'name' => $request->name,
            'email' => $email,
            'password' => bcrypt('password123'), // Default password
            'role' => 'student', // Explicitly set role - required field
            'school_id' => $school->id,
            'is_active' => true,
        ];
        
        try {
            $user = \App\Models\Sms\SmsUser::create($userData);
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database errors
            if (str_contains($e->getMessage(), 'role')) {
                return back()->withInput()->withErrors([
                    'name' => 'Database error: Role field issue. Please contact administrator.',
                ]);
            }
            return back()->withInput()->withErrors([
                'name' => 'Failed to create student account: ' . $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([
                'name' => 'Failed to create student account: ' . $e->getMessage(),
            ]);
        }

        // Generate Student ID: STU-YYYY-XXXXX format
        $currentYear = date('Y');
        $lastStudent = \App\Models\Sms\SmsStudent::where('school_id', $school->id)
            ->where('student_id_number', 'like', 'STU-' . $currentYear . '-%')
            ->orderBy('student_id_number', 'desc')
            ->first();
        
        if ($lastStudent && preg_match('/STU-' . $currentYear . '-(\d+)/', $lastStudent->student_id_number, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }
        
        $studentIdNumber = 'STU-' . $currentYear . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = $studentIdNumber . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $photoPath = $photo->storeAs('student-photos', $photoName, 'public');
        }

        // Create student profile
        try {
            $student = \App\Models\Sms\SmsStudent::create([
                'school_id' => $school->id,
                'user_id' => $user->id,
                'student_id_number' => $studentIdNumber,
                'class_id' => $request->class_id,
                'club_id' => $request->club_id,
                'club_position' => $request->club_position ?? 'Member',
                'admission_date' => now(),
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'photo' => $photoPath,
                'status' => 'active',
            ]);
        } catch (\Exception $e) {
            // If student creation fails, delete the user to maintain data integrity
            $user->delete();
            return back()->withInput()->withErrors([
                'name' => 'Failed to create student profile: ' . $e->getMessage(),
            ]);
        }

        // Verify both user and student were created successfully
        if (!$student || !$user) {
            return back()->withInput()->withErrors([
                'name' => 'Failed to create student account. Please try again.',
            ]);
        }

        return redirect()->route('school.students.index')
            ->with('success', "Student added successfully. Student ID: <strong>{$studentIdNumber}</strong> | Password: <strong>password123</strong>");
    }

    public function idCards()
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        // Get ALL registered students for this school (regardless of status)
        // This way admins can see all students they've registered and download their ID cards
        $students = \App\Models\Sms\SmsStudent::where('school_id', $school->id)
            ->with(['user', 'class', 'club'])
            ->orderBy('student_id_number')
            ->get();

        return view('school.students.id-cards', compact('students', 'school'));
    }

    public function downloadIdCard($id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        // Debug: Log the request
        \Log::info('ID Card download attempt', [
            'student_id' => $id,
            'school_id' => $school->id,
            'school_name' => $school->name,
        ]);

        // Find student by ID first (without school filter to see if student exists)
        $student = \App\Models\Sms\SmsStudent::where('id', $id)
            ->with(['user', 'class', 'club', 'school', 'parent.user'])
            ->first();

        if (!$student) {
            \Log::warning('Student not found in database', ['student_id' => $id]);
            return redirect()->route('school.students.id-cards')
                ->with('error', 'Student not found. Invalid student ID: ' . $id);
        }

        // Verify student belongs to this school
        if ($student->school_id != $school->id) {
            $studentSchool = $student->school ? $student->school->name : 'Unknown School';
            \Log::warning('Student school mismatch', [
                'student_id' => $id,
                'student_school_id' => $student->school_id,
                'admin_school_id' => $school->id,
            ]);
            return redirect()->route('school.students.id-cards')
                ->with('error', "This student belongs to '{$studentSchool}' and cannot be accessed from your school.");
        }

        \Log::info('ID Card download successful', [
            'student_id' => $id,
            'student_name' => $student->user->name ?? 'N/A',
        ]);

        // Load club relationship for department/group display
        $student->load('club');
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('school.students.id-card-pdf', compact('student', 'school'));
        // ID card size: 85.6mm x 53.98mm (credit card size) = 242.65 x 153.07 points
        // But we're using a larger format for better readability: 340px x 215px
        $pdf->setPaper([0, 0, 340, 215], 'portrait'); // Single page ID card
        
        $filename = 'ID_Card_' . $student->student_id_number . '.pdf';
        
        return $pdf->download($filename);
    }

    public function downloadAllIdCards()
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        // Get ALL registered students for this school (regardless of status)
        $students = \App\Models\Sms\SmsStudent::where('school_id', $school->id)
            ->with(['user', 'class', 'club', 'school'])
            ->orderBy('student_id_number')
            ->get();

        if ($students->isEmpty()) {
            return back()->with('error', 'No active students found.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('school.students.id-cards-pdf', compact('students', 'school'));
        $pdf->setPaper('a4', 'portrait');
        
        $filename = 'ID_Cards_' . $school->name . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    public function destroy($id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $student = \App\Models\Sms\SmsStudent::where('id', $id)
            ->where('school_id', $school->id)
            ->with('user')
            ->first();

        if (!$student) {
            return redirect()->route('school.students.index')
                ->with('error', 'Student not found or does not belong to your school.');
        }

        try {
            \DB::beginTransaction();

            $studentName = $student->user->name ?? 'Unknown';
            $studentIdNumber = $student->student_id_number;

            // Delete related records first
            // Delete parent-student relationships
            \DB::table('parent_student')->where('student_id', $student->id)->delete();
            
            // Delete fee payments
            \App\Models\Sms\SmsFeePayment::where('student_id', $student->id)->delete();
            
            // Delete student fees
            \App\Models\Sms\StudentFee::where('student_id', $student->id)->delete();
            
            // Delete exam results
            \App\Models\Sms\SmsExamResult::where('student_id', $student->id)->delete();
            
            // Delete exam sessions
            \App\Models\Sms\SmsExamSession::where('student_id', $student->id)->delete();
            
            // Delete attendance records
            \App\Models\Sms\SmsAttendance::where('student_id', $student->id)->delete();
            
            // Delete the student profile
            $student->delete();

            // Delete the user account if it exists
            if ($student->user) {
                $student->user->delete();
            }

            \DB::commit();

            return redirect()->route('school.students.index')
                ->with('success', "Student '{$studentName}' (ID: {$studentIdNumber}) has been deleted successfully.");
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error deleting student', [
                'student_id' => $id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('school.students.index')
                ->with('error', 'Failed to delete student: ' . $e->getMessage());
        }
    }

    public function cleanupDemoAccounts()
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        try {
            DB::beginTransaction();

            // Define demo account emails to keep (one per role)
            $demoEmailsToKeep = [
                'admin@demo.com',
                'teacher@demo.com',
                'ade.adebayo@student.demo.com', // Keep first seeded student
                'parent@demo.com',
            ];

            $deletedCount = 0;
            $deletedAccounts = [];

            // Get all demo users (by email pattern or name pattern)
            $demoUsers = \App\Models\Sms\SmsUser::where(function($query) {
                $query->where('email', 'like', '%@demo.com')
                      ->orWhere('email', 'like', '%@student.demo.com')
                      ->orWhere('email', 'like', '%demo%@school-demo.com')
                      ->orWhere('name', 'like', '%Demo%');
            })->get();

            // Process by role to avoid duplicates
            $roles = ['admin', 'teacher', 'student', 'parent'];
            $processedUsers = [];

            foreach ($roles as $role) {
                // Get all demo users for this role
                $roleUsers = \App\Models\Sms\SmsUser::where('role', $role)
                    ->where(function($q) {
                        $q->where('email', 'like', '%@demo.com')
                          ->orWhere('email', 'like', '%@student.demo.com')
                          ->orWhere('email', 'like', '%demo%@school-demo.com')
                          ->orWhere('name', 'like', '%Demo%');
                    })
                    ->whereNotIn('email', $demoEmailsToKeep)
                    ->orderBy('created_at', 'asc')
                    ->get();

                // Keep the first one, delete the rest
                $keepFirst = true;
                foreach ($roleUsers as $roleUser) {
                    if (in_array($roleUser->id, $processedUsers)) {
                        continue; // Already processed
                    }

                    if ($keepFirst) {
                        $keepFirst = false;
                        $processedUsers[] = $roleUser->id;
                        continue; // Keep this one
                    }

                    // Delete student profile if exists
                    if ($roleUser->role === 'student') {
                        $student = \App\Models\Sms\SmsStudent::where('user_id', $roleUser->id)->first();
                        if ($student) {
                            // Delete related records
                            DB::table('parent_student')->where('student_id', $student->id)->delete();
                            \App\Models\Sms\SmsFeePayment::where('student_id', $student->id)->delete();
                            \App\Models\Sms\StudentFee::where('student_id', $student->id)->delete();
                            \App\Models\Sms\SmsExamResult::where('student_id', $student->id)->delete();
                            \App\Models\Sms\SmsExamSession::where('student_id', $student->id)->delete();
                            \App\Models\Sms\SmsAttendance::where('student_id', $student->id)->delete();
                            $student->delete();
                        }
                    }

                    // Delete parent profile if exists
                    if ($roleUser->role === 'parent') {
                        $parent = \App\Models\Sms\SmsParent::where('user_id', $roleUser->id)->first();
                        if ($parent) {
                            DB::table('parent_student')->where('parent_id', $parent->id)->delete();
                            $parent->delete();
                        }
                    }

                    // Delete teacher profile if exists
                    if ($roleUser->role === 'teacher') {
                        $teacher = \App\Models\Sms\SmsTeacher::where('user_id', $roleUser->id)->first();
                        if ($teacher) {
                            $teacher->delete();
                        }
                    }

                    $deletedAccounts[] = $roleUser->email . ' (' . $roleUser->role . ')';
                    $roleUser->delete();
                    $deletedCount++;
                    $processedUsers[] = $roleUser->id;
                }
            }

            DB::commit();

            $message = "Cleanup completed. Deleted {$deletedCount} duplicate demo account(s).";
            if ($deletedCount > 0) {
                $message .= " Deleted: " . implode(', ', array_slice($deletedAccounts, 0, 10));
                if (count($deletedAccounts) > 10) {
                    $message .= ' and ' . (count($deletedAccounts) - 10) . ' more.';
                }
            }

            return redirect()->route('school.students.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error cleaning up demo accounts', [
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('school.students.index')
                ->with('error', 'Failed to cleanup demo accounts: ' . $e->getMessage());
        }
    }
}
