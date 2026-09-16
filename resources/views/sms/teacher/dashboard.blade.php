@extends('layouts.app')

@section('title', 'Teacher Dashboard - School Management System')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-dashboard {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
    }
    .sms-page-header {
        background: white;
        padding: 1.25rem 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        margin: -1rem -1rem 1.5rem -1rem;
        border-radius: 0;
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
        
        .sms-quick-actions {
            grid-template-columns: 1fr;
            gap: 1rem;
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
    }
    .sms-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .sms-stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.75rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
        background: linear-gradient(90deg, #1e3a8a, #10b981);
    }
    .sms-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.15);
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
    .sms-quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .sms-action-card {
        background: white;
        border-radius: 16px;
        padding: 1.75rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }
    .sms-action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -8px rgba(30, 58, 138, 0.15);
        border-color: #1e3a8a;
    }
    .sms-action-icon {
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
    .sms-action-content h3 {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
    }
    .sms-action-content p {
        font-size: 0.875rem;
        color: var(--sms-gray-600);
    }
    .sms-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        overflow: hidden;
        margin-bottom: 1.5rem;
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
    .sms-table tbody tr:hover {
        background: var(--sms-gray-50);
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
    .sms-badge-info {
        background: #dbeafe;
        color: #1e40af;
    }
    .sms-content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .sms-empty-state {
        text-align: center;
        padding: 2rem;
        color: var(--sms-gray-500);
    }
    .sms-class-badge, .sms-subject-badge {
        display: inline-block;
        padding: 0.375rem 0.875rem;
        background: var(--sms-gray-100);
        color: var(--sms-gray-700);
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        margin: 0.25rem;
    }
    @media (max-width: 768px) {
        .sms-content-grid {
            grid-template-columns: 1fr;
        }
        
        .sms-quick-actions {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .sms-action-card {
            padding: 1.25rem;
        }
        
        .sms-action-icon {
            width: 48px;
            height: 48px;
            font-size: 1.25rem;
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
    
    @media (max-width: 480px) {
        .sms-page-header {
            padding: 1rem;
            margin: -1rem -1rem 1rem -1rem;
        }
        
        .sms-page-title {
            font-size: 1.375rem;
        }
        
        .sms-page-subtitle {
            font-size: 0.8125rem;
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="sms-dashboard">
    <div class="sms-page-header">
        <h1 class="sms-page-title">Teacher Dashboard</h1>
        <div class="sms-page-subtitle">
            <span>Welcome, <strong>{{ $teacher->user->name ?? 'Teacher' }}</strong></span>
            <span style="padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.8125rem; font-weight: 600; background: var(--sms-gray-100); color: var(--sms-gray-700);">
                Employee ID: {{ $teacher->employee_id }}
            </span>
            <span style="padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.8125rem; font-weight: 600; background: var(--sms-gray-100); color: var(--sms-gray-700);">
                {{ $teacher->specialization ?? 'General' }} Teacher
            </span>
        </div>
    </div>

    <div style="max-width: 1400px; margin: 0 auto; padding: 0 2rem 2rem;">
        <!-- Stats Grid -->
        <div class="sms-stats-grid">
            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">{{ $stats['total_classes'] }}</div>
                        <div class="sms-stat-label">Assigned Classes</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #1e3a8a, #1e40af);">
                        <i class="fas fa-layer-group"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">{{ $stats['total_students'] }}</div>
                        <div class="sms-stat-label">Total Students</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">{{ $stats['total_subjects'] }}</div>
                        <div class="sms-stat-label">Assigned Subjects</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6);">
                        <i class="fas fa-book-open"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">{{ $stats['upcoming_classes'] ?? 0 }}</div>
                        <div class="sms-stat-label">Today's Classes</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">{{ $notices->count() ?? 0 }}</div>
                        <div class="sms-stat-label">New Notices</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #1e3a8a, #10b981);">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                </div>
            </div>

            <a href="{{ route('sms.teacher.attendance') }}" style="text-decoration: none; color: inherit;">
                <div class="sms-stat-card" style="cursor: pointer;">
                    <div class="sms-stat-header">
                        <div>
                            <div class="sms-stat-value">{{ $stats['attendance_today'] }}</div>
                            <div class="sms-stat-label">Attendance Today</div>
                        </div>
                        <div class="sms-stat-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Quick Actions -->
        <div class="sms-quick-actions">
            <a href="{{ route('sms.teacher.exams.create') }}" class="sms-action-card">
                <div class="sms-action-icon" style="background: linear-gradient(135deg, #1e3a8a, #1e40af);">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div class="sms-action-content">
                    <h3>Create Exam</h3>
                    <p>Create CA1, CA2, Test, or Exam (Online/Offline)</p>
                </div>
            </a>

            <a href="{{ route('sms.teacher.results-entry.index') }}" class="sms-action-card">
                <div class="sms-action-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="sms-action-content">
                    <h3>Enter Results</h3>
                    <p>Enter CA & Exam scores, Psychomotor & Affective assessments (Manual or CSV upload)</p>
                </div>
            </a>

            <a href="{{ route('sms.teacher.assignments.create') }}" class="sms-action-card">
                <div class="sms-action-icon" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6);">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="sms-action-content">
                    <h3>Create Assignment</h3>
                    <p>Create online or offline assignments</p>
                </div>
            </a>

            <a href="{{ route('sms.teacher.practice-sessions.create') }}" class="sms-action-card">
                <div class="sms-action-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <div class="sms-action-content">
                    <h3>Create Practice</h3>
                    <p>Create practice sessions with questions</p>
                </div>
            </a>
        </div>

        <!-- Main Content Grid -->
        <div class="sms-content-grid">
            <!-- Assigned Classes -->
            <div class="sms-card">
                <div class="sms-card-header">
                    <h2 class="sms-card-title">Assigned Classes</h2>
                </div>
                <div class="sms-card-body">
                    @if(isset($assignedClasses) && $assignedClasses->count() > 0)
                    <div>
                        @foreach($assignedClasses as $class)
                        <div style="padding: 1rem; background: var(--sms-gray-50); border-radius: 8px; margin-bottom: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-weight: 700; color: var(--sms-gray-900); margin-bottom: 0.25rem;">{{ $class->name }}</div>
                                <div style="font-size: 0.875rem; color: var(--sms-gray-600);">
                                    {{ $class->students->count() }} students • {{ $class->academic_year }}
                                </div>
                            </div>
                            <a href="{{ route('sms.teacher.attendance') }}?class_id={{ $class->id }}" class="sms-badge sms-badge-info" style="text-decoration: none;">
                                <i class="fas fa-clipboard-check"></i> Mark Attendance
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="sms-empty-state">
                        <div style="font-size: 2rem; color: var(--sms-gray-300); margin-bottom: 0.5rem;">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div style="font-size: 0.9375rem; color: var(--sms-gray-500);">No classes assigned yet</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Assigned Subjects -->
            <div class="sms-card">
                <div class="sms-card-header">
                    <h2 class="sms-card-title">Assigned Subjects</h2>
                </div>
                <div class="sms-card-body">
                    @if(isset($assignedSubjects) && $assignedSubjects->count() > 0)
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        @foreach($assignedSubjects as $subject)
                        <span class="sms-subject-badge">{{ $subject->name }}</span>
                        @endforeach
                    </div>
                    @else
                    <div class="sms-empty-state">
                        <div style="font-size: 2rem; color: var(--sms-gray-300); margin-bottom: 0.5rem;">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div style="font-size: 0.9375rem; color: var(--sms-gray-500);">No subjects assigned yet</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Today's Classes from Timetable -->
        @if(isset($upcomingClasses) && $upcomingClasses->count() > 0)
        <div class="sms-card">
            <div class="sms-card-header">
                <h2 class="sms-card-title">Today's Classes</h2>
                <a href="{{ route('sms.teacher.timetable') }}" style="font-size: 0.875rem; color: var(--sms-primary); text-decoration: none; font-weight: 600;">View Full Timetable</a>
            </div>
            <div class="sms-card-body">
                <table class="sms-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Class</th>
                            <th>Subject</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcomingClasses as $timetable)
                        <tr>
                            <td style="font-weight: 600;">
                                {{ \Carbon\Carbon::parse($timetable->start_time)->format('h:i A') }} - 
                                {{ \Carbon\Carbon::parse($timetable->end_time)->format('h:i A') }}
                            </td>
                            <td>{{ $timetable->class->name ?? 'N/A' }}</td>
                            <td>{{ $timetable->subject->name ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Latest Notices -->
        @if(isset($notices) && $notices->count() > 0)
        <div class="sms-card">
            <div class="sms-card-header">
                <h2 class="sms-card-title">Latest Notices & Announcements</h2>
                <a href="{{ route('sms.teacher.notices') }}" style="font-size: 0.875rem; color: var(--sms-primary); text-decoration: none; font-weight: 600;">View All</a>
            </div>
            <div class="sms-card-body">
                <div>
                    @foreach($notices as $notice)
                    <div style="padding: 1.25rem; background: var(--sms-gray-50); border-radius: 12px; border-left: 4px solid var(--sms-primary); margin-bottom: 1rem;">
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--sms-gray-900); margin-bottom: 0.5rem;">{{ $notice->title }}</h3>
                        <p style="font-size: 0.875rem; color: var(--sms-gray-600); margin-bottom: 0.75rem; line-height: 1.6;">{{ Str::limit($notice->content, 150) }}</p>
                        <p style="font-size: 0.75rem; color: var(--sms-gray-500);">
                            @php
                                $publishedAt = is_string($notice->published_at) ? \Carbon\Carbon::parse($notice->published_at) : ($notice->published_at ?? null);
                            @endphp
                            {{ $publishedAt ? $publishedAt->format('M d, Y') : 'Not published' }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
