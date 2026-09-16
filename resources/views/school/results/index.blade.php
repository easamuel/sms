@extends('layouts.admin')

@section('title', 'Results Management - School Management System')
@section('page-title', 'Results Management')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .sms-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
    }
    .sms-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .sms-table {
        width: 100%;
        border-collapse: collapse;
    }
    .sms-table thead {
        background: var(--sms-gray-50);
    }
    .sms-table th {
        padding: 0.75rem 1rem;
        text-align: left;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--sms-gray-700);
        border-bottom: 2px solid var(--sms-gray-200);
    }
    .sms-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        font-size: 0.9375rem;
        color: var(--sms-gray-700);
    }
    .sms-table tbody tr:hover {
        background: var(--sms-gray-50);
    }
    .sms-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.8125rem;
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
        padding: 0.625rem 0.875rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 0.9375rem;
        transition: border-color 0.2s;
    }
    .sms-form-input:focus,
    .sms-form-select:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--sms-gray-500);
    }
    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    .result-group {
        border: 1px solid var(--sms-gray-200);
        border-radius: 8px;
        margin-bottom: 1rem;
        overflow: hidden;
    }
    .result-group-header {
        background: var(--sms-gray-50);
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }
    .result-group-title {
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .result-group-content {
        display: none;
    }
    .result-group-content.active {
        display: block;
    }
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
        .sms-card {
            padding: 1rem;
        }
        .sms-table {
            font-size: 0.8125rem;
        }
        .sms-table th,
        .sms-table td {
            padding: 0.5rem;
        }
    }
</style>

<div>
    <!-- Filters -->
    <div class="sms-card">
        <div class="sms-card-header">
            <h3 class="sms-card-title">Results Overview</h3>
        </div>
        <div>
            <p style="color: var(--sms-gray-600); margin-bottom: 1rem;">
                <strong>Academic Year:</strong> {{ $currentYear }} | 
                <strong>Term:</strong> {{ $currentTerm }}
            </p>
            <p style="color: var(--sms-gray-600); font-size: 0.875rem;">
                Viewing results for {{ $resultsByClass->count() }} class(es) with {{ $resultsByStudent->count() }} student(s)
            </p>
        </div>
    </div>

    <!-- Results by Class -->
    <div class="sms-card">
        <div class="sms-card-header">
            <h3 class="sms-card-title">Results by Class</h3>
        </div>
        @if($resultsByClass->count() > 0)
            <div>
                @foreach($resultsByClass as $classId => $classResults)
                    @php
                        $class = $classes->firstWhere('id', $classId);
                        $studentsInClass = $classResults->groupBy('student_id');
                    @endphp
                    <div class="result-group">
                        <div class="result-group-header" onclick="toggleGroup('class-{{ $classId }}')">
                            <div>
                                <span class="result-group-title">{{ $class->name ?? 'Unknown Class' }}</span>
                                <span style="font-size: 0.875rem; color: var(--sms-gray-500); margin-left: 0.5rem;">
                                    ({{ $studentsInClass->count() }} student(s), {{ $classResults->count() }} result(s))
                                </span>
                            </div>
                            <i class="fas fa-chevron-down" id="icon-class-{{ $classId }}"></i>
                        </div>
                        <div class="result-group-content" id="class-{{ $classId }}">
                            <div style="overflow-x: auto;">
                                <table class="sms-table">
                                    <thead>
                                        <tr>
                                            <th>Student</th>
                                            <th>Subject</th>
                                            <th>CA Score</th>
                                            <th>Exam Score</th>
                                            <th>Total</th>
                                            <th>Grade</th>
                                            <th>Remark</th>
                                            <th>Position</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($classResults as $result)
                                            <tr>
                                                <td style="font-weight: 600;">
                                                    {{ $result->student->user->name ?? 'N/A' }}
                                                    <div style="font-size: 0.75rem; color: var(--sms-gray-500);">
                                                        {{ $result->student->student_id_number ?? '' }}
                                                    </div>
                                                </td>
                                                <td>{{ $result->subject->name ?? 'N/A' }}</td>
                                                <td>{{ number_format($result->ca_score ?? 0, 2) }}</td>
                                                <td>{{ number_format($result->exam_score ?? 0, 2) }}</td>
                                                <td style="font-weight: 600;">{{ number_format($result->total_score ?? 0, 2) }}</td>
                                                <td>
                                                    <span class="sms-badge {{ $result->grade == 'A' ? 'sms-badge-success' : ($result->grade == 'F' ? 'sms-badge-danger' : 'sms-badge-warning') }}">
                                                        {{ $result->grade ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td style="font-size: 0.875rem;">{{ $result->remark ?? 'N/A' }}</td>
                                                <td>
                                                    @if($result->position)
                                                        <span style="font-weight: 600;">{{ $result->position }}{{ $result->position == 1 ? 'st' : ($result->position == 2 ? 'nd' : ($result->position == 3 ? 'rd' : 'th')) }}</span>
                                                    @else
                                                        —
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <p>No results found for {{ $currentYear }} - {{ $currentTerm }}</p>
                <p style="font-size: 0.875rem; margin-top: 0.5rem;">
                    Results will appear here once teachers upload them.
                </p>
            </div>
        @endif
    </div>

    <!-- Results by Student -->
    <div class="sms-card">
        <div class="sms-card-header">
            <h3 class="sms-card-title">Results by Student</h3>
        </div>
        @if($resultsByStudent->count() > 0)
            <div>
                @foreach($resultsByStudent as $studentId => $studentResults)
                    @php
                        $student = $studentResults->first()->student;
                        $subjects = $studentResults->groupBy('subject_id');
                        $totalScore = $studentResults->sum('total_score');
                        $average = $studentResults->avg('total_score');
                    @endphp
                    <div class="result-group">
                        <div class="result-group-header" onclick="toggleGroup('student-{{ $studentId }}')">
                            <div>
                                <span class="result-group-title">{{ $student->user->name ?? 'Unknown Student' }}</span>
                                <span style="font-size: 0.875rem; color: var(--sms-gray-500); margin-left: 0.5rem;">
                                    ({{ $subjects->count() }} subject(s), Avg: {{ number_format($average, 2) }}%)
                                </span>
                            </div>
                            <i class="fas fa-chevron-down" id="icon-student-{{ $studentId }}"></i>
                        </div>
                        <div class="result-group-content" id="student-{{ $studentId }}">
                            <div style="overflow-x: auto;">
                                <table class="sms-table">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>CA Score</th>
                                            <th>Exam Score</th>
                                            <th>Total</th>
                                            <th>Grade</th>
                                            <th>Remark</th>
                                            <th>Position</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($studentResults as $result)
                                            <tr>
                                                <td style="font-weight: 600;">{{ $result->subject->name ?? 'N/A' }}</td>
                                                <td>{{ number_format($result->ca_score ?? 0, 2) }}</td>
                                                <td>{{ number_format($result->exam_score ?? 0, 2) }}</td>
                                                <td style="font-weight: 600;">{{ number_format($result->total_score ?? 0, 2) }}</td>
                                                <td>
                                                    <span class="sms-badge {{ $result->grade == 'A' ? 'sms-badge-success' : ($result->grade == 'F' ? 'sms-badge-danger' : 'sms-badge-warning') }}">
                                                        {{ $result->grade ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td style="font-size: 0.875rem;">{{ $result->remark ?? 'N/A' }}</td>
                                                <td>
                                                    @if($result->position)
                                                        <span style="font-weight: 600;">{{ $result->position }}{{ $result->position == 1 ? 'st' : ($result->position == 2 ? 'nd' : ($result->position == 3 ? 'rd' : 'th')) }}</span>
                                                    @else
                                                        —
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr style="background: var(--sms-gray-50); font-weight: 700;">
                                            <td colspan="3">Total / Average</td>
                                            <td>{{ number_format($totalScore, 2) }} / {{ number_format($average, 2) }}%</td>
                                            <td colspan="3"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <p>No student results found for {{ $currentYear }} - {{ $currentTerm }}</p>
            </div>
        @endif
    </div>
</div>

<script>
    function toggleGroup(groupId) {
        var group = document.getElementById(groupId);
        var icon = document.getElementById('icon-' + groupId);
        
        if (group.classList.contains('active')) {
            group.classList.remove('active');
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        } else {
            group.classList.add('active');
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        }
    }
</script>
@endsection
