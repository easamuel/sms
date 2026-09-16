<?php

namespace App\Http\Controllers\School;

use App\Models\Sms\SmsParent;
use App\Models\Sms\SmsUser;
use App\Models\Sms\SmsStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ParentController extends BaseSchoolController
{
    public function index(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $query = SmsParent::where('school_id', $school->id)
            ->with(['user', 'linkedStudents.user', 'linkedStudents.class']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $parents = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get statistics
        $totalParents = SmsParent::where('school_id', $school->id)->count();
        $activeParents = SmsParent::where('school_id', $school->id)
            ->whereHas('user', function($q) {
                $q->where('is_active', true);
            })->count();

        return view('school.parents.index', compact('parents', 'totalParents', 'activeParents', 'school'));
    }

    public function show($id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $parent = SmsParent::where('school_id', $school->id)
            ->with(['user', 'linkedStudents.user', 'linkedStudents.class', 'students.user', 'students.class'])
            ->findOrFail($id);

        // Get all linked children (both old parent_id and new many-to-many)
        $childrenOld = $parent->students()->with(['user', 'class'])->get();
        $childrenLinked = $parent->linkedStudents()->with(['user', 'class'])->get();
        $allChildren = $childrenOld->merge($childrenLinked)->unique('id');

        return view('school.parents.show', compact('parent', 'allChildren', 'school'));
    }

    public function edit($id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $parent = SmsParent::where('school_id', $school->id)
            ->with(['user', 'linkedStudents'])
            ->findOrFail($id);

        // Get all students for linking
        $students = SmsStudent::where('school_id', $school->id)
            ->with(['user', 'class'])
            ->whereHas('user', function($query) {
                $query->whereNotNull('name')
                      ->where('name', '!=', '');
            })
            ->orderBy('student_id_number')
            ->get();

        // Prepare students data for JavaScript
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

        // Get currently linked students
        $linkedStudentIds = $parent->linkedStudents()->pluck('sms_students.id')->toArray();
        $oldParentStudentIds = $parent->students()->pluck('id')->toArray();
        $allLinkedIds = array_unique(array_merge($linkedStudentIds, $oldParentStudentIds));

        return view('school.parents.edit', compact('parent', 'students', 'studentsData', 'allLinkedIds', 'school'));
    }

    public function update(Request $request, $id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $parent = SmsParent::where('school_id', $school->id)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:sms_users,email,' . $parent->user_id,
            'phone' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8',
            'is_active' => 'boolean',
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:sms_students,id',
            'relationships' => 'nullable|array',
            'relationships.*' => 'in:father,mother,guardian,other',
        ]);

        DB::beginTransaction();
        try {
            // Update user account
            $user = $parent->user;
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'] ?? null; // Update phone in user table for login
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            if (isset($validated['is_active'])) {
                $user->is_active = $validated['is_active'];
            }
            $user->save();

            // Update parent profile
            $parent->occupation = $validated['occupation'] ?? null;
            $parent->phone = $validated['phone'] ?? null;
            $parent->address = $validated['address'] ?? null;
            $parent->save();

            // Update student links if provided
            if (isset($validated['student_ids'])) {
                $studentIds = $validated['student_ids'];

                // Remove all existing links
                DB::table('parent_student')->where('parent_id', $parent->id)->delete();

                // Add new links (default relationship to 'parent')
                foreach ($studentIds as $index => $studentId) {
                    $student = SmsStudent::where('school_id', $school->id)
                        ->where('id', $studentId)
                        ->first();

                    if ($student) {
                        DB::table('parent_student')->insert([
                            'parent_id' => $parent->id,
                            'student_id' => $studentId,
                            'relationship' => 'guardian',
                            'created_by' => session('sms_user')->id ?? null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('school.parents.index')
                ->with('success', 'Parent updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Parent update failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Update failed: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $parent = SmsParent::where('school_id', $school->id)
            ->with('user')
            ->findOrFail($id);

        DB::beginTransaction();
        try {
            // Remove all parent-student relationships
            DB::table('parent_student')->where('parent_id', $parent->id)->delete();

            // Delete parent record
            $userId = $parent->user_id;
            $parent->delete();

            // Delete user account
            if ($userId) {
                SmsUser::where('id', $userId)->delete();
            }

            DB::commit();

            return redirect()->route('school.parents.index')
                ->with('success', 'Parent deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Parent deletion failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Deletion failed: ' . $e->getMessage());
        }
    }
}
