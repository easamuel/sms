<?php

namespace App\Http\Controllers\School;

use App\Models\Sms\SmsAttendance;
use App\Models\Sms\SmsClass;
use App\Models\Sms\SmsStudent;
use Illuminate\Http\Request;

class AttendanceController extends BaseSchoolController
{
    public function index(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $schoolId = $school->id;
        
        $date = $request->get('date', now()->format('Y-m-d'));
        $classId = $request->get('class_id');

        $classes = SmsClass::where('school_id', $schoolId)->get();

        $query = SmsAttendance::where('school_id', $schoolId)
            ->whereDate('date', $date);

        if ($classId) {
            $query->where('class_id', $classId);
        }

        $attendances = $query->with(['student', 'class'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('school.attendance.index', compact('attendances', 'classes', 'date', 'classId'));
    }

    public function mark(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $schoolId = $school->id;

        $validated = $request->validate([
            'student_id' => 'required|exists:sms_students,id',
            'class_id' => 'required|exists:sms_classes,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,excused',
            'remarks' => 'nullable|string',
        ]);

        SmsAttendance::updateOrCreate(
            [
                'school_id' => $schoolId,
                'student_id' => $validated['student_id'],
                'class_id' => $validated['class_id'],
                'date' => $validated['date'],
            ],
            [
                'status' => $validated['status'],
                'remarks' => $validated['remarks'] ?? null,
            ]
        );

        return redirect()->back()
            ->with('success', 'Attendance marked successfully.');
    }

}
