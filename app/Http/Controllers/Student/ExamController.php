<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index() { return view('student.exams'); }
    public function show($exam) { return view('student.exam-show'); }
    public function start($exam) { return redirect()->back(); }
    public function take($session) { return view('student.exam-take'); }
    public function saveAnswer($session, Request $request) { return response()->json(['success' => true]); }
    public function submit($session) { return redirect()->route('student.exams.result', $session); }
    public function result($session) { return view('student.exam-result'); }
}
