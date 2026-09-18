@extends('layouts.app')

@section('title', 'Exams & CBT Management - Teacher Portal')

@section('content')
<style>
    .page-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1.5rem 1rem;
    }
    .header-card {
        background: linear-gradient(135deg, #1e3a8a, #1e40af);
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
    .btn-create-exam {
        background: #10b981;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    .btn-create-exam:hover {
        background: #059669;
        transform: translateY(-2px);
        color: white;
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
        min-width: 650px;
    }
    .data-table th, .data-table td {
        padding: 1rem 1.25rem;
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
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.25rem 0.65rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .badge-primary { background: #dbeafe; color: #1e40af; }
    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-purple { background: #ede9fe; color: #6d28d9; }
    .badge-warning { background: #fef3c7; color: #92400e; }
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.45rem 0.85rem;
        border-radius: 8px;
        font-size: 0.8125rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
    }
    .action-btn-primary {
        background: #1e3a8a;
        color: white;
    }
    .action-btn-primary:hover {
        background: #172554;
        color: white;
    }
    .action-btn-outline {
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
    }
    .action-btn-outline:hover {
        background: #e2e8f0;
    }
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
                <h1>Exams &amp; CBT Portal</h1>
                <p>Manage examinations, CBT questions, assessments, and question banks.</p>
            </div>
            <div>
                <a href="{{ route('sms.teacher.exams.create') }}" class="btn-create-exam">
                    <i class="fas fa-plus"></i> Create New Exam
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="stats-row">
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(30, 58, 138, 0.1); color: #1e3a8a;">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $exams->total() }}</h3>
                <p>Total Exams</p>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                <i class="fas fa-laptop-code"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $exams->where('exam_mode', '!=', 'offline')->count() }}</h3>
                <p>CBT Exams</p>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(168, 85, 247, 0.1); color: #a855f7;">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $subjects->count() }}</h3>
                <p>Subjects Handled</p>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                <i class="fas fa-chalkboard"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $classes->count() }}</h3>
                <p>Assigned Classes</p>
            </div>
        </div>
    </div>

    <!-- Exam List Card -->
    <div class="content-card">
        <div class="card-top">
            <div class="card-title">
                <i class="fas fa-list text-primary"></i> Scheduled Exams &amp; Tests
            </div>
            <div>
                <a href="{{ route('sms.teacher.question-bank') }}" class="action-btn action-btn-outline">
                    <i class="fas fa-database"></i> View Question Bank
                </a>
            </div>
        </div>

        @if($exams->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="empty-title">No Exams Created Yet</div>
                <div class="empty-desc">You haven't set up any exams or CBT tests yet. Click the button below to create your first exam.</div>
                <a href="{{ route('sms.teacher.exams.create') }}" class="btn-create-exam">
                    <i class="fas fa-plus"></i> Set Up Your First Exam
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Exam Title</th>
                            <th>Class &amp; Subject</th>
                            <th>Type</th>
                            <th>Mode</th>
                            <th>Duration</th>
                            <th>Questions</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exams as $exam)
                            <tr>
                                <td>
                                    <div style="font-weight: 700; color: #0f172a; margin-bottom: 2px;">{{ $exam->title }}</div>
                                    <div style="font-size: 0.75rem; color: #64748b;">{{ $exam->scheduled_date ? \Carbon\Carbon::parse($exam->scheduled_date)->format('M d, Y') : 'Self-Paced' }}</div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #1e293b;">{{ $exam->class->name ?? 'Class' }}</div>
                                    <div style="font-size: 0.8rem; color: #64748b;">{{ $exam->subject->name ?? 'Subject' }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $exam->exam_type ?? 'Exam' }}</span>
                                </td>
                                <td>
                                    @if($exam->exam_mode === 'online')
                                        <span class="badge badge-success"><i class="fas fa-globe"></i> Online CBT</span>
                                    @elseif($exam->exam_mode === 'offline')
                                        <span class="badge badge-warning"><i class="fas fa-file-alt"></i> Paper/Offline</span>
                                    @else
                                        <span class="badge badge-purple"><i class="fas fa-sync"></i> Hybrid</span>
                                    @endif
                                </td>
                                <td>{{ $exam->duration_minutes ?? 45 }} mins</td>
                                <td>
                                    <span class="badge badge-primary">{{ $exam->total_questions ?? $exam->questions()->count() }} Questions</span>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 0.5rem;">
                                        <a href="{{ route('sms.teacher.exams.questions.create', $exam->id) }}" class="action-btn action-btn-primary" title="Add / Manage Questions">
                                            <i class="fas fa-plus-circle"></i> Questions
                                        </a>
                                        <a href="{{ route('sms.teacher.results.upload', ['exam_id' => $exam->id]) }}" class="action-btn action-btn-outline" title="Upload Results">
                                            <i class="fas fa-upload"></i> Results
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($exams->hasPages())
                <div style="padding: 1.25rem; border-top: 1px solid #f1f5f9;">
                    {{ $exams->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

