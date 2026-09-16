@extends('layouts.app')

@section('title', 'Payment Receipt - School Management System')

@section('content')
<style>
    .receipt-container {
        max-width: 800px;
        margin: 2rem auto;
        background: white;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    .receipt-header {
        text-align: center;
        border-bottom: 2px solid #1e3a8a;
        padding-bottom: 1.5rem;
        margin-bottom: 2rem;
    }
    .receipt-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1e3a8a;
        margin-bottom: 0.5rem;
    }
    .receipt-subtitle {
        color: #64748b;
        font-size: 0.875rem;
    }
    .receipt-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
        margin-bottom: 2rem;
    }
    .receipt-section {
        margin-bottom: 1.5rem;
    }
    .receipt-section-title {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.75rem;
        font-size: 1rem;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 0.5rem;
    }
    .receipt-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .receipt-item-label {
        color: #64748b;
        font-size: 0.875rem;
    }
    .receipt-item-value {
        font-weight: 600;
        color: #1e293b;
    }
    .receipt-amount {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 8px;
        margin: 2rem 0;
        border: 2px solid #1e3a8a;
    }
    .receipt-amount-label {
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 0.5rem;
    }
    .receipt-amount-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1e3a8a;
    }
    .receipt-footer {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
        text-align: center;
        color: #64748b;
        font-size: 0.875rem;
    }
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: #1e3a8a;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        margin-top: 1.5rem;
        border: none;
        cursor: pointer;
    }
    .btn:hover {
        background: #1e40af;
    }
    @media print {
        .btn {
            display: none;
        }
        .receipt-container {
            box-shadow: none;
            margin: 0;
            padding: 1rem;
        }
    }
</style>

<div class="receipt-container">
    <div class="receipt-header">
        <div class="receipt-title">PAYMENT RECEIPT</div>
        <div class="receipt-subtitle">{{ $payment->school->name ?? 'School Management System' }}</div>
    </div>

    <div class="receipt-info">
        <div class="receipt-section">
            <div class="receipt-section-title">Student Information</div>
            <div class="receipt-item">
                <span class="receipt-item-label">Student Name:</span>
                <span class="receipt-item-value">{{ $payment->student->user->name ?? 'N/A' }}</span>
            </div>
            <div class="receipt-item">
                <span class="receipt-item-label">Student ID:</span>
                <span class="receipt-item-value">{{ $payment->student->student_id_number ?? 'N/A' }}</span>
            </div>
            <div class="receipt-item">
                <span class="receipt-item-label">Class:</span>
                <span class="receipt-item-value">{{ $payment->student->class->name ?? 'N/A' }}</span>
            </div>
        </div>

        <div class="receipt-section">
            <div class="receipt-section-title">Payment Details</div>
            <div class="receipt-item">
                <span class="receipt-item-label">Receipt Number:</span>
                <span class="receipt-item-value">{{ $payment->receipt_number ?? 'REC-' . str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="receipt-item">
                <span class="receipt-item-label">Payment Date:</span>
                <span class="receipt-item-value">{{ $payment->payment_date->format('F d, Y') }}</span>
            </div>
            <div class="receipt-item">
                <span class="receipt-item-label">Fee Type:</span>
                <span class="receipt-item-value">{{ $payment->fee->name ?? 'N/A' }}</span>
            </div>
            <div class="receipt-item">
                <span class="receipt-item-label">Payment Method:</span>
                <span class="receipt-item-value">
                    @if($payment->gateway)
                        {{ ucfirst($payment->gateway) }}
                    @else
                        {{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? 'N/A')) }}
                    @endif
                </span>
            </div>
            @if($payment->transaction_id)
                <div class="receipt-item">
                    <span class="receipt-item-label">Transaction ID:</span>
                    <span class="receipt-item-value">{{ $payment->transaction_id }}</span>
                </div>
            @endif
        </div>
    </div>

    <div class="receipt-amount">
        <div class="receipt-amount-label">Amount Paid</div>
        <div class="receipt-amount-value">₦{{ number_format($payment->amount_paid, 2) }}</div>
    </div>

    @if($payment->remarks)
        <div class="receipt-section">
            <div class="receipt-section-title">Remarks</div>
            <p style="color: #64748b; font-size: 0.875rem;">{{ $payment->remarks }}</p>
        </div>
    @endif

    <div class="receipt-footer">
        <p>This is a computer-generated receipt. No signature required.</p>
        <p>Generated on {{ now()->format('F d, Y h:i A') }}</p>
    </div>

    <div style="text-align: center;">
        <button onclick="window.print()" class="btn">
            <i class="fas fa-print"></i> Print Receipt
        </button>
        <a href="{{ route('sms.parent.fees') }}" class="btn" style="background: #64748b; margin-left: 0.5rem;">
            <i class="fas fa-arrow-left"></i> Back to Fees
        </a>
    </div>
</div>
@endsection
