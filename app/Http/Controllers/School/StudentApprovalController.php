<?php

namespace App\Http\Controllers\School;

use Illuminate\Http\Request;

class StudentApprovalController extends BaseSchoolController
{
    public function approve($id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $student = \App\Models\Sms\SmsStudent::where('school_id', $school->id)
            ->where('id', $id)
            ->first();
        
        if (!$student) {
            abort(403, 'Student does not belong to your school.');
        }

        $student->update(['status' => 'active']);
        if ($student->user) {
            $student->user->update(['is_active' => true]);
        }

        return back()->with('success', 'Student approved successfully.');
    }

    public function reject($id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $student = \App\Models\Sms\SmsStudent::where('school_id', $school->id)
            ->where('id', $id)
            ->first();
        
        if (!$student) {
            abort(403, 'Student does not belong to your school.');
        }

        $student->update(['status' => 'inactive']);
        if ($student->user) {
            $student->user->update(['is_active' => false]);
        }

        return back()->with('success', 'Student rejected.');
    }
}

