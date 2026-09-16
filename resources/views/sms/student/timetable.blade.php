@extends('layouts.app')

@section('title', 'My Timetable - School Management System')

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
    .timetable-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem 2rem;
    }
    .timetable-grid {
        display: grid;
        grid-template-columns: 120px repeat(6, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .timetable-header {
        background: var(--sms-primary);
        color: white;
        padding: 1rem;
        text-align: center;
        font-weight: 700;
        font-size: 0.875rem;
        text-transform: uppercase;
        border-radius: 8px;
    }
    .timetable-period {
        background: white;
        padding: 0.75rem;
        text-align: center;
        font-weight: 600;
        font-size: 0.8125rem;
        color: var(--sms-gray-700);
        border: 1px solid var(--sms-gray-200);
        border-radius: 8px;
    }
    .timetable-cell {
        background: white;
        padding: 1rem;
        border: 1px solid var(--sms-gray-200);
        border-radius: 8px;
        min-height: 100px;
        transition: all 0.2s;
    }
    .timetable-cell:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    .timetable-cell.has-class {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
        border-color: var(--sms-primary);
    }
    .subject-name {
        color: var(--sms-primary);
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    .teacher-name {
        font-size: 0.875rem;
        color: var(--sms-gray-600);
        margin-bottom: 0.25rem;
    }
    .time-slot {
        font-size: 0.75rem;
        color: var(--sms-gray-600);
        margin-top: 0.5rem;
    }
    @media (max-width: 1024px) {
        .timetable-grid {
            grid-template-columns: 1fr;
        }
        .timetable-cell {
            min-height: auto;
        }
    }
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <h1 class="sms-page-title">My Class Timetable</h1>
        <p class="sms-page-subtitle">{{ $student->class->name ?? 'N/A' }} - {{ $currentYear }} - {{ $currentTerm }}</p>
    </div>

    <div class="timetable-container">
        <div class="timetable-grid">
            <div class="timetable-header">Time</div>
            <div class="timetable-header">Monday</div>
            <div class="timetable-header">Tuesday</div>
            <div class="timetable-header">Wednesday</div>
            <div class="timetable-header">Thursday</div>
            <div class="timetable-header">Friday</div>
            <div class="timetable-header">Saturday</div>

            @php
                $timeSlots = [
                    '08:00' => '08:00 - 08:40',
                    '08:40' => '08:40 - 09:20',
                    '09:20' => '09:20 - 10:00',
                    '10:00' => '10:00 - 10:20',
                    '10:20' => '10:20 - 11:00',
                    '11:00' => '11:00 - 11:40',
                    '11:40' => '11:40 - 12:20',
                    '12:20' => '12:20 - 13:00',
                    '13:00' => '13:00 - 13:40',
                ];
                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            @endphp

            @foreach($timeSlots as $startTime => $timeRange)
                <div class="timetable-period">{{ $timeRange }}</div>
                @foreach($days as $day)
                    @php
                        $classForSlot = $timetableByDay[$day] ?? collect();
                        $slotClass = $classForSlot->firstWhere(function($item) use ($startTime) {
                            return str_starts_with($item->start_time->format('H:i'), substr($startTime, 0, 5));
                        });
                    @endphp
                    <div class="timetable-cell {{ $slotClass ? 'has-class' : '' }}">
                        @if($slotClass)
                            <div class="subject-name">{{ $slotClass->subject->name }}</div>
                            <div class="teacher-name">{{ $slotClass->teacher->user->name ?? 'N/A' }}</div>
                            <div class="time-slot">{{ $slotClass->start_time->format('H:i') }} - {{ $slotClass->end_time->format('H:i') }}</div>
                        @else
                            <div style="color: var(--sms-gray-400); font-size: 0.875rem;">Free Period</div>
                        @endif
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</div>
@endsection
