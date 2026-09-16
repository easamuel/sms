@extends('layouts.app')

@section('title', 'Practice Sessions - Teacher Dashboard')

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
    .sms-badge-info { background: #dbeafe; color: #1e40af; }
</style>

<div style="max-width: 1400px; margin: 0 auto; padding: 1rem;">
    <div class="sms-page-header">
        <div>
            <h1 class="sms-page-title">Practice Sessions</h1>
            <p style="color: var(--sms-gray-600); font-size: 0.875rem; line-height: 1.5;">Create and manage practice sessions for students</p>
        </div>
        <a href="{{ route('sms.teacher.practice-sessions.create') }}" class="sms-btn sms-btn-primary">
            <i class="fas fa-plus-circle"></i> Create Practice Session
        </a>
    </div>

    @if(session('success'))
    <div style="background: #d1fae5; border: 1px solid #10b981; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem; color: #065f46;">
        <i class="fas fa-check-circle"></i> {!! session('success') !!}
    </div>
    @endif

    @if(session('error'))
    <div style="background: #fee2e2; border: 1px solid #ef4444; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem; color: #991b1b;">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif

    @if($practiceSessions->isEmpty())
    <div style="text-align: center; padding: 3rem; background: white; border-radius: 16px;">
        <div style="font-size: 3rem; color: var(--sms-gray-300); margin-bottom: 1rem;">
            <i class="fas fa-dumbbell"></i>
        </div>
        <div style="font-size: 1.125rem; font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.5rem;">
            No Practice Sessions Created Yet
        </div>
        <div style="color: var(--sms-gray-500); margin-bottom: 1.5rem;">
            Start by creating your first practice session
        </div>
        <a href="{{ route('sms.teacher.practice-sessions.create') }}" class="sms-btn sms-btn-primary">
            <i class="fas fa-plus-circle"></i> Create Practice Session
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
                    <th>Availability</th>
                    <th>Questions</th>
                    <th>Attempts</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($practiceSessions as $session)
                <tr>
                    <td style="font-weight: 600;">{{ $session->title }}</td>
                    <td>{{ $session->subject->name ?? 'N/A' }}</td>
                    <td>{{ $session->class->name ?? 'N/A' }}</td>
                    <td>
                        @if($session->availability === 'always_open')
                            <span class="sms-badge sms-badge-success">Always Open</span>
                        @else
                            <span class="sms-badge sms-badge-info">
                                @if($session->start_date)
                                    {{ \Carbon\Carbon::parse($session->start_date)->format('M j') }} - 
                                @endif
                                @if($session->end_date)
                                    {{ \Carbon\Carbon::parse($session->end_date)->format('M j') }}
                                @endif
                            </span>
                        @endif
                    </td>
                    <td>{{ $session->questions->count() }}</td>
                    <td>{{ $session->attempts->count() }}</td>
                    <td>
                        @if($session->is_active)
                            <span class="sms-badge sms-badge-success">Active</span>
                        @else
                            <span class="sms-badge sms-badge-warning">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('sms.teacher.practice-sessions.show', $session->id) }}" class="sms-btn" style="background: var(--sms-gray-200); color: var(--sms-gray-700); padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1.5rem;">
        {{ $practiceSessions->links() }}
    </div>
    @endif
</div>
@endsection
