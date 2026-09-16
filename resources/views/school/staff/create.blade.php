@extends('layouts.admin')

@section('title', 'Add New Teacher - School Management System')
@section('page-title', 'Add New Teacher')

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
    .form-help-text {
        font-size: 0.8125rem;
        color: var(--sms-gray-500);
        margin-top: 0.25rem;
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
    <form action="{{ route('school.staff.store') }}" method="POST">
        @csrf

        <div class="sms-form-group">
            <label class="sms-form-label">
                Full Name <span class="required">*</span>
            </label>
            <input type="text" 
                   name="name" 
                   class="sms-form-input" 
                   value="{{ old('name') }}" 
                   required 
                   placeholder="Enter teacher's full name">
            @error('name')
                <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <div style="background: #f0f4ff; border: 1px solid var(--sms-primary); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                <i class="fas fa-info-circle" style="color: var(--sms-primary); font-size: 1.25rem;"></i>
                <div style="font-weight: 600; color: var(--sms-gray-900);">Auto-Generated Credentials</div>
            </div>
            <div style="color: var(--sms-gray-700); font-size: 0.9375rem; line-height: 1.6;">
                <p style="margin-bottom: 0.5rem;">
                    <strong>Employee ID:</strong> Will be automatically generated (e.g., TCH-2026-0001)
                </p>
                <p>
                    <strong>Default Password:</strong> <code style="background: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-family: monospace;">password123</code>
                </p>
                <p style="margin-top: 0.75rem; font-size: 0.875rem; color: var(--sms-gray-600);">
                    The teacher will use their Employee ID and password to login to the portal.
                </p>
            </div>
        </div>

        <div class="sms-form-row">
            <div class="sms-form-group">
                <label class="sms-form-label">
                    Teacher Type <span class="required">*</span>
                </label>
                <select name="teacher_type" class="sms-form-select" required>
                    <option value="">Select Type</option>
                    <option value="primary" {{ old('teacher_type') == 'primary' ? 'selected' : '' }}>Primary (Basic 1-6)</option>
                    <option value="secondary" {{ old('teacher_type', 'secondary') == 'secondary' ? 'selected' : '' }}>Secondary (JSS1-SS3)</option>
                </select>
                @error('teacher_type')
                    <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="sms-form-group">
                <label class="sms-form-label">Phone Number</label>
                <input type="text" 
                       name="phone" 
                       class="sms-form-input" 
                       value="{{ old('phone') }}" 
                       placeholder="+234 801 234 5678">
            </div>
        </div>

        <div class="sms-form-row">
            <div class="sms-form-group">
                <label class="sms-form-label">Qualification</label>
                <input type="text" 
                       name="qualification" 
                       class="sms-form-input" 
                       value="{{ old('qualification') }}" 
                       placeholder="e.g. B.Ed, M.Sc">
            </div>

            <div class="sms-form-group">
                <label class="sms-form-label">Specialization</label>
                <input type="text" 
                       name="specialization" 
                       class="sms-form-input" 
                       value="{{ old('specialization') }}" 
                       placeholder="e.g. Mathematics, Physics">
            </div>
        </div>

        <div class="sms-form-row">
            <div class="sms-form-group">
                <label class="sms-form-label">Hire Date</label>
                <input type="date" 
                       name="hire_date" 
                       class="sms-form-input" 
                       value="{{ old('hire_date', date('Y-m-d')) }}">
            </div>

            <div class="sms-form-group">
                <label class="sms-form-label">Salary</label>
                <input type="number" 
                       name="salary" 
                       class="sms-form-input" 
                       value="{{ old('salary') }}" 
                       step="0.01" 
                       placeholder="0.00">
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('school.staff.index') }}" class="sms-btn sms-btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
            <button type="submit" class="sms-btn sms-btn-primary">
                <i class="fas fa-save"></i> Create Teacher
            </button>
        </div>
    </form>
</div>
@endsection
