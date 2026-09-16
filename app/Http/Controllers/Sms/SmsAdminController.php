<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SmsAdminController extends Controller
{
    /**
     * SMS Super Admin Dashboard
     * This is completely separate from LearnersCom admin
     */
    public function dashboard()
    {
        // Get SMS user from session
        $smsUser = session('sms_user');
        $smsRole = session('sms_role');

        // Verify this is SMS session
        if (!$smsUser || !$smsRole) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Please login to access the School Management System.');
        }

        // Get SMS-specific stats (using SMS models, NOT LearnersCom)
        $stats = [
            'total_schools' => \App\Models\School::where('is_active', true)->count(),
            'total_students' => \App\Models\SchoolStudent::where('status', 'active')->count(),
            'total_teachers' => 0, // Will be implemented when teacher model is ready
            'total_exams' => \App\Models\Exam::whereHas('school')->count(),
            'pending_approvals' => \App\Models\SchoolStudent::where(function($query) {
                $query->where('status', 'pending')
                      ->orWhereNull('status');
            })->count(),
        ];

        // Get recent schools
        $recentSchools = \App\Models\School::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('sms.admin.dashboard', compact('stats', 'recentSchools', 'smsUser', 'smsRole'));
    }
}
