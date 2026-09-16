@extends('layouts.app')

@section('title', 'Select Questions - ' . $practiceSession->title)

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
    .sms-selection-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    .sms-info-box {
        background: #dbeafe;
        border-left: 4px solid #3b82f6;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }
    .sms-info-title {
        font-weight: 700;
        color: #1e40af;
        margin-bottom: 0.5rem;
    }
    .sms-info-text {
        font-size: 0.875rem;
        color: #1e40af;
        line-height: 1.5;
    }
    .sms-form-group {
        margin-bottom: 1.5rem;
    }
    .sms-form-label {
        display: block;
        font-weight: 600;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }
    .sms-form-input {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.2s;
    }
    .sms-form-input:focus {
        outline: none;
        border-color: var(--sms-primary);
    }
    .sms-form-help {
        font-size: 0.875rem;
        color: var(--sms-gray-600);
        margin-top: 0.5rem;
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
        width: 100%;
        justify-content: center;
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
        gap: 1rem;
        margin-top: 2rem;
    }
    .sms-question-count {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--sms-primary);
        text-align: center;
        padding: 1rem;
        background: var(--sms-gray-50);
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <h1 class="sms-page-title">{{ $practiceSession->title }}</h1>
        <p class="sms-page-subtitle">
            Subject: <strong>{{ $practiceSession->subject->name ?? 'N/A' }}</strong> | 
            Class: {{ $practiceSession->class->name ?? 'N/A' }}
        </p>
    </div>

    <div style="max-width: 1000px; margin: 0 auto; padding: 0 2rem 2rem;">
        <div class="sms-selection-card">
            <div class="sms-info-box">
                <div class="sms-info-title">
                    <i class="fas fa-info-circle"></i> Select Number of Questions
                </div>
                <div class="sms-info-text">
                    Choose how many questions you want to practice. You can select any number from 1 to {{ $practiceSession->questions->count() }} questions. 
                    Your score will be calculated based on the questions you select.
                </div>
            </div>

            <div class="sms-question-count">
                Total Questions Available: <strong>{{ $practiceSession->questions->count() }}</strong>
            </div>

            <form method="POST" action="{{ route('sms.student.practice-sessions.take', $practiceSession->id) }}">
                @csrf
                <div class="sms-form-group">
                    <label for="num_questions" class="sms-form-label">
                        How many questions would you like to answer?
                    </label>
                    <input 
                        type="number" 
                        id="num_questions" 
                        name="num_questions" 
                        class="sms-form-input"
                        min="1" 
                        max="{{ $practiceSession->questions->count() }}" 
                        value="{{ min(20, $practiceSession->questions->count()) }}"
                        required
                    >
                    <div class="sms-form-help">
                        Enter a number between 1 and {{ $practiceSession->questions->count() }}. Questions will be randomly selected.
                    </div>
                </div>

                <div class="sms-actions">
                    <a href="{{ route('sms.student.practice-sessions') }}" class="sms-btn sms-btn-secondary" style="flex: 1;">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="sms-btn sms-btn-primary" style="flex: 2;">
                        <i class="fas fa-play"></i> Start Practice
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('num_questions');
    const max = {{ $practiceSession->questions->count() }};
    
    input.addEventListener('input', function() {
        if (this.value > max) {
            this.value = max;
        }
        if (this.value < 1) {
            this.value = 1;
        }
    });
});
</script>
@endsection
