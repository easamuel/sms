<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionBankController extends Controller
{
    public function index() { return view('admin.question-bank'); }
    public function create() { return view('admin.question-bank-create'); }
    public function store(Request $request) { return redirect()->back(); }
    public function edit($questionBank) { return view('admin.question-bank-edit'); }
    public function update($questionBank, Request $request) { return redirect()->back(); }
    public function destroy($questionBank) { return redirect()->back(); }
}
