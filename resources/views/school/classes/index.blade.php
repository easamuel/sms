@extends('layouts.admin')

@section('title', 'Classes Management - School Management System')
@section('page-title', 'Classes Management')

@section('content')
@include('sms.partials.design-system')
<style>
    .page-header {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        line-height: 1.2;
    }
    .sms-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .sms-card-header {
        padding: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        background: var(--sms-gray-50);
    }
    .sms-card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .sms-card-body {
        padding: 1rem;
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
    .sms-form-input,
    .sms-form-select {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 16px;
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
        min-height: 44px;
        touch-action: manipulation;
        width: 100%;
    }
    
    @media (min-width: 640px) {
        .page-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 1.75rem;
        }
        
        .sms-card-header,
        .sms-card-body {
            padding: 1.5rem;
        }
        
        .sms-form-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .sms-btn {
            width: auto;
            padding: 0.625rem 1.25rem;
        }
    }
    
    @media (min-width: 768px) {
        .page-title {
            font-size: 1.875rem;
        }
    }
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
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
    }
    .classes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    .class-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid var(--sms-gray-200);
        transition: all 0.3s;
    }
    .class-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    .class-name {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
    }
    .class-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--sms-gray-200);
    }
    .class-info-item {
        display: flex;
        justify-content: space-between;
        font-size: 0.875rem;
    }
    .class-info-label {
        color: var(--sms-gray-600);
    }
    .class-info-value {
        font-weight: 600;
        color: var(--sms-gray-900);
    }
</style>

<div class="page-header">
    <h1 class="page-title">Classes Management</h1>
</div>

<!-- Create Class Form -->
<div class="sms-card">
    <div class="sms-card-header">
        <h2 class="sms-card-title">Create New Class</h2>
    </div>
    <div class="sms-card-body">
        <form action="{{ route('school.classes.store') }}" method="POST">
            @csrf
            <div class="sms-form-row">
                <div class="sms-form-group">
                    <label class="sms-form-label">Class Name *</label>
                    <select name="name" class="sms-form-select" required>
                        <option value="">Select Class</option>
                        <optgroup label="Primary (Basic)">
                            <option value="Basic 1">Basic 1</option>
                            <option value="Basic 2">Basic 2</option>
                            <option value="Basic 3">Basic 3</option>
                            <option value="Basic 4">Basic 4</option>
                            <option value="Basic 5">Basic 5</option>
                            <option value="Basic 6">Basic 6</option>
                        </optgroup>
                        <optgroup label="Junior Secondary">
                            <option value="JSS1">JSS1</option>
                            <option value="JSS2">JSS2</option>
                            <option value="JSS3">JSS3</option>
                        </optgroup>
                        <optgroup label="Senior Secondary">
                            <option value="SS1">SS1</option>
                            <option value="SS2">SS2</option>
                            <option value="SS3">SS3</option>
                        </optgroup>
                    </select>
                </div>
                <div class="sms-form-group">
                    <label class="sms-form-label">Academic Year *</label>
                    <input type="text" name="academic_year" class="sms-form-input" value="{{ date('Y') }}" required>
                </div>
                <div class="sms-form-group">
                    <label class="sms-form-label">Capacity</label>
                    <input type="number" name="capacity" class="sms-form-input" value="40" min="1">
                </div>
                <div class="sms-form-group">
                    <label class="sms-form-label">Class Teacher</label>
                    <select name="class_teacher_id" class="sms-form-select">
                        <option value="">Select Teacher</option>
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->user->name ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="sms-btn sms-btn-primary">
                <i class="fas fa-plus"></i> Create Class
            </button>
        </form>
    </div>
</div>

<!-- Classes List -->
<div class="sms-card">
    <div class="sms-card-header">
        <h2 class="sms-card-title">All Classes</h2>
    </div>
    <div class="sms-card-body">
        @if($classes->count() > 0)
        <div class="classes-grid">
            @foreach($classes as $class)
            <div class="class-card">
                <div class="class-name">{{ $class->name }}</div>
                <div class="class-info">
                    <div class="class-info-item">
                        <span class="class-info-label">Academic Year:</span>
                        <span class="class-info-value">{{ $class->academic_year ?? 'N/A' }}</span>
                    </div>
                    <div class="class-info-item">
                        <span class="class-info-label">Students:</span>
                        <span class="class-info-value">{{ $class->students->count() ?? 0 }}</span>
                    </div>
                    <div class="class-info-item">
                        <span class="class-info-label">Capacity:</span>
                        <span class="class-info-value">{{ $class->capacity ?? 'N/A' }}</span>
                    </div>
                    @if($class->classTeacher)
                    <div class="class-info-item">
                        <span class="class-info-label">Class Teacher:</span>
                        <span class="class-info-value">{{ $class->classTeacher->user->name ?? 'N/A' }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align: center; padding: 3rem;">
            <div style="font-size: 3rem; color: var(--sms-gray-300); margin-bottom: 1rem;">
                <i class="fas fa-layer-group"></i>
            </div>
            <div style="font-size: 1.125rem; font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.5rem;">
                No Classes Yet
            </div>
            <div style="color: var(--sms-gray-500);">
                Create your first class above
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
