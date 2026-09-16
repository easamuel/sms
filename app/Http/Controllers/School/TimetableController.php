<?php

namespace App\Http\Controllers\School;

use App\Models\Sms\Timetable;
use App\Models\Sms\SmsClass;
use App\Models\Sms\SmsSubject;
use App\Models\Sms\SmsTeacher;
use Illuminate\Http\Request;

class TimetableController extends BaseSchoolController
{
    /**
     * Display timetables management page
     */
    public function index()
    {
        $school = $this->getSchool();

        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $currentYear = date('Y');
        $currentTerm = 'First Term';

        $classes = SmsClass::where('school_id', $school->id)->get();
        $subjects = SmsSubject::where('school_id', $school->id)->get();
        $teachers = SmsTeacher::where('school_id', $school->id)->get();

        $timetables = Timetable::where('school_id', $school->id)
            ->where('academic_year', $currentYear)
            ->where('term', $currentTerm)
            ->with(['class', 'subject', 'teacher'])
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        // Group by class and day
        $timetableByClass = $timetables->groupBy('class_id');

        return view('school.timetable.index', compact('classes', 'subjects', 'teachers', 'timetableByClass', 'currentYear', 'currentTerm'));
    }

    /**
     * Store new timetable entry
     */
    public function store(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $request->validate([
            'class_id' => 'required|exists:sms_classes,id',
            'subject_id' => 'required|exists:sms_subjects,id',
            'teacher_id' => 'required|exists:sms_teachers,id',
            'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'period_number' => 'nullable|string',
            'academic_year' => 'required|string',
            'term' => 'required|string',
        ]);

        Timetable::create([
            'school_id' => $school->id,
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'period_number' => $request->period_number,
            'academic_year' => $request->academic_year,
            'term' => $request->term,
            'is_active' => true,
        ]);

        return redirect()->route('school.timetable.index')
            ->with('success', 'Timetable entry created successfully.');
    }

    /**
     * Delete timetable entry
     */
    public function destroy(Timetable $timetable)
    {
        $timetable->delete();

        return redirect()->route('school.timetable.index')
            ->with('success', 'Timetable entry deleted successfully.');
    }
}
