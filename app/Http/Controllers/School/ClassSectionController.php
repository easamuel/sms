<?php

namespace App\Http\Controllers\School;

use App\Models\Sms\SmsClass;
use App\Models\Sms\SmsTeacher;
use Illuminate\Http\Request;

class ClassSectionController extends BaseSchoolController
{
    public function index()
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $classes = SmsClass::where('school_id', $school->id)
            ->with(['classTeacher', 'students'])
            ->orderBy('name')
            ->get();

        $teachers = SmsTeacher::where('school_id', $school->id)
            ->where('status', 'active')
            ->with('user')
            ->get();

        return view('school.classes.index', compact('classes', 'teachers', 'school'));
    }

    public function store(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|in:Basic 1,Basic 2,Basic 3,Basic 4,Basic 5,Basic 6,JSS1,JSS2,JSS3,SS1,SS2,SS3',
            'academic_year' => 'required|string',
            'capacity' => 'nullable|integer|min:1',
            'class_teacher_id' => 'nullable|exists:sms_teachers,id',
        ]);

        SmsClass::create([
            'school_id' => $school->id,
            'name' => $validated['name'],
            'section' => null, // No sections - removed
            'academic_year' => $validated['academic_year'],
            'capacity' => $validated['capacity'] ?? 40,
            'class_teacher_id' => $validated['class_teacher_id'] ?? null,
        ]);

        return redirect()->route('school.classes.index')
            ->with('success', 'Class created successfully.');
    }
}
