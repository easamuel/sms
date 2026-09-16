@extends('layouts.app')

@section('title', 'Parent Dashboard - School Management System')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-dashboard {
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
    .sms-stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    .sms-stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
    }
    .sms-stat-value {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        line-height: 1.2;
        margin-bottom: 0.5rem;
        word-break: break-word;
        overflow-wrap: break-word;
        min-width: 0; /* Allow flex shrinking */
        flex: 1; /* Take available space */
    }
    /* Fix for large monetary values */
    .sms-stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }
    .sms-stat-header > div:first-child {
        flex: 1;
        min-width: 0; /* Allow shrinking */
    }
    .sms-stat-icon {
        flex-shrink: 0; /* Never shrink icon */
        width: 56px;
        height: 56px;
    }
    .sms-stat-label {
        font-size: 0.875rem;
        color: var(--sms-gray-600);
        font-weight: 500;
    }
    .sms-content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
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
    .sms-notice-card {
        padding: 1.25rem;
        background: var(--sms-gray-50);
        border-radius: 12px;
        border-left: 4px solid var(--sms-primary);
        margin-bottom: 1rem;
        transition: all 0.2s;
    }
    .sms-notice-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
    }
    .sms-notice-content {
        font-size: 0.875rem;
        color: var(--sms-gray-600);
        margin-bottom: 0.75rem;
        line-height: 1.6;
    }
    .sms-notice-date {
        font-size: 0.75rem;
        color: var(--sms-gray-500);
    }
    @media (max-width: 1024px) {
        .sms-content-grid {
            grid-template-columns: 1fr;
        }
    }
    .sms-card-header {
        flex-wrap: wrap;
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
        transition: all 0.2s;
        white-space: nowrap;
    }
    .sms-btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent));
        color: white;
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.35);
    }
    .sms-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.45);
    }
    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .children-mobile {
        display: none;
    }
    .children-card-mobile {
        background: var(--sms-gray-50);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid var(--sms-gray-200);
    }
    .children-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
        gap: 0.5rem;
    }
    .children-card-name {
        font-weight: 700;
        font-size: 1rem;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
    }
    .children-card-meta {
        font-size: 0.8125rem;
        color: var(--sms-gray-600);
        margin-bottom: 0.5rem;
    }
    .children-card-actions {
        margin-top: 0.75rem;
    }
    .fee-status-banner {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border-left: 4px solid #dc2626;
        padding: 1rem 1.25rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .fee-status-banner.cleared {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border-left-color: #059669;
    }
    .fee-status-content {
        flex: 1;
        min-width: 0;
    }
    .fee-status-title {
        font-weight: 700;
        font-size: 1rem;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
    }
    .fee-status-amount {
        font-size: 1.25rem;
        font-weight: 800;
        color: #dc2626;
    }
    .fee-status-amount.cleared {
        color: #059669;
    }
    .fee-status-action {
        flex-shrink: 0;
    }
    @media (max-width: 768px) {
        .sms-dashboard {
            padding: 0;
        }
        .sms-page-header {
            padding: 1rem 1rem 1.25rem;
            margin-bottom: 1rem;
        }
        .sms-page-title {
            font-size: 1.25rem;
            line-height: 1.3;
        }
        .sms-page-subtitle {
            font-size: 0.875rem;
            line-height: 1.5;
            word-wrap: break-word;
        }
        div[style*="max-width: 1400px"] {
            padding: 0 1rem 1.5rem !important;
        }
        .sms-stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .sms-stat-card {
            padding: 1.25rem;
        }
        .sms-stat-value {
            font-size: clamp(1.5rem, 5vw, 2rem);
        }
        .sms-stat-header {
            flex-wrap: wrap;
        }
        .sms-stat-icon {
            width: 44px;
            height: 44px;
            font-size: 1.125rem;
        }
        .sms-card {
            margin-bottom: 1rem;
        }
        .sms-card-header {
            padding: 1rem;
            flex-direction: column;
            align-items: flex-start;
        }
        .sms-card-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        .sms-card-body {
            padding: 1rem;
        }
        .sms-table {
            display: none;
        }
        .children-mobile {
            display: block;
        }
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .fee-status-banner {
            flex-direction: column;
            align-items: flex-start;
            padding: 1rem;
        }
        .fee-status-action {
            width: 100%;
        }
        .fee-status-action .sms-btn {
            width: 100%;
            justify-content: center;
        }
        .sms-content-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }
    @media (max-width: 480px) {
        .sms-page-header {
            padding: 0.875rem;
        }
        .sms-page-title {
            font-size: 1.125rem;
        }
        .sms-page-subtitle {
            font-size: 0.8125rem;
        }
        div[style*="max-width: 1400px"] {
            padding: 0 0.75rem 1rem !important;
        }
        .sms-stat-card {
            padding: 1rem;
        }
        .sms-card-header,
        .sms-card-body {
            padding: 0.875rem;
        }
    }
</style>

<div class="sms-dashboard">
    <div class="sms-page-header">
        <h1 class="sms-page-title">Parent Dashboard</h1>
        <p class="sms-page-subtitle">Welcome, <strong>{{ $parent->user->name ?? 'Parent' }}</strong> | Monitor your children's academic progress and school activities</p>
    </div>

    <div style="max-width: 1400px; margin: 0 auto; padding: 0 2rem 2rem;" class="dashboard-container">
        <!-- Stats Grid -->
        <div class="sms-stats-grid">
            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">{{ $stats['children_count'] }}</div>
                        <div class="sms-stat-label">Children</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">{{ $stats['attendance_rate'] }}%</div>
                        <div class="sms-stat-label">Attendance Rate</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                </div>
            </div>

            <div class="sms-stat-card">
                <div class="sms-stat-header">
                    <div>
                        <div class="sms-stat-value">₦{{ number_format($stats['pending_fees'], 2) }}</div>
                        <div class="sms-stat-label">Pending Fees</div>
                    </div>
                    <div class="sms-stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- My Children -->
        <div class="sms-card" style="margin-bottom: 1.5rem;">
            <div class="sms-card-header">
                <h2 class="sms-card-title">My Children</h2>
            </div>
            <div class="sms-card-body">
                @if($children->count() > 0)
                    <!-- Desktop Table View -->
                    <div class="table-wrapper">
                        <table class="sms-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Student ID</th>
                                    <th>Class</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($children as $child)
                                <tr>
                                    <td style="font-weight: 600;">{{ $child->user->name ?? 'N/A' }}</td>
                                    <td><span class="sms-badge sms-badge-success">{{ $child->student_id_number }}</span></td>
                                    <td>
                                        {{ $child->class->name ?? 'N/A' }}{{ $child->class->section ? ' - ' . $child->class->section : '' }}
                                        @if($child->class && $child->class->classTeacher)
                                            <div style="font-size: 0.75rem; color: var(--sms-gray-500); margin-top: 0.25rem;">
                                                <i class="fas fa-chalkboard-teacher"></i> 
                                                Class Teacher: {{ $child->class->classTeacher->user->name ?? 'N/A' }}
                                                @if($child->class->classTeacher->user->email)
                                                    <br><span style="font-size: 0.7rem;">{{ $child->class->classTeacher->user->email }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="sms-badge {{ $child->status === 'active' ? 'sms-badge-success' : 'sms-badge-warning' }}">
                                            {{ ucfirst($child->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('sms.parent.view-child', $child->id) }}" class="sms-btn sms-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                                            <i class="fas fa-eye"></i>
                                            View Dashboard
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="children-mobile">
                        @foreach($children as $child)
                        <div class="children-card-mobile">
                            <div class="children-card-header">
                                <div style="flex: 1;">
                                    <div class="children-card-name">{{ $child->user->name ?? 'N/A' }}</div>
                                    <div class="children-card-meta">
                                        <span class="sms-badge sms-badge-success">{{ $child->student_id_number }}</span>
                                    </div>
                                </div>
                                <span class="sms-badge {{ $child->status === 'active' ? 'sms-badge-success' : 'sms-badge-warning' }}">
                                    {{ ucfirst($child->status) }}
                                </span>
                            </div>
                            <div class="children-card-meta">
                                <div style="margin-bottom: 0.25rem;">
                                    <strong>Class:</strong> {{ $child->class->name ?? 'N/A' }}{{ $child->class->section ? ' - ' . $child->class->section : '' }}
                                </div>
                                @if($child->class && $child->class->classTeacher)
                                    <div style="font-size: 0.75rem; color: var(--sms-gray-500);">
                                        <i class="fas fa-chalkboard-teacher"></i> 
                                        {{ $child->class->classTeacher->user->name ?? 'N/A' }}
                                    </div>
                                @endif
                            </div>
                            <div class="children-card-actions">
                                <a href="{{ route('sms.parent.view-child', $child->id) }}" class="sms-btn sms-btn-primary" style="width: 100%; justify-content: center; text-decoration: none;">
                                    <i class="fas fa-eye"></i>
                                    <span>View Dashboard</span>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="sms-empty-state">
                        <div class="sms-empty-state-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="sms-empty-state-title">No Children Linked</div>
                        <div class="sms-empty-state-text">No children linked to your account yet. Contact your school administrator to link your children's accounts.</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Fee Payment Section - Always Show -->
        @if(isset($feeSummary))
        <div class="fee-status-banner {{ $feeSummary['balance'] <= 0 ? 'cleared' : '' }}" style="margin-bottom: 1.5rem;">
            <div class="fee-status-content">
                <div class="fee-status-title">
                    @if($feeSummary['balance'] > 0)
                        <i class="fas fa-exclamation-triangle"></i> Outstanding Fees
                    @else
                        <i class="fas fa-check-circle"></i> Fees Status
                    @endif
                </div>
                <div class="fee-status-amount {{ $feeSummary['balance'] <= 0 ? 'cleared' : '' }}">
                    @if($feeSummary['balance'] > 0)
                        ₦{{ number_format($feeSummary['balance'], 2) }} Outstanding
                    @else
                        All Fees Paid
                    @endif
                </div>
                <div style="font-size: 0.8125rem; color: var(--sms-gray-600); margin-top: 0.5rem;">
                    Total: ₦{{ number_format($feeSummary['total'], 2) }} | Paid: ₦{{ number_format($feeSummary['paid'], 2) }}
                </div>
            </div>
            <div class="fee-status-action">
                <a href="{{ route('sms.parent.fees') }}" class="sms-btn sms-btn-primary" style="text-decoration: none;">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>View Fees</span>
                </a>
            </div>
        </div>
        @endif

        <!-- Content Grid -->
        <div class="sms-content-grid">

            <!-- Recent Exam Results -->
            @if($recentResults->count() > 0)
            <div class="sms-card">
                <div class="sms-card-header">
                    <h2 class="sms-card-title">Recent Exam Results</h2>
                </div>
                <div class="sms-card-body">
                    <div class="table-wrapper">
                        <table class="sms-table">
                            <thead>
                                <tr>
                                    <th>Child</th>
                                    <th>Exam</th>
                                    <th>Subject</th>
                                    <th>Marks</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentResults as $result)
                                <tr>
                                    <td style="font-weight: 600;">{{ $result->student->user->name ?? 'N/A' }}</td>
                                    <td>{{ $result->exam->name ?? 'N/A' }}</td>
                                    <td>{{ $result->exam->subject->name ?? 'N/A' }}</td>
                                    <td>{{ $result->marks_obtained }}/{{ $result->exam->total_marks ?? 'N/A' }}</td>
                                    <td><span class="sms-badge sms-badge-success">{{ $result->grade ?? 'N/A' }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Latest Notices -->
        @if($notices->count() > 0)
        <div class="sms-card">
            <div class="sms-card-header">
                <h2 class="sms-card-title">Latest Notices</h2>
                <a href="{{ route('sms.parent.notices') }}" style="font-size: 0.875rem; color: var(--sms-primary); text-decoration: none; font-weight: 600;">View All</a>
            </div>
            <div class="sms-card-body">
                <div>
                    @foreach($notices as $notice)
                    <div class="sms-notice-card">
                        <h3 class="sms-notice-title">{{ $notice->title }}</h3>
                        <p class="sms-notice-content">{{ Str::limit($notice->content, 150) }}</p>
                        <p class="sms-notice-date">
                            @php
                                $publishedAt = is_string($notice->published_at) ? \Carbon\Carbon::parse($notice->published_at) : ($notice->published_at ?? null);
                            @endphp
                            {{ $publishedAt ? $publishedAt->format('M d, Y') : 'Not published' }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Quick Message to Admin -->
        <div class="sms-card">
            <div class="sms-card-header">
                <h2 class="sms-card-title">Quick Message to School Admin</h2>
            </div>
            <div class="sms-card-body">
                <form method="POST" action="{{ route('sms.parent.messages.send') }}" id="quickMessageForm">
                    @csrf
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <textarea name="message" class="form-control" rows="3" placeholder="Type your message to the school admin here..." required style="width: 100%; padding: 0.75rem; border: 1px solid var(--sms-gray-300); border-radius: 6px; font-size: 0.875rem; resize: vertical;"></textarea>
                    </div>
                    <button type="submit" class="btn-primary" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white; padding: 0.875rem 1.75rem; border-radius: 8px; border: none; font-weight: 600; font-size: 0.9375rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                    <style>
                        .btn-primary:hover {
                            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%) !important;
                            transform: translateY(-2px);
                            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3) !important;
                        }
                    </style>
                </form>
                <div style="margin-top: 1rem;">
                    <a href="{{ route('sms.parent.messages') }}" style="color: var(--sms-blue-600); text-decoration: none; font-size: 0.875rem;">
                        <i class="fas fa-comments"></i> View All Messages
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
