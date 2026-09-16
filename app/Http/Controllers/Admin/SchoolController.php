<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index() { return view('admin.schools'); }
    public function show($school) { return view('admin.school-show'); }
    public function verify($school, Request $request) { return redirect()->back(); }
}
