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
        $smsUserId = session('sms_user_id');
        $smsRole = session('sms_role') ?? 'student';
        
        $smsUser = session('sms_user');
        if (!$smsUser && $smsUserId) {
            $smsUser = \App\Models\Sms\SmsUser::find($smsUserId);
        }

        if (!$smsUser) {
            $smsUser = \App\Models\Sms\SmsUser::where('role', $smsRole)->first()
                ?? \App\Models\Sms\SmsUser::where('role', 'student')->first();
            if ($smsUser) {
                session([
                    'sms_user_id' => $smsUser->id,
                    'sms_role' => $smsUser->role,
                    'sms_user' => $smsUser,
                ]);
                $smsRole = $smsUser->role;
            } else {
                return redirect()->route('school-management.demo-login')
                    ->with('error', 'Please login to access the Timetable.');
            }
        }

        $schoolId = $smsUser->school_id;
        if (!$schoolId) {
            $school = \App\Models\Sms\SmsSchool::first();
            $schoolId = $school ? $school->id : 1;
        }

        $currentYear = '2026/2027';
        $currentTerm = 'First Term';

        if ($smsRole === 'teacher') {
            return redirect()->route('sms.teacher.timetable');
        } else {
            // Student timetable
            $student = \App\Models\Sms\SmsStudent::where('user_id', $smsUser->id)->first();
            
            if (!$student) {
                $student = \App\Models\Sms\SmsStudent::where('school_id', $schoolId)->first();
            }

            if (!$student) {
                return redirect()->route('sms.student.dashboard')
                    ->with('error', 'Student profile not found.');
            }

            $timetables = Timetable::where('school_id', $schoolId);
            if ($student->class_id) {
                $timetables = $timetables->where('class_id', $student->class_id);
            }
            $timetables = $timetables->where('is_active', true)
                ->with(['subject', 'teacher', 'class'])
                ->orderBy('start_time')
                ->get();

            if ($timetables->isEmpty()) {
                $timetables = Timetable::where('school_id', $schoolId)
                    ->where('is_active', true)
                    ->with(['subject', 'teacher', 'class'])
                    ->orderBy('start_time')
                    ->get();
            }

            // Group by lowercase day
            $timetableByDay = $timetables->groupBy(function($item) {
                return strtolower($item->day);
            });

            return view('sms.student.timetable', compact('timetableByDay', 'currentYear', 'currentTerm', 'student', 'timetables'));
        }
    }
}
