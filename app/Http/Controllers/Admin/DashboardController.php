<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() { return view('admin.dashboard'); }
    public function users() { return view('admin.users'); }
    public function showUser($user) { return view('admin.user-show'); }
    public function updateUserStatus($user, Request $request) { return redirect()->back(); }
    public function exams() { return view('admin.exams'); }
    public function activityLogs() { return view('admin.activity-logs'); }
}
