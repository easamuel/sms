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
        padding: 1.25rem 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        margin: -1rem -1rem 1.5rem -1rem;
        border-radius: 0;
        display: flex;
        flex-direction: column;
        gap: 1rem;
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
    .sms-btn {
        min-height: 44px;
        touch-action: manipulation;
        width: 100%;
    }
    
    @media (min-width: 640px) {
        .sms-page-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            margin: -1.5rem -1.5rem 1.5rem -1.5rem;
        }
        
        .sms-page-title {
            font-size: 1.75rem;
        }
        
        .sms-page-subtitle {
            font-size: 1rem;
        }
        
        .sms-btn {
            width: auto;
        }
    }
    
    @media (min-width: 768px) {
        .sms-page-header {
            padding: 2rem;
            margin: -2rem -2rem 2rem -2rem;
        }
        
        .sms-page-title {
            font-size: 1.875rem;
        }
    }
    .sms-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
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
    .sms-table {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
    }
    .sms-table table {
        width: 100%;
        border-collapse: collapse;
    }
    .sms-table thead {
        background: var(--sms-gray-50);
    }
    .sms-table th {
        padding: 1rem 1.5rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--sms-gray-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid var(--sms-gray-200);
    }
    .sms-table td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--sms-gray-200);
        color: var(--sms-gray-800);
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
    .sms-actions {
        display: flex;
        gap: 0.5rem;
    }
    .sms-btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.8125rem;
    }
    .sms-empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--sms-gray-500);
    }
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <div>
            <h1 class="sms-page-title">Exams Management</h1>
            <p class="sms-page-subtitle">Manage all school examinations</p>
        </div>
        <a href="{{ route('school.exams.create') }}" class="sms-btn sms-btn-primary">
            <i class="fas fa-plus"></i> Create New Exam
        </a>
    </div>

    <div style="max-width: 1400px; margin: 0 auto; padding: 0 2rem 2rem;">
        @if($exams->count() > 0)
        <div class="sms-table">
            <table>
                <thead>
                    <tr>
                        <th>Exam Title</th>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Type</th>
                        <th>Scheduled Date</th>
                        <th>Duration</th>
                        <th>Questions</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                    <tr>
                        <td>
                            <strong>{{ $exam->title ?? $exam->name }}</strong>
                            @if($exam->description)
                            <br><small style="color: var(--sms-gray-500);">{{ Str::limit($exam->description, 50) }}</small>
                            @endif
                        </td>
                        <td>{{ $exam->subject->name ?? 'N/A' }}</td>
                        <td>{{ $exam->class->name ?? 'N/A' }}</td>
                        <td>
                            <span class="sms-badge sms-badge-info">{{ $exam->exam_type ?? 'N/A' }}</span>
                        </td>
                        <td>
                            @if($exam->scheduled_date)
                                {{ \Carbon\Carbon::parse($exam->scheduled_date)->format('M j, Y') }}
                                @if($exam->scheduled_time)
                                    <br><small>{{ $exam->scheduled_time }}</small>
                                @endif
                            @else
                                <span style="color: var(--sms-gray-400);">Not scheduled</span>
                            @endif
                        </td>
                        <td>{{ $exam->duration_minutes ?? 0 }} min</td>
                        <td>{{ $exam->total_questions ?? 0 }}</td>
                        <td>
                            @if($exam->is_active)
                                <span class="sms-badge sms-badge-success">Active</span>
                            @else
                                <span class="sms-badge sms-badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="sms-actions">
                                <a href="{{ route('school.exams.show', $exam->id) }}" class="sms-btn sms-btn-secondary sms-btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 2rem;">
            {{ $exams->links() }}
        </div>
        @else
        <div class="sms-empty-state">
            <div style="font-size: 3rem; color: var(--sms-gray-300); margin-bottom: 1rem;">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div style="font-size: 1.125rem; font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.5rem;">
                No Exams Found
            </div>
            <div style="font-size: 0.9375rem; color: var(--sms-gray-500); margin-bottom: 1.5rem;">
                Get started by creating your first exam.
            </div>
            <a href="{{ route('school.exams.create') }}" class="sms-btn sms-btn-primary">
                <i class="fas fa-plus"></i> Create First Exam
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
