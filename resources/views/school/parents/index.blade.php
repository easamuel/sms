@extends('layouts.admin')

@section('title', 'Parents Management - School Management System')
@section('page-title', 'Parents Management')

@section('content')
@include('sms.partials.design-system')
<style>
    .page-header {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        line-height: 1.2;
    }

    .page-subtitle {
        font-size: 0.9375rem;
        color: var(--sms-gray-500);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 0.875rem 1rem;
        border: 1px solid var(--sms-gray-200);
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.06);
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .stat-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--sms-gray-500);
        font-weight: 600;
    }

    .stat-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--sms-gray-900);
    }

    .sms-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.07);
        border: 1px solid rgba(148, 163, 184, 0.25);
        overflow: hidden;
        margin-bottom: 1.75rem;
    }

    .sms-card-header {
        padding: 1rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.9);
        background: radial-gradient(circle at top left, rgba(129, 140, 248, 0.12), transparent 55%), #f9fafb;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .sms-card-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .sms-card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sms-card-title-icon {
        width: 32px;
        height: 32px;
        border-radius: 9999px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(37, 99, 235, 0.18));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--sms-primary);
    }

    .filter-row {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .filter-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .filter-input {
        position: relative;
        flex: 1 1 180px;
        min-width: 0;
    }

    .filter-input input {
        width: 100%;
        border-radius: 9999px;
        border: 1px solid var(--sms-gray-300);
        padding: 0.5rem 0.875rem 0.5rem 2.25rem;
        font-size: 0.875rem;
        outline: none;
        background: white;
        transition: all 0.15s ease;
    }

    .filter-input input:focus {
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 1px rgba(79, 70, 229, 0.2);
    }

    .filter-input-icon {
        position: absolute;
        inset-y: 0;
        left: 0.75rem;
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        color: var(--sms-gray-400);
    }

    .sms-card-body {
        padding: 1rem;
    }

    .sms-table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .sms-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 720px;
    }

    .sms-table thead {
        background: #f9fafb;
    }

    .sms-table th {
        padding: 0.75rem 0.75rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--sms-gray-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid var(--sms-gray-200);
        white-space: nowrap;
    }

    .sms-table td {
        padding: 0.75rem 0.75rem;
        border-bottom: 1px solid var(--sms-gray-200);
        color: var(--sms-gray-800);
        font-size: 0.875rem;
        vertical-align: middle;
    }

    .sms-table tbody tr:hover {
        background: var(--sms-gray-50);
    }

    .parent-name {
        font-weight: 600;
        color: var(--sms-gray-900);
    }

    .parent-meta {
        font-size: 0.75rem;
        color: var(--sms-gray-500);
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
        color: #b91c1c;
    }

    .sms-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 9999px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .sms-btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.35);
    }

    .sms-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.45);
    }

    .sms-btn-ghost {
        background: transparent;
        color: var(--sms-gray-700);
        border: 1px solid var(--sms-gray-300);
    }

    .sms-btn-ghost:hover {
        background: var(--sms-gray-50);
    }

    .sms-btn-danger {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .sms-btn-danger:hover {
        background: #fecaca;
        transform: translateY(-1px);
    }

    .actions-cell {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .parent-list-mobile {
        display: none;
    }

    @media (min-width: 640px) {
        .page-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.75rem;
        }

        .sms-card-header {
            padding: 1.25rem 1.5rem;
        }

        .sms-card-body {
            padding: 1.25rem 1.5rem 1.5rem;
        }
    }

    @media (min-width: 768px) {
        .page-title {
            font-size: 1.875rem;
        }

        .stats-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .sms-table-wrapper {
            overflow: visible;
        }

        .sms-table {
            display: none;
        }

        .parent-list-mobile {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .parent-card-mobile {
            padding: 0.9rem 1rem;
            border-radius: 12px;
            border: 1px solid rgba(226, 232, 240, 0.9);
            background: white;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .parent-card-header {
            display: flex;
            justify-content: space-between;
            gap: 0.5rem;
            align-items: center;
        }

        .parent-card-meta {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.25rem 0.75rem;
            font-size: 0.75rem;
            color: var(--sms-gray-600);
        }

        .parent-card-actions {
            margin-top: 0.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Parents Management</h1>
        <p class="page-subtitle">
            Manage all registered parents – view details, edit information, and manage student links.
        </p>
    </div>
    <a href="{{ route('school.parents.register') }}" class="sms-btn sms-btn-primary">
        <i class="fas fa-user-plus"></i>
        <span>Register New Parent</span>
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Parents</div>
        <div class="stat-value">{{ $totalParents ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Active</div>
        <div class="stat-value">{{ $activeParents ?? 0 }}</div>
    </div>
</div>

<div class="sms-card">
    <div class="sms-card-header">
        <div class="sms-card-title-row">
            <div class="sms-card-title">
                <span class="sms-card-title-icon">
                    <i class="fas fa-users"></i>
                </span>
                <span>All Parents</span>
            </div>
        </div>
        <form method="GET" action="{{ route('school.parents.index') }}" class="filter-row">
            <div class="filter-group">
                <div class="filter-input">
                    <span class="filter-input-icon">
                        <i class="fas fa-search"></i>
                    </span>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by name, email, or phone..."
                    >
                </div>
                <button type="submit" class="sms-btn sms-btn-primary">
                    <i class="fas fa-filter"></i>
                    <span>Search</span>
                </button>
            </div>
        </form>
    </div>
    <div class="sms-card-body">
        @if($parents->count() > 0)
        <div class="sms-table-wrapper">
            <table class="sms-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Children</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parents as $parent)
                        <tr>
                            <td>
                                <div class="parent-name">{{ $parent->user->name ?? 'N/A' }}</div>
                                <div class="parent-meta">
                                    {{ $parent->occupation ?? 'No occupation' }}
                                </div>
                            </td>
                            <td>
                                <div>{{ $parent->user->email ?? 'N/A' }}</div>
                                @if($parent->phone || $parent->user->phone)
                                    <div class="parent-meta">{{ $parent->phone ?? $parent->user->phone }}</div>
                                @endif
                            </td>
                            <td>
                                @php
                                    $childrenOld = $parent->students()->count();
                                    $childrenLinked = $parent->linkedStudents()->count();
                                    $totalChildren = $childrenOld + $childrenLinked;
                                @endphp
                                <span class="sms-badge sms-badge-success">{{ $totalChildren }} child(ren)</span>
                            </td>
                            <td>
                                @if($parent->user && $parent->user->is_active)
                                    <span class="sms-badge sms-badge-success">Active</span>
                                @else
                                    <span class="sms-badge sms-badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <a
                                        href="{{ route('school.parents.show', $parent->id) }}"
                                        class="sms-btn sms-btn-ghost"
                                        title="View"
                                    >
                                        <i class="fas fa-eye"></i>
                                        <span>View</span>
                                    </a>
                                    <a
                                        href="{{ route('school.parents.edit', $parent->id) }}"
                                        class="sms-btn sms-btn-primary"
                                        title="Edit"
                                    >
                                        <i class="fas fa-edit"></i>
                                        <span>Edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('school.parents.destroy', $parent->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this parent? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="sms-btn sms-btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile list view --}}
        <div class="parent-list-mobile">
            @foreach($parents as $parent)
                <div class="parent-card-mobile">
                    <div class="parent-card-header">
                        <div>
                            <div class="parent-name">{{ $parent->user->name ?? 'N/A' }}</div>
                            <div class="parent-meta">
                                {{ $parent->user->email ?? 'N/A' }}
                            </div>
                        </div>
                        @if($parent->user && $parent->user->is_active)
                            <span class="sms-badge sms-badge-success">Active</span>
                        @else
                            <span class="sms-badge sms-badge-danger">Inactive</span>
                        @endif
                    </div>
                    <div class="parent-card-meta">
                        <span><strong>Phone:</strong> {{ $parent->phone ?? $parent->user->phone ?? 'N/A' }}</span>
                        <span><strong>Occupation:</strong> {{ $parent->occupation ?? 'N/A' }}</span>
                        @php
                            $childrenOld = $parent->students()->count();
                            $childrenLinked = $parent->linkedStudents()->count();
                            $totalChildren = $childrenOld + $childrenLinked;
                        @endphp
                        <span><strong>Children:</strong> {{ $totalChildren }}</span>
                    </div>
                    <div class="parent-card-actions">
                        <a href="{{ route('school.parents.show', $parent->id) }}" class="sms-btn sms-btn-ghost">
                            <i class="fas fa-eye"></i>
                            <span>View</span>
                        </a>
                        <a href="{{ route('school.parents.edit', $parent->id) }}" class="sms-btn sms-btn-primary">
                            <i class="fas fa-edit"></i>
                            <span>Edit</span>
                        </a>
                        <form method="POST" action="{{ route('school.parents.destroy', $parent->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this parent? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="sms-btn sms-btn-danger">
                                <i class="fas fa-trash"></i>
                                <span>Delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 1.5rem;">
            {{ $parents->links() }}
        </div>
        @else
        <div style="text-align: center; padding: 3rem;">
            <div style="font-size: 3rem; color: var(--sms-gray-300); margin-bottom: 1rem;">
                <i class="fas fa-users"></i>
            </div>
            <div style="font-size: 1.125rem; font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.5rem;">
                No Parents Registered Yet
            </div>
            <div style="color: var(--sms-gray-500); margin-bottom: 1.5rem;">
                Start by registering your first parent
            </div>
            <a href="{{ route('school.parents.register') }}" class="sms-btn sms-btn-primary">
                <i class="fas fa-user-plus"></i> Register Parent
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
