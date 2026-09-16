<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionScraperController extends Controller
{
    public function index() { return view('admin.question-scraper'); }
    public function scrapeFromUrl(Request $request) { return redirect()->back(); }
    public function importFromText(Request $request) { return redirect()->back(); }
    public function importScraped(Request $request) { return redirect()->back(); }
}
