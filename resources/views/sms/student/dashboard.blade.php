@extends('layouts.app')

@section('title', 'Student Dashboard - School Management System')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-dashboard {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
    }
    .sms-page-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        padding: 1.25rem 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        margin: -1rem -1rem 1.5rem -1rem;
        border-radius: 0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }
    .sms-page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #1e3a8a, #10b981, #3b82f6);
    }
    .sms-page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }
    .sms-page-subtitle {
        color: var(--sms-gray-600);
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
        line-height: 1.5;
    }
    .sms-page-subtitle .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
        background: var(--sms-gray-100);
        color: var(--sms-gray-700);
    }
    .sms-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    @media (max-width: 640px) {
        .sms-page-header {
            padding: 1rem;
            margin: -1rem -1rem 1rem -1rem;
        }
        
        .sms-page-title {
            font-size: 1.375rem;
        }
        
        .sms-page-subtitle {
            font-size: 0.8125rem;
        }
        
        .sms-stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
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
    }
    
    @media (min-width: 768px) {
        .sms-page-header {
            padding: 2rem;
            margin: -2rem -2rem 2rem -2rem;
        }
        
        .sms-page-title {
            font-size: 1.875rem;
        }
        
        .sms-page-subtitle {
            font-size: 1rem;
        }
        
        .sms-stats-grid {
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
    }
    .sms-stat-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .sms-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #1e3a8a, #10b981, #3b82f6);
        opacity: 0.9;
    }
    .sms-stat-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.25), 0 8px 16px -4px rgba(0, 0, 0, 0.1);
        border-color: var(--sms-primary);
    }
    .sms-stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    .sms-stat-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }
    .sms-stat-card:hover .sms-stat-icon {
        transform: scale(1.15) rotate(5deg);
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
    .sms-modules-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .sms-module-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        color: inherit;
        display: block;
        position: relative;
        overflow: hidden;
    }
    .sms-module-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #1e3a8a, #10b981, #3b82f6);
        opacity: 0.8;
    }
    .sms-module-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.25), 0 8px 16px -4px rgba(0, 0, 0, 0.1);
        border-color: var(--sms-primary);
        text-decoration: none;
        color: inherit;
    }
    .sms-module-icon {
        width: 72px;
        height: 72px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.25rem;
        color: white;
        margin-bottom: 1.25rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }
    .sms-module-card:hover .sms-module-icon {
        transform: scale(1.1) rotate(5deg);
    }
    .sms-module-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
    }
    .sms-module-description {
        font-size: 0.875rem;
        color: var(--sms-gray-600);
        line-height: 1.5;
    }
    .sms-attendance-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        margin-bottom: 1.5rem;
    }
    .sms-attendance-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .sms-attendance-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .sms-attendance-summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .sms-attendance-item {
        text-align: center;
        padding: 1rem;
        background: var(--sms-gray-50);
        border-radius: 12px;
    }
    .sms-attendance-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
    }
    .sms-attendance-label {
        font-size: 0.75rem;
        color: var(--sms-gray-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .sms-attendance-recent {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }
    .sms-attendance-day {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        font-weight: 600;
        color: white;
    }
    .sms-attendance-day.present {
        background: #10b981;
    }
    .sms-attendance-day.absent {
        background: #ef4444;
    }
    .sms-attendance-day.present::before {
        content: '✓';
    }
    .sms-attendance-day.absent::before {
        content: '✖';
    }
    .sms-notices-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
    }
    .sms-notice-item {
        padding: 1rem;
        background: var(--sms-gray-50);
        border-radius: 12px;
        border-left: 4px solid var(--sms-primary);
        margin-bottom: 0.75rem;
    }
    .sms-notice-item:last-child {
        margin-bottom: 0;
    }
    .sms-notice-title {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
    }
    .sms-notice-date {
        font-size: 0.75rem;
        color: var(--sms-gray-500);
    }
    @media (max-width: 768px) {
        .sms-page-header {
            padding: 1.5rem;
        }
        .sms-page-title {
            font-size: 1.5rem;
        }
        .sms-stats-grid {
            grid-template-columns: 1fr;
        }
        .sms-modules-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .sms-module-card {
            padding: 1.5rem;
        }
        
        .sms-module-icon {
            width: 56px;
            height: 56px;
            font-size: 1.75rem;
        }
        
        .sms-attendance-summary {
            grid-template-columns: 1fr;
        }
        
        .sms-attendance-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }
</style>

<div class="sms-dashboard">
    <div class="sms-page-header">
        <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
            <div style="flex: 1;">
                <h1 class="sms-page-title">Student Dashboard</h1>
                <div class="sms-page-subtitle">
                    <span>Welcome, <strong>{{ $student->user->name ?? 'Student' }}</strong></span>
                    <span class="badge">ID: {{ $student->student_id_number }}</span>
                    @if($student->class)
                        <span class="badge">{{ $student->class->name }}</span>
                    @endif
                </div>
            </div>
            @if($student->photo)
            <div style="flex-shrink: 0;">
                @php
                    // Try multiple paths to find the photo
                    $photoPath = asset('storage/' . $student->photo);
                    // Check if file exists in public storage
                    if (!file_exists(public_path('storage/' . $student->photo))) {
                        // Try storage path
                        if (file_exists(storage_path('app/public/' . $student->photo))) {
                            $photoPath = asset('storage/' . $student->photo);
                        }
                    }
                @endphp
                <img src="{{ $photoPath }}" 
                     alt="Student Photo" 
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                     style="width: 120px; height: 120px; border-radius: 12px; border: 3px solid var(--sms-primary); object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                <div style="display: none; width: 120px; height: 120px; border-radius: 12px; border: 3px solid var(--sms-primary); background: var(--sms-gray-100); align-items: center; justify-content: center; color: var(--sms-gray-500); font-size: 0.875rem;">
                    No Photo
                </div>
            </div>
            @endif
        </div>
    </div>

    <div style="max-width: 1400px; margin: 0 auto; padding: 0 2rem 2rem;">
        <!-- Stats Grid -->
        <div class="sms-stats-grid">
            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">{{ $stats['attendance_rate'] }}%</div>
                        <div class="sms-stat-label">Attendance Rate (This Month)</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value" style="color: {{ $stats['pending_fees'] > 0 ? '#dc2626' : '#10b981' }};">₦{{ number_format($stats['pending_fees'], 2) }}</div>
                        <div class="sms-stat-label">Pending Fees</div>
                        @if($stats['pending_fees'] > 0)
                        <div style="font-size: 0.75rem; color: #dc2626; margin-top: 0.25rem;">
                            <i class="fas fa-exclamation-circle"></i> Payment Required
                        </div>
                        @else
                        <div style="font-size: 0.75rem; color: #10b981; margin-top: 0.25rem;">
                            <i class="fas fa-check-circle"></i> All Fees Cleared
                        </div>
                        @endif
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, {{ $stats['pending_fees'] > 0 ? '#f59e0b' : '#10b981' }}, {{ $stats['pending_fees'] > 0 ? '#d97706' : '#059669' }});">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value" style="font-size: 1.5rem;">{{ $clubPosition ?? 'N/A' }}</div>
                        <div class="sms-stat-label">Club / Position</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            @if($latestNotice)
            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value" style="font-size: 1.125rem; line-height: 1.4;">{{ Str::limit($latestNotice->title, 40) }}</div>
                        <div class="sms-stat-label">{{ $latestNotice->published_at->format('M d, Y') }}</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Modules Grid -->
        <div class="sms-modules-grid">
            <a href="{{ route('sms.student.exams') }}" class="sms-module-card">
                <div class="sms-module-icon" style="background: linear-gradient(135deg, #1e3a8a, #1e40af); box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 class="sms-module-title">Exams</h3>
                <p class="sms-module-description">Access your scheduled exams. Ensure fees are paid to take exams.</p>
            </a>

            <a href="{{ route('sms.student.practice-sessions') }}" class="sms-module-card">
                <div class="sms-module-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <h3 class="sms-module-title">Practice Sessions</h3>
                <p class="sms-module-description">Practice with unlimited questions. Improve your skills anytime.</p>
            </a>

            <a href="{{ route('sms.student.assignments') }}" class="sms-module-card">
                <div class="sms-module-icon" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6);">
                    <i class="fas fa-tasks"></i>
                </div>
                <h3 class="sms-module-title">Assignments</h3>
                <p class="sms-module-description">View and submit assignments online. Track submission status.</p>
            </a>

            <a href="{{ route('sms.student.results') }}" class="sms-module-card">
                <div class="sms-module-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3 class="sms-module-title">Results</h3>
                <p class="sms-module-description">View your exam results, grades, and performance summary.</p>
            </a>

            <a href="{{ route('sms.student.timetable') }}" class="sms-module-card">
                <div class="sms-module-icon" style="background: linear-gradient(135deg, #1e3a8a, #10b981);">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3 class="sms-module-title">Timetable</h3>
                <p class="sms-module-description">View your daily and weekly class schedule.</p>
            </a>

            <a href="{{ route('sms.student.attendance') }}" class="sms-module-card">
                <div class="sms-module-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h3 class="sms-module-title">Attendance</h3>
                <p class="sms-module-description">View your attendance records and history.</p>
            </a>

            <a href="{{ route('sms.student.fees') }}" class="sms-module-card">
                <div class="sms-module-icon" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6);">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h3 class="sms-module-title">Fees</h3>
                <p class="sms-module-description">View fee statements and payment history. Track outstanding balances.</p>
            </a>
        </div>

        <!-- Attendance Summary -->
        <div class="sms-attendance-card">
            <div class="sms-attendance-header">
                <h3 class="sms-attendance-title">Attendance Summary ({{ now()->format('F Y') }})</h3>
                <a href="{{ route('sms.student.attendance') }}" style="font-size: 0.875rem; color: var(--sms-primary); text-decoration: none; font-weight: 600;">
                    View Details <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="sms-attendance-summary">
                <div class="sms-attendance-item">
                    <div class="sms-attendance-value">{{ $attendanceSummary['total'] }}</div>
                    <div class="sms-attendance-label">Total Days</div>
                </div>
                <div class="sms-attendance-item">
                    <div class="sms-attendance-value" style="color: #10b981;">{{ $attendanceSummary['present'] }}</div>
                    <div class="sms-attendance-label">Present</div>
                </div>
                <div class="sms-attendance-item">
                    <div class="sms-attendance-value" style="color: #ef4444;">{{ $attendanceSummary['absent'] }}</div>
                    <div class="sms-attendance-label">Absent</div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 1rem;">
                @if(isset($attendanceSummary['no_current_month']) && $attendanceSummary['no_current_month'])
                    <div style="font-size: 0.875rem; color: var(--sms-gray-500);">
                        No attendance records for this month
                    </div>
                @else
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--sms-gray-900);">
                        {{ $attendanceSummary['percentage'] }}%
                    </div>
                    <div style="font-size: 0.75rem; color: var(--sms-gray-600); text-transform: uppercase; letter-spacing: 0.05em;">
                        Attendance Rate
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Change Password Section -->
    <div class="sms-card" style="max-width: 600px; margin: 2rem auto;">
        <div class="sms-card-header">
            <h3 class="sms-card-title">
                <i class="fas fa-lock"></i> Change Password
            </h3>
        </div>
        <form action="{{ route('sms.student.change-password') }}" method="POST" id="password-change-form">
            @csrf
            <div class="sms-form-group">
                <label class="sms-form-label">Current Password <span style="color: #dc2626;">*</span></label>
                <input type="password" 
                       name="current_password" 
                       class="sms-form-input" 
                       required 
                       placeholder="Enter your current password">
                @error('current_password')
                    <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>
            <div class="sms-form-group">
                <label class="sms-form-label">New Password <span style="color: #dc2626;">*</span></label>
                <input type="password" 
                       name="new_password" 
                       id="new_password"
                       class="sms-form-input" 
                       required 
                       minlength="6"
                       placeholder="Enter new password (min. 6 characters)">
                @error('new_password')
                    <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>
            <div class="sms-form-group">
                <label class="sms-form-label">Confirm New Password <span style="color: #dc2626;">*</span></label>
                <input type="password" 
                       name="new_password_confirmation" 
                       id="new_password_confirmation"
                       class="sms-form-input" 
                       required 
                       minlength="6"
                       placeholder="Confirm new password">
                <div id="password-match" style="font-size: 0.8125rem; margin-top: 0.25rem; display: none;"></div>
            </div>
            <div style="margin-top: 1.5rem;">
                <button type="submit" class="sms-btn sms-btn-primary">
                    <i class="fas fa-key"></i> Change Password
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Password match validation
    document.getElementById('new_password_confirmation').addEventListener('input', function() {
        var newPassword = document.getElementById('new_password').value;
        var confirmPassword = this.value;
        var matchDiv = document.getElementById('password-match');
        
        if (confirmPassword.length > 0) {
            if (newPassword === confirmPassword) {
                matchDiv.style.color = '#10b981';
                matchDiv.textContent = '✓ Passwords match';
                matchDiv.style.display = 'block';
            } else {
                matchDiv.style.color = '#dc2626';
                matchDiv.textContent = '✗ Passwords do not match';
                matchDiv.style.display = 'block';
            }
        } else {
            matchDiv.style.display = 'none';
        }
    });

    // Form validation
    document.getElementById('password-change-form').addEventListener('submit', function(e) {
        var newPassword = document.getElementById('new_password').value;
        var confirmPassword = document.getElementById('new_password_confirmation').value;
        
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('Passwords do not match. Please try again.');
            return false;
        }
    });
</script>
@endsection
