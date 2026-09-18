@extends('layouts.app')

@section('title', 'Student Results & Grading - Teacher Portal')

@section('content')
<style>
    .page-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1.5rem 1rem;
    }
    .header-card {
        background: linear-gradient(135deg, #1e3a8a, #0d9488);
        color: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px -4px rgba(30, 58, 138, 0.25);
    }
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.25rem;
    }
    .header-title h1 {
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.35rem;
        letter-spacing: -0.02em;
    }
    .header-title p {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.85);
    }
    .btn-action-group {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .btn-action-primary {
        background: #10b981;
        color: white;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    .btn-action-primary:hover {
        background: #059669;
        transform: translateY(-2px);
        color: white;
    }
    .btn-action-secondary {
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
        color: white;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.2s;
    }
    .btn-action-secondary:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }
    .stat-box {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .stat-info h3 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }
    .stat-info p {
        font-size: 0.8125rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .content-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .card-top {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        background: #f8fafc;
    }
    .card-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
    }
    .data-table th, .data-table td {
        padding: 0.875rem 1.125rem;
        text-align: left;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.875rem;
    }
    .data-table th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }
    .data-table tr:hover td {
        background: #f8fafc;
    }
    .grade-badge {
        display: inline-block;
        padding: 0.25rem 0.65rem;
        border-radius: 6px;
        font-weight: 800;
        font-size: 0.8125rem;
        text-align: center;
        min-width: 32px;
    }
    .grade-A { background: #d1fae5; color: #065f46; }
    .grade-B { background: #dbeafe; color: #1e40af; }
    .grade-C { background: #ede9fe; color: #6d28d9; }
    .grade-D { background: #fef3c7; color: #92400e; }
    .grade-F { background: #fee2e2; color: #991b1b; }
    .empty-state {
        text-align: center;
        padding: 4rem 1.5rem;
    }
    .empty-icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: #94a3b8;
    }
    .empty-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.5rem;
    }
    .empty-desc {
        font-size: 0.95rem;
        color: #64748b;
        max-width: 420px;
        margin: 0 auto 1.5rem;
    }
</style>

<div class="page-container">
    <div class="header-card">
        <div class="header-content">
            <div class="header-title">
                <h1>Results &amp; Academic Grading</h1>
                <p>Record Continuous Assessment (CA) scores, exam marks, and broadsheet remarks.</p>
            </div>
            <div class="btn-action-group">
                <a href="{{ route('sms.teacher.results.upload') }}" class="btn-action-primary">
                    <i class="fas fa-upload"></i> Upload CSV Scores
                </a>
                <a href="{{ route('sms.teacher.results-entry.index') }}" class="btn-action-secondary">
                    <i class="fas fa-th"></i> Results Entry Grid
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="stats-row">
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(13, 148, 136, 0.1); color: #0d9488;">
                <i class="fas fa-poll-h"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $results->total() }}</h3>
                <p>Results Computed</p>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(30, 58, 138, 0.1); color: #1e3a8a;">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $classes->count() }}</h3>
                <p>Classes Recorded</p>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                <i class="fas fa-book-reader"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $subjects->count() }}</h3>
                <p>Subjects Covered</p>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h3>2026/2027</h3>
                <p>Current Session</p>
            </div>
        </div>
    </div>

    <!-- Results Table Card -->
    <div class="content-card">
        <div class="card-top">
            <div class="card-title">
                <i class="fas fa-award text-primary"></i> Assessment Records
            </div>
            <div>
                <a href="{{ route('sms.teacher.results-entry.index') }}" style="color: #1e3a8a; font-weight: 700; text-decoration: none; font-size: 0.875rem;">
                    Full Broadsheet <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        @if($results->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="empty-title">No Results Entered Yet</div>
                <div class="empty-desc">You haven't uploaded or entered student results for this session yet. Upload a CSV spreadsheet or use the quick results entry grid.</div>
                <div class="btn-action-group" style="justify-content: center;">
                    <a href="{{ route('sms.teacher.results.upload') }}" class="btn-action-primary">
                        <i class="fas fa-upload"></i> Upload CSV Results
                    </a>
                    <a href="{{ route('sms.teacher.results-entry.index') }}" class="btn-action-primary" style="background: #1e3a8a;">
                        <i class="fas fa-th"></i> Open Results Grid
                    </a>
                </div>
            </div>
        @else
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>CA (40%)</th>
                            <th>Exam (60%)</th>
                            <th>Total (100%)</th>
                            <th>Grade</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                            @php
                                $total = $result->total_score ?? (($result->ca_score ?? 0) + ($result->exam_score ?? 0));
                                $grade = $result->grade ?? ($total >= 70 ? 'A' : ($total >= 60 ? 'B' : ($total >= 50 ? 'C' : ($total >= 45 ? 'D' : 'F'))));
                            @endphp
                            <tr>
                                <td>
                                    <div style="font-weight: 700; color: #0f172a;">{{ $result->student->user->name ?? 'Student' }}</div>
                                    <div style="font-size: 0.75rem; color: #64748b;">{{ $result->student->student_id_number ?? 'ID: #' . $result->student_id }}</div>
                                </td>
                                <td>{{ $result->class->name ?? 'N/A' }}</td>
                                <td>{{ $result->subject->name ?? 'N/A' }}</td>
                                <td>{{ $result->ca_score ?? '-' }}</td>
                                <td>{{ $result->exam_score ?? '-' }}</td>
                                <td>
                                    <strong style="color: #0f172a; font-size: 0.95rem;">{{ $total }}%</strong>
                                </td>
                                <td>
                                    <span class="grade-badge grade-{{ $grade }}">{{ $grade }}</span>
                                </td>
                                <td>
                                    <span style="font-size: 0.8125rem; font-weight: 600; color: #475569;">
                                        {{ $result->remark ?? ($total >= 70 ? 'Distinction' : ($total >= 50 ? 'Credit' : 'Pass')) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($results->hasPages())
                <div style="padding: 1.25rem; border-top: 1px solid #f1f5f9;">
                    {{ $results->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

