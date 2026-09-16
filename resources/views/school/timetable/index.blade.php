@extends('layouts.admin')

@section('title', 'Timetable Management - School Management System')
@section('page-title', 'Timetable Management')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .sms-card-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--sms-gray-200);
        background: var(--sms-gray-50);
    }
    .sms-card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .sms-card-body {
        padding: 1.5rem;
    }
    .timetable-grid {
        display: grid;
        grid-template-columns: 80px repeat(6, 1fr);
        gap: 0.5rem;
        margin-top: 1rem;
    }
    .timetable-header {
        background: var(--sms-primary);
        color: white;
        padding: 0.75rem;
        text-align: center;
        font-weight: 700;
        font-size: 0.875rem;
        border-radius: 8px;
    }
    .timetable-time {
        background: var(--sms-gray-100);
        padding: 0.75rem;
        text-align: center;
        font-weight: 600;
        font-size: 0.8125rem;
        border-radius: 8px;
    }
    .timetable-cell {
        background: var(--sms-gray-50);
        padding: 0.75rem;
        min-height: 80px;
        border-radius: 8px;
        font-size: 0.8125rem;
    }
    .timetable-entry {
        background: white;
        border: 1px solid var(--sms-gray-200);
        padding: 0.5rem;
        border-radius: 6px;
        margin-bottom: 0.5rem;
    }
    .timetable-entry-subject {
        font-weight: 600;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
    }
    .timetable-entry-teacher {
        font-size: 0.75rem;
        color: var(--sms-gray-600);
    }
    .sms-form-group {
        margin-bottom: 1rem;
    }
    .sms-form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--sms-gray-700);
        margin-bottom: 0.5rem;
    }
    .sms-form-input,
    .sms-form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 0.9375rem;
    }
    .sms-form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    .sms-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }
    .sms-btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
    }
</style>

<div class="sms-card">
    <div class="sms-card-header">
        <h2 class="sms-card-title">Create Timetable Entry</h2>
    </div>
    <div class="sms-card-body">
        <form action="{{ route('school.timetable.store') }}" method="POST">
            @csrf
            <div class="sms-form-row">
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
                    <label class="sms-form-label">Subject *</label>
                    <select name="subject_id" class="sms-form-select" required>
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sms-form-group">
                    <label class="sms-form-label">Teacher *</label>
                    <select name="teacher_id" class="sms-form-select" required>
                        <option value="">Select Teacher</option>
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->user->name ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sms-form-group">
                    <label class="sms-form-label">Day *</label>
                    <select name="day" class="sms-form-select" required>
                        <option value="monday">Monday</option>
                        <option value="tuesday">Tuesday</option>
                        <option value="wednesday">Wednesday</option>
                        <option value="thursday">Thursday</option>
                        <option value="friday">Friday</option>
                        <option value="saturday">Saturday</option>
                    </select>
                </div>
                <div class="sms-form-group">
                    <label class="sms-form-label">Start Time *</label>
                    <input type="time" name="start_time" class="sms-form-input" required>
                </div>
                <div class="sms-form-group">
                    <label class="sms-form-label">End Time *</label>
                    <input type="time" name="end_time" class="sms-form-input" required>
                </div>
            </div>
            <input type="hidden" name="academic_year" value="{{ $currentYear }}">
            <input type="hidden" name="term" value="{{ $currentTerm }}">
            <button type="submit" class="sms-btn sms-btn-primary">
                <i class="fas fa-plus"></i> Add to Timetable
            </button>
        </form>
    </div>
</div>

@foreach($timetableByClass as $classId => $classTimetables)
@php
    $class = $classes->firstWhere('id', $classId);
@endphp
<div class="sms-card">
    <div class="sms-card-header">
        <h2 class="sms-card-title">{{ $class->name ?? 'Unknown Class' }} - Timetable</h2>
    </div>
    <div class="sms-card-body">
        <div class="timetable-grid">
            <div class="timetable-header">Time</div>
            <div class="timetable-header">Monday</div>
            <div class="timetable-header">Tuesday</div>
            <div class="timetable-header">Wednesday</div>
            <div class="timetable-header">Thursday</div>
            <div class="timetable-header">Friday</div>
            <div class="timetable-header">Saturday</div>
            
            @php
                $timeSlots = $classTimetables->groupBy(function($item) {
                    return $item->start_time . '-' . $item->end_time;
                });
            @endphp
            
            @foreach($timeSlots as $timeSlot => $entries)
            <div class="timetable-time">{{ $entries->first()->start_time }} - {{ $entries->first()->end_time }}</div>
            @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
            <div class="timetable-cell">
                @php
                    $dayEntry = $entries->firstWhere('day', $day);
                @endphp
                @if($dayEntry)
                <div class="timetable-entry">
                    <div class="timetable-entry-subject">{{ $dayEntry->subject->name ?? 'N/A' }}</div>
                    <div class="timetable-entry-teacher">{{ $dayEntry->teacher->user->name ?? 'N/A' }}</div>
                </div>
                @endif
            </div>
            @endforeach
            @endforeach
        </div>
    </div>
</div>
@endforeach

@if($timetableByClass->isEmpty())
<div class="sms-card">
    <div class="sms-card-body" style="text-align: center; padding: 3rem;">
        <div style="font-size: 3rem; color: var(--sms-gray-300); margin-bottom: 1rem;">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div style="font-size: 1.125rem; font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.5rem;">
            No Timetable Entries
        </div>
        <div style="color: var(--sms-gray-500);">
            Create timetable entries above
        </div>
    </div>
</div>
@endif
@endsection
