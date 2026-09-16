@extends('layouts.app')

@section('title', 'Practice Session Result')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
    }
    .sms-page-header {
        background: white;
        padding: 2rem;
        border-bottom: 1px solid var(--sms-gray-200);
        margin-bottom: 2rem;
    }
    .sms-page-title {
        font-size: 1.875rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }
    .sms-result-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        margin-bottom: 2rem;
    }
    .sms-result-summary {
        text-align: center;
        padding: 2rem;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border-radius: 12px;
        color: white;
        margin-bottom: 2rem;
    }
    .sms-result-score {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    .sms-result-label {
        font-size: 1.125rem;
        opacity: 0.9;
    }
    .sms-question-card {
        background: var(--sms-gray-50);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--sms-gray-200);
    }
    .sms-question-number {
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--sms-primary);
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .sms-question-text {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--sms-gray-900);
        margin-bottom: 1rem;
        line-height: 1.6;
    }
    .sms-options-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    .sms-option-item {
        padding: 1rem;
        background: white;
        border: 2px solid var(--sms-gray-200);
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .sms-option-item.correct {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.1);
    }
    .sms-option-item.incorrect {
        border-color: #ef4444;
        background: rgba(239, 68, 68, 0.1);
    }
    .sms-option-item.selected {
        border-color: var(--sms-primary);
        background: rgba(99, 102, 241, 0.1);
    }
    .sms-option-text {
        flex: 1;
        font-size: 0.9375rem;
        color: var(--sms-gray-800);
    }
    .sms-answer-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }
    .sms-badge-success {
        background: #d1fae5;
        color: #065f46;
    }
    .sms-badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }
    .sms-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-size: 0.9375rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .sms-btn-primary {
        background: var(--sms-primary);
        color: white;
    }
    .sms-btn-primary:hover {
        background: var(--sms-primary-dark);
    }
    .sms-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--sms-gray-200);
    }
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <h1 class="sms-page-title">Practice Session Result</h1>
        <p class="sms-page-subtitle">
            {{ $attempt->practiceSession->title }} | 
            {{ $attempt->practiceSession->subject->name ?? 'N/A' }}
        </p>
    </div>

    <div style="max-width: 1000px; margin: 0 auto; padding: 0 2rem 2rem;">
        <div class="sms-result-card">
            @php
                $totalMarks = $attempt->practiceSession->questions->sum('marks');
            @endphp
            <div class="sms-result-summary">
                <div class="sms-result-score">{{ number_format($attempt->percentage, 1) }}%</div>
                <div class="sms-result-label">
                    Score: {{ $attempt->score }} / {{ $totalMarks }} marks
                </div>
            </div>

            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--sms-gray-900); margin-bottom: 1.5rem;">
                Review Your Answers
            </h2>

            @php
                $selectedQuestionIds = $attempt->selected_question_ids ?? [];
                $questions = $attempt->practiceSession->questions->whereIn('id', $selectedQuestionIds);
            @endphp
            @foreach($questions as $index => $question)
            @php
                $studentAnswer = $attempt->answers[$question->id] ?? null;
                $isCorrect = $studentAnswer && $studentAnswer === $question->correct_answer;
            @endphp
            <div class="sms-question-card">
                <div class="sms-question-number">
                    Question {{ $index + 1 }} of {{ $questions->count() }}
                    @if($isCorrect)
                        <span class="sms-answer-badge sms-badge-success">Correct</span>
                    @else
                        <span class="sms-answer-badge sms-badge-danger">Incorrect</span>
                    @endif
                </div>
                <div class="sms-question-text">{{ $question->question_text }}</div>
                
                @if($question->question_type === 'objective' && $question->options)
                <div class="sms-options-list">
                    @php
                        $options = is_string($question->options) ? json_decode($question->options, true) : $question->options;
                        $options = $options ?? [];
                    @endphp
                    @foreach($options as $key => $option)
                    @php
                        $isSelected = $studentAnswer === $option;
                        $isCorrectOption = $option === $question->correct_answer;
                        $optionClass = '';
                        if ($isCorrectOption) {
                            $optionClass = 'correct';
                        } elseif ($isSelected && !$isCorrectOption) {
                            $optionClass = 'incorrect';
                        } elseif ($isSelected) {
                            $optionClass = 'selected';
                        }
                    @endphp
                    <div class="sms-option-item {{ $optionClass }}">
                        <div class="sms-option-text">
                            {{ chr(65 + $key) }}. {{ $option }}
                            @if($isCorrectOption)
                                <span class="sms-answer-badge sms-badge-success">Correct Answer</span>
                            @endif
                            @if($isSelected && !$isCorrectOption)
                                <span class="sms-answer-badge sms-badge-danger">Your Answer</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div style="margin-top: 1rem;">
                    <div style="padding: 1rem; background: #d1fae5; border-radius: 8px; margin-bottom: 0.5rem;">
                        <strong style="color: #065f46; font-size: 0.875rem;">Correct Answer:</strong>
                        <p style="color: #065f46; margin-top: 0.5rem;">{{ $question->correct_answer ?? 'N/A' }}</p>
                    </div>
                    @if($studentAnswer)
                    <div style="padding: 1rem; background: {{ $isCorrect ? '#d1fae5' : '#fee2e2' }}; border-radius: 8px;">
                        <strong style="color: {{ $isCorrect ? '#065f46' : '#991b1b' }}; font-size: 0.875rem;">Your Answer:</strong>
                        <p style="color: {{ $isCorrect ? '#065f46' : '#991b1b' }}; margin-top: 0.5rem;">{{ $studentAnswer }}</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>
            @endforeach

            <div class="sms-actions">
                <a href="{{ route('sms.student.practice-sessions') }}" class="sms-btn sms-btn-primary">
                    <i class="fas fa-arrow-left"></i> Back to Practice Sessions
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
