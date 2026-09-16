@extends('layouts.admin')

@section('title', 'Edit Fee Structure - School Management System')
@section('page-title', 'Edit Fee Structure')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        padding: 1.25rem;
        max-width: 800px;
        margin: 0 auto;
    }
    .sms-form-group {
        margin-bottom: 1.25rem;
    }
    .sms-form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--sms-gray-700);
        margin-bottom: 0.5rem;
    }
    .sms-form-label .required {
        color: #dc2626;
    }
    .sms-form-input,
    .sms-form-select {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.2s;
        background: white;
        min-height: 44px;
        touch-action: manipulation;
    }
    .sms-form-input:focus,
    .sms-form-select:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .sms-form-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }
    .sms-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 1.5rem;
        font-size: 0.9375rem;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        min-height: 44px;
        touch-action: manipulation;
        width: 100%;
    }
    .sms-btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
    }
    .sms-btn-primary:active {
        transform: scale(0.98);
        box-shadow: 0 1px 4px rgba(99, 102, 241, 0.3);
    }
    .sms-btn-secondary {
        background: white;
        color: var(--sms-gray-700);
        border: 1px solid var(--sms-gray-300);
    }
    .sms-btn-secondary:active {
        transform: scale(0.98);
        background: var(--sms-gray-50);
    }
    .form-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--sms-gray-200);
    }
    .checkbox-group {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.75rem;
        background: var(--sms-gray-50);
        border-radius: 8px;
    }
    .checkbox-group input[type="checkbox"] {
        width: 20px;
        height: 20px;
        min-width: 20px;
        min-height: 20px;
        margin-top: 0.125rem;
        cursor: pointer;
        touch-action: manipulation;
    }
    .checkbox-group label {
        flex: 1;
        margin: 0;
        cursor: pointer;
        font-weight: 500;
        line-height: 1.5;
    }
    
    @media (min-width: 640px) {
        .sms-form-card {
            padding: 2rem;
            border-radius: 16px;
        }
        
        .sms-form-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .form-actions {
            flex-direction: row;
            justify-content: flex-end;
            gap: 1rem;
        }
        
        .sms-btn {
            width: auto;
            padding: 0.625rem 1.25rem;
        }
    }
</style>

<div class="sms-form-card">
    <form action="{{ route('school.fees.update', $fee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="sms-form-group">
            <label class="sms-form-label">
                Fee Name <span class="required">*</span>
            </label>
            <input type="text" 
                   name="name" 
                   class="sms-form-input" 
                   value="{{ old('name', $fee->name) }}" 
                   required 
                   placeholder="e.g., Tuition Fee, Development Fee">
            @error('name')
                <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <div class="sms-form-row">
            <div class="sms-form-group">
                <label class="sms-form-label">
                    Class <span class="required">*</span>
                </label>
                <select name="class_id" class="sms-form-select" required>
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id', $fee->class_id) == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
                @error('class_id')
                    <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="sms-form-group">
                <label class="sms-form-label">
                    Amount (₦) <span class="required">*</span>
                </label>
                <input type="number" 
                       name="amount" 
                       class="sms-form-input" 
                       value="{{ old('amount', $fee->amount) }}" 
                       required 
                       step="0.01" 
                       min="0" 
                       placeholder="0.00">
                @error('amount')
                    <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="sms-form-row">
            <div class="sms-form-group">
                <label class="sms-form-label">
                    Due Date <span class="required">*</span>
                </label>
                <input type="date" 
                       name="due_date" 
                       class="sms-form-input" 
                       value="{{ old('due_date', $fee->due_date ? \Carbon\Carbon::parse($fee->due_date)->format('Y-m-d') : '') }}" 
                       required>
                @error('due_date')
                    <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="sms-form-group">
                <label class="sms-form-label">
                    Academic Year <span class="required">*</span>
                </label>
                <input type="text" 
                       name="academic_year" 
                       class="sms-form-input" 
                       value="{{ old('academic_year', $fee->academic_year) }}" 
                       required 
                       placeholder="e.g., 2026">
                @error('academic_year')
                    <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="sms-form-group">
            <div class="checkbox-group">
                <input type="checkbox" 
                       name="is_active" 
                       id="is_active" 
                       value="1" 
                       {{ old('is_active', $fee->is_active) ? 'checked' : '' }}
                       style="width: auto; margin: 0;">
                <label for="is_active" class="sms-form-label" style="margin: 0; cursor: pointer;">
                    Active (Fee structure is currently active and visible to students/parents)
                </label>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('school.fees.index') }}" class="sms-btn sms-btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
            <button type="submit" class="sms-btn sms-btn-primary">
                <i class="fas fa-save"></i> Update Fee Structure
            </button>
        </div>
    </form>
</div>

<script>
    // Handle custom fee name input
    document.getElementById('fee-name-select')?.addEventListener('change', function() {
        const customInput = document.getElementById('custom-fee-input');
        if (this.value === 'Other') {
            customInput.style.display = 'block';
            customInput.required = true;
        } else {
            customInput.style.display = 'none';
            customInput.required = false;
        }
    });
</script>
@endsection
