@extends('layouts.app')

@section('title', 'Super Admin Dashboard - School Management System')

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
    .sms-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .sms-stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.75rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .sms-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--sms-primary), var(--sms-accent));
    }
    .sms-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.15);
    }
    .sms-stat-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--sms-gray-600);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .sms-stat-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        line-height: 1;
    }
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
    @media (max-width: 768px) {
        .sms-page-header {
            padding: 1.5rem;
        }
        .sms-page-title {
            font-size: 1.5rem;
        }
        .sms-stats-grid {
            grid-template-columns: 1fr;
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
        <h1 class="sms-page-title">Super Admin Dashboard</h1>
        <p class="sms-page-subtitle">Complete system overview and management</p>
    </div>

    <div style="max-width: 1400px; margin: 0 auto; padding: 0 2rem 2rem;">
        <div class="sms-stats-grid">
            <div class="sms-stat-card">
                <div class="sms-stat-label">Total Schools</div>
                <div class="sms-stat-value">{{ $stats['total_schools'] }}</div>
            </div>
            <div class="sms-stat-card">
                <div class="sms-stat-label">Total Students</div>
                <div class="sms-stat-value">{{ $stats['total_students'] }}</div>
            </div>
            <div class="sms-stat-card">
                <div class="sms-stat-label">Total Teachers</div>
                <div class="sms-stat-value">{{ $stats['total_teachers'] }}</div>
            </div>
            <div class="sms-stat-card">
                <div class="sms-stat-label">Total Exams</div>
                <div class="sms-stat-value">{{ $stats['total_exams'] }}</div>
            </div>
            <div class="sms-stat-card">
                <div class="sms-stat-label">Pending Approvals</div>
                <div class="sms-stat-value" style="color: #f59e0b;">{{ $stats['pending_approvals'] }}</div>
            </div>
        </div>

        <div class="sms-card">
            <div class="sms-card-header">
                <h2 class="sms-card-title">Recent Schools</h2>
                <a href="{{ route('school.dashboard') }}" class="sms-btn sms-btn-primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.25rem; font-size: 0.9375rem; font-weight: 600; border-radius: 8px; background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark)); color: white;">
                    <i class="fas fa-eye"></i> View All Schools
                </a>
            </div>
            <div class="sms-card-body">
                @if($recentSchools->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="sms-table">
                            <thead>
                                <tr>
                                    <th>School Name</th>
                                    <th>Registration Number</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentSchools as $school)
                                <tr>
                                    <td style="font-weight: 600;">{{ $school->school_name }}</td>
                                    <td style="color: var(--sms-gray-600);">{{ $school->registration_number ?? 'N/A' }}</td>
                                    <td style="color: var(--sms-gray-600);">{{ $school->school_type ?? 'N/A' }}</td>
                                    <td>
                                        <span class="sms-badge {{ $school->is_active ? 'sms-badge-success' : 'sms-badge-warning' }}">
                                            {{ $school->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td style="color: var(--sms-gray-600);">{{ $school->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="text-align: center; padding: 3rem 2rem; color: var(--sms-gray-500);">
                        <div style="font-size: 3rem; color: var(--sms-gray-300); margin-bottom: 1rem;">
                            <i class="fas fa-school"></i>
                        </div>
                        <div style="font-size: 1.125rem; font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.5rem;">No Schools Registered</div>
                        <div style="font-size: 0.9375rem; color: var(--sms-gray-500);">No schools have been registered in the system yet.</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
