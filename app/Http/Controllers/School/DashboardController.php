<?php

namespace App\Http\Controllers\School;

use Illuminate\Http\Request;

class DashboardController extends BaseSchoolController
{
    public function index()
    {
        // Check if this is SMS session (not LearnersCom auth)
        if (session('sms_role') === 'admin' || session('sms_role') === 'accountant') {
            // This is SMS admin - use SMS models and data
            return $this->smsAdminDashboard();
        }

        // If not SMS session, redirect to SMS login
        return redirect()->route('school-management.demo-login')
            ->with('error', 'Please login to access the School Management System.');
    }

    /**
     * SMS Admin Dashboard (separate from LearnersCom)
     */
    private function smsAdminDashboard()
    {
        $smsUser = session('sms_user');
        $smsRole = session('sms_role');

        if (!$smsUser || !$smsRole) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'Please login to access the School Management System.');
        }

        // Ensure admin has a school assigned
        if (!$smsUser->school_id) {
            $school = $this->ensureSchoolForAdmin($smsUser);
            if (!$school) {
                return redirect()->route('school-management.demo-login')
                    ->with('error', 'School not found. Please contact support.');
            }
            $schoolId = $school->id;
        } else {
            $schoolId = $smsUser->school_id;
        }

        // Get SMS-specific stats (dashboard summary cards)
        $currentYear = date('Y');
        $currentMonth = date('m');
        
        // Basic counts
        $totalStudents = \App\Models\Sms\SmsStudent::where('school_id', $schoolId)
            ->where('status', 'active')
            ->count();
        $totalParents = \App\Models\Sms\SmsParent::where('school_id', $schoolId)->count();
        $totalTeachers = \App\Models\Sms\SmsTeacher::where('school_id', $schoolId)
            ->where('status', 'active')
            ->count();
        
        // Get distinct academic years for sessions
        $sessions = \App\Models\Sms\SmsClass::where('school_id', $schoolId)
            ->whereNotNull('academic_year')
            ->distinct()
            ->pluck('academic_year')
            ->filter()
            ->unique()
            ->count();
        
        // Financial metrics
        $feesCollectedThisYear = \App\Models\Sms\SmsFeePayment::where('school_id', $schoolId)
            ->whereYear('payment_date', $currentYear)
            ->sum('amount_paid');
        
        $feesCollectedThisMonth = \App\Models\Sms\SmsFeePayment::where('school_id', $schoolId)
            ->whereYear('payment_date', $currentYear)
            ->whereMonth('payment_date', $currentMonth)
            ->sum('amount_paid');
        
        $totalIncome = \App\Models\Sms\SmsFeePayment::where('school_id', $schoolId)
            ->sum('amount_paid');
        
        // Expenses (placeholder - will need to create expense model)
        $totalExpenses = 0; // TODO: Implement expense tracking
        
        $balance = $totalIncome - $totalExpenses;
        
        // Monthly fee collection for chart (last 12 months)
        $monthlyFees = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthKey = $date->format('M Y');
            $monthlyFees[$monthKey] = \App\Models\Sms\SmsFeePayment::where('school_id', $schoolId)
                ->whereYear('payment_date', $date->year)
                ->whereMonth('payment_date', $date->month)
                ->sum('amount_paid');
        }
        
        // Today's attendance
        $todayAttendance = \App\Models\Sms\SmsAttendance::where('school_id', $schoolId)
            ->whereDate('date', today())
            ->get();
        $todayPresent = $todayAttendance->where('status', 'present')->count();
        $todayAbsent = $todayAttendance->where('status', 'absent')->count();
        $todayTotal = $todayAttendance->count();
        $todayAttendanceRate = $todayTotal > 0 ? round(($todayPresent / $todayTotal) * 100, 1) : 0;
        
        // Upcoming exams (next 7 days)
        $upcomingExams = \App\Models\Sms\SmsExam::where('school_id', $schoolId)
            ->where('is_active', true)
            ->whereDate('scheduled_date', '>=', today())
            ->whereDate('scheduled_date', '<=', today()->addDays(7))
            ->with(['subject', 'class'])
            ->orderBy('scheduled_date')
            ->limit(5)
            ->get();
        
        $stats = [
            'total_students' => $totalStudents,
            'total_parents' => $totalParents,
            'total_teachers' => $totalTeachers,
            'total_sessions' => $sessions,
            'fees_collected' => $feesCollectedThisYear,
            'fees_collected_month' => $feesCollectedThisMonth,
            'revenue' => $feesCollectedThisYear,
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'balance' => $balance,
            'monthly_fees' => $monthlyFees,
            'today_attendance' => [
                'present' => $todayPresent,
                'absent' => $todayAbsent,
                'total' => $todayTotal,
                'rate' => $todayAttendanceRate,
            ],
        ];

        // Get recent students
        $recentStudents = \App\Models\Sms\SmsStudent::where('school_id', $schoolId)
            ->where('status', 'active')
            ->with(['user', 'class'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get recent exams
        $recentExams = \App\Models\Sms\SmsExam::where('school_id', $schoolId)
            ->with(['subject', 'class'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get pending approvals
        $pendingStudents = \App\Models\Sms\SmsStudent::where('school_id', $schoolId)
            ->where(function($query) {
                $query->where('status', 'pending')
                      ->orWhereNull('status');
            })
            ->with(['user', 'class'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $school = \App\Models\Sms\SmsSchool::find($schoolId);

        return view('school.dashboard', compact('stats', 'pendingStudents', 'recentStudents', 'recentExams', 'upcomingExams', 'school', 'smsUser', 'smsRole', 'currentYear'));
    }

    /**
     * Ensure admin user has a school assigned
     */
    protected function ensureSchoolForAdmin($smsUser)
    {
        // Try to get seeded school first
        $school = \App\Models\Sms\SmsSchool::where('name', 'Excellence Secondary School')->first();
        
        if (!$school) {
            // Create demo school if doesn't exist
            $school = \App\Models\Sms\SmsSchool::firstOrCreate(
                ['name' => 'Excellence Secondary School'],
                [
                    'registration_number' => 'ESS-2024-001',
                    'school_type' => 'Secondary',
                    'address' => '123 Education Avenue',
                    'city' => 'Lagos',
                    'state' => 'Lagos',
                    'country' => 'Nigeria',
                    'phone' => '+234 801 234 5678',
                    'email' => 'info@excellenceschool.ng',
                    'website' => 'https://excellenceschool.ng',
                    'is_active' => true,
                ]
            );
        }

        // Update user with school_id
        $smsUser->update(['school_id' => $school->id]);
        
        // Update session
        session(['sms_user' => $smsUser->fresh()]);

        return $school;
    }
}
