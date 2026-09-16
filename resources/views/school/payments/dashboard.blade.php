@extends('layouts.admin')

@section('title', 'Payment Dashboard - School Management System')
@section('page-title', 'Payment Dashboard')

@push('styles')
<!-- Font Awesome Icons - Multiple CDN sources for reliability -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
        padding: 2rem 0;
    }
    .sms-card {
        background: white;
        border-radius: var(--sms-radius-lg);
        box-shadow: var(--sms-shadow);
        border: 1px solid var(--sms-gray-200);
        padding: 2rem;
        margin-bottom: 2rem;
        transition: all 0.2s;
    }
    .sms-card:hover {
        box-shadow: var(--sms-shadow-md);
    }
    .sms-card-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--sms-gray-100);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .sms-card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        letter-spacing: -0.02em;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: linear-gradient(135deg, white 0%, var(--sms-gray-50) 100%);
        border-radius: var(--sms-radius-lg);
        padding: 1.75rem;
        box-shadow: var(--sms-shadow);
        border: 1px solid var(--sms-gray-200);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--sms-primary), var(--sms-accent));
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--sms-shadow-lg);
    }
    .stat-icon {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        width: 56px;
        height: 56px;
        border-radius: var(--sms-radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        z-index: 1;
    }
    .stat-card.success .stat-icon {
        background: rgba(5, 150, 105, 0.1);
        color: #059669;
    }
    .stat-card.danger .stat-icon {
        background: rgba(220, 38, 38, 0.1);
        color: #dc2626;
    }
    .stat-card.info .stat-icon {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }
    .stat-icon i {
        display: block;
    }
    .stat-card.success::before {
        background: linear-gradient(90deg, #059669, #10b981);
    }
    .stat-card.danger::before {
        background: linear-gradient(90deg, #dc2626, #ef4444);
    }
    .stat-card.info::before {
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
    }
    .stat-label {
        font-size: 0.875rem;
        color: var(--sms-gray-600);
        margin-bottom: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        line-height: 1.2;
        margin-bottom: 0.5rem;
    }
    .stat-value.success {
        color: #059669;
    }
    .stat-value.danger {
        color: #dc2626;
    }
    .stat-value.info {
        color: #2563eb;
    }
    .sms-table-wrapper {
        overflow-x: auto;
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
        padding: 0.75rem 1rem;
        text-align: left;
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--sms-gray-700);
        border-bottom: 2px solid var(--sms-gray-200);
    }
    .sms-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        font-size: 0.875rem;
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
    .sms-badge-info {
        background: #dbeafe;
        color: #1e40af;
    }
    .filters {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1.25rem;
        margin-bottom: 0;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .filter-label {
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--sms-gray-700);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .filter-select {
        padding: 0.75rem;
        border: 2px solid var(--sms-gray-200);
        border-radius: var(--sms-radius);
        font-size: 0.875rem;
        background: white;
        transition: all 0.2s;
        font-family: inherit;
    }
    .filter-select:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
    }
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: var(--sms-radius);
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }
    .btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        box-shadow: var(--sms-shadow-sm);
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--sms-shadow-md);
    }
    .btn-outline {
        background: white;
        color: var(--sms-primary);
        border: 2px solid var(--sms-primary);
    }
    .btn-outline:hover {
        background: var(--sms-primary);
        color: white;
    }
    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.8125rem;
    }
    .alert {
        padding: 1rem 1.25rem;
        border-radius: var(--sms-radius);
        margin-bottom: 1.5rem;
        border-left: 4px solid;
    }
    .alert-info {
        background: #dbeafe;
        color: #1e40af;
        border-color: #3b82f6;
    }
    .page-header {
        margin-bottom: 2rem;
    }
    .page-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }
    .page-subtitle {
        color: var(--sms-gray-600);
        font-size: 0.9375rem;
    }
</style>

<div class="sms-page">
    <div class="container-fluid py-4">
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-label">Total Paid</div>
                <div class="stat-value success">₦{{ number_format($totalPaid, 2) }}</div>
                <div style="font-size: 0.75rem; color: var(--sms-gray-500); margin-top: 0.25rem;">All completed payments</div>
            </div>
            <div class="stat-card danger">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="stat-label">Outstanding</div>
                <div class="stat-value danger">₦{{ number_format($totalOutstanding, 2) }}</div>
                <div style="font-size: 0.75rem; color: var(--sms-gray-500); margin-top: 0.25rem;">Unpaid balances</div>
            </div>
            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="stat-label">Online Payments</div>
                <div class="stat-value success">₦{{ number_format($onlinePayments, 2) }}</div>
                <div style="font-size: 0.75rem; color: var(--sms-gray-500); margin-top: 0.25rem;">Paystack, Flutterwave, etc.</div>
            </div>
            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-university"></i>
                </div>
                <div class="stat-label">Manual Transfers</div>
                <div class="stat-value success">₦{{ number_format($manualPayments, 2) }}</div>
                <div style="font-size: 0.75rem; color: var(--sms-gray-500); margin-top: 0.25rem;">Bank transfer payments</div>
            </div>
            <div class="stat-card info">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-label">Pending Transfers</div>
                <div class="stat-value info">{{ $pendingTransfers }}</div>
                <div style="font-size: 0.75rem; color: var(--sms-gray-500); margin-top: 0.25rem;">Awaiting approval</div>
                @if($pendingTransfers > 0)
                    <a href="{{ route('school.payments.manual-transfers', ['status' => 'pending']) }}" class="btn btn-outline" style="margin-top: 0.75rem; font-size: 0.8125rem; padding: 0.5rem 1rem; width: 100%; justify-content: center;">
                        <i class="fas fa-eye"></i> Review Now
                    </a>
                @endif
            </div>
        </div>

        <!-- Filters -->
        <div class="sms-card">
            <div class="sms-card-header">
                <h3 class="sms-card-title" style="margin: 0;">Filter Payments</h3>
            </div>
            <form method="GET" action="{{ route('school.payments.index') }}" class="filters" style="padding-top: 0;">
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-filter" style="margin-right: 0.25rem;"></i> Status
                    </label>
                    <select name="status" class="filter-select">
                        <option value="all" {{ $statusFilter === 'all' ? 'selected' : '' }}>All</option>
                        <option value="success" {{ $statusFilter === 'success' ? 'selected' : '' }}>Success</option>
                        <option value="pending" {{ $statusFilter === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ $statusFilter === 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-credit-card" style="margin-right: 0.25rem;"></i> Payment Method
                    </label>
                    <select name="method" class="filter-select">
                        <option value="all" {{ $methodFilter === 'all' ? 'selected' : '' }}>All</option>
                        <option value="online" {{ $methodFilter === 'online' ? 'selected' : '' }}>Online</option>
                        <option value="bank_transfer" {{ $methodFilter === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="cash" {{ $methodFilter === 'cash' ? 'selected' : '' }}>Cash</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-users" style="margin-right: 0.25rem;"></i> Class
                    </label>
                    <select name="class_id" class="filter-select">
                        <option value="all" {{ $classFilter === 'all' ? 'selected' : '' }}>All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $classFilter == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-calendar-alt" style="margin-right: 0.25rem;"></i> From Date
                    </label>
                    <input type="date" name="date_from" value="{{ $dateFrom }}" class="filter-select">
                </div>

                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-calendar-check" style="margin-right: 0.25rem;"></i> To Date
                    </label>
                    <input type="date" name="date_to" value="{{ $dateTo }}" class="filter-select">
                </div>

                <div class="filter-group" style="justify-content: flex-end; align-items: flex-end;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; min-height: 44px; justify-content: center;">
                        <i class="fas fa-search"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Payments Table -->
        <div class="sms-card">
            <div class="sms-card-header">
                <h3 class="sms-card-title">Payment History</h3>
                <a href="{{ route('school.payments.settings') }}" class="btn btn-outline">
                    <i class="fas fa-cog"></i> Payment Settings
                </a>
            </div>

            <div class="sms-table-wrapper">
                <table class="sms-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Fee</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Reference</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                <td>{{ $payment->student->user->name ?? 'N/A' }}</td>
                                <td>{{ $payment->student->class->name ?? 'N/A' }}</td>
                                <td>{{ $payment->fee->name ?? 'N/A' }}</td>
                                <td>₦{{ number_format($payment->amount_paid, 2) }}</td>
                                <td>
                                    @if($payment->gateway)
                                        <span class="sms-badge sms-badge-info">{{ ucfirst($payment->gateway) }}</span>
                                    @else
                                        {{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? 'N/A')) }}
                                    @endif
                                </td>
                                <td>
                                    @if($payment->payment_status === 'success')
                                        <span class="sms-badge sms-badge-success">Success</span>
                                    @elseif($payment->payment_status === 'pending')
                                        <span class="sms-badge sms-badge-warning">Pending</span>
                                    @else
                                        <span class="sms-badge sms-badge-danger">Failed</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $payment->transaction_id ?? $payment->gateway_reference ?? 'N/A' }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No payments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div style="margin-top: 1.5rem;">
                {{ $payments->links() }}
            </div>
        </div>

        <!-- Parent Payments View -->
        <div class="sms-card">
            <div class="sms-card-header">
                <h3 class="sms-card-title">Payments by Parent</h3>
            </div>
            <div class="sms-table-wrapper">
                <table class="sms-table">
                    <thead>
                        <tr>
                            <th>Parent Name</th>
                            <th>Student(s)</th>
                            <th>Class</th>
                            <th>Amount Paid</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($parentPaymentsList as $item)
                            <tr>
                                <td><strong>{{ $item['parent_name'] }}</strong></td>
                                <td>{{ $item['payment']->student->user->name ?? 'N/A' }}</td>
                                <td>{{ $item['payment']->student->class->name ?? 'N/A' }}</td>
                                <td>₦{{ number_format($item['payment']->amount_paid, 2) }}</td>
                                <td>
                                    @if($item['payment']->gateway)
                                        <span class="sms-badge sms-badge-info">{{ ucfirst($item['payment']->gateway) }}</span>
                                    @else
                                        {{ ucfirst(str_replace('_', ' ', $item['payment']->payment_method ?? 'N/A')) }}
                                    @endif
                                </td>
                                <td>
                                    @if($item['payment']->payment_status === 'success')
                                        <span class="sms-badge sms-badge-success">Paid</span>
                                    @elseif($item['payment']->payment_status === 'pending')
                                        <span class="sms-badge sms-badge-warning">Pending</span>
                                    @else
                                        <span class="sms-badge sms-badge-danger">Failed</span>
                                    @endif
                                </td>
                                <td>{{ $item['payment']->payment_date->format('M d, Y') }}</td>
                                <td>
                                    @if($item['payment']->payment_status === 'success')
                                        <a href="{{ route('sms.parent.fees.receipt', $item['payment']->id) }}" target="_blank" class="btn btn-outline" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                            View
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No parent payments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
