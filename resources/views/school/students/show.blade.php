@extends('layouts.admin')

@section('title', 'Student Profile - School Management System')
@section('page-title', 'Student Profile')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
        padding: 1rem;
    }
    
    .page-header {
        background: linear-gradient(135deg, var(--sms-primary) 0%, var(--sms-primary-dark) 100%);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.2);
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .page-header-content {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        position: relative;
        z-index: 1;
    }
    
    .page-header-top {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    
    .student-avatar-large {
        width: 120px;
        height: 120px;
        border-radius: 16px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        object-fit: cover;
        background: rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    
    .student-avatar-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 16px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.1));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
        color: white;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    
    .student-info-header {
        flex: 1;
        min-width: 200px;
    }
    
    .student-name {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: white;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .student-id-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.9375rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    
    .student-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        font-size: 0.9375rem;
        color: rgba(255, 255, 255, 0.9);
    }
    
    .student-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .page-header-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .sms-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-size: 0.9375rem;
        font-weight: 600;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
        min-height: 44px;
    }
    
    .sms-btn-white {
        background: white;
        color: var(--sms-primary);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .sms-btn-white:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }
    
    .sms-btn-outline-white {
        background: transparent;
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.5);
    }
    
    .sms-btn-outline-white:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: white;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        border: 1px solid var(--sms-gray-200);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .stat-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
    }
    
    .stat-card-icon.primary {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(79, 70, 229, 0.15));
        color: var(--sms-primary);
    }
    
    .stat-card-icon.success {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(22, 163, 74, 0.15));
        color: #16a34a;
    }
    
    .stat-card-icon.warning {
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.1), rgba(245, 158, 11, 0.15));
        color: #f59e0b;
    }
    
    .stat-card-icon.info {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(37, 99, 235, 0.15));
        color: #3b82f6;
    }
    
    .stat-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--sms-gray-500);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .stat-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        line-height: 1;
    }
    
    .sms-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--sms-gray-200);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .sms-card-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--sms-gray-200);
        background: linear-gradient(to right, rgba(99, 102, 241, 0.05), transparent);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .sms-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .sms-card-title-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
    }
    
    .sms-card-body {
        padding: 1.5rem;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
        padding: 1rem;
        background: var(--sms-gray-50);
        border-radius: 10px;
        border-left: 4px solid var(--sms-primary);
    }
    
    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--sms-gray-500);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--sms-gray-900);
    }
    
    .sms-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .sms-table thead {
        background: var(--sms-gray-50);
    }
    
    .sms-table th {
        padding: 1rem;
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
    
    .sms-badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .sms-badge-warning {
        background: #fef3c7;
        color: #92400e;
    }
    
    .score-cell {
        font-weight: 700;
        font-size: 1.0625rem;
    }
    
    .score-pass {
        color: #16a34a;
    }
    
    .score-fail {
        color: #dc2626;
    }
    
    .sms-empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--sms-gray-500);
    }
    
    .sms-empty-state-icon {
        font-size: 4rem;
        color: var(--sms-gray-300);
        margin-bottom: 1rem;
    }
    
    .sms-empty-state-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--sms-gray-700);
        margin-bottom: 0.5rem;
    }
    
    .sms-empty-state-text {
        font-size: 0.9375rem;
        color: var(--sms-gray-500);
    }
    
    @media (max-width: 768px) {
        .sms-page {
            padding: 0.75rem;
        }
        
        .page-header {
            padding: 1.5rem;
            border-radius: 12px;
        }
        
        .student-name {
            font-size: 1.5rem;
        }
        
        .student-avatar-large,
        .student-avatar-placeholder {
            width: 80px;
            height: 80px;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .sms-table {
            font-size: 0.8125rem;
        }
        
        .sms-table th,
        .sms-table td {
            padding: 0.75rem 0.5rem;
        }
        
        .page-header-actions {
            width: 100%;
        }
        
        .sms-btn {
            flex: 1;
            justify-content: center;
        }
    }
</style>

<div class="sms-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-top">
                @if($student->photo)
                    <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->user->name ?? 'Student' }}" class="student-avatar-large">
                @else
                    <div class="student-avatar-placeholder">
                        {{ strtoupper(substr($student->user->name ?? 'S', 0, 1)) }}
                    </div>
                @endif
                <div class="student-info-header">
                    <h1 class="student-name">{{ $student->user->name ?? 'Unknown Student' }}</h1>
                    <div class="student-id-badge">
                        <i class="fas fa-id-card"></i>
                        <span>{{ $student->student_id_number ?? 'Not Generated' }}</span>
                    </div>
                    <div class="student-meta">
                        <div class="student-meta-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>{{ $student->class->name ?? 'N/A' }}</span>
                        </div>
                        <div class="student-meta-item">
                            <i class="fas fa-{{ $student->gender === 'male' ? 'mars' : 'venus' }}"></i>
                            <span>{{ ucfirst($student->gender ?? 'N/A') }}</span>
                        </div>
                        <div class="student-meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('M d, Y') : 'N/A' }}</span>
                        </div>
                        <div class="student-meta-item">
                            <span class="sms-badge {{ ($student->status ?? 'active') === 'active' ? 'sms-badge-success' : 'sms-badge-danger' }}">
                                {{ ucfirst($student->status ?? 'Active') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('school.students.index') }}" class="sms-btn sms-btn-outline-white">
                    <i class="fas fa-arrow-left"></i> Back to Students
                </a>
                <a href="{{ route('school.students.id-cards.download', $student->id) }}" class="sms-btn sms-btn-white">
                    <i class="fas fa-download"></i> Download ID Card
                </a>
            </div>
        </div>
    </div>

    <div style="max-width: 1400px; margin: 0 auto;">
        <!-- Stats Cards -->
        @php
            $examSessions = \App\Models\Sms\SmsExamSession::where('student_id', $student->id)
                ->where('status', 'completed')
                ->get();
            $totalExams = $examSessions->count();
            $passedExams = $examSessions->where('passed', true)->count();
            $averageScore = $examSessions->avg('percentage') ?? 0;
            $totalFees = \App\Models\Sms\StudentFee::where('student_id', $student->id)->sum('amount') ?? 0;
            $paidFees = \App\Models\Sms\StudentFee::where('student_id', $student->id)->sum('paid_amount') ?? 0;
        @endphp
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-icon primary">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div class="stat-label">Total Exams</div>
                <div class="stat-value">{{ $totalExams }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-label">Passed Exams</div>
                <div class="stat-value">{{ $passedExams }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-icon warning">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-label">Average Score</div>
                <div class="stat-value">{{ number_format($averageScore, 1) }}%</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-icon info">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-label">Fees Status</div>
                <div class="stat-value">{{ $totalFees > 0 ? number_format(($paidFees / $totalFees) * 100, 0) : 0 }}%</div>
            </div>
        </div>

        <!-- Student Information -->
        <div class="sms-card">
            <div class="sms-card-header">
                <h2 class="sms-card-title">
                    <div class="sms-card-title-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    Student Information
                </h2>
            </div>
            <div class="sms-card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Student ID</div>
                        <div class="info-value">{{ $student->student_id_number ?? 'Not Generated' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">{{ $student->user->name ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $student->user->email ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Date of Birth</div>
                        <div class="info-value">{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('F d, Y') : 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Gender</div>
                        <div class="info-value">{{ ucfirst($student->gender ?? 'N/A') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Class</div>
                        <div class="info-value">{{ $student->class->name ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Admission Date</div>
                        <div class="info-value">{{ $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('F d, Y') : 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div>
                            <span class="sms-badge {{ ($student->status ?? 'active') === 'active' ? 'sms-badge-success' : 'sms-badge-danger' }}">
                                {{ ucfirst($student->status ?? 'Active') }}
                            </span>
                        </div>
                    </div>
                    @if($student->club)
                    <div class="info-item">
                        <div class="info-label">Club/Organization</div>
                        <div class="info-value">{{ $student->club->name ?? 'N/A' }}</div>
                    </div>
                    @endif
                    @if($student->club_position)
                    <div class="info-item">
                        <div class="info-label">Position</div>
                        <div class="info-value">{{ $student->club_position }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Exam Results -->
        <div class="sms-card">
            <div class="sms-card-header">
                <h2 class="sms-card-title">
                    <div class="sms-card-title-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    Exam Results
                </h2>
            </div>
            <div class="sms-card-body">
                @php
                    $examSessionsPaginated = \App\Models\Sms\SmsExamSession::where('student_id', $student->id)
                        ->where('status', 'completed')
                        ->with(['exam.subject'])
                        ->orderBy('submitted_at', 'desc')
                        ->paginate(20);
                @endphp
                @if($examSessionsPaginated->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="sms-table">
                            <thead>
                                <tr>
                                    <th>Exam</th>
                                    <th>Subject</th>
                                    <th>Score</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($examSessionsPaginated as $session)
                                <tr>
                                    <td style="font-weight: 600;">{{ $session->exam->title ?? $session->exam->name ?? 'N/A' }}</td>
                                    <td style="color: var(--sms-gray-600);">{{ $session->exam->subject->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="score-cell {{ $session->passed ? 'score-pass' : 'score-fail' }}">
                                            {{ number_format($session->percentage ?? 0, 1) }}%
                                        </span>
                                    </td>
                                    <td>
                                        <span class="sms-badge {{ $session->passed ? 'sms-badge-success' : 'sms-badge-danger' }}">
                                            {{ $session->passed ? 'Passed' : 'Failed' }}
                                        </span>
                                    </td>
                                    <td style="color: var(--sms-gray-600);">{{ $session->submitted_at ? $session->submitted_at->format('M d, Y') : ($session->created_at->format('M d, Y') ?? 'N/A') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 1.5rem;">
                        {{ $examSessionsPaginated->links() }}
                    </div>
                @else
                    <div class="sms-empty-state">
                        <div class="sms-empty-state-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="sms-empty-state-title">No Exam Results</div>
                        <div class="sms-empty-state-text">This student has not completed any exams yet.</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
