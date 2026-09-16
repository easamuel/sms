@extends('layouts.app')

@section('title', 'Assignments - Teacher Dashboard')

@section('content')
@include('sms.partials.design-system')
<style>
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
        line-height: 1.2;
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
    .sms-table-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .sms-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }
    .sms-table thead {
        background: var(--sms-gray-50);
    }
    .sms-table th {
        padding: 0.75rem 0.75rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--sms-gray-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid var(--sms-gray-200);
        white-space: nowrap;
    }
    .sms-table td {
        padding: 0.75rem 0.75rem;
        border-bottom: 1px solid var(--sms-gray-200);
        color: var(--sms-gray-800);
        font-size: 0.875rem;
    }
    .sms-table td .sms-btn {
        width: auto;
        padding: 0.5rem 0.75rem;
        font-size: 0.8125rem;
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
        
        .sms-btn {
            width: auto;
            padding: 0.625rem 1.25rem;
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
        
        .sms-table th,
        .sms-table td {
            padding: 1rem 1.5rem;
            font-size: 0.9375rem;
        }
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
    .sms-badge-warning { background: #fef3c7; color: #92400e; }
    .sms-badge-danger { background: #fee2e2; color: #991b1b; }
    .sms-badge-info { background: #dbeafe; color: #1e40af; }
</style>

<div style="max-width: 1400px; margin: 0 auto; padding: 1rem;">
    <div class="sms-page-header">
        <div>
            <h1 class="sms-page-title">Assignments</h1>
            <p style="color: var(--sms-gray-600); font-size: 0.875rem; line-height: 1.5;">Manage all assignments for your classes</p>
        </div>
        <a href="{{ route('sms.teacher.assignments.create') }}" class="sms-btn sms-btn-primary">
            <i class="fas fa-plus-circle"></i> Create Assignment
        </a>
    </div>

    @if($assignments->count() === 0)
    <div style="text-align: center; padding: 3rem; background: white; border-radius: 16px;">
        <div style="font-size: 3rem; color: var(--sms-gray-300); margin-bottom: 1rem;">
            <i class="fas fa-tasks"></i>
        </div>
        <div style="font-size: 1.125rem; font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.5rem;">
            No Assignments Created Yet
        </div>
        <div style="color: var(--sms-gray-500); margin-bottom: 1.5rem;">
            Start by creating your first assignment
        </div>
        <a href="{{ route('sms.teacher.assignments.create') }}" class="sms-btn sms-btn-primary">
            <i class="fas fa-plus-circle"></i> Create Assignment
        </a>
    </div>
    @else
    <div class="sms-table-container">
        <table class="sms-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>Class</th>
                    <th>Type</th>
                    <th>Due Date</th>
                    <th>Submissions</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignments as $assignment)
                <tr>
                    <td style="font-weight: 600;">{{ $assignment->title }}</td>
                    <td>{{ $assignment->subject->name ?? 'N/A' }}</td>
                    <td>{{ $assignment->class->name ?? 'N/A' }}</td>
                    <td>
                        <span class="sms-badge sms-badge-info">
                            {{ ucfirst($assignment->submission_type) }}
                        </span>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($assignment->due_date)->format('M j, Y') }}
                        @if($assignment->due_time)
                            at {{ \Carbon\Carbon::parse($assignment->due_time)->format('h:i A') }}
                        @endif
                    </td>
                    <td>
                        {{ $assignment->submissions->count() }} / 
                        {{ $assignment->class->students->count() ?? 0 }}
                    </td>
                    <td>
                        @if($assignment->is_active)
                            <span class="sms-badge sms-badge-success">Active</span>
                        @else
                            <span class="sms-badge sms-badge-warning">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="#" class="sms-btn sms-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1.5rem;">
        {{ $assignments->links('vendor.pagination.tailwind') }}
    </div>
    @endif
</div>
@endsection
