@extends('layouts.app')

@section('title', 'My Results - School Management System')

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
    .sms-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        overflow: hidden;
        margin-bottom: 1.5rem;
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
    .sms-form-group {
        margin-bottom: 1.5rem;
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
        padding: 0.75rem 1rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 0.9375rem;
        transition: border-color 0.2s;
        background: white;
    }
    .sms-form-input:focus,
    .sms-form-select:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .sms-form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    .sms-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-size: 0.9375rem;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .sms-btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
    }
    .sms-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
    }
    .sms-btn-secondary {
        background: var(--sms-gray-200);
        color: var(--sms-gray-700);
    }
    .sms-btn-secondary:hover {
        background: var(--sms-gray-300);
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
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <h1 class="sms-page-title">My Results</h1>
        <p class="sms-page-subtitle">View your academic results by selecting year/session and term</p>
    </div>

    <div style="max-width: 1400px; margin: 0 auto; padding: 0 2rem 2rem;">
        <div class="sms-card">
            <div class="sms-card-header">
                <h2 class="sms-card-title">Select Academic Year and Term</h2>
            </div>
            <div class="sms-card-body">
                <form method="GET" action="{{ route('sms.student.results') }}">
                    <div class="sms-form-row">
                        <div class="sms-form-group">
                            <label class="sms-form-label">Academic Year / Session</label>
                            <select name="academic_year" class="sms-form-select" required>
                                @if($availableYears->count() > 0)
                                    @foreach($availableYears as $year)
                                        <option value="{{ $year }}" {{ $academicYear == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="{{ date('Y') }}/{{ date('Y') + 1 }}" selected>
                                        {{ date('Y') }}/{{ date('Y') + 1 }}
                                    </option>
                                @endif
                            </select>
                        </div>
                        <div class="sms-form-group">
                            <label class="sms-form-label">Term</label>
                            <select name="term" class="sms-form-select" required>
                                <option value="First Term" {{ $term == 'First Term' ? 'selected' : '' }}>First Term</option>
                                <option value="Second Term" {{ $term == 'Second Term' ? 'selected' : '' }}>Second Term</option>
                                <option value="Third Term" {{ $term == 'Third Term' ? 'selected' : '' }}>Third Term</option>
                            </select>
                        </div>
                    </div>
                    <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                        <button type="submit" name="check_result" value="1" class="sms-btn sms-btn-primary">
                            <i class="fas fa-search"></i> Check Result
                        </button>
                        @if($results->count() > 0)
                        <a href="{{ route('sms.student.results.download-pdf', ['academic_year' => $academicYear, 'term' => $term]) }}" class="sms-btn sms-btn-secondary">
                            <i class="fas fa-download"></i> Download PDF
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if($results->count() > 0)
        <div class="sms-card">
            <div class="sms-card-body">
                <p style="color: var(--sms-gray-600); margin-bottom: 1rem;">
                    Click "Check Result" above to view your full report card, or download it as PDF.
                </p>
            </div>
        </div>
        @elseif(request()->has('check_result'))
        <div class="sms-card">
            <div class="sms-card-body">
                <div class="sms-empty-state">
                    <div class="sms-empty-state-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="sms-empty-state-title">No Results Found</div>
                    <div class="sms-empty-state-text">
                        No results available for {{ $academicYear }} - {{ $term }}. Please select a different year or term.
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
