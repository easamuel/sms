<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index() { return view('tutor.marketplace'); }
    public function show($tutor) { return view('tutor.marketplace-show'); }
    public function book($tutor, Request $request) { return redirect()->back(); }
}
