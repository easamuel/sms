@extends('layouts.app')

@section('title', 'Fee Payments - School Management System')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-dashboard {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #f0f9ff 100%);
        min-height: calc(100vh - 80px);
        padding: 0;
    }
    
    /* Beautiful Header */
    .fees-page-header {
        background: linear-gradient(135deg, var(--sms-primary) 0%, var(--sms-primary-dark) 100%);
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
    }
    
    .fees-page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .fees-page-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }
    
    .fees-header-content {
        position: relative;
        z-index: 1;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .fees-page-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.75rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        letter-spacing: -0.02em;
    }
    
    .fees-page-subtitle {
        font-size: 1.125rem;
        opacity: 0.95;
        font-weight: 400;
    }
    
    .fees-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem 3rem;
    }
    
    /* Modern Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.8);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, var(--sms-primary), var(--sms-accent));
    }
    
    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .stat-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }
    
    .stat-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .stat-icon.total {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
    }
    
    .stat-icon.paid {
        background: linear-gradient(135deg, #10b981, #059669);
    }
    
    .stat-icon.balance {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }
    
    .stat-label {
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--sms-gray-500);
        font-weight: 600;
        margin-bottom: 0.75rem;
    }
    
    .stat-value {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        line-height: 1.2;
    }
    
    .stat-value.paid {
        color: #059669;
    }
    
    .stat-value.balance {
        color: #dc2626;
    }
    
    /* Alert Messages */
    .alert {
        padding: 1.25rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        font-size: 0.9375rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        border: 2px solid #6ee7b7;
    }
    
    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        border: 2px solid #fca5a5;
    }
    
    /* Main Card */
    .sms-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.8);
        overflow: hidden;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }
    
    .sms-card:hover {
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.12);
    }
    
    .sms-card-header {
        padding: 2rem;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(139, 92, 246, 0.05));
        border-bottom: 2px solid var(--sms-gray-100);
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .sms-card-title-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }
    
    .sms-card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin: 0;
    }
    
    .sms-card-body {
        padding: 2rem;
    }
    
    /* Fee Item Cards */
    .fee-item {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 2px solid var(--sms-gray-200);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .fee-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: linear-gradient(180deg, var(--sms-primary), var(--sms-accent));
    }
    
    .fee-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        border-color: var(--sms-primary);
    }
    
    .fee-item-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--sms-gray-100);
    }
    
    .fee-student-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .fee-student-avatar {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }
    
    .fee-student-name {
        font-weight: 700;
        font-size: 1.375rem;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
    }
    
    .fee-class {
        color: var(--sms-gray-600);
        font-size: 0.9375rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    /* Fee Amounts Grid */
    .fee-amounts {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(139, 92, 246, 0.05));
        border-radius: 16px;
        border: 1px solid rgba(99, 102, 241, 0.1);
    }
    
    .fee-amount-item {
        text-align: center;
        padding: 1rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .fee-amount-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .fee-amount-label {
        font-size: 0.8125rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--sms-gray-500);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .fee-amount-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--sms-gray-900);
    }
    
    .fee-amount-value.paid {
        color: #059669;
    }
    
    .fee-amount-value.balance {
        color: #dc2626;
    }
    
    /* Fee Breakdown */
    .fee-breakdown {
        margin-bottom: 2rem;
    }
    
    .fee-breakdown-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .fee-breakdown-title::before {
        content: '';
        width: 4px;
        height: 24px;
        background: linear-gradient(180deg, var(--sms-primary), var(--sms-accent));
        border-radius: 2px;
    }
    
    .fee-breakdown-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem;
        background: white;
        border: 2px solid var(--sms-gray-100);
        border-radius: 12px;
        margin-bottom: 0.875rem;
        transition: all 0.3s ease;
    }
    
    .fee-breakdown-item:hover {
        border-color: var(--sms-primary);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1);
        transform: translateX(4px);
    }
    
    .fee-breakdown-info {
        flex: 1;
    }
    
    .fee-breakdown-name {
        font-weight: 600;
        font-size: 1rem;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
    }
    
    .fee-breakdown-details {
        font-size: 0.875rem;
        color: var(--sms-gray-600);
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .fee-breakdown-detail-item {
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }
    
    /* Payment Button */
    .payment-buttons {
        margin-top: 2rem;
    }
    
    .btn {
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        position: relative;
        overflow: hidden;
        min-height: 52px;
    }
    
    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .btn:hover::before {
        width: 400px;
        height: 400px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--sms-primary) 0%, var(--sms-primary-dark) 100%);
        color: white;
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(99, 102, 241, 0.4);
    }
    
    .btn-primary:active {
        transform: translateY(-1px);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .btn-success:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(16, 185, 129, 0.4);
    }
    
    .btn-outline {
        background: white;
        color: var(--sms-primary);
        border: 2px solid var(--sms-primary);
    }
    
    .btn-outline:hover {
        background: var(--sms-primary);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(99, 102, 241, 0.3);
    }
    
    /* Badges */
    .sms-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.8125rem;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .sms-badge-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        border: 1px solid #6ee7b7;
    }
    
    .sms-badge-warning {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        border: 1px solid #fcd34d;
    }
    
    .sms-badge-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        border: 1px solid #fca5a5;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--sms-gray-500);
    }
    
    .empty-state-icon {
        font-size: 5rem;
        color: var(--sms-gray-300);
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }
    
    .empty-state-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--sms-gray-700);
        margin-bottom: 0.75rem;
    }
    
    .empty-state-text {
        font-size: 1rem;
        color: var(--sms-gray-500);
    }
    
    /* Paid Status Card */
    .paid-status-card {
        padding: 1.5rem;
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        border-radius: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border: 2px solid #6ee7b7;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }
    
    /* Modals */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    
    .modal.active {
        display: flex;
        animation: fadeIn 0.2s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .modal-content {
        background: white;
        border-radius: 24px;
        padding: 2.5rem;
        max-width: 600px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
        animation: modalSlideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    .modal-content h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: var(--sms-gray-700);
        font-size: 0.9375rem;
    }
    
    .form-control {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid var(--sms-gray-300);
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        transform: translateY(-1px);
    }
    
    .bank-details {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 2px solid var(--sms-blue-300);
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
    }
    
    .bank-details h4 {
        margin-bottom: 1.5rem;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .bank-details-item {
        padding: 1.25rem 0;
        border-bottom: 1px solid rgba(59, 130, 246, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .bank-details-item:last-child {
        border-bottom: none;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .fees-page-header {
            padding: 2rem 1.5rem;
        }
        
        .fees-page-title {
            font-size: 1.75rem;
        }
        
        .fees-container {
            padding: 0 1rem 2rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .stat-card {
            padding: 1.5rem;
        }
        
        .fee-item {
            padding: 1.5rem;
        }
        
        .fee-amounts {
            grid-template-columns: 1fr;
            padding: 1rem;
        }
        
        .sms-card-body {
            padding: 1.5rem;
        }
        
        .modal-content {
            padding: 1.5rem;
            border-radius: 16px;
        }
    }
</style>

<div class="sms-dashboard">
    <!-- Beautiful Header -->
    <div class="fees-page-header">
        <div class="fees-header-content">
            <h1 class="fees-page-title">
                <i class="fas fa-money-bill-wave" style="margin-right: 0.75rem;"></i>
                Fee Payments
            </h1>
            <p class="fees-page-subtitle">View and manage fee payments for your children</p>
        </div>
    </div>

    <div class="fees-container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle" style="font-size: 1.25rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle" style="font-size: 1.25rem;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Summary Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-label">Total Fees</div>
                        <div class="stat-value">₦{{ number_format($totalFees, 2) }}</div>
                    </div>
                    <div class="stat-icon total">
                        <i class="fas fa-receipt"></i>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-label">Total Paid</div>
                        <div class="stat-value paid">₦{{ number_format($totalPaid, 2) }}</div>
                    </div>
                    <div class="stat-icon paid">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-label">Outstanding Balance</div>
                        <div class="stat-value balance">₦{{ number_format($totalBalance, 2) }}</div>
                    </div>
                    <div class="stat-icon balance">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fees List - Grouped by Child -->
        <div class="sms-card">
            <div class="sms-card-header">
                <div class="sms-card-title-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3 class="sms-card-title">Fee Payments by Child</h3>
            </div>

            <div class="sms-card-body">
                @forelse($feesByChild as $childData)
                    @php
                        $student = $childData['student'];
                        $childFees = $childData['fees'];
                        $childTotalAmount = $childData['total_amount'];
                        $childTotalPaid = $childData['total_paid'];
                        $childTotalBalance = $childData['total_balance'];
                    @endphp
                    
                    <div class="fee-item">
                        <!-- Child Header -->
                        <div class="fee-item-header">
                            <div class="fee-student-info">
                                <div class="fee-student-avatar">
                                    {{ strtoupper(substr($student->user->name ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fee-student-name">{{ $student->user->name ?? 'N/A' }}</div>
                                    <div class="fee-class">
                                        <i class="fas fa-graduation-cap"></i>
                                        <span>{{ $student->class->name ?? 'N/A' }} | Student ID: {{ $student->student_id_number }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Child Summary -->
                        <div class="fee-amounts">
                            <div class="fee-amount-item">
                                <div class="fee-amount-label">Total Fees</div>
                                <div class="fee-amount-value">₦{{ number_format($childTotalAmount, 2) }}</div>
                            </div>
                            <div class="fee-amount-item">
                                <div class="fee-amount-label">Total Paid</div>
                                <div class="fee-amount-value paid">₦{{ number_format($childTotalPaid, 2) }}</div>
                            </div>
                            <div class="fee-amount-item">
                                <div class="fee-amount-label">Outstanding</div>
                                <div class="fee-amount-value balance">₦{{ number_format($childTotalBalance, 2) }}</div>
                            </div>
                        </div>

                        <!-- Individual Fee Breakdown -->
                        <div class="fee-breakdown">
                            <h4 class="fee-breakdown-title">Fee Breakdown</h4>
                            @foreach($childFees as $studentFee)
                                <div class="fee-breakdown-item" data-fee-id="{{ $studentFee->fee_id }}">
                                    <div class="fee-breakdown-info">
                                        <div class="fee-breakdown-name">{{ $studentFee->fee->name ?? 'Fee #' . $studentFee->fee_id }}</div>
                                        <div class="fee-breakdown-details">
                                            <div class="fee-breakdown-detail-item">
                                                <i class="fas fa-money-bill" style="color: var(--sms-gray-400);"></i>
                                                <span>Amount: <strong>₦{{ number_format($studentFee->amount, 2) }}</strong></span>
                                            </div>
                                            <div class="fee-breakdown-detail-item">
                                                <i class="fas fa-check-circle" style="color: #059669;"></i>
                                                <span>Paid: <strong>₦{{ number_format($studentFee->paid_amount, 2) }}</strong></span>
                                            </div>
                                            <div class="fee-breakdown-detail-item">
                                                <i class="fas fa-exclamation-circle" style="color: #dc2626;"></i>
                                                <span>Balance: <strong>₦{{ number_format($studentFee->balance, 2) }}</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        @if($studentFee->status === 'paid')
                                            <span class="sms-badge sms-badge-success">
                                                <i class="fas fa-check" style="margin-right: 0.25rem;"></i> Paid
                                            </span>
                                        @elseif($studentFee->status === 'partial')
                                            <span class="sms-badge sms-badge-warning">
                                                <i class="fas fa-clock" style="margin-right: 0.25rem;"></i> Partial
                                            </span>
                                        @else
                                            <span class="sms-badge sms-badge-danger">
                                                <i class="fas fa-exclamation" style="margin-right: 0.25rem;"></i> Pending
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Payment Button for Child -->
                        @if($childTotalBalance > 0)
                            @php
                                $hasPendingTransfer = $childData['has_pending_transfer'] ?? false;
                                $pendingTransfers = $childData['pending_transfers'] ?? collect();
                            @endphp
                            
                            @if($hasPendingTransfer)
                                <!-- Pending Payment Message -->
                                <div class="payment-buttons">
                                    <div class="pending-payment-alert" style="
                                        background: linear-gradient(135deg, #fef3c7, #fde68a);
                                        border: 2px solid #fcd34d;
                                        border-radius: 12px;
                                        padding: 1.25rem;
                                        display: flex;
                                        align-items: center;
                                        gap: 1rem;
                                        margin-bottom: 1rem;
                                    ">
                                        <div style="
                                            width: 48px;
                                            height: 48px;
                                            border-radius: 50%;
                                            background: #f59e0b;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            color: white;
                                            font-size: 1.5rem;
                                            flex-shrink: 0;
                                        ">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div style="flex: 1;">
                                            <div style="
                                                font-weight: 700;
                                                color: #92400e;
                                                margin-bottom: 0.5rem;
                                                font-size: 1.125rem;
                                            ">
                                                Payment Pending Approval
                                            </div>
                                            <div style="
                                                color: #78350f;
                                                font-size: 0.9375rem;
                                                line-height: 1.5;
                                            ">
                                                @if($pendingTransfers->count() > 0)
                                                    @php
                                                        $totalPending = $pendingTransfers->sum('amount');
                                                        $latestTransfer = $pendingTransfers->sortByDesc('created_at')->first();
                                                    @endphp
                                                    You have a pending payment of <strong>₦{{ number_format($totalPending, 2) }}</strong> awaiting admin approval.
                                                    @if($latestTransfer)
                                                        <br><small style="opacity: 0.8;">Submitted on {{ $latestTransfer->created_at->format('M d, Y h:i A') }}</small>
                                                    @endif
                                                @else
                                                    You have a pending payment awaiting admin approval. Please wait for the admin to review your payment proof before making another payment.
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @php
                                    // Extract real fee IDs (numeric IDs from StudentFee table)
                                    $realFeeIds = $childFees->filter(function($f) { 
                                        $id = $f->id ?? null;
                                        if (!$id) return false;
                                        return is_numeric($id) || (is_string($id) && !str_starts_with($id, 'virtual_') && is_numeric($id));
                                    })->map(function($f) {
                                        $id = $f->id ?? null;
                                        return is_numeric($id) ? (int)$id : (is_string($id) && is_numeric($id) ? (int)$id : null);
                                    })->filter()->values();
                                    
                                    // Extract virtual fee IDs (from SmsFee table, stored in fee_id property)
                                    $virtualFeeIds = $childFees->filter(function($f) { 
                                        $id = $f->id ?? null;
                                        return $id && is_string($id) && str_starts_with($id, 'virtual_');
                                    })->map(function($f) { 
                                        if (isset($f->fee_id) && $f->fee_id) {
                                            return (int)$f->fee_id;
                                        }
                                        if ($f->fee && isset($f->fee->id)) {
                                            return (int)$f->fee->id;
                                        }
                                        if (is_string($f->id) && str_starts_with($f->id, 'virtual_')) {
                                            $parts = explode('_', $f->id);
                                            if (count($parts) >= 3 && is_numeric($parts[2])) {
                                                return (int)$parts[2];
                                            }
                                        }
                                        return null;
                                    })->filter()->values();
                                @endphp
                                <div class="payment-buttons">
                                    <button type="button" class="btn btn-primary make-payment-btn" 
                                            data-student-id="{{ $student->id }}"
                                            data-balance="{{ $childTotalBalance }}"
                                            data-total-amount="{{ $childTotalAmount }}"
                                            data-fee-ids="{{ $realFeeIds->implode(',') }}"
                                            data-fee-ids-virtual="{{ $virtualFeeIds->implode(',') }}"
                                            data-has-virtual-fees="{{ $virtualFeeIds->count() > 0 ? 'true' : 'false' }}">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <span>Make Payment - ₦{{ number_format($childTotalBalance, 2) }}</span>
                                    </button>
                                </div>
                            @endif
                        @else
                            <div class="payment-buttons">
                                <div class="paid-status-card">
                                    <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
                                    <span>All fees paid for this child</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="empty-state-title">No Fees Found</div>
                        <div class="empty-state-text">No fees have been assigned to your children yet.</div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Transaction History -->
        @if(isset($transactionHistory) && $transactionHistory->count() > 0)
        <div class="sms-card">
            <div class="sms-card-header">
                <div class="sms-card-title-icon">
                    <i class="fas fa-history"></i>
                </div>
                <h3 class="sms-card-title">Transaction History</h3>
            </div>

            <div class="sms-card-body">
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($transactionHistory as $transaction)
                        @php
                            $item = $transaction['data'];
                            $student = $item->student ?? null;
                            $fee = $item->fee ?? ($item->studentFee->fee ?? null);
                        @endphp
                        <div class="transaction-item" style="
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            padding: 1.25rem;
                            background: {{ $transaction['status'] === 'completed' ? 'linear-gradient(135deg, #d1fae5, #a7f3d0)' : ($transaction['status'] === 'pending' ? 'linear-gradient(135deg, #fef3c7, #fde68a)' : 'linear-gradient(135deg, #fee2e2, #fecaca)') }};
                            border-radius: 12px;
                            border: 2px solid {{ $transaction['status'] === 'completed' ? '#6ee7b7' : ($transaction['status'] === 'pending' ? '#fcd34d' : '#fca5a5') }};
                            transition: all 0.3s ease;
                        " onmouseover="this.style.transform='translateX(4px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='none';">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                    <div style="
                                        width: 48px;
                                        height: 48px;
                                        border-radius: 12px;
                                        background: {{ $transaction['status'] === 'completed' ? '#10b981' : ($transaction['status'] === 'pending' ? '#f59e0b' : '#ef4444') }};
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        color: white;
                                        font-size: 1.25rem;
                                        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
                                    ">
                                        @if($transaction['type'] === 'payment')
                                            <i class="fas fa-check-circle"></i>
                                        @else
                                            <i class="fas fa-{{ $transaction['status'] === 'pending' ? 'clock' : ($transaction['status'] === 'approved' ? 'check' : 'times') }}"></i>
                                        @endif
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-weight: 700; font-size: 1rem; color: var(--sms-gray-900); margin-bottom: 0.25rem;">
                                            {{ $student && $student->user ? $student->user->name : 'N/A' }} - {{ $fee ? $fee->name : 'Fee Payment' }}
                                        </div>
                                        <div style="font-size: 0.875rem; color: var(--sms-gray-600); display: flex; flex-wrap: wrap; gap: 1rem;">
                                            <span><i class="fas fa-calendar"></i> {{ $transaction['date']->format('M d, Y h:i A') }}</span>
                                            <span><i class="fas fa-{{ $transaction['method'] === 'bank_transfer' ? 'university' : 'credit-card' }}"></i> {{ ucfirst(str_replace('_', ' ', $transaction['method'])) }}</span>
                                            @if($transaction['type'] === 'manual_transfer' && $transaction['status'] === 'pending')
                                                <span><i class="fas fa-hourglass-half"></i> Awaiting Approval</span>
                                            @elseif($transaction['type'] === 'manual_transfer' && $transaction['status'] === 'approved')
                                                <span><i class="fas fa-check"></i> Approved</span>
                                            @elseif($transaction['type'] === 'manual_transfer' && $transaction['status'] === 'rejected')
                                                <span><i class="fas fa-times"></i> Rejected</span>
                                            @endif
                                            @if($transaction['type'] === 'payment' && isset($item->transaction_id))
                                                <span><i class="fas fa-hashtag"></i> Ref: {{ $item->transaction_id }}</span>
                                            @elseif($transaction['type'] === 'manual_transfer' && isset($item->transaction_reference))
                                                <span><i class="fas fa-hashtag"></i> Ref: {{ $item->transaction_reference }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 1.5rem; font-weight: 800; color: var(--sms-gray-900); margin-bottom: 0.25rem;">
                                    ₦{{ number_format($transaction['amount'], 2) }}
                                </div>
                                <span class="sms-badge {{ $transaction['status'] === 'completed' ? 'sms-badge-success' : ($transaction['status'] === 'pending' ? 'sms-badge-warning' : 'sms-badge-danger') }}">
                                    {{ ucfirst($transaction['status']) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Payment Method Selection Modal -->
<div id="paymentMethodModal" class="modal">
    <div class="modal-content">
        <h3>
            <i class="fas fa-credit-card" style="color: var(--sms-primary);"></i>
            Select Payment Method
        </h3>
        <input type="hidden" id="method_student_fee_id">
        <input type="hidden" id="method_balance">
        <input type="hidden" id="method_amount">
        
        <div class="form-group">
            <label class="form-label">Choose Payment Method</label>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @if($paymentSettings && $paymentSettings->getActiveGateway())
                    <button type="button" class="btn btn-primary" style="width: 100%; padding: 1.25rem; text-align: left; justify-content: flex-start;" onclick="selectPaymentMethod('online')">
                        <i class="fas fa-credit-card" style="font-size: 1.25rem;"></i>
                        <div style="flex: 1;">
                            <strong style="display: block; margin-bottom: 0.25rem;">Pay Online</strong>
                            <div style="font-size: 0.875rem; opacity: 0.9;">Secure online payment via {{ ucfirst($paymentSettings->getActiveGateway()) }}</div>
                        </div>
                    </button>
                @endif
                
                @php
                    $hasBankDetails = $paymentSettings && 
                                      !empty($paymentSettings->account_number) && 
                                      !empty($paymentSettings->bank_name) && 
                                      !empty($paymentSettings->account_name);
                @endphp
                @if($hasBankDetails)
                    <button type="button" class="btn btn-outline" style="width: 100%; padding: 1.25rem; text-align: left; justify-content: flex-start;" onclick="selectPaymentMethod('manual')">
                        <i class="fas fa-university" style="font-size: 1.25rem;"></i>
                        <div style="flex: 1;">
                            <strong style="display: block; margin-bottom: 0.25rem;">Bank Transfer (Manual)</strong>
                            <div style="font-size: 0.875rem; opacity: 0.9;">Transfer to school account and upload proof</div>
                        </div>
                    </button>
                @else
                    <button type="button" class="btn btn-outline" style="width: 100%; padding: 1.25rem; text-align: left; justify-content: flex-start;" onclick="selectPaymentMethod('manual')">
                        <i class="fas fa-university" style="font-size: 1.25rem;"></i>
                        <div style="flex: 1;">
                            <strong style="display: block; margin-bottom: 0.25rem;">Bank Transfer (Manual)</strong>
                            <div style="font-size: 0.875rem; opacity: 0.9;">Contact school for bank details</div>
                        </div>
                    </button>
                @endif
            </div>
        </div>

        <div class="payment-buttons" style="margin-top: 1.5rem;">
            <button type="button" class="btn btn-outline" onclick="closePaymentMethodModal()" style="width: 100%;">Cancel</button>
        </div>
    </div>
</div>

<!-- Online Payment Modal -->
<div id="onlinePaymentModal" class="modal">
    <div class="modal-content">
        <h3>
            <i class="fas fa-credit-card" style="color: var(--sms-primary);"></i>
            Pay Online
        </h3>
        <form id="onlinePaymentForm" method="POST" action="{{ route('sms.parent.fees.initiate') }}">
            @csrf
            <input type="hidden" name="student_fee_id" id="online_student_fee_id">
            <input type="hidden" name="payment_type" id="online_payment_type" value="full">
            
            <div class="form-group">
                <label class="form-label">Payment Type</label>
                <select name="payment_type" id="online_payment_type_select" class="form-control" onchange="updateOnlineAmount()">
                    <option value="full">Full Payment</option>
                    <option value="partial">Partial Payment</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Amount (₦)</label>
                <input type="number" name="amount" id="online_amount" class="form-control" step="0.01" min="0.01" required>
                <small style="color: var(--sms-gray-500); margin-top: 0.5rem; display: block;">Balance: ₦<span id="online_balance">0.00</span></small>
            </div>

            <div class="payment-buttons" style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Proceed to Payment</button>
                <button type="button" class="btn btn-outline" onclick="closeOnlinePaymentModal()" style="flex: 1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Manual Transfer Modal -->
<div id="manualTransferModal" class="modal">
    <div class="modal-content">
        <h3>
            <i class="fas fa-university" style="color: var(--sms-primary);"></i>
            Bank Transfer Payment
        </h3>
        
        <!-- Always show bank details prominently when manual payment is selected -->
        @php
            $hasBankDetails = $paymentSettings && 
                              !empty($paymentSettings->account_number) && 
                              !empty($paymentSettings->bank_name) && 
                              !empty($paymentSettings->account_name);
        @endphp
        @if($hasBankDetails)
            <div class="bank-details">
                <h4>
                    <i class="fas fa-university" style="color: var(--sms-blue-600);"></i>
                    School Bank Account Details
                </h4>
                <div class="bank-details-item">
                    <span style="font-weight: 600; color: var(--sms-gray-700);">Bank Name:</span>
                    <span style="font-weight: 700; color: var(--sms-gray-900); font-size: 1.0625rem;">{{ $paymentSettings->bank_name ?? 'N/A' }}</span>
                </div>
                <div class="bank-details-item">
                    <span style="font-weight: 600; color: var(--sms-gray-700);">Account Name:</span>
                    <span style="font-weight: 700; color: var(--sms-gray-900); font-size: 1.0625rem;">{{ $paymentSettings->account_name ?: 'N/A' }}</span>
                </div>
                <div class="bank-details-item">
                    <span style="font-weight: 600; color: var(--sms-gray-700);">Account Number:</span>
                    <span style="font-weight: 700; color: var(--sms-blue-600); font-size: 1.5rem; letter-spacing: 0.1em; background: white; padding: 0.75rem 1.25rem; border-radius: 12px; border: 2px solid var(--sms-blue-300); box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);">{{ $paymentSettings->account_number }}</span>
                </div>
                @if($paymentSettings->transfer_instructions)
                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid rgba(59, 130, 246, 0.2);">
                        <strong style="color: var(--sms-gray-900); display: block; margin-bottom: 0.875rem; font-size: 1rem;">Payment Instructions:</strong>
                        <p style="margin: 0; font-size: 0.9375rem; line-height: 1.7; color: var(--sms-gray-700); background: white; padding: 1.25rem; border-radius: 12px; border-left: 4px solid var(--sms-blue-500);">{{ $paymentSettings->transfer_instructions }}</p>
                    </div>
                @endif
                <div style="margin-top: 1.5rem; padding: 1.25rem; background: #fef3c7; border-radius: 12px; border-left: 4px solid #f59e0b;">
                    <p style="margin: 0; font-size: 0.9375rem; color: #92400e; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-info-circle" style="font-size: 1.125rem;"></i>
                        After making the transfer, please upload the proof of payment below and submit for admin approval.
                    </p>
                </div>
            </div>
        @else
            <div style="padding: 1.75rem; background: #fef3c7; border-radius: 12px; margin-bottom: 1.75rem; border-left: 4px solid #f59e0b;">
                <p style="margin: 0; color: #92400e; font-weight: 600; display: flex; align-items: center; gap: 0.75rem; font-size: 0.9375rem;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 1.25rem;"></i>
                    Bank details not configured. Please contact the school administrator for bank account information before making payment.
                </p>
            </div>
        @endif

        <form id="manualTransferForm" method="POST" action="{{ route('sms.parent.fees.manual-transfer') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="student_fee_id" id="manual_student_fee_id">
            
            <div class="form-group">
                <label class="form-label">Amount (₦)</label>
                <input type="number" name="amount" id="manual_amount" class="form-control" step="0.01" min="0.01" required readonly>
                <small style="color: var(--sms-gray-500); margin-top: 0.5rem; display: block;">Balance: ₦<span id="manual_balance">0.00</span></small>
            </div>

            <div class="form-group">
                <label class="form-label">Transaction Reference</label>
                <input type="text" name="transaction_reference" class="form-control" placeholder="Enter transaction reference from bank">
            </div>

            <div class="form-group">
                <label class="form-label">Your Bank Name (Optional)</label>
                <input type="text" name="bank_name" class="form-control" placeholder="e.g., Access Bank">
            </div>

            <div class="form-group">
                <label class="form-label">Payment Proof (Image/PDF)</label>
                <input type="file" name="proof_document" class="form-control" accept="image/*,.pdf" required>
                <small style="color: var(--sms-gray-500); margin-top: 0.5rem; display: block;">Upload screenshot or PDF of transfer confirmation (Max 5MB)</small>
            </div>

            <div class="form-group">
                <label class="form-label">Notes (Optional)</label>
                <textarea name="notes" class="form-control" rows="3" placeholder="Any additional information..."></textarea>
            </div>

            <div class="payment-buttons" style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Submit Transfer Proof</button>
                <button type="button" class="btn btn-outline" onclick="closeManualTransferModal()" style="flex: 1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
// Store child fee IDs for payment processing
let currentChildFeeIds = [];

function openPaymentMethodModalForChild(studentId, balance, totalAmount, feeIds) {
    try {
        // Handle feeIds - could be array, string, or single number
        if (typeof feeIds === 'string') {
            try {
                currentChildFeeIds = JSON.parse(feeIds);
            } catch (e) {
                const matches = feeIds.match(/\d+/g);
                currentChildFeeIds = matches ? matches.map(Number) : [parseInt(feeIds)];
            }
        } else if (Array.isArray(feeIds)) {
            currentChildFeeIds = feeIds;
        } else {
            currentChildFeeIds = [feeIds];
        }
        
        let firstFeeId = feeIds;
        if (Array.isArray(feeIds) && feeIds.length > 0) {
            firstFeeId = feeIds[0];
        } else if (currentChildFeeIds.length > 0) {
            firstFeeId = currentChildFeeIds[0];
        }
        
        if (typeof firstFeeId === 'string' && firstFeeId.startsWith('virtual_')) {
            openPaymentMethodModal(firstFeeId, balance, totalAmount);
        } else {
            const numericId = parseInt(firstFeeId);
            if (!isNaN(numericId)) {
                openPaymentMethodModal(numericId, balance, totalAmount);
            } else {
                console.error('Invalid fee ID:', firstFeeId);
                alert('Invalid fee information. Please refresh the page.');
            }
        }
    } catch (error) {
        console.error('Error opening payment modal:', error);
        alert('Error opening payment modal. Please refresh the page and try again.');
    }
}

function openPaymentMethodModal(studentFeeId, balance, totalAmount) {
    try {
        console.log('Opening payment method modal:', studentFeeId, balance, totalAmount);
        const modal = document.getElementById('paymentMethodModal');
        const feeIdInput = document.getElementById('method_student_fee_id');
        const balanceInput = document.getElementById('method_balance');
        const amountInput = document.getElementById('method_amount');
        
        if (!modal) {
            console.error('Modal element not found!');
            alert('Payment modal not found. Please refresh the page.');
            return;
        }
        
        if (feeIdInput) feeIdInput.value = studentFeeId || '';
        if (balanceInput) balanceInput.value = balance || 0;
        if (amountInput) amountInput.value = totalAmount || 0;
        
        modal.classList.add('active');
        console.log('Modal opened successfully');
    } catch (error) {
        console.error('Error in openPaymentMethodModal:', error);
        alert('Error opening payment options. Please try again.');
    }
}

function closePaymentMethodModal() {
    const modal = document.getElementById('paymentMethodModal');
    if (modal) {
        modal.classList.remove('active');
    }
}

function selectPaymentMethod(method) {
    const studentFeeId = document.getElementById('method_student_fee_id').value;
    const balance = parseFloat(document.getElementById('method_balance').value);
    const totalAmount = parseFloat(document.getElementById('method_amount').value);
    
    closePaymentMethodModal();
    
    if (method === 'online') {
        openOnlinePaymentModal(studentFeeId, balance, totalAmount);
    } else if (method === 'manual') {
        openManualTransferModal(studentFeeId, balance);
    }
}

function openOnlinePaymentModal(studentFeeId, balance, totalAmount) {
    document.getElementById('online_student_fee_id').value = studentFeeId;
    document.getElementById('online_amount').value = balance;
    document.getElementById('online_balance').textContent = balance.toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    document.getElementById('onlinePaymentModal').classList.add('active');
}

function closeOnlinePaymentModal() {
    document.getElementById('onlinePaymentModal').classList.remove('active');
    const studentFeeId = document.getElementById('online_student_fee_id').value;
    const balance = parseFloat(document.getElementById('online_balance').textContent.replace(/,/g, ''));
    const totalAmount = parseFloat(document.getElementById('method_amount').value);
    if (studentFeeId && balance) {
        openPaymentMethodModal(studentFeeId, balance, totalAmount);
    }
}

function updateOnlineAmount() {
    const type = document.getElementById('online_payment_type_select').value;
    const balance = parseFloat(document.getElementById('online_balance').textContent.replace(/,/g, ''));
    const amountInput = document.getElementById('online_amount');
    
    if (type === 'full') {
        amountInput.value = balance;
        amountInput.readOnly = true;
    } else {
        amountInput.value = '';
        amountInput.readOnly = false;
        amountInput.min = 0.01;
        amountInput.max = balance;
    }
}

function openManualTransferModal(studentFeeId, balance) {
    document.getElementById('manual_student_fee_id').value = studentFeeId;
    document.getElementById('manual_amount').value = balance;
    document.getElementById('manual_balance').textContent = balance.toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    document.getElementById('manualTransferModal').classList.add('active');
}

function closeManualTransferModal() {
    document.getElementById('manualTransferModal').classList.remove('active');
    const studentFeeId = document.getElementById('manual_student_fee_id').value;
    const balance = parseFloat(document.getElementById('manual_balance').textContent.replace(/,/g, ''));
    const totalAmount = parseFloat(document.getElementById('method_amount').value);
    if (studentFeeId && balance) {
        openPaymentMethodModal(studentFeeId, balance, totalAmount);
    }
}

// Close modals on outside click
document.getElementById('paymentMethodModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePaymentMethodModal();
    }
});
document.getElementById('onlinePaymentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeOnlinePaymentModal();
    }
});
document.getElementById('manualTransferModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeManualTransferModal();
    }
});

// Handle Make Payment button clicks using event delegation
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        if (e.target.closest('.make-payment-btn')) {
            const button = e.target.closest('.make-payment-btn');
            const studentId = button.getAttribute('data-student-id');
            const balance = parseFloat(button.getAttribute('data-balance'));
            const totalAmount = parseFloat(button.getAttribute('data-total-amount'));
            const feeIdsStr = button.getAttribute('data-fee-ids');
            const virtualFeeIdsStr = button.getAttribute('data-fee-ids-virtual');
            const hasVirtualFees = button.getAttribute('data-has-virtual-fees') === 'true';
            
            // Parse fee IDs from comma-separated string (real StudentFee IDs)
            let feeIds = [];
            if (feeIdsStr && feeIdsStr.trim()) {
                feeIds = feeIdsStr.split(',').map(id => {
                    const trimmed = id.trim();
                    if (trimmed.startsWith('virtual_')) {
                        return trimmed;
                    }
                    const parsed = parseInt(trimmed);
                    return !isNaN(parsed) ? parsed : null;
                }).filter(id => id !== null);
            }
            
            // If no real fee IDs, check for virtual fees (from SmsFee table)
            if (feeIds.length === 0 && virtualFeeIdsStr && virtualFeeIdsStr.trim()) {
                const virtualFeeIds = virtualFeeIdsStr.split(',').map(id => parseInt(id.trim())).filter(id => !isNaN(id));
                if (virtualFeeIds.length > 0) {
                    feeIds = ['virtual_' + studentId + '_' + virtualFeeIds[0]];
                }
            }
            
            // Additional check: if we have a balance but no fee IDs, try to find fees from child fees list
            if (feeIds.length === 0 && balance > 0) {
                console.warn('No fee IDs found but balance > 0, attempting to find fees from page data', {
                    studentId: studentId,
                    balance: balance,
                    feeIdsStr: feeIdsStr,
                    virtualFeeIdsStr: virtualFeeIdsStr
                });
                
                const studentSection = button.closest('.fee-item');
                if (studentSection) {
                    const feeItems = studentSection.querySelectorAll('[data-fee-id]');
                    if (feeItems.length > 0) {
                        const firstFeeId = feeItems[0].getAttribute('data-fee-id');
                        if (firstFeeId) {
                            feeIds = ['virtual_' + studentId + '_' + firstFeeId];
                            console.log('Found fee ID from DOM:', feeIds);
                        }
                    }
                }
            }
            
            if (feeIds.length > 0) {
                openPaymentMethodModalForChild(studentId, balance, totalAmount, feeIds);
            } else {
                console.error('Payment button clicked but no fee IDs found', {
                    studentId: studentId,
                    balance: balance,
                    totalAmount: totalAmount,
                    feeIdsStr: feeIdsStr,
                    virtualFeeIdsStr: virtualFeeIdsStr,
                    hasVirtualFees: hasVirtualFees,
                    buttonHTML: button.outerHTML.substring(0, 200)
                });
                alert('No fees found for payment. Please contact the school administrator if you believe this is an error.');
            }
        }
    });
});
</script>
@endsection
