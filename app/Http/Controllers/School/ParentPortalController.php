<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;

class ParentPortalController extends BaseSchoolController
{
    public function index() { return view('school.parents'); }
}
