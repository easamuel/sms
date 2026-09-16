<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamAssignmentController extends BaseSchoolController
{
    public function assignExam($exam) { return view('school.exams.assign'); }
    public function storeAssignment($exam, Request $request) { return redirect()->back(); }
    public function assignToAllStudents($exam, Request $request) { return redirect()->back(); }
    public function removeAssignment($exam, $student) { return redirect()->back(); }
}
