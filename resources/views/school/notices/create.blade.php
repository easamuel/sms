@extends('layouts.admin')

@section('title', 'Create Notice - School Management System')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
        padding: 2rem;
    }
    .sms-page-header {
        margin-bottom: 2rem;
    }
    .sms-page-title {
        font-size: 1.875rem;
        font-weight: 800;
        color: var(--sms-gray-900);
    }
    .sms-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        overflow: hidden;
    }
    .sms-card-body {
        padding: 2rem;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        display: block;
        font-weight: 600;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
    }
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 10px;
        font-size: 0.9375rem;
        transition: all 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }
    .btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent));
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <h1 class="sms-page-title">Create Notice</h1>
    </div>

    <div class="sms-card">
        <div class="sms-card-body">
            <form method="POST" action="{{ route('school.notices.store') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    @error('title')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Content *</label>
                    <textarea name="content" class="form-control" required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Target Audience *</label>
                    <select name="target_audience" class="form-control" required>
                        <option value="all" {{ old('target_audience') == 'all' ? 'selected' : '' }}>All Users</option>
                        <option value="parents" {{ old('target_audience') == 'parents' ? 'selected' : '' }}>Parents Only</option>
                        <option value="students" {{ old('target_audience') == 'students' ? 'selected' : '' }}>Students Only</option>
                        <option value="teachers" {{ old('target_audience') == 'teachers' ? 'selected' : '' }}>Teachers Only</option>
                    </select>
                    @error('target_audience')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Published At</label>
                    <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at') }}">
                    @error('published_at')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Expires At</label>
                    <input type="datetime-local" name="expires_at" class="form-control" value="{{ old('expires_at') }}">
                    @error('expires_at')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <span class="form-label" style="display: inline; margin-left: 0.5rem;">Active</span>
                    </label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Create Notice
                    </button>
                    <a href="{{ route('school.notices.index') }}" class="btn btn-outline-secondary" style="margin-left: 0.5rem;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
