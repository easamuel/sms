@extends('layouts.app')

@section('title', 'Practice Sessions - Student Dashboard')

@section('content')
@include('sms.partials.design-system')
<style>
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
    }
    .sms-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        padding: 2rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }
    .sms-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
    .sms-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
    }
    .subject-filter {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }
    .subject-filter a {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.2s;
    }
    .subject-filter a.active {
        background: var(--sms-primary);
        color: white;
    }
    .subject-filter a:not(.active) {
        background: var(--sms-gray-100);
        color: var(--sms-gray-700);
    }
</style>

<div style="max-width: 1400px; margin: 0 auto; padding: 2rem;">
    <div class="sms-page-header">
        <div>
            <h1 class="sms-page-title">Practice Sessions</h1>
            <p style="color: var(--sms-gray-600);">Practice with unlimited questions to improve your skills</p>
        </div>
    </div>

    @if($subjects->count() > 0)
    <div class="subject-filter">
        <a href="{{ route('sms.student.practice-sessions') }}" class="{{ !$selectedSubject ? 'active' : '' }}">
            All Subjects
        </a>
        @foreach($subjects as $subject)
        <a href="{{ route('sms.student.practice-sessions', ['subject_id' => $subject->id]) }}" 
           class="{{ $selectedSubject && $selectedSubject->id == $subject->id ? 'active' : '' }}">
            {{ $subject->name }}
        </a>
        @endforeach
    </div>
    @endif

    @if($practiceSessions->isEmpty())
    <div style="text-align: center; padding: 3rem; background: white; border-radius: 16px;">
        <div style="font-size: 3rem; color: var(--sms-gray-300); margin-bottom: 1rem;">
            <i class="fas fa-dumbbell"></i>
        </div>
        <div style="font-size: 1.125rem; font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.5rem;">
            No Practice Sessions Available
        </div>
        <div style="color: var(--sms-gray-500);">
            @if($selectedSubject)
                No practice sessions have been created for {{ $selectedSubject->name }} yet.
            @else
                No practice sessions have been created for your class yet. Please check back later.
            @endif
        </div>
    </div>
    @else
    @foreach($practiceSessions as $session)
    <div class="sms-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
            <div style="flex: 1;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--sms-gray-900); margin-bottom: 0.5rem;">
                    {{ $session->title }}
                </h3>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem;">
                    <span style="color: var(--sms-gray-600); font-size: 0.875rem;">
                        <i class="fas fa-book"></i> {{ $session->subject->name ?? 'N/A' }}
                    </span>
                    <span style="color: var(--sms-gray-600); font-size: 0.875rem;">
                        <i class="fas fa-users"></i> {{ $session->class->name ?? 'N/A' }}
                    </span>
                    <span style="color: var(--sms-gray-600); font-size: 0.875rem;">
                        <i class="fas fa-question-circle"></i> {{ $session->questions->count() }} Questions
                    </span>
                </div>
                @if($session->description)
                <p style="color: var(--sms-gray-700); font-size: 0.9375rem; margin-bottom: 1rem;">
                    {{ $session->description }}
                </p>
                @endif
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    @if($session->availability === 'always_open')
                        <span class="sms-badge sms-badge-success">Always Available</span>
                    @else
                        <span class="sms-badge sms-badge-info">
                            @if($session->start_date)
                                Available: {{ \Carbon\Carbon::parse($session->start_date)->format('M j') }} - 
                            @endif
                            @if($session->end_date)
                                {{ \Carbon\Carbon::parse($session->end_date)->format('M j, Y') }}
                            @endif
                        </span>
                    @endif
                    @if($session->show_answers_immediately)
                        <span class="sms-badge sms-badge-info">Answers Shown Immediately</span>
                    @endif
                </div>
            </div>
            <div>
                @php
                    // Get the most recent completed attempt for this student
                    $lastAttempt = $session->attempts
                        ->where('student_id', $student->id)
                        ->whereNotNull('completed_at')
                        ->sortByDesc('completed_at')
                        ->first();
                @endphp
                @if($lastAttempt)
                @php
                    // Calculate total marks for selected questions
                    $selectedQuestionIds = $lastAttempt->selected_question_ids ?? [];
                    if (empty($selectedQuestionIds)) {
                        // Fallback: if no selected_question_ids, use all questions (for old attempts)
                        $selectedQuestions = $session->questions;
                    } else {
                        $selectedQuestions = $session->questions->whereIn('id', $selectedQuestionIds);
                    }
                    $totalMarks = $selectedQuestions->sum('marks');
                @endphp
                <div style="margin-bottom: 0.75rem; text-align: right;">
                    <div style="font-size: 0.75rem; color: var(--sms-gray-600); margin-bottom: 0.25rem;">Last Attempt</div>
                    <div style="font-weight: 600; color: var(--sms-gray-900);">
                        {{ number_format($lastAttempt->percentage, 1) }}% ({{ $lastAttempt->score }}/{{ $totalMarks }} marks)
                    </div>
                    <div style="font-size: 0.75rem; color: var(--sms-gray-500); margin-top: 0.25rem;">
                        {{ $lastAttempt->total_questions }} question{{ $lastAttempt->total_questions > 1 ? 's' : '' }}
                    </div>
                </div>
                @endif
                <a href="{{ route('sms.student.practice-sessions.take', $session->id) }}" class="sms-btn sms-btn-primary">
                    <i class="fas fa-play"></i> Start Practice
                </a>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>
@endsection
