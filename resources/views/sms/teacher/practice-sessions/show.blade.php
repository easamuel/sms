@extends('layouts.app')

@section('title', 'View Practice Session - Teacher Dashboard')

@section('content')
@include('sms.partials.design-system')
<style>
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
        line-height: 1.2;
    }
    .sms-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .sms-btn {
        min-height: 44px;
        touch-action: manipulation;
        width: 100%;
        margin-bottom: 0.5rem;
    }
    .question-item {
        padding: 1rem;
    }
    .info-grid {
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }
    .attempts-table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .attempts-table {
        min-width: 600px;
    }
    
    @media (min-width: 640px) {
        .sms-page-header {
            padding: 1.5rem;
            margin: -1.5rem -1.5rem 1.5rem -1.5rem;
        }
        
        .sms-page-title {
            font-size: 1.75rem;
        }
        
        .sms-card {
            padding: 1.5rem;
        }
        
        .sms-btn {
            width: auto;
            margin-bottom: 0;
        }
        
        .info-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
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
        
        .info-grid {
            grid-template-columns: repeat(4, 1fr);
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
    .sms-badge-success { background: #d1fae5; color: #065f46; }
    .sms-badge-warning { background: #fef3c7; color: #92400e; }
    .sms-badge-info { background: #dbeafe; color: #1e40af; }
    .sms-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        font-size: 0.9375rem;
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
    .sms-btn-secondary {
        background: var(--sms-gray-200);
        color: var(--sms-gray-700);
    }
    .question-item {
        background: var(--sms-gray-50);
        border: 1px solid var(--sms-gray-200);
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }
    .question-number {
        font-weight: 700;
        color: var(--sms-primary);
        margin-bottom: 0.5rem;
    }
    .option-item {
        padding: 0.5rem;
        margin: 0.25rem 0;
        background: white;
        border-radius: 4px;
    }
    .correct-option {
        background: #d1fae5;
        border-left: 3px solid #10b981;
    }
</style>

<div style="max-width: 1400px; margin: 0 auto; padding: 1rem;">
    <div class="sms-page-header">
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div>
                <h1 class="sms-page-title">{{ $practiceSession->title }}</h1>
                <p style="color: var(--sms-gray-600); font-size: 0.875rem; line-height: 1.5;">
                    {{ $practiceSession->subject->name ?? 'N/A' }} - {{ $practiceSession->class->name ?? 'N/A' }}
                </p>
            </div>
            <a href="{{ route('sms.teacher.practice-sessions') }}" class="sms-btn sms-btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Practice Sessions
            </a>
        </div>
    </div>

    <div class="sms-card">
        <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--sms-gray-900); margin-bottom: 1.5rem;">
            Session Details
        </h2>
        
        <div class="info-grid" style="display: grid;">
            <div>
                <p style="font-size: 0.75rem; color: var(--sms-gray-600); margin-bottom: 0.25rem;">Title</p>
                <p style="font-weight: 600; color: var(--sms-gray-900);">{{ $practiceSession->title }}</p>
            </div>
            <div>
                <p style="font-size: 0.75rem; color: var(--sms-gray-600); margin-bottom: 0.25rem;">Subject</p>
                <p style="font-weight: 600; color: var(--sms-gray-900);">{{ $practiceSession->subject->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p style="font-size: 0.75rem; color: var(--sms-gray-600); margin-bottom: 0.25rem;">Class</p>
                <p style="font-weight: 600; color: var(--sms-gray-900);">{{ $practiceSession->class->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p style="font-size: 0.75rem; color: var(--sms-gray-600); margin-bottom: 0.25rem;">Availability</p>
                @if($practiceSession->availability === 'always_open')
                    <span class="sms-badge sms-badge-success">Always Open</span>
                @else
                    <span class="sms-badge sms-badge-info">
                        @if($practiceSession->start_date)
                            {{ \Carbon\Carbon::parse($practiceSession->start_date)->format('M j, Y') }}
                        @endif
                        @if($practiceSession->end_date)
                            - {{ \Carbon\Carbon::parse($practiceSession->end_date)->format('M j, Y') }}
                        @endif
                    </span>
                @endif
            </div>
            <div>
                <p style="font-size: 0.75rem; color: var(--sms-gray-600); margin-bottom: 0.25rem;">Total Questions</p>
                <p style="font-weight: 600; color: var(--sms-gray-900);">{{ $practiceSession->questions->count() }}</p>
            </div>
            <div>
                <p style="font-size: 0.75rem; color: var(--sms-gray-600); margin-bottom: 0.25rem;">Total Attempts</p>
                <p style="font-weight: 600; color: var(--sms-gray-900);">{{ $practiceSession->attempts->count() }}</p>
            </div>
            <div>
                <p style="font-size: 0.75rem; color: var(--sms-gray-600); margin-bottom: 0.25rem;">Status</p>
                @if($practiceSession->is_active)
                    <span class="sms-badge sms-badge-success">Active</span>
                @else
                    <span class="sms-badge sms-badge-warning">Inactive</span>
                @endif
            </div>
            <div>
                <p style="font-size: 0.75rem; color: var(--sms-gray-600); margin-bottom: 0.25rem;">Show Answers</p>
                <p style="font-weight: 600; color: var(--sms-gray-900);">
                    {{ $practiceSession->show_answers_immediately ? 'Yes' : 'No' }}
                </p>
            </div>
        </div>

        @if($practiceSession->description)
        <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--sms-gray-200);">
            <p style="font-size: 0.75rem; color: var(--sms-gray-600); margin-bottom: 0.25rem;">Description</p>
            <p style="color: var(--sms-gray-800);">{{ $practiceSession->description }}</p>
        </div>
        @endif
    </div>

    <div class="sms-card">
        <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--sms-gray-900); margin-bottom: 1.5rem;">
            Questions ({{ $practiceSession->questions->count() }})
        </h2>

        @if($practiceSession->questions->isEmpty())
        <p style="color: var(--sms-gray-500); text-align: center; padding: 2rem;">No questions added yet.</p>
        @else
        @foreach($practiceSession->questions as $index => $question)
        <div class="question-item">
            <div class="question-number">Question {{ $index + 1 }} ({{ $question->marks }} mark{{ $question->marks > 1 ? 's' : '' }})</div>
            <p style="font-weight: 600; color: var(--sms-gray-900); margin-bottom: 1rem;">{{ $question->question_text }}</p>
            
            @if($question->question_type === 'objective' && $question->options)
            <div style="margin-top: 1rem;">
                <p style="font-size: 0.875rem; color: var(--sms-gray-600); margin-bottom: 0.5rem;">Options:</p>
                @foreach($question->options as $key => $option)
                <div class="option-item {{ $option === $question->correct_answer ? 'correct-option' : '' }}">
                    <strong>{{ chr(65 + $key) }}.</strong> {{ $option }}
                    @if($option === $question->correct_answer)
                        <span class="sms-badge sms-badge-success" style="margin-left: 0.5rem;">Correct</span>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            @if($question->correct_answer && $question->question_type !== 'objective')
            <div style="margin-top: 1rem; padding: 0.75rem; background: #d1fae5; border-radius: 6px;">
                <p style="font-size: 0.875rem; color: #065f46; font-weight: 600; margin-bottom: 0.25rem;">Correct Answer:</p>
                <p style="color: #065f46;">{{ $question->correct_answer }}</p>
            </div>
            @endif

            @if($question->explanation)
            <div style="margin-top: 1rem; padding: 0.75rem; background: #dbeafe; border-radius: 6px;">
                <p style="font-size: 0.875rem; color: #1e40af; font-weight: 600; margin-bottom: 0.25rem;">Explanation:</p>
                <p style="color: #1e40af;">{{ $question->explanation }}</p>
            </div>
            @endif
        </div>
        @endforeach
        @endif
    </div>

    @if($practiceSession->attempts->count() > 0)
    <div class="sms-card">
        <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--sms-gray-900); margin-bottom: 1.5rem;">
            Student Attempts ({{ $practiceSession->attempts->count() }})
        </h2>
        <div class="attempts-table-wrapper">
            <table class="attempts-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--sms-gray-50);">
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: var(--sms-gray-600);">Student</th>
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: var(--sms-gray-600);">Score</th>
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: var(--sms-gray-600);">Percentage</th>
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: var(--sms-gray-600);">Completed</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($practiceSession->attempts as $attempt)
                    <tr style="border-bottom: 1px solid var(--sms-gray-200);">
                        <td style="padding: 0.75rem;">{{ $attempt->student->user->name ?? 'N/A' }}</td>
                        <td style="padding: 0.75rem;">{{ $attempt->score }}/{{ $attempt->total_questions }}</td>
                        <td style="padding: 0.75rem;">{{ number_format($attempt->percentage, 1) }}%</td>
                        <td style="padding: 0.75rem;">
                            @if($attempt->completed_at)
                                {{ \Carbon\Carbon::parse($attempt->completed_at)->format('M j, Y g:i A') }}
                            @else
                                In Progress
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
