@extends('layouts.admin')

@section('page-title', 'Student Fees Management')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
        padding: 2rem 0;
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
        font-size: 1rem;
    }
    
    .sms-card {
        background: white;
        border-radius: var(--sms-radius-lg);
        box-shadow: var(--sms-shadow);
        border: 1px solid var(--sms-gray-200);
        padding: 0;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .card-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--sms-gray-200);
        background: var(--sms-gray-50);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filters-card {
        background: white;
        border-radius: var(--sms-radius-lg);
        box-shadow: var(--sms-shadow);
        border: 1px solid var(--sms-gray-200);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
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
    
    .filter-input,
    .filter-select {
        padding: 0.75rem;
        border: 2px solid var(--sms-gray-200);
        border-radius: var(--sms-radius);
        font-size: 0.9375rem;
        background: white;
        transition: all 0.2s;
        min-height: 44px;
        font-family: inherit;
    }
    
    .filter-input:focus,
    .filter-select:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
    }
    
    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1000px;
    }
    
    .data-table thead {
        background: var(--sms-gray-50);
    }
    
    .data-table th {
        padding: 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--sms-gray-700);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid var(--sms-gray-200);
        white-space: nowrap;
    }
    
    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        font-size: 0.9375rem;
        color: var(--sms-gray-800);
    }
    
    .data-table tbody tr {
        transition: background 0.15s;
    }
    
    .data-table tbody tr:hover {
        background: var(--sms-gray-50);
    }
    
    .student-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--sms-gray-200);
        flex-shrink: 0;
    }
    
    .student-name {
        font-weight: 600;
        color: var(--sms-gray-900);
    }
    
    .progress-bar-container {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 150px;
    }
    
    .progress-bar {
        flex: 1;
        height: 8px;
        background: var(--sms-gray-200);
        border-radius: 4px;
        overflow: hidden;
        min-width: 80px;
    }
    
    .progress-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.3s ease;
    }
    
    .progress-fill.success {
        background: linear-gradient(90deg, #059669, #10b981);
    }
    
    .progress-fill.warning {
        background: linear-gradient(90deg, #f59e0b, #fbbf24);
    }
    
    .progress-fill.danger {
        background: linear-gradient(90deg, #dc2626, #ef4444);
    }
    
    .progress-text {
        font-size: 0.8125rem;
        font-weight: 600;
        min-width: 50px;
        text-align: right;
    }
    
    .amount-cell {
        font-weight: 600;
        font-size: 0.9375rem;
    }
    
    .amount-paid {
        color: #059669;
    }
    
    .amount-balance {
        font-weight: 600;
    }
    
    .amount-balance.positive {
        color: #dc2626;
    }
    
    .amount-balance.zero {
        color: #059669;
    }
    
    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: var(--sms-radius);
        font-weight: 600;
        font-size: 0.8125rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        white-space: nowrap;
    }
    
    .btn-action-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        box-shadow: var(--sms-shadow-sm);
    }
    
    .btn-action-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--sms-shadow-md);
    }
    
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    
    .modal-overlay.active {
        display: flex;
    }
    
    .modal-content {
        background: white;
        border-radius: var(--sms-radius-lg);
        width: 100%;
        max-width: 500px;
        max-height: 90vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: var(--sms-shadow-xl);
    }
    
    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--sms-gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--sms-gray-50);
    }
    
    .modal-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    
    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: var(--sms-gray-500);
        cursor: pointer;
        padding: 0.5rem;
        min-width: 44px;
        min-height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--sms-radius);
        transition: all 0.2s;
    }
    
    .modal-close:hover {
        background: var(--sms-gray-100);
        color: var(--sms-gray-700);
    }
    
    .modal-body {
        padding: 1.5rem;
        overflow-y: auto;
        flex: 1;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--sms-gray-700);
        font-size: 0.875rem;
    }
    
    .form-input,
    .form-select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid var(--sms-gray-200);
        border-radius: var(--sms-radius);
        font-size: 0.9375rem;
        transition: all 0.2s;
        min-height: 44px;
        font-family: inherit;
    }
    
    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
    }
    
    .form-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }
    
    .btn {
        flex: 1;
        padding: 0.75rem 1.5rem;
        border-radius: var(--sms-radius);
        font-weight: 600;
        font-size: 0.9375rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .btn-secondary {
        background: white;
        color: var(--sms-gray-700);
        border: 2px solid var(--sms-gray-300);
    }
    
    .btn-secondary:hover {
        background: var(--sms-gray-50);
        border-color: var(--sms-gray-400);
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
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--sms-gray-500);
    }
    
    .empty-state-icon {
        font-size: 3rem;
        color: var(--sms-gray-300);
        margin-bottom: 1rem;
    }
    
    @media (max-width: 768px) {
        .sms-page {
            padding: 1rem 0;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .filters-grid {
            grid-template-columns: 1fr;
        }
        
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .data-table {
            min-width: 800px;
        }
        
        .data-table th,
        .data-table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8125rem;
        }
        
        .student-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .progress-bar-container {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .modal-content {
            max-width: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
    }
    
    @media (max-width: 480px) {
        .page-title {
            font-size: 1.25rem;
        }
        
        .filters-card,
        .card-header {
            padding: 1rem;
        }
        
        .data-table th,
        .data-table td {
            padding: 0.5rem;
            font-size: 0.75rem;
        }
    }
</style>

<div class="sms-page">
    <div class="container-fluid">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-money-bill-wave" style="color: var(--sms-primary);"></i>
                Student Fees Management
            </h1>
            <p class="page-subtitle">Manage student fees and record manual payments</p>
        </div>

        @if(session('success'))
            <div class="sms-alert sms-alert-success" style="margin-bottom: 1.5rem;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="sms-alert sms-alert-danger" style="margin-bottom: 1.5rem;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="filters-card">
            <div class="filters-grid">
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-search"></i> Search
                    </label>
                    <input type="text" id="searchInput" placeholder="Search by student name or ID..." class="filter-input">
                </div>
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-users"></i> Class
                    </label>
                    <select id="classFilter" class="filter-select">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-filter"></i> Status
                    </label>
                    <select id="statusFilter" class="filter-select">
                        <option value="">All Status</option>
                        <option value="cleared">Can Write Exams</option>
                        <option value="pending">Pending Payment</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Students Table -->
        <div class="sms-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-list"></i>
                    Students Fee Status
                    <span style="font-size: 0.875rem; font-weight: 500; color: var(--sms-gray-600); margin-left: 0.5rem;">
                        ({{ $studentsWithFees->count() }})
                    </span>
                </h2>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Student ID</th>
                            <th>Class</th>
                            <th>Total Fees</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>% Paid</th>
                            <th>Exam Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentsTable">
                        @forelse($studentsWithFees as $item)
                        <tr data-name="{{ strtolower($item['student']->user->name ?? '') }}" 
                            data-id="{{ strtolower($item['student']->student_id_number) }}"
                            data-class="{{ $item['student']->class_id }}"
                            data-status="{{ $item['canWriteExams'] ? 'cleared' : 'pending' }}">
                            <td>
                                <div class="student-info">
                                    @if($item['student']->photo)
                                        <img src="{{ asset('storage/' . $item['student']->photo) }}" 
                                             alt="Photo" 
                                             class="student-avatar"
                                             onerror="this.style.display='none';">
                                    @else
                                        <div class="student-avatar" style="background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                            {{ strtoupper(substr($item['student']->user->name ?? 'N', 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="student-name">{{ $item['student']->user->name ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><strong>{{ $item['student']->student_id_number }}</strong></td>
                            <td>
                                @if($item['student']->class)
                                    <span class="sms-badge sms-badge-primary">{{ $item['student']->class->name }}</span>
                                @else
                                    <span style="color: var(--sms-gray-400);">Not Assigned</span>
                                @endif
                            </td>
                            <td class="amount-cell">₦{{ number_format($item['totalFees'], 2) }}</td>
                            <td class="amount-cell amount-paid">₦{{ number_format($item['totalPaid'], 2) }}</td>
                            <td class="amount-cell amount-balance {{ $item['totalBalance'] > 0 ? 'positive' : 'zero' }}">
                                ₦{{ number_format($item['totalBalance'], 2) }}
                            </td>
                            <td>
                                <div class="progress-bar-container">
                                    <div class="progress-bar">
                                        <div class="progress-fill {{ $item['percentagePaid'] >= 50 ? 'success' : ($item['percentagePaid'] > 0 ? 'warning' : 'danger') }}" 
                                             style="width: {{ min($item['percentagePaid'], 100) }}%;"></div>
                                    </div>
                                    <span class="progress-text">{{ number_format($item['percentagePaid'], 1) }}%</span>
                                </div>
                            </td>
                            <td>
                                @if($item['canWriteExams'])
                                    <span class="sms-badge sms-badge-success">
                                        <i class="fas fa-check-circle"></i> Cleared
                                    </span>
                                @else
                                    <span class="sms-badge sms-badge-danger">
                                        <i class="fas fa-times-circle"></i> Blocked
                                    </span>
                                @endif
                            </td>
                            <td>
                                <button onclick="openPaymentModal({{ $item['student']->id }}, '{{ addslashes($item['student']->user->name ?? 'N/A') }}', {{ json_encode($item['applicableFees']->values()) }})" 
                                        class="btn-action btn-action-primary">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <span class="d-none d-md-inline">Record Payment</span>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <div style="font-size: 1rem; font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.5rem;">No students found</div>
                                <div>No active students with fee records found.</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="modal-overlay" onclick="if(event.target === this) closePaymentModal()">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fas fa-money-bill-wave" style="color: var(--sms-primary); margin-right: 0.5rem;"></i>
                Record Payment
            </h3>
            <button onclick="closePaymentModal()" class="modal-close" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="paymentForm" action="{{ route('school.fees.record-student-payment') }}" method="POST" class="modal-body">
            @csrf
            <input type="hidden" name="student_id" id="modal_student_id">
            
            <div class="form-group">
                <label class="form-label">Student</label>
                <input type="text" id="modal_student_name" class="form-input" readonly>
            </div>

            <div class="form-group">
                <label class="form-label">Fee Type <span style="color: #dc2626;">*</span></label>
                <select name="fee_id" id="modal_fee_id" class="form-select" required>
                    <option value="">Select Fee</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Amount Paid (₦) <span style="color: #dc2626;">*</span></label>
                <input type="number" name="amount_paid" step="0.01" min="0.01" class="form-input" required placeholder="0.00">
            </div>

            <div class="form-group">
                <label class="form-label">Payment Date <span style="color: #dc2626;">*</span></label>
                <input type="date" name="payment_date" class="form-input" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Payment Method <span style="color: #dc2626;">*</span></label>
                <select name="payment_method" class="form-select" required>
                    <option value="cash" selected>Cash</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="card">Card</option>
                    <option value="cheque">Cheque</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Transaction ID (Optional)</label>
                <input type="text" name="transaction_id" class="form-input" placeholder="Enter transaction reference">
            </div>

            <div class="form-group">
                <label class="form-label">Remarks (Optional)</label>
                <textarea name="remarks" class="form-input" rows="3" placeholder="Additional notes..."></textarea>
            </div>

            <div class="form-actions">
                <button type="button" onclick="closePaymentModal()" class="btn btn-secondary">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Record Payment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openPaymentModal(studentId, studentName, fees) {
        document.getElementById('modal_student_id').value = studentId;
        document.getElementById('modal_student_name').value = studentName;
        
        const feeSelect = document.getElementById('modal_fee_id');
        feeSelect.innerHTML = '<option value="">Select Fee</option>';
        
        fees.forEach(fee => {
            const option = document.createElement('option');
            option.value = fee.id;
            option.textContent = `${fee.name} - ₦${parseFloat(fee.amount).toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            feeSelect.appendChild(option);
        });
        
        document.getElementById('paymentModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.remove('active');
        document.getElementById('paymentForm').reset();
        document.body.style.overflow = '';
    }

    // Search and filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const classFilter = document.getElementById('classFilter');
        const statusFilter = document.getElementById('statusFilter');
        const tableBody = document.getElementById('studentsTable');
        const rows = tableBody.querySelectorAll('tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const selectedClass = classFilter.value;
            const selectedStatus = statusFilter.value;
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.getAttribute('data-name') || '';
                const id = row.getAttribute('data-id') || '';
                const classId = row.getAttribute('data-class') || '';
                const status = row.getAttribute('data-status') || '';

                const matchesSearch = name.includes(searchTerm) || id.includes(searchTerm);
                const matchesClass = !selectedClass || classId === selectedClass;
                const matchesStatus = !selectedStatus || status === selectedStatus;

                if (matchesSearch && matchesClass && matchesStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterTable);
        classFilter.addEventListener('change', filterTable);
        statusFilter.addEventListener('change', filterTable);
    });
</script>
@endsection
