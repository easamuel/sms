@extends('layouts.app')

@section('title', 'Question Bank & Test Items - Teacher Portal')

@section('content')
<style>
    .page-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1.5rem 1rem;
    }
    .header-card {
        background: linear-gradient(135deg, #1e3a8a, #6366f1);
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
    .btn-create {
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
    }
    .btn-create:hover {
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
    .question-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .question-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 0.75rem;
        flex-wrap: wrap;
    }
    .question-text {
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.4;
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
    .badge-exam { background: #dbeafe; color: #1e40af; }
    .badge-assignment { background: #fef3c7; color: #92400e; }
    .badge-practice { background: #d1fae5; color: #065f46; }
    .options-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 0.65rem;
        margin: 0.85rem 0;
    }
    .option-pill {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
        color: #334155;
    }
    .option-pill.is-correct {
        background: #ecfdf5;
        border-color: #10b981;
        color: #065f46;
        font-weight: 700;
    }
    .question-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.8rem;
        color: #64748b;
        padding-top: 0.75rem;
        border-top: 1px solid #f1f5f9;
        margin-top: 0.5rem;
    }
    .empty-state {
        text-align: center;
        padding: 4rem 1.5rem;
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
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
</style>

<div class="page-container">
    <div class="header-card">
        <div class="header-content">
            <div class="header-title">
                <h1>Question Bank Repository</h1>
                <p>Centralized item repository for CBT exams, homework assignments, and self-paced practice drill tests.</p>
            </div>
            <div class="btn-action-group">
                <a href="{{ route('sms.teacher.exams.create') }}" class="btn-create">
                    <i class="fas fa-plus"></i> New Exam Question
                </a>
                <a href="{{ route('sms.teacher.practice-sessions.create') }}" class="btn-create" style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);">
                    <i class="fas fa-laptop"></i> New Practice Session
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="stats-row">
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
                <i class="fas fa-database"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $allQuestions->count() }}</h3>
                <p>Total Test Items</p>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(30, 58, 138, 0.1); color: #1e3a8a;">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $allQuestions->where('type', 'exam')->count() }}</h3>
                <p>Exam Questions</p>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $allQuestions->where('type', 'assignment')->count() }}</h3>
                <p>Assignment Items</p>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                <i class="fas fa-dumbbell"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $allQuestions->where('type', 'practice')->count() }}</h3>
                <p>Practice Items</p>
            </div>
        </div>
    </div>

    @if($allQuestions->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <h3 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem;">Question Bank is Empty</h3>
            <p style="color: #64748b; max-width: 450px; margin: 0 auto 1.5rem;">As you create exams, practice drills, and assignments, your questions will automatically be indexed here for reuse across terms.</p>
            <a href="{{ route('sms.teacher.exams.create') }}" class="btn-create" style="display: inline-flex;">
                <i class="fas fa-plus"></i> Create Questions Now
            </a>
        </div>
    @else
        @foreach($allQuestions as $item)
            @php
                $q = $item['question'];
                $type = $item['type'];
                $options = is_string($q->options ?? null) ? json_decode($q->options, true) : ($q->options ?? []);
            @endphp
            <div class="question-card">
                <div class="question-header">
                    <div class="question-text">
                        {{ $q->question_text ?? 'Question' }}
                    </div>
                    <div>
                        @if($type === 'exam')
                            <span class="badge badge-exam"><i class="fas fa-graduation-cap"></i> CBT Exam</span>
                        @elseif($type === 'assignment')
                            <span class="badge badge-assignment"><i class="fas fa-tasks"></i> Assignment</span>
                        @else
                            <span class="badge badge-practice"><i class="fas fa-dumbbell"></i> Practice Session</span>
                        @endif
                    </div>
                </div>

                @if(!empty($options) && is_array($options))
                    <div class="options-grid">
                        @foreach($options as $idx => $opt)
                            @php
                                $optStr = is_array($opt) ? ($opt['text'] ?? json_encode($opt)) : (string)$opt;
                                $correctStr = is_string($q->correct_answer ?? null) ? $q->correct_answer : '';
                                $isCorrect = !empty($correctStr) && (
                                    strtolower(trim($optStr)) === strtolower(trim($correctStr)) ||
                                    strtoupper(trim($correctStr)) === chr(65 + $idx)
                                );
                            @endphp
                            <div class="option-pill {{ $isCorrect ? 'is-correct' : '' }}">
                                <strong>{{ chr(65 + $idx) }}.</strong> {{ $optStr }}
                                @if($isCorrect) <i class="fas fa-check-circle" style="float: right;"></i> @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="question-footer">
                    <div>
                        <span style="font-weight: 700; color: #0f172a;">Answer:</span> {{ $q->correct_answer ?? 'N/A' }}
                    </div>
                    <div>
                        <span>Marks: <strong>{{ $q->points ?? ($q->marks ?? 1) }}</strong></span>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

