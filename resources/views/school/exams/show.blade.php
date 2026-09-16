@extends('layouts.app')

@section('title', 'Exam Details - School Management System')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
    }
    .sms-page-header {
        background: white;
        padding: 1.25rem 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        margin: -1rem -1rem 1.5rem -1rem;
        border-radius: 0;
        display: flex;
        flex-direction: column;
        gap: 1rem;
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
        line-height: 1.5;
    }
    .sms-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 1.5rem;
        font-size: 0.9375rem;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        min-height: 44px;
        touch-action: manipulation;
        width: 100%;
    }
    .sms-btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
    }
    .sms-btn-primary:active {
        transform: scale(0.98);
        box-shadow: 0 1px 4px rgba(99, 102, 241, 0.3);
    }
    .sms-btn-secondary {
        background: white;
        color: var(--sms-gray-700);
        border: 1px solid var(--sms-gray-300);
    }
    .sms-btn-secondary:active {
        transform: scale(0.98);
        background: var(--sms-gray-50);
    }
    .sms-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        margin-bottom: 1.5rem;
    }
    .sms-card-header {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
    }
    .sms-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .sms-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .sms-info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    .sms-info-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--sms-gray-500);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .sms-info-grid {
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }
    
    .sms-info-value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--sms-gray-900);
    }
    
    @media (min-width: 640px) {
        .sms-page-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            margin: -1.5rem -1.5rem 1.5rem -1.5rem;
        }
        
        .sms-page-title {
            font-size: 1.75rem;
        }
        
        .sms-page-subtitle {
            font-size: 1rem;
        }
        
        .sms-card {
            padding: 1.5rem;
        }
        
        .sms-card-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        
        .sms-info-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .sms-btn {
            width: auto;
            padding: 0.625rem 1.25rem;
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
        
        .sms-card {
            padding: 2rem;
            border-radius: 16px;
        }
    }
    .sms-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
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
    .sms-questions-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .sms-question-item {
        padding: 1rem;
        background: var(--sms-gray-50);
        border-radius: 8px;
        border: 1px solid var(--sms-gray-200);
    }
    .sms-question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    .sms-question-number {
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--sms-primary);
    }
    .sms-question-text {
        font-size: 0.9375rem;
        color: var(--sms-gray-800);
        margin-bottom: 0.5rem;
    }
    .sms-question-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.8125rem;
        color: var(--sms-gray-500);
    }
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <div>
            <h1 class="sms-page-title">Exam Details</h1>
            <p class="sms-page-subtitle">{{ $exam->title ?? $exam->name }}</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('school.exams.index') }}" class="sms-btn sms-btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Exams
            </a>
            @if($exam->questions->count() == 0)
            <a href="{{ route('school.exams.questions.create', $exam->id) }}" class="sms-btn sms-btn-primary">
                <i class="fas fa-plus"></i> Add Questions
            </a>
            @endif
        </div>
    </div>

    <div style="max-width: 1400px; margin: 0 auto; padding: 0 2rem 2rem;">
        <!-- Exam Information -->
        <div class="sms-card">
            <div class="sms-card-header">
                <h2 class="sms-card-title">Exam Information</h2>
                @if($exam->is_active)
                    <span class="sms-badge sms-badge-success">Active</span>
                @else
                    <span class="sms-badge sms-badge-danger">Inactive</span>
                @endif
            </div>
            
            <div class="sms-info-grid">
                <div class="sms-info-item">
                    <span class="sms-info-label">Subject</span>
                    <span class="sms-info-value">{{ $exam->subject->name ?? 'N/A' }}</span>
                </div>
                <div class="sms-info-item">
                    <span class="sms-info-label">Class</span>
                    <span class="sms-info-value">{{ $exam->class->name ?? 'N/A' }}</span>
                </div>
                <div class="sms-info-item">
                    <span class="sms-info-label">Exam Type</span>
                    <span class="sms-info-value">
                        <span class="sms-badge sms-badge-info">{{ $exam->exam_type ?? 'N/A' }}</span>
                    </span>
                </div>
                <div class="sms-info-item">
                    <span class="sms-info-label">Duration</span>
                    <span class="sms-info-value">{{ $exam->duration_minutes ?? 0 }} minutes</span>
                </div>
                <div class="sms-info-item">
                    <span class="sms-info-label">Passing Score</span>
                    <span class="sms-info-value">{{ $exam->passing_score ?? 0 }}%</span>
                </div>
                <div class="sms-info-item">
                    <span class="sms-info-label">Total Questions</span>
                    <span class="sms-info-value">{{ $exam->total_questions ?? $exam->questions->count() }}</span>
                </div>
                @if($exam->scheduled_date)
                <div class="sms-info-item">
                    <span class="sms-info-label">Scheduled Date</span>
                    <span class="sms-info-value">
                        {{ \Carbon\Carbon::parse($exam->scheduled_date)->format('F j, Y') }}
                        @if($exam->scheduled_time)
                            at {{ $exam->scheduled_time }}
                        @endif
                    </span>
                </div>
                @endif
            </div>

            @if($exam->description)
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--sms-gray-200);">
                <span class="sms-info-label">Description</span>
                <p style="margin-top: 0.5rem; color: var(--sms-gray-700); line-height: 1.6;">{{ $exam->description }}</p>
            </div>
            @endif
        </div>

        <!-- Questions -->
        <div class="sms-card">
            <div class="sms-card-header">
                <h2 class="sms-card-title">Questions ({{ $exam->questions->count() }})</h2>
                @if($exam->questions->count() == 0)
                <a href="{{ route('school.exams.questions.create', $exam->id) }}" class="sms-btn sms-btn-primary">
                    <i class="fas fa-plus"></i> Add Questions
                </a>
                @endif
            </div>

            @if($exam->questions->count() > 0)
            <div class="sms-questions-list">
                @foreach($exam->questions as $index => $question)
                <div class="sms-question-item">
                    <div class="sms-question-header">
                        <span class="sms-question-number">Question {{ $index + 1 }}</span>
                        <span class="sms-badge sms-badge-info">{{ $question->points ?? 1 }} points</span>
                    </div>
                    <div class="sms-question-text">{{ $question->question_text }}</div>
                    <div class="sms-question-meta">
                        <span>Type: {{ ucfirst(str_replace('_', ' ', $question->question_type)) }}</span>
                        <span>Correct Answer: <strong>{{ $question->correct_answer }}</strong></span>
                    </div>
                    @if($question->question_type === 'multiple_choice' && $question->options)
                    <div style="margin-top: 0.75rem; padding: 0.75rem; background: white; border-radius: 6px; border: 1px solid var(--sms-gray-200);">
                        <div style="font-size: 0.8125rem; font-weight: 600; color: var(--sms-gray-600); margin-bottom: 0.5rem;">Options:</div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            @php
                                $options = is_string($question->options) ? json_decode($question->options, true) : $question->options;
                                $options = $options ?? [];
                            @endphp
                            @foreach($options as $option)
                            <div style="padding: 0.5rem; background: var(--sms-gray-50); border-radius: 4px; font-size: 0.875rem;">
                                {{ $option }}
                                @if($option === $question->correct_answer)
                                    <span class="sms-badge sms-badge-success" style="margin-left: 0.5rem;">Correct</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div style="text-align: center; padding: 3rem 2rem; color: var(--sms-gray-500);">
                <div style="font-size: 3rem; color: var(--sms-gray-300); margin-bottom: 1rem;">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div style="font-size: 1.125rem; font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.5rem;">
                    No Questions Added Yet
                </div>
                <div style="font-size: 0.9375rem; color: var(--sms-gray-500); margin-bottom: 1.5rem;">
                    Add questions to make this exam available to students.
                </div>
                <a href="{{ route('school.exams.questions.create', $exam->id) }}" class="sms-btn sms-btn-primary">
                    <i class="fas fa-plus"></i> Add Questions
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
