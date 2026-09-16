<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TutorRegistrationController extends Controller
{
    public function index() { return view('student.tutors'); }
    public function show($tutor) { return view('student.tutor-show'); }
    public function register($tutor, Request $request) { return redirect()->back(); }
}
