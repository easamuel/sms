<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesMaterialsController extends Controller
{
    /**
     * Interactive Hub displaying all 5 sales proofs and outreach materials
     */
    public function index()
    {
        return view('materials.index');
    }

    /**
     * Proof 1: Master Continuous Assessment & Examination Broadsheet ("The Tally Sheet")
     */
    public function tally()
    {
        return view('materials.tally');
    }

    /**
     * Proof 2: Official Student Terminal Report Card Sample
     */
    public function reportCard()
    {
        return view('materials.report-card');
    }

    /**
     * Proof 3: Official School Graduation Certificate & Testimonial Sample
     */
    public function certificate()
    {
        return view('materials.certificate');
    }

    /**
     * Proof 4: Bursar Tuition Recovery & Paystack Fee Clearance Audit Slip
     */
    public function bursarClearance()
    {
        return view('materials.bursar-clearance');
    }

    /**
     * Proof 5: Amazon-Style "Working Backwards" 1-Page Press Release / Meta Physical Sales Leave-Behind
     */
    public function executiveOnePager()
    {
        return view('materials.executive-one-pager');
    }
}

