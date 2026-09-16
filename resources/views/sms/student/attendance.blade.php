@extends('layouts.app')

@section('title', 'My Attendance - School Management System')

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
    .sms-info-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }
    .sms-info-item {
        display: flex;
        flex-direction: column;
    }
    .sms-info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--sms-gray-500);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .sms-info-value {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .sms-stat-box {
        min-width: 130px;
        padding: 1rem;
        border-radius: 12px;
        background: var(--sms-gray-50);
    }
    .sms-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        overflow: hidden;
    }
    .sms-card-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--sms-gray-200);
        background: var(--sms-gray-50);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .sms-card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .sms-card-body {
        padding: 1.5rem;
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
    .sms-table tbody tr {
        transition: background 0.15s ease;
    }
    .sms-table tbody tr:hover {
        background: var(--sms-gray-50);
    }
    .sms-table tbody tr:last-child td {
        border-bottom: none;
    }
    .sms-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1;
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
    .sms-empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--sms-gray-500);
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
    @media (max-width: 768px) {
        .sms-page-header {
            padding: 1.5rem;
        }
        .sms-page-title {
            font-size: 1.5rem;
        }
        .sms-table {
            font-size: 0.875rem;
        }
        .sms-table th,
        .sms-table td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <h1 class="sms-page-title">Attendance</h1>
        <p class="sms-page-subtitle">Track your daily attendance records for the current and previous terms.</p>
    </div>

    <div style="max-width: 1400px; margin: 0 auto; padding: 0 2rem 2rem;">
        <div class="sms-info-card">
            <div class="sms-info-item">
                <div class="sms-info-label">Current Class</div>
                <div class="sms-info-value">
                    {{ $student->class?->name ?? 'N/A' }}
                </div>
            </div>
            <div class="sms-stat-box">
                <div class="sms-info-label">Total Records</div>
                <div class="sms-info-value">{{ $attendances->total() }}</div>
            </div>
        </div>

        <div class="sms-card">
            <div class="sms-card-header">
                <h2 class="sms-card-title">Attendance History</h2>
                <div style="font-size: 0.875rem; color: var(--sms-gray-600);">
                    Showing {{ $attendances->firstItem() ?? 0 }}–{{ $attendances->lastItem() ?? 0 }} of {{ $attendances->total() }} days
                </div>
            </div>
            <div class="sms-card-body">
                @if($attendances->count())
                    <div style="width: 100%; overflow-x: auto;">
                        <table class="sms-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Class</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                <tr>
                                    <td>
                                        @php
                                            $date = $attendance->date;
                                            if ($date) {
                                                if (is_string($date)) {
                                                    $date = \Carbon\Carbon::parse($date);
                                                }
                                                echo $date->format('M d, Y');
                                            } else {
                                                echo '—';
                                            }
                                        @endphp
                                    </td>
                                    <td>
                                        @if($attendance->status === 'present')
                                            <span class="sms-badge sms-badge-success">Present</span>
                                        @elseif($attendance->status === 'absent')
                                            <span class="sms-badge sms-badge-danger">Absent</span>
                                        @elseif($attendance->status === 'late')
                                            <span class="sms-badge sms-badge-warning">Late</span>
                                        @else
                                            <span class="sms-badge sms-badge-info">{{ ucfirst($attendance->status ?? 'N/A') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $attendance->class?->name ?? '—' }}</td>
                                    <td style="color: var(--sms-gray-600);">{{ $attendance->remarks ?? '—' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 1.5rem;">
                        {{ $attendances->links() }}
                    </div>
                @else
                    <div class="sms-empty-state">
                        <div class="sms-empty-state-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div class="sms-empty-state-title">No Attendance Records</div>
                        <div class="sms-empty-state-text">No attendance records found yet.</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
