@extends('layouts.admin')

@section('title', 'View Parent - School Management System')
@section('page-title', 'View Parent')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
        padding: 1rem;
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
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        flex-wrap: wrap;
        gap: 1rem;
    }
    .sms-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }
    .info-item {
        display: flex;
        flex-direction: column;
    }
    .info-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--sms-gray-500);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }
    .info-value {
        font-size: 0.9375rem;
        color: var(--sms-gray-900);
        font-weight: 500;
        word-wrap: break-word;
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
    .sms-badge-danger {
        background: #fee2e2;
        color: #991b1b;
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
        min-height: 44px;
    }
    .sms-btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
    }
    .sms-btn-secondary {
        background: white;
        color: var(--sms-gray-700);
        border: 1px solid var(--sms-gray-300);
    }
    .sms-btn-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .sms-btn-danger:hover {
        background: #fecaca;
    }
    .student-list-item {
        padding: 0.875rem;
        background: var(--sms-gray-50);
        border-radius: 8px;
        margin-bottom: 0.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--sms-gray-900);
    }
    
    @media (min-width: 640px) {
        .sms-page {
            padding: 2rem;
        }
        .sms-card {
            padding: 1.5rem;
        }
        .info-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        .page-title {
            font-size: 1.875rem;
        }
    }
</style>

<div class="sms-page">
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $parent->user->name ?? 'N/A' }}</h1>
            <p style="color: var(--sms-gray-600); margin-top: 0.5rem;">Parent Details</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('school.parents.edit', $parent->id) }}" class="sms-btn sms-btn-primary">
                <i class="fas fa-edit"></i> Edit Parent
            </a>
            <form method="POST" action="{{ route('school.parents.destroy', $parent->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this parent? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="sms-btn sms-btn-danger">
                    <i class="fas fa-trash"></i> Delete Parent
                </button>
            </form>
            <a href="{{ route('school.parents.index') }}" class="sms-btn sms-btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <!-- Basic Information -->
    <div class="sms-card">
        <div class="sms-card-header">
            <h3 class="sms-card-title">Basic Information</h3>
        </div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Full Name</div>
                <div class="info-value">{{ $parent->user->name ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $parent->user->email ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Phone</div>
                <div class="info-value">{{ $parent->phone ?? $parent->user->phone ?? '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Occupation</div>
                <div class="info-value">{{ $parent->occupation ?? '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Address</div>
                <div class="info-value">{{ $parent->address ?? '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Status</div>
                <div class="info-value">
                    @if($parent->user && $parent->user->is_active)
                        <span class="sms-badge sms-badge-success">Active</span>
                    @else
                        <span class="sms-badge sms-badge-danger">Inactive</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Linked Children -->
    <div class="sms-card">
        <div class="sms-card-header">
            <h3 class="sms-card-title">Linked Children ({{ $allChildren->count() }})</h3>
        </div>
        @if($allChildren->count() > 0)
            <div>
                @foreach($allChildren as $child)
                    <div class="student-list-item">
                        <div>
                            <div style="font-weight: 600; color: var(--sms-gray-900); margin-bottom: 0.25rem;">
                                {{ $child->user->name ?? 'N/A' }}
                            </div>
                            <div style="font-size: 0.8125rem; color: var(--sms-gray-600);">
                                {{ $child->student_id_number ?? 'N/A' }} | {{ $child->class->name ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 2rem; color: var(--sms-gray-500);">
                <i class="fas fa-user-graduate" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <p>No children linked to this parent.</p>
            </div>
        @endif
    </div>
</div>
@endsection
