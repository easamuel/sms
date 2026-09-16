@extends('layouts.admin')

@section('title', 'Attendance Management - School Management System')
@section('page-title', 'Attendance Management')

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
    .sms-table {
        width: 100%;
        border-collapse: collapse;
    }
    .sms-table thead {
        background: var(--sms-gray-50);
    }
    .sms-table th {
        padding: 0.875rem 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--sms-gray-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid var(--sms-gray-200);
    }
    .sms-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        color: var(--sms-gray-800);
        font-size: 0.9375rem;
    }
    .sms-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .sms-badge-success {
        background: #d1fae5;
        color: #065f46;
    }
    .sms-badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }
</style>

<div class="sms-card">
    <div class="sms-card-header">
        <h2 class="sms-card-title">Filter Attendance</h2>
    </div>
    <div class="sms-card-body">
        <form method="GET" action="{{ route('school.attendance.index') }}">
            <div class="sms-form-row">
                <div class="sms-form-group">
                    <label class="sms-form-label">Date</label>
                    <input type="date" name="date" class="sms-form-input" value="{{ $date ?? date('Y-m-d') }}">
                </div>
                <div class="sms-form-group">
                    <label class="sms-form-label">Class</label>
                    <select name="class_id" class="sms-form-select">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="sms-form-group" style="display: flex; align-items: flex-end;">
                    <button type="submit" class="sms-btn sms-btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="sms-card">
    <div class="sms-card-header">
        <h2 class="sms-card-title">Attendance Records</h2>
    </div>
    <div class="sms-card-body">
        @if($attendances->count() > 0)
        <div style="overflow-x: auto;">
            <table class="sms-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                    <tr>
                        <td style="font-weight: 600;">{{ $attendance->student->user->name ?? 'N/A' }}</td>
                        <td>{{ $attendance->class->name ?? 'N/A' }}</td>
                        <td>
                            @php
                                $date = is_string($attendance->date) ? \Carbon\Carbon::parse($attendance->date) : $attendance->date;
                            @endphp
                            {{ $date->format('M d, Y') }}
                        </td>
                        <td>
                            @if($attendance->status === 'present')
                                <span class="sms-badge sms-badge-success">Present</span>
                            @elseif($attendance->status === 'absent')
                                <span class="sms-badge sms-badge-danger">Absent</span>
                            @else
                                <span class="sms-badge">{{ ucfirst($attendance->status) }}</span>
                            @endif
                        </td>
                        <td>{{ $attendance->remarks ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top: 1.5rem;">
            {{ $attendances->links() }}
        </div>
        @else
        <div style="text-align: center; padding: 3rem;">
            <div style="font-size: 3rem; color: var(--sms-gray-300); margin-bottom: 1rem;">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div style="font-size: 1.125rem; font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.5rem;">
                No Attendance Records
            </div>
            <div style="color: var(--sms-gray-500);">
                No attendance records found for the selected date and class
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
