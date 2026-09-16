@extends('layouts.app')

@section('title', 'Fees Status - School Management System')

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
    .sms-content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
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
    @media (max-width: 1024px) {
        .sms-content-grid {
            grid-template-columns: 1fr;
        }
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
        <h1 class="sms-page-title">Fees & Payments</h1>
        <p class="sms-page-subtitle">See all assigned fees, payments you have made, and your outstanding balance.</p>
    </div>

    <div style="max-width: 1400px; margin: 0 auto; padding: 0 2rem 2rem;">
        @php
            $totalFees = $fees->sum('amount');
            $totalPaid = $payments->sum('amount_paid');
            $outstanding = max(0, $totalFees - $totalPaid);
        @endphp

        <div class="sms-stats-grid">
            <div class="sms-stat-card">
                <div class="sms-stat-label">Total Assigned Fees</div>
                <div class="sms-stat-value">₦{{ number_format($totalFees, 2) }}</div>
            </div>
            <div class="sms-stat-card">
                <div class="sms-stat-label">Total Paid</div>
                <div class="sms-stat-value" style="color: #16a34a;">₦{{ number_format($totalPaid, 2) }}</div>
            </div>
            <div class="sms-stat-card">
                <div class="sms-stat-label">Outstanding Balance</div>
                <div class="sms-stat-value" style="color: {{ $outstanding > 0 ? '#dc2626' : '#16a34a' }};">₦{{ number_format($outstanding, 2) }}</div>
            </div>
        </div>

        <div class="sms-content-grid">
            <div class="sms-card">
                <div class="sms-card-header">
                    <h2 class="sms-card-title">Assigned Fees</h2>
                </div>
                <div class="sms-card-body">
                    @if($fees->count())
                        <div style="width: 100%; overflow-x: auto;">
                            <table class="sms-table">
                                <thead>
                                    <tr>
                                        <th>Fee</th>
                                        <th style="text-align: right;">Amount</th>
                                        <th>Due Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fees as $fee)
                                    <tr>
                                        <td style="font-weight: 600;">{{ $fee->name }}</td>
                                        <td style="text-align: right;">₦{{ number_format($fee->amount, 2) }}</td>
                                        <td style="color: var(--sms-gray-600);">
                                            @php
                                                $dueDate = $fee->due_date;
                                                if ($dueDate) {
                                                    if (is_string($dueDate)) {
                                                        $dueDate = \Carbon\Carbon::parse($dueDate);
                                                    }
                                                    echo $dueDate->format('M d, Y');
                                                } else {
                                                    echo '—';
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="sms-empty-state">
                            <div class="sms-empty-state-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="sms-empty-state-title">No Fees Assigned</div>
                            <div class="sms-empty-state-text">No fees have been assigned to you yet.</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="sms-card">
                <div class="sms-card-header">
                    <h2 class="sms-card-title">Payment History</h2>
                </div>
                <div class="sms-card-body">
                    @if($payments->count())
                        <div style="width: 100%; overflow-x: auto;">
                            <table class="sms-table">
                                <thead>
                                    <tr>
                                        <th>Receipt</th>
                                        <th>Fee</th>
                                        <th>Date</th>
                                        <th style="text-align: right;">Amount Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                    <tr>
                                        <td style="color: var(--sms-gray-600);">{{ $payment->receipt_number ?? '—' }}</td>
                                        <td>{{ $payment->fee?->name ?? 'N/A' }}</td>
                                        <td style="color: var(--sms-gray-600);">
                                            @php
                                                $paymentDate = $payment->payment_date;
                                                if ($paymentDate) {
                                                    if (is_string($paymentDate)) {
                                                        $paymentDate = \Carbon\Carbon::parse($paymentDate);
                                                    }
                                                    echo $paymentDate->format('M d, Y');
                                                } else {
                                                    echo '—';
                                                }
                                            @endphp
                                        </td>
                                        <td style="text-align: right; font-weight: 600;">₦{{ number_format($payment->amount_paid, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="sms-empty-state">
                            <div class="sms-empty-state-icon">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div class="sms-empty-state-title">No Payments Yet</div>
                            <div class="sms-empty-state-text">You have not made any payments yet.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
