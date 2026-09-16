@extends('layouts.app')

@section('title', 'Practice Mode - ' . $subject->name . ' - School Management System')

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
    .sms-page-subtitle {
        color: var(--sms-gray-600);
        font-size: 1rem;
    }
    .sms-practice-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        margin-bottom: 2rem;
    }
    .sms-practice-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
    }
    .sms-practice-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .sms-practice-badge {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
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
    }
    .sms-option-item {
        padding: 1rem;
        background: white;
        border: 2px solid var(--sms-gray-200);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .sms-option-item:hover {
        border-color: var(--sms-primary);
        background: rgba(99, 102, 241, 0.05);
    }
    .sms-option-item.selected {
        border-color: var(--sms-primary);
        background: rgba(99, 102, 241, 0.1);
    }
    .sms-option-item.correct {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.1);
    }
    .sms-option-item.incorrect {
        border-color: #ef4444;
        background: rgba(239, 68, 68, 0.1);
    }
    .sms-option-radio {
        width: 20px;
        height: 20px;
        border: 2px solid var(--sms-gray-300);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .sms-option-item.selected .sms-option-radio {
        border-color: var(--sms-primary);
    }
    .sms-option-item.selected .sms-option-radio::after {
        content: '';
        width: 10px;
        height: 10px;
        background: var(--sms-primary);
        border-radius: 50%;
    }
    .sms-option-text {
        flex: 1;
        font-size: 0.9375rem;
        color: var(--sms-gray-800);
    }
    .sms-practice-info {
        background: #dbeafe;
        border-left: 4px solid #3b82f6;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    .sms-practice-info-title {
        font-weight: 700;
        color: #1e40af;
        margin-bottom: 0.5rem;
    }
    .sms-practice-info-text {
        font-size: 0.875rem;
        color: #1e40af;
        line-height: 1.5;
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
    .sms-btn-secondary {
        background: var(--sms-gray-200);
        color: var(--sms-gray-700);
    }
    .sms-btn-secondary:hover {
        background: var(--sms-gray-300);
    }
    .sms-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--sms-gray-200);
    }
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <h1 class="sms-page-title">Practice Mode</h1>
        <p class="sms-page-subtitle">
            Subject: <strong>{{ $subject->name }}</strong> | 
            Class: {{ $student->class?->name ?? 'N/A' }}{{ $student->class && $student->class->section ? ' - '.$student->class->section : '' }}
        </p>
    </div>

    <div style="max-width: 1000px; margin: 0 auto; padding: 0 2rem 2rem;">
        <div class="sms-practice-card">
            <div class="sms-practice-header">
                <h2 class="sms-practice-title">Practice Questions</h2>
                <span class="sms-practice-badge">
                    <i class="fas fa-dumbbell"></i> Practice Mode
                </span>
            </div>

            <div class="sms-practice-info">
                <div class="sms-practice-info-title">
                    <i class="fas fa-info-circle"></i> Practice Mode Information
                </div>
                <div class="sms-practice-info-text">
                    This is practice mode. You can answer questions at your own pace. 
                    No time limit, no fee restrictions. Use this to prepare for your exams.
                    Answers will be shown after you submit.
                </div>
            </div>

            <form id="practiceForm">
                @csrf
                @foreach($practiceQuestions as $index => $question)
                <div class="sms-question-card" data-question-id="{{ $question->id }}">
                    <div class="sms-question-number">Question {{ $index + 1 }} of {{ $practiceQuestions->count() }}</div>
                    <div class="sms-question-text">{{ $question->question_text }}</div>
                    
                    @if($question->question_type === 'multiple_choice' && $question->options)
                    <div class="sms-options-list">
                        @php
                            $options = is_string($question->options) ? json_decode($question->options, true) : $question->options;
                            $options = $options ?? [];
                        @endphp
                        @foreach($options as $option)
                        <div class="sms-option-item" data-option="{{ $option }}">
                            <div class="sms-option-radio"></div>
                            <div class="sms-option-text">{{ $option }}</div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div style="padding: 1rem; background: white; border-radius: 8px; border: 1px solid var(--sms-gray-200);">
                        <textarea 
                            name="answer_{{ $question->id }}" 
                            rows="4" 
                            style="width: 100%; border: none; outline: none; resize: vertical; font-size: 0.9375rem;"
                            placeholder="Type your answer here..."
                        ></textarea>
                    </div>
                    @endif
                </div>
                @endforeach

                <div class="sms-actions">
                    <a href="{{ route('sms.student.exams') }}" class="sms-btn sms-btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Exams
                    </a>
                    <button type="button" id="submitPractice" class="sms-btn sms-btn-primary">
                        <i class="fas fa-check"></i> Submit Practice
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle option selection for multiple choice
    document.querySelectorAll('.sms-option-item').forEach(item => {
        item.addEventListener('click', function() {
            const questionCard = this.closest('.sms-question-card');
            questionCard.querySelectorAll('.sms-option-item').forEach(opt => {
                opt.classList.remove('selected');
            });
            this.classList.add('selected');
            
            // Store answer
            const questionId = questionCard.dataset.questionId;
            const answer = this.dataset.option;
            const hiddenInput = document.querySelector(`input[name="answer_${questionId}"]`);
            if (!hiddenInput) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `answer_${questionId}`;
                input.value = answer;
                questionCard.appendChild(input);
            } else {
                hiddenInput.value = answer;
            }
        });
    });

    // Submit practice
    document.getElementById('submitPractice').addEventListener('click', function() {
        if (confirm('Submit your practice answers? You will see the correct answers.')) {
            // For now, just show a message
            // In a full implementation, this would submit to a practice results page
            alert('Practice mode results will be shown here. This feature is being enhanced.');
        }
    });
});
</script>
@endsection
