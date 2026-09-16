<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;

class SettingController extends BaseSchoolController
{
    public function index() { return view('school.settings'); }
}
