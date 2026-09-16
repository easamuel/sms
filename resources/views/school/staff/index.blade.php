@extends('layouts.admin')

@section('title', 'Staff Management - School Management System')
@section('page-title', 'Staff Management')

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

    .stat-meta {
        font-size: 0.75rem;
        color: var(--sms-gray-500);
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.125rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.6875rem;
        font-weight: 600;
        background: rgba(34, 197, 94, 0.1);
        color: #15803d;
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

    .sms-card-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: flex-start;
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

    .filter-select {
        min-width: 140px;
        border-radius: 9999px;
        border: 1px solid var(--sms-gray-300);
        padding: 0.5rem 0.875rem;
        font-size: 0.8125rem;
        background: white;
        color: var(--sms-gray-700);
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

    .teacher-name {
        font-weight: 600;
        color: var(--sms-gray-900);
    }

    .teacher-meta {
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

    .sms-badge-warning {
        background: #fef3c7;
        color: #92400e;
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

    .sms-btn-icon-only {
        padding-inline: 0.6rem;
    }

    .actions-cell {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
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

    /* Mobile friendly list view for teachers */
    @media (max-width: 768px) {
        .sms-table-wrapper {
            overflow: visible;
        }

        .sms-table {
            display: none;
        }

        .teacher-list-mobile {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .teacher-card-mobile {
            padding: 0.9rem 1rem;
            border-radius: 12px;
            border: 1px solid rgba(226, 232, 240, 0.9);
            background: white;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .teacher-card-header {
            display: flex;
            justify-content: space-between;
            gap: 0.5rem;
            align-items: center;
        }

        .teacher-card-meta {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.25rem 0.75rem;
            font-size: 0.75rem;
            color: var(--sms-gray-600);
        }

        .teacher-card-actions {
            margin-top: 0.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Staff Management</h1>
        <p class="page-subtitle">
            Manage all your teachers in one place – add new staff, review details, and keep statuses up to date.
        </p>
    </div>
    <a href="{{ route('school.staff.create') }}" class="sms-btn sms-btn-primary">
        <i class="fas fa-user-plus"></i>
        <span>Add New Teacher</span>
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Staff</div>
        <div class="stat-value">{{ $totalStaff ?? 0 }}</div>
        <div class="stat-meta">
            <span class="stat-pill">
                <i class="fas fa-chalkboard-teacher"></i>
                All teachers
            </span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Active</div>
        <div class="stat-value">{{ $activeStaff ?? 0 }}</div>
        <div class="stat-meta">
            <i class="fas fa-circle" style="font-size: 0.5rem; color: #16a34a;"></i>
            Currently teaching
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Inactive</div>
        <div class="stat-value">{{ $inactiveStaff ?? 0 }}</div>
        <div class="stat-meta">
            <i class="fas fa-circle" style="font-size: 0.5rem; color: #f97316;"></i>
            Not in use
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Suspended</div>
        <div class="stat-value">{{ $suspendedStaff ?? 0 }}</div>
        <div class="stat-meta">
            <i class="fas fa-circle" style="font-size: 0.5rem; color: #dc2626;"></i>
            Review required
        </div>
    </div>
</div>

<div class="sms-card">
    <div class="sms-card-header">
        <div class="sms-card-title-row">
            <div class="sms-card-title">
                <span class="sms-card-title-icon">
                    <i class="fas fa-users"></i>
                </span>
                <span>All Teachers</span>
            </div>
            <div class="sms-card-actions">
                <a href="{{ route('school.staff.index') }}" class="sms-btn sms-btn-ghost sms-btn-icon-only" title="Reset Filters">
                    <i class="fas fa-rotate"></i>
                </a>
            </div>
        </div>
        <form method="GET" action="{{ route('school.staff.index') }}" class="filter-row">
            <div class="filter-group">
                <div class="filter-input">
                    <span class="filter-input-icon">
                        <i class="fas fa-search"></i>
                    </span>
                    <input
                        type="text"
                        name="q"
                        value="{{ $search ?? request('q') }}"
                        placeholder="Search by name, email, phone or employee ID..."
                    >
                </div>
            </div>
            <div class="filter-group">
                <select name="status" class="filter-select">
                    <option value="">Status (All)</option>
                    <option value="active" {{ (($status ?? request('status')) === 'active') ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ (($status ?? request('status')) === 'inactive') ? 'selected' : '' }}>Inactive</option>
                    <option value="suspended" {{ (($status ?? request('status')) === 'suspended') ? 'selected' : '' }}>Suspended</option>
                </select>
                <select name="teacher_type" class="filter-select">
                    <option value="">Teacher Type (All)</option>
                    <option value="primary" {{ (($teacherType ?? request('teacher_type')) === 'primary') ? 'selected' : '' }}>Primary</option>
                    <option value="secondary" {{ (($teacherType ?? request('teacher_type')) === 'secondary') ? 'selected' : '' }}>Secondary</option>
                </select>
                <button type="submit" class="sms-btn sms-btn-primary">
                    <i class="fas fa-filter"></i>
                    <span>Apply Filters</span>
                </button>
            </div>
        </form>
    </div>
    <div class="sms-card-body">
        @if($teachers->count() > 0)
        <div class="sms-table-wrapper">
            <table class="sms-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Employee ID</th>
                        <th>Qualification</th>
                        <th>Specialization</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $teacher)
                        <tr>
                            <td>
                                <div class="teacher-name">{{ $teacher->user->name ?? 'N/A' }}</div>
                                <div class="teacher-meta">
                                    {{ ucfirst($teacher->teacher_type ?? 'secondary') }} teacher
                                </div>
                            </td>
                            <td>
                                <div>{{ $teacher->user->email ?? 'N/A' }}</div>
                                @if(!empty($teacher->user->phone))
                                    <div class="teacher-meta">{{ $teacher->user->phone }}</div>
                                @endif
                            </td>
                            <td>{{ $teacher->employee_id ?? 'N/A' }}</td>
                            <td>{{ $teacher->qualification ?? '—' }}</td>
                            <td>{{ $teacher->specialization ?? '—' }}</td>
                            <td>
                                @php
                                    $statusClass = 'sms-badge-success';
                                    if (($teacher->status ?? '') === 'inactive') {
                                        $statusClass = 'sms-badge-warning';
                                    } elseif (($teacher->status ?? '') === 'suspended') {
                                        $statusClass = 'sms-badge-danger';
                                    }
                                @endphp
                                <span class="sms-badge {{ $statusClass }}">
                                    {{ ucfirst($teacher->status ?? 'active') }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <a
                                        href="{{ route('school.staff.show', $teacher->id) }}"
                                        class="sms-btn sms-btn-ghost"
                                    >
                                        <i class="fas fa-eye"></i>
                                        <span>View</span>
                                    </a>
                                    <a
                                        href="{{ route('school.staff.edit', $teacher->id) }}"
                                        class="sms-btn sms-btn-primary"
                                    >
                                        <i class="fas fa-edit"></i>
                                        <span>Edit</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile list view --}}
        <div class="teacher-list-mobile">
            @foreach($teachers as $teacher)
                <div class="teacher-card-mobile">
                    <div class="teacher-card-header">
                        <div>
                            <div class="teacher-name">{{ $teacher->user->name ?? 'N/A' }}</div>
                            <div class="teacher-meta">
                                {{ $teacher->employee_id ?? 'N/A' }} • {{ ucfirst($teacher->teacher_type ?? 'secondary') }}
                            </div>
                        </div>
                        @php
                            $statusClass = 'sms-badge-success';
                            if (($teacher->status ?? '') === 'inactive') {
                                $statusClass = 'sms-badge-warning';
                            } elseif (($teacher->status ?? '') === 'suspended') {
                                $statusClass = 'sms-badge-danger';
                            }
                        @endphp
                        <span class="sms-badge {{ $statusClass }}">
                            {{ ucfirst($teacher->status ?? 'active') }}
                        </span>
                    </div>
                    <div class="teacher-card-meta">
                        <span><strong>Email:</strong> {{ $teacher->user->email ?? 'N/A' }}</span>
                        <span><strong>Phone:</strong> {{ $teacher->user->phone ?? 'N/A' }}</span>
                        <span><strong>Qualification:</strong> {{ $teacher->qualification ?? '—' }}</span>
                        <span><strong>Specialization:</strong> {{ $teacher->specialization ?? '—' }}</span>
                    </div>
                    <div class="teacher-card-actions">
                        <a href="{{ route('school.staff.show', $teacher->id) }}" class="sms-btn sms-btn-ghost">
                            <i class="fas fa-eye"></i>
                            <span>View</span>
                        </a>
                        <a href="{{ route('school.staff.edit', $teacher->id) }}" class="sms-btn sms-btn-primary">
                            <i class="fas fa-edit"></i>
                            <span>Edit</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 1.5rem;">
            {{ $teachers->links() }}
        </div>
        @else
        <div style="text-align: center; padding: 3rem;">
            <div style="font-size: 3rem; color: var(--sms-gray-300); margin-bottom: 1rem;">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div style="font-size: 1.125rem; font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.5rem;">
                No Teachers Yet
            </div>
            <div style="color: var(--sms-gray-500); margin-bottom: 1.5rem;">
                Start by adding your first teacher
            </div>
            <a href="{{ route('school.staff.create') }}" class="sms-btn sms-btn-primary">
                <i class="fas fa-user-plus"></i> Add Teacher
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
