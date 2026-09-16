@extends('layouts.app')

@section('title', 'Exams - School Management System')

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
    .sms-alert {
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border-left: 4px solid;
        max-width: 1400px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 0;
    }
    .sms-alert-warning {
        background: #fef3c7;
        border-color: #f59e0b;
        color: #92400e;
    }
    .sms-subjects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem 2rem;
    }
    .sms-subject-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: block;
        color: inherit;
    }
    .sms-subject-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.15);
        text-decoration: none;
        color: inherit;
    }
    .sms-subject-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
    }
    .sms-subject-code {
        font-size: 0.875rem;
        color: var(--sms-gray-600);
    }
    .sms-exam-detail-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem 2rem;
    }
    .sms-back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: white;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        color: var(--sms-gray-700);
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 1.5rem;
        transition: all 0.2s;
    }
    .sms-back-button:hover {
        background: var(--sms-gray-50);
        text-decoration: none;
        color: var(--sms-gray-900);
    }
    .sms-exam-type-section {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        margin-bottom: 1.5rem;
    }
    .sms-exam-type-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--sms-gray-200);
    }
    .sms-exam-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: var(--sms-gray-50);
        border-radius: 12px;
        margin-bottom: 0.75rem;
        transition: all 0.2s;
    }
    .sms-exam-item:hover {
        background: var(--sms-gray-100);
    }
    .sms-exam-info {
        flex: 1;
    }
    .sms-exam-name {
        font-weight: 600;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
    }
    .sms-exam-date {
        font-size: 0.875rem;
        color: var(--sms-gray-600);
    }
    .sms-exam-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
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
    .sms-btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .sms-btn-primary {
        background: var(--sms-primary);
        color: white;
    }
    .sms-btn-primary:hover {
        background: var(--sms-primary-dark);
        text-decoration: none;
        color: white;
    }
    .sms-btn-secondary {
        background: var(--sms-gray-200);
        color: var(--sms-gray-700);
    }
    .sms-btn-secondary:hover {
        background: var(--sms-gray-300);
        text-decoration: none;
        color: var(--sms-gray-900);
    }
    .sms-empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--sms-gray-500);
        background: white;
        border-radius: 16px;
        margin-top: 1.5rem;
    }
    .sms-empty-state-icon {
        font-size: 3rem;
        color: var(--sms-gray-300);
        margin-bottom: 1rem;
    }
    .sms-empty-state-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--sms-gray-700);
        margin-bottom: 0.5rem;
    }
    .sms-empty-state-text {
        font-size: 0.9375rem;
        color: var(--sms-gray-500);
    }
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <h1 class="sms-page-title">Exams</h1>
        <p class="sms-page-subtitle">
            Student ID: {{ $student->student_id_number }} | 
            Class: {{ $student->class?->name ?? 'N/A' }}
        </p>
    </div>

    @if(!$feeStatus['cleared'])
    <div class="sms-alert sms-alert-warning" style="margin-left: auto; margin-right: auto; margin-top: 0; margin-bottom: 2rem; background: linear-gradient(135deg, #fef3c7, #fde68a); border: 2px solid #f59e0b; padding: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="font-size: 2rem;">⚠️</div>
            <div style="flex: 1;">
                <strong style="font-size: 1.125rem; display: block; margin-bottom: 0.5rem;">Fee Payment Required</strong>
                <p style="margin: 0; font-size: 0.9375rem;">You are still owing school fees ({{ $feeStatus['percentage_paid'] }}% paid). Please pay at least 50% to sit for exams.</p>
            </div>
        </div>
    </div>
    @endif

    @if($selectedSubjectId)
        <!-- Show exams for selected subject -->
        <div class="sms-exam-detail-container">
            <a href="{{ route('sms.student.exams') }}" class="sms-back-button">
                <i class="fas fa-arrow-left"></i> Back to Subjects
            </a>

            @php
                $selectedSubject = $subjects->firstWhere('id', $selectedSubjectId);
            @endphp

            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--sms-gray-900); margin-bottom: 1.5rem;">
                {{ $selectedSubject->name ?? 'Subject' }} - Exams
            </h2>

            @if(!$feeStatus['cleared'])
                <!-- Payment Restriction Banner -->
                <div class="sms-exam-type-section" style="background: linear-gradient(135deg, #fee2e2, #fecaca); border: 2px solid #dc2626; text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🔒</div>
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #991b1b; margin-bottom: 0.75rem;">Exam Access Restricted</h3>
                    <p style="font-size: 1rem; color: #7f1d1d; margin-bottom: 1.5rem; line-height: 1.6;">
                        You cannot access exams until you have paid at least 50% of your school fees.<br>
                        Current payment: <strong>{{ $feeStatus['percentage_paid'] }}%</strong>
                    </p>
                    <a href="{{ route('sms.parent.fees') }}" class="sms-btn" style="background: #dc2626; color: white; padding: 0.875rem 2rem; font-size: 1rem; font-weight: 600;">
                        <i class="fas fa-credit-card"></i> Pay Fees Now
                    </a>
                </div>
            @endif

            @if($examsByType->isEmpty())
                <div class="sms-empty-state">
                    <div class="sms-empty-state-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="sms-empty-state-title">No Exams Available</div>
                    <div class="sms-empty-state-text">No exams have been scheduled for this subject yet.</div>
                </div>
            @else
                <!-- Only show Exams -->
                @if($examsByType->has('Exam'))
                <div class="sms-exam-type-section">
                    <h3 class="sms-exam-type-title">
                        <i class="fas fa-graduation-cap" style="margin-right: 0.5rem;"></i>
                        Exams
                    </h3>
                    @foreach($examsByType->get('Exam') as $exam)
                        @include('sms.student.partials.exam-item', ['exam' => $exam, 'examSessions' => $examSessions, 'feeStatus' => $feeStatus])
                    @endforeach
                </div>
                @endif
            @endif
        </div>
    @else
        <!-- Show list of subjects -->
        <div class="sms-subjects-grid">
            @forelse($subjects as $subject)
            <a href="{{ route('sms.student.exams', ['subject_id' => $subject->id]) }}" class="sms-subject-card">
                <div class="sms-subject-title">{{ $subject->name }}</div>
                <div class="sms-subject-code">{{ $subject->code ?? 'N/A' }}</div>
            </a>
            @empty
            <div class="sms-empty-state" style="grid-column: 1 / -1;">
                <div class="sms-empty-state-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="sms-empty-state-title">No Subjects Available</div>
                <div class="sms-empty-state-text">No subjects have been assigned to your class yet.</div>
            </div>
            @endforelse
        </div>
    @endif
</div>
@endsection
