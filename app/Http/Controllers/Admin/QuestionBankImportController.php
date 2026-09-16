<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionBankImportController extends Controller
{
    public function showImportForm() { return view('admin.question-bank-import'); }
    public function importFromCSV(Request $request) { return redirect()->back(); }
    public function importBulk(Request $request) { return redirect()->back(); }
}
