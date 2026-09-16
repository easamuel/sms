@extends('layouts.admin')

@section('title', 'Notice Board - School Management System')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
        padding: 2rem;
    }
    .sms-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .sms-page-title {
        font-size: 1.875rem;
        font-weight: 800;
        color: var(--sms-gray-900);
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
    .sms-table {
        width: 100%;
        border-collapse: collapse;
    }
    .sms-table th {
        padding: 0.875rem 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--sms-gray-600);
        text-transform: uppercase;
        background: var(--sms-gray-50);
        border-bottom: 2px solid var(--sms-gray-200);
    }
    .sms-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        color: var(--sms-gray-800);
        font-size: 0.9375rem;
    }
    .sms-table tbody tr:hover {
        background: var(--sms-gray-50);
    }
    .sms-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
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
    .btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent));
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <h1 class="sms-page-title">Notice Board</h1>
        <a href="{{ route('school.notices.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Create Notice
        </a>
    </div>

    <div class="sms-card">
        <div class="sms-card-header">
            <h2 class="sms-card-title">All Notices</h2>
        </div>
        <div class="sms-card-body">
            @if($notices->count() > 0)
                <table class="sms-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Target Audience</th>
                            <th>Published</th>
                            <th>Expires</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notices as $notice)
                            <tr>
                                <td><strong>{{ $notice->title }}</strong></td>
                                <td>
                                    <span class="sms-badge">
                                        {{ ucfirst($notice->target_audience) }}
                                    </span>
                                </td>
                                <td>
                                    @if($notice->published_at)
                                        @php
                                            $publishedAt = is_string($notice->published_at) ? \Carbon\Carbon::parse($notice->published_at) : $notice->published_at;
                                        @endphp
                                        {{ $publishedAt->format('M d, Y') }}
                                    @else
                                        Not published
                                    @endif
                                </td>
                                <td>
                                    @if($notice->expires_at)
                                        @php
                                            $expiresAt = is_string($notice->expires_at) ? \Carbon\Carbon::parse($notice->expires_at) : $notice->expires_at;
                                        @endphp
                                        {{ $expiresAt->format('M d, Y') }}
                                    @else
                                        No expiry
                                    @endif
                                </td>
                                <td>
                                    @if($notice->is_active)
                                        <span class="sms-badge sms-badge-success">Active</span>
                                    @else
                                        <span class="sms-badge sms-badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('school.notices.edit', $notice) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('school.notices.destroy', $notice) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this notice?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div style="margin-top: 1.5rem;">
                    {{ $notices->links() }}
                </div>
            @else
                <p class="text-muted text-center py-4">No notices found. <a href="{{ route('school.notices.create') }}">Create your first notice</a></p>
            @endif
        </div>
    </div>
</div>
@endsection
