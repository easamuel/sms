<?php

namespace App\Http\Controllers\School;

use App\Models\Sms\SmsParent;
use App\Models\Sms\SmsStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentStudentController extends BaseSchoolController
{
    public function index()
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $students = SmsStudent::where('school_id', $school->id)
            ->with(['user', 'class', 'linkedParents.user'])
            ->orderBy('student_id_number')
            ->paginate(20);

        $parents = SmsParent::where('school_id', $school->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('school.students.assign-parent', compact('students', 'parents', 'school'));
    }

    public function assign(Request $request)
    {
        $school = $this->getSchool();
        $smsUser = session('sms_user');

        if (!$school || !$smsUser) {
            return back()->with('error', 'Unauthorized.');
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:sms_students,id',
            'parent_id' => 'required|exists:sms_parents,id',
            'relationship' => 'required|in:father,mother,guardian,other',
        ]);

        // Verify student belongs to school
        $student = SmsStudent::where('school_id', $school->id)
            ->where('id', $validated['student_id'])
            ->firstOrFail();

        // Verify parent belongs to school
        $parent = SmsParent::where('school_id', $school->id)
            ->where('id', $validated['parent_id'])
            ->firstOrFail();

        // Check if relationship already exists
        $exists = DB::table('parent_student')
            ->where('parent_id', $validated['parent_id'])
            ->where('student_id', $validated['student_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'This parent is already linked to this student.');
        }

        // CRITICAL: Enforce 2-child maximum per parent
        // Count children via parent_student pivot table
        $pivotChildrenCount = DB::table('parent_student')
            ->where('parent_id', $validated['parent_id'])
            ->count();
        
        // Count children via old parent_id field (but exclude if already in pivot)
        $oldParentIdStudents = SmsStudent::where('parent_id', $validated['parent_id'])
            ->where('school_id', $school->id)
            ->pluck('id')
            ->toArray();
        
        // Get students already in pivot table for this parent
        $pivotStudentIds = DB::table('parent_student')
            ->where('parent_id', $validated['parent_id'])
            ->pluck('student_id')
            ->toArray();
        
        // Count only students in old parent_id that are NOT in pivot table
        $oldParentIdCount = count(array_diff($oldParentIdStudents, $pivotStudentIds));
        
        $totalChildren = $pivotChildrenCount + $oldParentIdCount;
        
        // STRICT: Block if parent already has 2 or more children
        if ($totalChildren >= 2) {
            return back()->with('error', 'This parent already has ' . $totalChildren . ' children assigned. Maximum of 2 children per parent is enforced. Please remove an existing assignment first.');
        }

        // Create relationship
        DB::table('parent_student')->insert([
            'parent_id' => $validated['parent_id'],
            'student_id' => $validated['student_id'],
            'relationship' => $validated['relationship'],
            'created_by' => $smsUser->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Parent assigned successfully.');
    }

    public function remove(Request $request, $studentId, $parentId)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return back()->with('error', 'Unauthorized.');
        }

        // Verify both belong to school
        $student = SmsStudent::where('school_id', $school->id)
            ->where('id', $studentId)
            ->firstOrFail();

        $parent = SmsParent::where('school_id', $school->id)
            ->where('id', $parentId)
            ->firstOrFail();

        DB::table('parent_student')
            ->where('parent_id', $parentId)
            ->where('student_id', $studentId)
            ->delete();

        return back()->with('success', 'Parent-student relationship removed.');
    }
}
