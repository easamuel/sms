<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index() { return view('tutor.students'); }
    public function show($student) { return view('tutor.student-show'); }
    public function approve($tutorStudent, Request $request) { return redirect()->back(); }
    public function reject($tutorStudent, Request $request) { return redirect()->back(); }
}
