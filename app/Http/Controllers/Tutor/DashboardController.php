<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() { return view('tutor.dashboard'); }
}
