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
        letter-spacing: -0.02em;
        line-height: 1.2;
    }
    .sms-page-subtitle {
        color: var(--sms-gray-600);
        font-size: 0.875rem;
        line-height: 1.5;
    }
    .timetable-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem 1rem;
    }
    .timetable-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .timetable-day-section {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
    }
    .day-header {
        background: var(--sms-primary);
        color: white;
        padding: 0.875rem;
        text-align: center;
        font-weight: 700;
        font-size: 0.875rem;
        text-transform: uppercase;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    .timetable-period {
        background: var(--sms-gray-50);
        padding: 0.75rem;
        text-align: center;
        font-weight: 600;
        font-size: 0.8125rem;
        color: var(--sms-gray-700);
        border: 1px solid var(--sms-gray-200);
        border-radius: 8px;
        margin-bottom: 0.75rem;
    }
    .timetable-cell {
        background: white;
        padding: 1rem;
        border: 1px solid var(--sms-gray-200);
        border-radius: 8px;
        min-height: auto;
        transition: all 0.2s;
        margin-bottom: 0.75rem;
    }
    .timetable-cell:active {
        transform: scale(0.98);
    }
    .timetable-cell.has-class {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
        border-color: var(--sms-primary);
        border-width: 2px;
    }
    .class-info {
        font-weight: 600;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
        font-size: 0.9375rem;
    }
    .subject-name {
        color: var(--sms-primary);
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }
    .time-slot {
        font-size: 0.75rem;
        color: var(--sms-gray-600);
        margin-top: 0.5rem;
    }
    
    @media (min-width: 640px) {
        .sms-page-header {
            padding: 1.5rem;
            margin: -1.5rem -1.5rem 1.5rem -1.5rem;
        }
        
        .sms-page-title {
            font-size: 1.75rem;
        }
        
        .sms-page-subtitle {
            font-size: 1rem;
        }
        
        .timetable-container {
            padding: 0 1.5rem 1.5rem;
        }
    }
    
    @media (min-width: 1024px) {
        .sms-page-header {
            padding: 2rem;
            margin: -2rem -2rem 2rem -2rem;
        }
        
        .sms-page-title {
            font-size: 1.875rem;
        }
        
        .timetable-container {
            padding: 0 2rem 2rem;
        }
        
        .timetable-grid {
            grid-template-columns: 120px repeat(6, 1fr);
            gap: 1rem;
        }
        
        .timetable-day-section {
            display: none;
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
        
        .timetable-cell {
            min-height: 100px;
        }
        
        .timetable-cell:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
    }
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <h1 class="sms-page-title">My Teaching Timetable</h1>
        <p class="sms-page-subtitle">{{ $currentYear }} - {{ $currentTerm }}</p>
    </div>

    <div class="timetable-container">
        <!-- Desktop Grid View -->
        <div class="timetable-grid" style="display: none;">
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
                    '10:00' => '10:00 - 10:20', // Break
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
                            <div class="class-info">{{ $slotClass->class->name }}{{ $slotClass->class->section ? ' - ' . $slotClass->class->section : '' }}</div>
                            <div class="time-slot">{{ $slotClass->start_time->format('H:i') }} - {{ $slotClass->end_time->format('H:i') }}</div>
                        @else
                            <div style="color: var(--sms-gray-400); font-size: 0.875rem;">Free</div>
                        @endif
                    </div>
                @endforeach
            @endforeach
        </div>
        
        <!-- Mobile Day-by-Day View -->
        @php
            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            $dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        @endphp
        
        @foreach($days as $index => $day)
        <div class="timetable-day-section">
            <div class="day-header">{{ $dayNames[$index] }}</div>
            @php
                $dayClasses = $timetableByDay[$day] ?? collect();
            @endphp
            @if($dayClasses->isEmpty())
                <div class="timetable-cell">
                    <div style="color: var(--sms-gray-400); font-size: 0.875rem; text-align: center; padding: 1rem;">No classes scheduled</div>
                </div>
            @else
                @foreach($dayClasses as $slotClass)
                <div class="timetable-cell has-class">
                    <div class="timetable-period">{{ $slotClass->start_time->format('H:i') }} - {{ $slotClass->end_time->format('H:i') }}</div>
                    <div class="subject-name">{{ $slotClass->subject->name }}</div>
                    <div class="class-info">{{ $slotClass->class->name }}{{ $slotClass->class->section ? ' - ' . $slotClass->class->section : '' }}</div>
                </div>
                @endforeach
            @endif
        </div>
        @endforeach
    </div>
    
    <style>
        @media (min-width: 1024px) {
            .timetable-grid {
                display: grid !important;
            }
            
            .timetable-day-section {
                display: none !important;
            }
        }
    </style>
</div>
@endsection
