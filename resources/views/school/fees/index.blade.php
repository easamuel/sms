@extends('layouts.admin')

@section('title', 'Fees Management - School Management System')
@section('page-title', 'Fees Management')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
    }
    .sms-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .sms-card-header {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
    }
    .sms-card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .sms-table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .sms-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
    }
    .sms-table thead {
        background: var(--sms-gray-50);
    }
    .sms-table th {
        padding: 0.75rem 0.75rem;
        text-align: left;
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--sms-gray-700);
        border-bottom: 2px solid var(--sms-gray-200);
        white-space: nowrap;
    }
    .sms-table td {
        padding: 0.75rem 0.75rem;
        border-bottom: 1px solid var(--sms-gray-200);
        font-size: 0.875rem;
        color: var(--sms-gray-700);
    }
    .sms-table tbody tr:hover {
        background: var(--sms-gray-50);
    }
    
    @media (min-width: 640px) {
        .sms-card {
            padding: 1.5rem;
        }
        
        .sms-card-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        
        .sms-card-title {
            font-size: 1.25rem;
        }
        
        .sms-table th,
        .sms-table td {
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
        }
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
    .sms-form-group {
        margin-bottom: 1rem;
    }
    .sms-form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--sms-gray-700);
        margin-bottom: 0.5rem;
    }
    .sms-form-input,
    .sms-form-select {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.2s;
        min-height: 44px;
        touch-action: manipulation;
    }
    .sms-form-input:focus,
    .sms-form-select:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .sms-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        font-size: 0.9375rem;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }
    .sms-btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
    }
    .sms-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }
    .sms-btn-secondary {
        background: white;
        color: var(--sms-gray-700);
        border: 1px solid var(--sms-gray-300);
    }
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    .classes-checkbox-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 0.75rem;
    }
    .class-checkbox-label:hover {
        background: rgba(255,255,255,0.2) !important;
    }
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
        .sms-card {
            padding: 1rem;
        }
        .sms-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        .classes-checkbox-grid {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 0.5rem;
            padding: 0.75rem !important;
        }
        .class-checkbox-label {
            padding: 0.375rem !important;
            font-size: 0.8125rem !important;
        }
        .sms-form-group {
            margin-bottom: 1rem;
        }
    }
    @media (max-width: 480px) {
        .classes-checkbox-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .sms-card {
            padding: 0.75rem;
        }
    }
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--sms-gray-500);
    }
    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
</style>

<div>
    <!-- Bulk Create Fee Structure -->
    <div class="sms-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; margin-bottom: 1.5rem;">
        <div class="sms-card-header" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.2);">
            <h3 class="sms-card-title" style="color: white;">
                <i class="fas fa-layer-group"></i> Bulk Create Fee Structure
            </h3>
        </div>
        <div style="color: white; padding: 1.5rem;">
            <p style="margin-bottom: 1.5rem; opacity: 0.95;">
                Create the same fee structure for multiple classes at once. Perfect for setting up Tuition Fees, Development Fees, etc. across all classes.
            </p>
            <form action="{{ route('school.fees.bulk-create') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="sms-form-group">
                        <label class="sms-form-label" style="color: white;">Fee Name <span style="color: #fee2e2;">*</span></label>
                        <select name="fee_name" class="sms-form-select" required style="background: white;">
                            <option value="">Select Fee Type</option>
                            <option value="Tuition Fee">Tuition Fee</option>
                            <option value="Development Fee">Development Fee</option>
                            <option value="Library Fee">Library Fee</option>
                            <option value="Laboratory Fee">Laboratory Fee</option>
                            <option value="Sports Fee">Sports Fee</option>
                            <option value="Computer Fee">Computer Fee</option>
                            <option value="Examination Fee">Examination Fee</option>
                            <option value="PTA Levy">PTA Levy</option>
                            <option value="Medical Fee">Medical Fee</option>
                            <option value="Uniform Fee">Uniform Fee</option>
                            <option value="Textbook Fee">Textbook Fee</option>
                            <option value="Other">Other (Specify)</option>
                        </select>
                        <input type="text" name="fee_name_custom" class="sms-form-input" style="margin-top: 0.5rem; background: white; display: none;" placeholder="Enter custom fee name" id="custom-fee-name">
                    </div>
                    <div class="sms-form-group">
                        <label class="sms-form-label" style="color: white;">Amount (₦) <span style="color: #fee2e2;">*</span></label>
                        <input type="number" name="amount" class="sms-form-input" required step="0.01" min="0" placeholder="0.00" style="background: white;">
                    </div>
                    <div class="sms-form-group">
                        <label class="sms-form-label" style="color: white;">Due Date <span style="color: #fee2e2;">*</span></label>
                        <input type="date" name="due_date" class="sms-form-input" required style="background: white;">
                    </div>
                    <div class="sms-form-group">
                        <label class="sms-form-label" style="color: white;">Academic Year <span style="color: #fee2e2;">*</span></label>
                        <input type="text" name="academic_year" class="sms-form-input" value="{{ date('Y') }}" required placeholder="e.g., 2026" style="background: white;">
                    </div>
                </div>
                <div class="sms-form-group" style="margin-top: 1rem;">
                    <label class="sms-form-label" style="color: white;">Select Classes <span style="color: #fee2e2;">*</span></label>
                    <div class="classes-checkbox-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 0.75rem; max-height: 200px; overflow-y: auto; padding: 1rem; background: rgba(255,255,255,0.1); border-radius: 8px;">
                        @foreach($classes as $class)
                            <label class="class-checkbox-label" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; cursor: pointer; border-radius: 6px; background: rgba(255,255,255,0.1); transition: background 0.2s;">
                                <input type="checkbox" name="class_ids[]" value="{{ $class->id }}" style="margin: 0; cursor: pointer; width: auto;">
                                <span style="font-size: 0.875rem; color: white;">{{ $class->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div style="margin-top: 0.5rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <button type="button" onclick="selectAllClasses()" class="sms-btn" style="background: rgba(255,255,255,0.2); color: white; padding: 0.5rem 1rem; font-size: 0.8125rem;">
                            Select All
                        </button>
                        <button type="button" onclick="clearAllClasses()" class="sms-btn" style="background: rgba(255,255,255,0.2); color: white; padding: 0.5rem 1rem; font-size: 0.8125rem;">
                            Clear All
                        </button>
                    </div>
                </div>
                <div style="margin-top: 1.5rem;">
                    <button type="submit" class="sms-btn" style="background: white; color: #059669; font-weight: 700; padding: 0.75rem 1.5rem;">
                        <i class="fas fa-layer-group"></i> Create for Selected Classes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Create Single Fee Form -->
    <div class="sms-card">
        <div class="sms-card-header">
            <h3 class="sms-card-title">Create Single Fee Structure</h3>
        </div>
        <form action="{{ route('school.fees.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="sms-form-group">
                    <label class="sms-form-label">Fee Name <span style="color: #dc2626;">*</span></label>
                    <select name="name" class="sms-form-select" required id="fee-name-select" onchange="handleFeeNameChange(this)">
                        <option value="">Select Fee Type</option>
                        <option value="Tuition Fee" {{ old('name') == 'Tuition Fee' ? 'selected' : '' }}>Tuition Fee</option>
                        <option value="Development Fee" {{ old('name') == 'Development Fee' ? 'selected' : '' }}>Development Fee</option>
                        <option value="Library Fee" {{ old('name') == 'Library Fee' ? 'selected' : '' }}>Library Fee</option>
                        <option value="Laboratory Fee" {{ old('name') == 'Laboratory Fee' ? 'selected' : '' }}>Laboratory Fee</option>
                        <option value="Sports Fee" {{ old('name') == 'Sports Fee' ? 'selected' : '' }}>Sports Fee</option>
                        <option value="Computer Fee" {{ old('name') == 'Computer Fee' ? 'selected' : '' }}>Computer Fee</option>
                        <option value="Examination Fee" {{ old('name') == 'Examination Fee' ? 'selected' : '' }}>Examination Fee</option>
                        <option value="PTA Levy" {{ old('name') == 'PTA Levy' ? 'selected' : '' }}>PTA Levy</option>
                        <option value="Medical Fee" {{ old('name') == 'Medical Fee' ? 'selected' : '' }}>Medical Fee</option>
                        <option value="Uniform Fee" {{ old('name') == 'Uniform Fee' ? 'selected' : '' }}>Uniform Fee</option>
                        <option value="Textbook Fee" {{ old('name') == 'Textbook Fee' ? 'selected' : '' }}>Textbook Fee</option>
                        <option value="Other" {{ old('name') == 'Other' ? 'selected' : '' }}>Other (Specify)</option>
                    </select>
                    <input type="text" name="name" id="custom-fee-input" class="sms-form-input" value="{{ old('name') }}" style="margin-top: 0.5rem; display: none;" placeholder="Enter custom fee name">
                    @error('name')
                        <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="sms-form-group">
                    <label class="sms-form-label">Class <span style="color: #dc2626;">*</span></label>
                    <select name="class_id" class="sms-form-select" required>
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="sms-form-group">
                    <label class="sms-form-label">Amount (₦) <span style="color: #dc2626;">*</span></label>
                    <input type="number" name="amount" class="sms-form-input" value="{{ old('amount') }}" required step="0.01" min="0" placeholder="0.00">
                    @error('amount')
                        <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="sms-form-group">
                    <label class="sms-form-label">Due Date <span style="color: #dc2626;">*</span></label>
                    <input type="date" name="due_date" class="sms-form-input" value="{{ old('due_date') }}" required>
                    @error('due_date')
                        <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="sms-form-group">
                    <label class="sms-form-label">Academic Year <span style="color: #dc2626;">*</span></label>
                    <input type="text" name="academic_year" class="sms-form-input" value="{{ old('academic_year', date('Y')) }}" required placeholder="e.g., 2026">
                    @error('academic_year')
                        <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div style="margin-top: 1.5rem;">
                <button type="submit" class="sms-btn sms-btn-primary">
                    <i class="fas fa-plus"></i> Create Fee Structure
                </button>
            </div>
        </form>
    </div>

    <!-- Fees List (Grouped) -->
    <div class="sms-card">
        <div class="sms-card-header">
            <h3 class="sms-card-title">Fee Structures ({{ $fees->count() }} total)</h3>
        </div>
        @if($groupedFees->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($groupedFees as $feeName => $feeGroup)
                    <div style="border: 1px solid var(--sms-gray-200); border-radius: 8px; overflow: hidden;">
                        <div style="background: var(--sms-gray-50); padding: 0.75rem 1rem; border-bottom: 1px solid var(--sms-gray-200); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                            <div>
                                <h4 style="font-size: 1rem; font-weight: 700; color: var(--sms-gray-900); margin: 0;">
                                    {{ $feeName }}
                                </h4>
                                <span style="font-size: 0.75rem; color: var(--sms-gray-500);">
                                    {{ $feeGroup->count() }} class(es)
                                </span>
                            </div>
                            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                <button type="button" onclick="toggleFeeGroup('{{ md5($feeName) }}')" class="sms-btn sms-btn-secondary" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem;">
                                    <i class="fas fa-chevron-down" id="icon-{{ md5($feeName) }}"></i> <span id="toggle-text-{{ md5($feeName) }}">Show</span>
                                </button>
                            </div>
                        </div>
                        <div id="group-{{ md5($feeName) }}" style="display: none;">
                            <div class="sms-table-wrapper">
                                <table class="sms-table" style="margin: 0;">
                                    <thead>
                                        <tr>
                                            <th style="padding: 0.5rem 0.75rem;">Class</th>
                                            <th style="padding: 0.5rem 0.75rem;">Amount (₦)</th>
                                            <th style="padding: 0.5rem 0.75rem;">Due Date</th>
                                            <th style="padding: 0.5rem 0.75rem;">Year</th>
                                            <th style="padding: 0.5rem 0.75rem;">Status</th>
                                            <th style="padding: 0.5rem 0.75rem;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($feeGroup as $fee)
                                            <tr>
                                                <td style="padding: 0.5rem 0.75rem; font-weight: 600;">{{ $fee->class->name ?? 'N/A' }}</td>
                                                <td style="padding: 0.5rem 0.75rem;">₦{{ number_format($fee->amount, 2) }}</td>
                                                <td style="padding: 0.5rem 0.75rem; font-size: 0.875rem;">{{ \Carbon\Carbon::parse($fee->due_date)->format('M d, Y') }}</td>
                                                <td style="padding: 0.5rem 0.75rem;">{{ $fee->academic_year }}</td>
                                                <td style="padding: 0.5rem 0.75rem;">
                                                    @if($fee->is_active)
                                                        <span class="sms-badge sms-badge-success" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">Active</span>
                                                    @else
                                                        <span class="sms-badge sms-badge-danger" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">Inactive</span>
                                                    @endif
                                                </td>
                                                <td style="padding: 0.5rem 0.75rem;">
                                                    <div style="display: flex; gap: 0.25rem;">
                                                        <a href="{{ route('school.fees.edit', $fee->id) }}" class="sms-btn sms-btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.75rem; text-decoration: none;" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('school.fees.destroy', $fee->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this fee structure?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="sms-btn" style="padding: 0.25rem 0.5rem; font-size: 0.75rem; background: #fee2e2; color: #991b1b; border: none;" title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <p>No fee structures created yet.</p>
                <p style="font-size: 0.875rem; margin-top: 0.5rem;">Create your first fee structure using the form above.</p>
            </div>
        @endif
    </div>

    <!-- Recent Payments -->
    @if($payments->count() > 0)
    <div class="sms-card">
        <div class="sms-card-header">
            <h3 class="sms-card-title">Recent Payments</h3>
        </div>
        <div class="sms-table-wrapper">
            <table class="sms-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Fee</th>
                        <th>Amount Paid (₦)</th>
                        <th>Payment Date</th>
                        <th>Method</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{ $payment->student->user->name ?? 'N/A' }}</td>
                            <td>{{ $payment->fee->name ?? 'N/A' }}</td>
                            <td style="font-weight: 600;">₦{{ number_format($payment->amount_paid, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                            <td>
                                <span class="sms-badge sms-badge-success">{{ ucfirst($payment->payment_method) }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<script>
    // Select all classes
    function selectAllClasses() {
        document.querySelectorAll('input[name="class_ids[]"]').forEach(function(cb) {
            cb.checked = true;
        });
    }

    // Clear all classes
    function clearAllClasses() {
        document.querySelectorAll('input[name="class_ids[]"]').forEach(function(cb) {
            cb.checked = false;
        });
    }

    // Handle custom fee name in bulk form
    document.addEventListener('DOMContentLoaded', function() {
        var bulkFeeSelect = document.querySelector('select[name="fee_name"]');
        if (bulkFeeSelect) {
            bulkFeeSelect.addEventListener('change', function() {
                var customInput = document.getElementById('custom-fee-name');
                if (this.value === 'Other') {
                    customInput.style.display = 'block';
                    customInput.required = true;
                    customInput.name = 'fee_name';
                    this.name = '';
                } else {
                    customInput.style.display = 'none';
                    customInput.required = false;
                    customInput.name = '';
                    this.name = 'fee_name';
                }
            });
        }

        // Handle custom fee name in single form
        var singleFeeSelect = document.getElementById('fee-name-select');
        if (singleFeeSelect) {
            singleFeeSelect.addEventListener('change', function() {
                handleFeeNameChange(this);
            });
        }
    });

    // Handle fee name change for single form
    function handleFeeNameChange(selectElement) {
        var customInput = document.getElementById('custom-fee-input');
        if (selectElement.value === 'Other') {
            customInput.style.display = 'block';
            customInput.required = true;
            customInput.name = 'name';
            selectElement.name = '';
        } else {
            customInput.style.display = 'none';
            customInput.required = false;
            customInput.name = '';
            selectElement.name = 'name';
        }
    }

    // Toggle fee group visibility
    function toggleFeeGroup(groupId) {
        var group = document.getElementById('group-' + groupId);
        var icon = document.getElementById('icon-' + groupId);
        var text = document.getElementById('toggle-text-' + groupId);
        
        if (group.style.display === 'none') {
            group.style.display = 'block';
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
            text.textContent = 'Hide';
        } else {
            group.style.display = 'none';
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
            text.textContent = 'Show';
        }
    }
</script>
@endsection
