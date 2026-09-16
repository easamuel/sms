@extends('layouts.app')

@section('title', 'Create Exam - Teacher Dashboard')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .sms-form-group {
        margin-bottom: 1.25rem;
    }
    .sms-form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--sms-gray-700);
        margin-bottom: 0.5rem;
    }
    .sms-form-input, .sms-form-select, .sms-form-textarea {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 16px;
        min-height: 44px;
        touch-action: manipulation;
        transition: border-color 0.2s;
    }
    .sms-form-textarea {
        min-height: 100px;
        resize: vertical;
        font-size: 16px;
    }
    .sms-form-input:focus, .sms-form-select:focus, .sms-form-textarea:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .sms-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
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
    
    @media (min-width: 640px) {
        .sms-form-card {
            padding: 1.5rem;
        }
        
        .sms-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .sms-btn {
            width: auto;
            padding: 0.625rem 1.25rem;
        }
    }
    
    @media (min-width: 768px) {
        .sms-form-card {
            padding: 2rem;
            border-radius: 16px;
        }
        
        .sms-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
    }
</style>

<div style="max-width: 1000px; margin: 0 auto; padding: 1rem;">
    <div style="margin-bottom: 1.5rem;">
        <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--sms-gray-900); margin-bottom: 0.5rem; line-height: 1.2;">
            Create Exam
        </h1>
        <p style="color: var(--sms-gray-600); font-size: 0.875rem; line-height: 1.5;">Create CA1, CA2, Test, or Exam (Online/Offline)</p>
    </div>

    <form action="{{ route('sms.teacher.exams.store') }}" method="POST">
        @csrf

        <div class="sms-form-card">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--sms-gray-900); margin-bottom: 1.5rem;">
                Exam Details
            </h2>

            <div class="sms-form-group">
                <label class="sms-form-label">Exam Title *</label>
                <input type="text" name="title" class="sms-form-input" required placeholder="e.g., First Term Mathematics Exam">
            </div>

            <div class="sms-form-group">
                <label class="sms-form-label">Description</label>
                <textarea name="description" class="sms-form-textarea" placeholder="Optional description"></textarea>
            </div>

            <div class="sms-grid">
                <div class="sms-form-group">
                    <label class="sms-form-label">Subject *</label>
                    <select name="subject_id" class="sms-form-select" required id="subject-select">
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ $subjects->count() === 1 ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @if($subjects->count() === 0)
                        <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">
                            No subjects assigned. Please contact administrator to assign subjects.
                        </div>
                    @elseif($subjects->count() === 1)
                        <div style="color: var(--sms-primary); font-size: 0.8125rem; margin-top: 0.25rem;">
                            <i class="fas fa-info-circle"></i> Subject automatically selected (only one assigned)
                        </div>
                    @endif
                </div>

                <div class="sms-form-group">
                    <label class="sms-form-label">Class *</label>
                    <select name="class_id" class="sms-form-select" required>
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sms-form-group">
                    <label class="sms-form-label">Exam Type *</label>
                    <select name="exam_type" class="sms-form-select" required>
                        <option value="">Select Type</option>
                        <option value="CA1">CA1</option>
                        <option value="CA2">CA2</option>
                        <option value="Test">Test</option>
                        <option value="Exam">Exam</option>
                    </select>
                </div>

                <div class="sms-form-group">
                    <label class="sms-form-label">Exam Mode *</label>
                    <select name="exam_mode" class="sms-form-select" required id="examMode">
                        <option value="">Select Mode</option>
                        <option value="online">Online (CBE)</option>
                        <option value="offline">Offline (Manual/Theory)</option>
                        <option value="both">Both (Online + Offline)</option>
                    </select>
                </div>

                <div class="sms-form-group">
                    <label class="sms-form-label">Duration (Minutes) *</label>
                    <input type="number" name="duration_minutes" class="sms-form-input" required min="1" value="60">
                </div>

                <div class="sms-form-group">
                    <label class="sms-form-label">Passing Score (%) *</label>
                    <input type="number" name="passing_score" class="sms-form-input" required min="0" max="100" value="50">
                </div>

                <div class="sms-form-group">
                    <label class="sms-form-label">Scheduled Date</label>
                    <input type="date" name="scheduled_date" class="sms-form-input">
                </div>

                <div class="sms-form-group">
                    <label class="sms-form-label">Scheduled Time</label>
                    <input type="time" name="scheduled_time" class="sms-form-input">
                </div>
            </div>

            <div class="sms-form-group" id="manualGradingGroup" style="display: none;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="allow_manual_grading" value="1">
                    <span class="sms-form-label" style="margin: 0;">Allow Manual Grading</span>
                </label>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('sms.teacher.exams') }}" class="sms-btn" style="background: var(--sms-gray-200); color: var(--sms-gray-700);">
                Cancel
            </a>
            <button type="submit" class="sms-btn sms-btn-primary">
                <i class="fas fa-arrow-right"></i> Continue
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('examMode')?.addEventListener('change', function() {
        const mode = this.value;
        const manualGradingGroup = document.getElementById('manualGradingGroup');
        
        if (mode === 'offline' || mode === 'both') {
            manualGradingGroup.style.display = 'block';
        } else {
            manualGradingGroup.style.display = 'none';
        }
    });
</script>
@endsection
