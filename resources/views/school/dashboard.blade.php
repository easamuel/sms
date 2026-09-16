@extends('layouts.admin')

@section('title', 'Admin Dashboard - School Management System')
@section('page-title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-dashboard {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
        padding: 2rem 0;
    }
    .sms-page-header {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        border-radius: 0;
        box-shadow: var(--sms-shadow-lg);
    }
    .sms-page-title {
        font-size: 2.25rem;
        font-weight: 800;
        color: white;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .sms-page-title i {
        font-size: 2rem;
        opacity: 0.9;
    }
    .sms-page-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.125rem;
        font-weight: 400;
    }
    .sms-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .sms-stat-card {
        background: white;
        border-radius: var(--sms-radius-lg);
        padding: 1.75rem;
        box-shadow: var(--sms-shadow);
        border: 1px solid var(--sms-gray-200);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .sms-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--sms-primary), var(--sms-accent));
    }
    .sms-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--sms-shadow-lg);
        border-color: var(--sms-primary);
    }
    .sms-stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    .sms-stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
    }
    .sms-stat-value {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        line-height: 1;
        margin-bottom: 0.5rem;
    }
    .sms-stat-label {
        font-size: 0.875rem;
        color: var(--sms-gray-600);
        font-weight: 500;
    }
    .sms-content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .sms-card {
        background: white;
        border-radius: var(--sms-radius-lg);
        box-shadow: var(--sms-shadow);
        border: 1px solid var(--sms-gray-200);
        overflow: hidden;
        transition: all 0.2s ease;
    }
    .sms-card:hover {
        box-shadow: var(--sms-shadow-md);
    }
    .sms-card-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--sms-gray-200);
        background: var(--sms-gray-50);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .sms-card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .sms-card-link {
        font-size: 0.875rem;
        color: var(--sms-primary);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s;
    }
    .sms-card-link:hover {
        color: var(--sms-primary-dark);
    }
    .sms-card-body {
        padding: 1.5rem;
    }
    .sms-table {
        width: 100%;
        border-collapse: collapse;
    }
    .sms-table thead {
        background: var(--sms-gray-50);
    }
    .sms-table th {
        padding: 0.875rem 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--sms-gray-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid var(--sms-gray-200);
    }
    .sms-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        color: var(--sms-gray-800);
        font-size: 0.9375rem;
    }
    .sms-table tbody tr {
        transition: background 0.15s ease;
    }
    .sms-table tbody tr:hover {
        background: var(--sms-gray-50);
    }
    .sms-table tbody tr:last-child td {
        border-bottom: none;
    }
    .sms-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1;
    }
    .sms-badge-success {
        background: #d1fae5;
        color: #065f46;
    }
    .sms-badge-warning {
        background: #fef3c7;
        color: #92400e;
    }
    .sms-badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }
    .sms-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .sms-btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
    }
    .sms-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
    }
    .sms-btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    .sms-btn-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    .sms-btn-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .sms-btn-danger:hover {
        background: #fecaca;
    }
    .sms-btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.8125rem;
    }
    .sms-empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--sms-gray-500);
    }
    .sms-empty-state-icon {
        font-size: 3rem;
        color: var(--sms-gray-300);
        margin-bottom: 1rem;
    }
    .sms-empty-state-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--sms-gray-700);
        margin-bottom: 0.5rem;
    }
    .sms-empty-state-text {
        font-size: 0.9375rem;
        color: var(--sms-gray-500);
    }
    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
    }
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }
    .quick-action-card {
        background: white;
        border-radius: var(--sms-radius-lg);
        padding: 1.75rem;
        border: 2px solid var(--sms-gray-200);
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        position: relative;
        overflow: hidden;
    }
    .quick-action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--sms-primary), var(--sms-accent));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    .quick-action-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--sms-shadow-lg);
        border-color: var(--sms-primary);
    }
    .quick-action-card:hover::before {
        transform: scaleX(1);
    }
    .quick-action-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
    }
    .quick-action-content h3 {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
    }
    .quick-action-content p {
        font-size: 0.875rem;
        color: var(--sms-gray-600);
    }
    @media (max-width: 1024px) {
        .sms-content-grid {
            grid-template-columns: 1fr;
        }
        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 768px) {
        .sms-dashboard {
            padding: 1rem 0;
        }
        
        .sms-page-header {
            padding: 2rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .sms-page-title {
            font-size: 1.75rem;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .sms-page-title i {
            font-size: 1.5rem;
        }
        
        .sms-page-subtitle {
            font-size: 1rem;
        }
        
        .sms-stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
            padding: 0 1rem;
        }
        
        .sms-stat-card {
            padding: 1.25rem;
        }
        
        .sms-stat-icon {
            width: 48px;
            height: 48px;
            font-size: 1.25rem;
        }
        
        .sms-stat-value {
            font-size: 1.875rem;
        }
        
        .sms-content-grid {
            grid-template-columns: 1fr !important;
            padding: 0 1rem;
        }
        
        .quick-actions {
            padding: 0 1rem;
        }
    }
    
    @media (max-width: 480px) {
        .sms-page-header {
            padding: 1rem;
        }
        
        .sms-page-title {
            font-size: 1.25rem;
        }
        
        .sms-card-header {
            padding: 1rem;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .sms-card-body {
            padding: 1rem;
        }
    }
    
    .sms-stat-value {
            font-size: 1.875rem;
        }
        .sms-table {
            font-size: 0.875rem;
        }
        .sms-table th,
        .sms-table td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>

<div class="sms-dashboard">
    <div class="sms-page-header">
        <h1 class="sms-page-title">
            <i class="fas fa-tachometer-alt"></i>
            School Dashboard
        </h1>
        <p class="sms-page-subtitle">
            @if($school)
                {{ $school->name ?? $school->school_name }}
            @else
                Manage your school and students
            @endif
        </p>
    </div>

    <div style="max-width: 1400px; margin: 0 auto; padding: 0 2rem 2rem;" class="dashboard-container">
        <!-- Stats Grid - Dashboard Summary Cards -->
        <div class="sms-stats-grid">
            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">{{ $stats['total_students'] ?? 0 }}</div>
                        <div class="sms-stat-label">Students</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #1e3a8a, #1e40af);">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">{{ $stats['total_parents'] ?? 0 }}</div>
                        <div class="sms-stat-label">Parents</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">{{ $stats['total_teachers'] ?? 0 }}</div>
                        <div class="sms-stat-label">Teachers</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">{{ $stats['total_sessions'] ?? 0 }}</div>
                        <div class="sms-stat-label">Sessions</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6);">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">₦{{ number_format($stats['fees_collected'] ?? 0, 2) }}</div>
                        <div class="sms-stat-label">Fees Collection ({{ $currentYear ?? date('Y') }})</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #1e3a8a, #10b981);">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">₦{{ number_format($stats['revenue'] ?? 0, 2) }}</div>
                        <div class="sms-stat-label">Revenue ({{ $currentYear ?? date('Y') }})</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">₦{{ number_format($stats['total_income'] ?? 0, 2) }}</div>
                        <div class="sms-stat-label">Total Income</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">₦{{ number_format($stats['total_expenses'] ?? 0, 2) }}</div>
                        <div class="sms-stat-label">Total Expenses</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value" style="color: {{ ($stats['balance'] ?? 0) >= 0 ? '#10b981' : '#ef4444' }};">
                            ₦{{ number_format($stats['balance'] ?? 0, 2) }}
                        </div>
                        <div class="sms-stat-label">Balance</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #1e3a8a, #1e40af);">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">₦{{ number_format($stats['fees_collected_month'] ?? 0, 2) }}</div>
                        <div class="sms-stat-label">This Month</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Analytics Section -->
        <div class="sms-content-grid" style="grid-template-columns: 2fr 1fr; margin-bottom: 1.5rem;">
            <!-- Monthly Fee Collection Chart -->
            <div class="sms-card">
                <div class="sms-card-header">
                    <h2 class="sms-card-title">Monthly Fee Collection</h2>
                </div>
                <div class="sms-card-body">
                    <canvas id="monthlyFeesChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Today's Attendance -->
            <div class="sms-card">
                <div class="sms-card-header">
                    <h2 class="sms-card-title">Today's Attendance</h2>
                </div>
                <div class="sms-card-body">
                    @if(isset($stats['today_attendance']))
                    <div style="text-align: center; padding: 1rem 0;">
                        <div style="font-size: 3rem; font-weight: 800; color: var(--sms-primary); margin-bottom: 0.5rem;">
                            {{ $stats['today_attendance']['rate'] ?? 0 }}%
                        </div>
                        <div style="color: var(--sms-gray-600); margin-bottom: 1.5rem;">Attendance Rate</div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1.5rem;">
                            <div style="padding: 1rem; background: #d1fae5; border-radius: 8px;">
                                <div style="font-size: 1.5rem; font-weight: 700; color: #065f46;">
                                    {{ $stats['today_attendance']['present'] ?? 0 }}
                                </div>
                                <div style="font-size: 0.875rem; color: #065f46;">Present</div>
                            </div>
                            <div style="padding: 1rem; background: #fee2e2; border-radius: 8px;">
                                <div style="font-size: 1.5rem; font-weight: 700; color: #991b1b;">
                                    {{ $stats['today_attendance']['absent'] ?? 0 }}
                                </div>
                                <div style="font-size: 0.875rem; color: #991b1b;">Absent</div>
                            </div>
                        </div>
                        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--sms-gray-200);">
                            <div style="font-size: 0.875rem; color: var(--sms-gray-600);">
                                Total: {{ $stats['today_attendance']['total'] ?? 0 }} students
                            </div>
                        </div>
                    </div>
                    @else
                    <div style="text-align: center; padding: 2rem; color: var(--sms-gray-500);">
                        <i class="fas fa-clipboard-check" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <div>No attendance data for today</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Income vs Expenses Chart -->
        <div class="sms-card" style="margin-bottom: 1.5rem;">
            <div class="sms-card-header">
                <h2 class="sms-card-title">Income vs Expenses</h2>
            </div>
            <div class="sms-card-body">
                <canvas id="incomeExpenseChart" style="max-height: 300px;"></canvas>
            </div>
        </div>

        <!-- Upcoming Exams -->
        @if(isset($upcomingExams) && $upcomingExams->count() > 0)
        <div class="sms-card" style="margin-bottom: 1.5rem;">
            <div class="sms-card-header">
                <h2 class="sms-card-title">Upcoming Exams (Next 7 Days)</h2>
                <a href="{{ route('school.exams.index') }}" class="sms-card-link">
                    View All <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="sms-card-body">
                <table class="sms-table">
                    <thead>
                        <tr>
                            <th>Exam</th>
                            <th>Subject</th>
                            <th>Class</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcomingExams as $exam)
                        <tr>
                            <td style="font-weight: 600;">{{ $exam->title ?? $exam->name }}</td>
                            <td>{{ $exam->subject->name ?? 'N/A' }}</td>
                            <td>{{ $exam->class->name ?? 'N/A' }}</td>
                            <td>
                                @if($exam->scheduled_date)
                                    @php
                                        $date = is_string($exam->scheduled_date) ? \Carbon\Carbon::parse($exam->scheduled_date) : $exam->scheduled_date;
                                    @endphp
                                    {{ $date->format('M d, Y') }}
                                @else
                                    Not scheduled
                                @endif
                            </td>
                            <td>
                                @if($exam->scheduled_time)
                                    @php
                                        $time = is_string($exam->scheduled_time) ? \Carbon\Carbon::parse($exam->scheduled_time) : $exam->scheduled_time;
                                    @endphp
                                    {{ $time->format('h:i A') }}
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Content Grid -->
        <div class="sms-content-grid">
            <!-- Recent Students -->
            @if($recentStudents->count() > 0)
            <div class="sms-card">
                <div class="sms-card-header">
                    <h2 class="sms-card-title">Recent Students</h2>
                    <a href="{{ route('school.students.index') }}" class="sms-card-link">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="sms-card-body">
                    <table class="sms-table">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Email</th>
                                <th>Student ID</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentStudents as $schoolStudent)
                            @php
                                // Handle both SMS and LearnersCom structures
                                $studentName = $schoolStudent->user->name ?? $schoolStudent->student->name ?? $schoolStudent->name ?? 'Unknown';
                                $studentEmail = $schoolStudent->user->email ?? $schoolStudent->student->email ?? 'N/A';
                                $studentId = $schoolStudent->student_id_number ?? $schoolStudent->student->student_id ?? 'N/A';
                            @endphp
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div class="student-avatar" style="background: linear-gradient(135deg, #10b981, #059669);">
                                            {{ strtoupper(substr($studentName, 0, 1)) }}
                                        </div>
                                        <div style="font-weight: 600; color: var(--sms-gray-900);">{{ $studentName }}</div>
                                    </div>
                                </td>
                                <td>{{ $studentEmail }}</td>
                                <td>{{ $studentId }}</td>
                                <td>
                                    <span class="sms-badge sms-badge-success">Active</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Recent Exams -->
            @if(isset($recentExams) && $recentExams->count() > 0)
            <div class="sms-card">
                <div class="sms-card-header">
                    <h2 class="sms-card-title">Recent Exams</h2>
                    <a href="{{ route('school.exams.index') }}" class="sms-card-link">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="sms-card-body">
                    <table class="sms-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Subject</th>
                                <th>Questions</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentExams as $exam)
                            <tr>
                                <td style="font-weight: 600;">{{ $exam->title }}</td>
                                <td>{{ $exam->subject->name }}</td>
                                <td>{{ $exam->total_questions }}</td>
                                <td>
                                    <span class="sms-badge {{ $exam->is_active ? 'sms-badge-success' : 'sms-badge-warning' }}">
                                        {{ $exam->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="{{ route('school.exams.index') }}" class="quick-action-card">
                <div class="quick-action-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="quick-action-content">
                    <h3>Manage Exams</h3>
                    <p>Create and manage exams for your students</p>
                </div>
            </a>
            <a href="{{ route('school.students.index') }}" class="quick-action-card">
                <div class="quick-action-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="quick-action-content">
                    <h3>Manage Students</h3>
                    <p>View students and their performance</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Fee Collection Chart
    const monthlyFeesCtx = document.getElementById('monthlyFeesChart');
    if (monthlyFeesCtx) {
        const monthlyFeesData = @json($stats['monthly_fees'] ?? []);
        const labels = Object.keys(monthlyFeesData);
        const values = Object.values(monthlyFeesData);
        
        new Chart(monthlyFeesCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Fee Collection (₦)',
                    data: values,
                    borderColor: 'rgb(99, 102, 241)',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₦' + parseFloat(context.parsed.y).toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₦' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Income vs Expenses Chart
    const incomeExpenseCtx = document.getElementById('incomeExpenseChart');
    if (incomeExpenseCtx) {
        const totalIncome = {{ $stats['total_income'] ?? 0 }};
        const totalExpenses = {{ $stats['total_expenses'] ?? 0 }};
        
        new Chart(incomeExpenseCtx, {
            type: 'bar',
            data: {
                labels: ['Income', 'Expenses'],
                datasets: [{
                    label: 'Amount (₦)',
                    data: [totalIncome, totalExpenses],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgb(16, 185, 129)',
                        'rgb(239, 68, 68)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₦' + parseFloat(context.parsed.y).toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₦' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection
