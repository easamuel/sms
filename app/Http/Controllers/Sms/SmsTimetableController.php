<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\Sms\Timetable;
use App\Models\Sms\SmsClass;
use App\Models\Sms\SmsSubject;
use App\Models\Sms\SmsTeacher;
use Illuminate\Http\Request;

class SmsTimetableController extends Controller
{
    /**
     * Show timetable for current user (teacher or student)
     */
    public function index()
    {
        $smsUser = session('sms_user');
        $smsRole = session('sms_role');
        $schoolId = $smsUser->school_id ?? null;

        if (!$schoolId) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found.');
        }

        $currentYear = date('Y');
        $currentTerm = 'First Term'; // Default, can be made dynamic

        if ($smsRole === 'teacher') {
            // Get teacher's timetable
            $teacher = SmsTeacher::where('user_id', $smsUser->id)->first();
            
            if (!$teacher) {
                return redirect()->route('sms.teacher.dashboard')
                    ->with('error', 'Teacher profile not found.');
            }

            $timetables = Timetable::where('school_id', $schoolId)
                ->where('teacher_id', $teacher->id)
                ->where('academic_year', $currentYear)
                ->where('term', $currentTerm)
                ->where('is_active', true)
                ->with(['class', 'subject'])
                ->orderBy('day')
                ->orderBy('start_time')
                ->get();

            // Group by day
            $timetableByDay = $timetables->groupBy('day');

            return view('sms.teacher.timetable', compact('timetableByDay', 'currentYear', 'currentTerm'));
        } else {
            // Student timetable
            $student = \App\Models\Sms\SmsStudent::where('user_id', $smsUser->id)->first();
            
            if (!$student || !$student->class_id) {
                return redirect()->route('sms.student.dashboard')
                    ->with('error', 'Student profile or class not found.');
            }

            $timetables = Timetable::where('school_id', $schoolId)
                ->where('class_id', $student->class_id)
                ->where('academic_year', $currentYear)
                ->where('term', $currentTerm)
                ->where('is_active', true)
                ->with(['subject', 'teacher'])
                ->orderBy('day')
                ->orderBy('start_time')
                ->get();

            // Group by day
            $timetableByDay = $timetables->groupBy('day');

            return view('sms.student.timetable', compact('timetableByDay', 'currentYear', 'currentTerm', 'student'));
        }
    }
}
