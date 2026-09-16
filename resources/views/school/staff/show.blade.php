@extends('layouts.admin')

@section('title', 'View Teacher - School Management System')
@section('page-title', 'View Teacher')

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
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .sms-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
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
    
    .sms-card {
        padding: 1.25rem;
    }
    
    .sms-btn {
        min-height: 44px;
        touch-action: manipulation;
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    @media (min-width: 640px) {
        .sms-card {
            padding: 1.5rem;
        }
        
        .info-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .sms-btn {
            width: auto;
            margin-bottom: 0;
        }
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
    .sms-badge-primary {
        background: #dbeafe;
        color: #1e40af;
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
    .sms-btn-secondary {
        background: white;
        color: var(--sms-gray-700);
        border: 1px solid var(--sms-gray-300);
    }
    .list-item {
        padding: 0.75rem;
        background: var(--sms-gray-50);
        border-radius: 8px;
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
        color: var(--sms-gray-700);
    }
</style>

<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 800; color: var(--sms-gray-900); margin-bottom: 0.5rem;">
                {{ $teacher->user->name ?? 'N/A' }}
            </h1>
            <p style="color: var(--sms-gray-600);">Employee ID: {{ $teacher->employee_id }}</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('school.staff.edit', $teacher->id) }}" class="sms-btn sms-btn-primary">
                <i class="fas fa-edit"></i> Edit Teacher
            </a>
            <a href="{{ route('school.staff.index') }}" class="sms-btn sms-btn-secondary">
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
                <div class="info-value">{{ $teacher->user->name ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Employee ID</div>
                <div class="info-value">{{ $teacher->employee_id }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $teacher->user->email ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Phone</div>
                <div class="info-value">{{ $teacher->user->phone ?? '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Teacher Type</div>
                <div class="info-value">
                    <span class="sms-badge {{ $teacher->teacher_type === 'primary' ? 'sms-badge-primary' : 'sms-badge-warning' }}">
                        {{ ucfirst($teacher->teacher_type ?? 'secondary') }}
                    </span>
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Status</div>
                <div class="info-value">
                    <span class="sms-badge {{ $teacher->status === 'active' ? 'sms-badge-success' : ($teacher->status === 'suspended' ? 'sms-badge-danger' : 'sms-badge-warning') }}">
                        {{ ucfirst($teacher->status ?? 'active') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Information -->
    <div class="sms-card">
        <div class="sms-card-header">
            <h3 class="sms-card-title">Professional Information</h3>
        </div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Qualification</div>
                <div class="info-value">{{ $teacher->qualification ?? '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Specialization</div>
                <div class="info-value">{{ $teacher->specialization ?? '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Hire Date</div>
                <div class="info-value">{{ $teacher->hire_date ? \Carbon\Carbon::parse($teacher->hire_date)->format('M d, Y') : '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Salary</div>
                <div class="info-value">{{ $teacher->salary ? '₦' . number_format($teacher->salary, 2) : '—' }}</div>
            </div>
        </div>
    </div>

    <!-- Assigned Subjects -->
    <div class="sms-card">
        <div class="sms-card-header">
            <h3 class="sms-card-title">Assigned Subjects</h3>
            <button type="button" onclick="document.getElementById('assign-subjects-form').style.display = 'block'; this.style.display = 'none';" class="sms-btn sms-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                <i class="fas fa-plus"></i> Assign Subjects
            </button>
        </div>
        
        <!-- Assign Subjects Form -->
        <div id="assign-subjects-form" style="display: none; padding: 1.5rem; background: var(--sms-gray-50); border-radius: 8px; margin-bottom: 1.5rem;">
            <form action="{{ route('school.staff.assign-subjects', $teacher->id) }}" method="POST" id="assign-subjects-form-element">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.75rem;">
                        Select Subjects for {{ $teacher->teacher_type === 'primary' ? 'Primary (Basic 1-6)' : 'Secondary (JSS1-SS3)' }} Teacher
                    </label>
                    @if(isset($availableSubjects) && $availableSubjects->count() > 0)
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 0.75rem; max-height: 300px; overflow-y: auto; padding: 1rem; background: white; border-radius: 8px; border: 1px solid var(--sms-gray-200);">
                            @foreach($availableSubjects as $subject)
                                <label style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; cursor: pointer; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='var(--sms-gray-50)'" onmouseout="this.style.background='transparent'">
                                    <input type="checkbox" 
                                           name="subject_ids[]" 
                                           value="{{ $subject->id }}"
                                           {{ isset($assignedSubjects) && $assignedSubjects->contains('id', $subject->id) ? 'checked' : '' }}
                                           style="margin: 0; cursor: pointer;">
                                    <span style="font-size: 0.9375rem; color: var(--sms-gray-700);">{{ $subject->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        <div style="margin-top: 0.5rem; display: flex; gap: 0.5rem;">
                            <button type="button" onclick="selectAllSubjects()" class="sms-btn sms-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.8125rem;">
                                Select All
                            </button>
                            <button type="button" onclick="clearAllSubjects()" class="sms-btn sms-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.8125rem;">
                                Clear All
                            </button>
                        </div>
                    @else
                        <div style="color: #dc2626; font-size: 0.8125rem; padding: 1rem; background: white; border-radius: 8px; border: 1px solid var(--sms-gray-200);">
                            <i class="fas fa-exclamation-triangle"></i> No subjects available. Please create subjects first from the Subjects management page.
                        </div>
                    @endif
                </div>
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" onclick="closeAssignSubjectsForm()" class="sms-btn sms-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                        Cancel
                    </button>
                    <button type="submit" class="sms-btn sms-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                        <i class="fas fa-save"></i> Save Assignments
                    </button>
                </div>
            </form>
        </div>

        @if($assignedSubjects->count() > 0)
            <div>
                @foreach($assignedSubjects as $subject)
                    <div class="list-item" style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <i class="fas fa-book" style="color: var(--sms-primary); margin-right: 0.5rem;"></i>
                            {{ $subject->name }}
                        </div>
                        <form action="{{ route('school.staff.remove-subject', [$teacher->id, $subject->id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Remove {{ $subject->name }} from this teacher?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #fee2e2; color: #991b1b; border: none; padding: 0.25rem 0.75rem; border-radius: 6px; cursor: pointer; font-size: 0.8125rem; font-weight: 600;">
                                <i class="fas fa-times"></i> Remove
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 2rem; color: var(--sms-gray-500);">
                <i class="fas fa-info-circle" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <p>No subjects assigned yet.</p>
                <p style="font-size: 0.875rem; margin-top: 0.5rem;">Click "Assign Subjects" above to assign subjects to this teacher.</p>
            </div>
        @endif
    </div>

    <!-- Assigned Classes -->
    <div class="sms-card">
        <div class="sms-card-header">
            <h3 class="sms-card-title">Assigned Classes</h3>
            <button type="button" onclick="document.getElementById('assign-classes-form').style.display = 'block'; this.style.display = 'none';" class="sms-btn sms-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                <i class="fas fa-plus"></i> Assign Classes
            </button>
        </div>
        
        <!-- Assign Classes Form -->
        <div id="assign-classes-form" style="display: none; padding: 1.5rem; background: var(--sms-gray-50); border-radius: 8px; margin-bottom: 1.5rem;">
            <form action="{{ route('school.staff.assign-classes', $teacher->id) }}" method="POST">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.75rem;">
                        Select Classes for {{ $teacher->teacher_type === 'primary' ? 'Primary (Basic 1-6)' : 'Secondary (JSS1-SS3)' }} Teacher
                    </label>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 0.75rem; max-height: 300px; overflow-y: auto; padding: 1rem; background: white; border-radius: 8px; border: 1px solid var(--sms-gray-200);">
                        @foreach($availableClasses as $class)
                            <label style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; cursor: pointer; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='var(--sms-gray-50)'" onmouseout="this.style.background='transparent'">
                                <input type="checkbox" 
                                       name="class_ids[]" 
                                       value="{{ $class->id }}"
                                       {{ $assignedClasses->contains('id', $class->id) ? 'checked' : '' }}
                                       style="margin: 0; cursor: pointer;">
                                <span style="font-size: 0.9375rem; color: var(--sms-gray-700);">{{ $class->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @if($availableClasses->count() === 0)
                        <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem;">
                            No classes available. Please create classes first.
                        </div>
                    @endif
                </div>
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" onclick="document.getElementById('assign-classes-form').style.display = 'none'; document.querySelector('button[onclick*=\"assign-classes-form\"]').style.display = 'inline-flex';" class="sms-btn sms-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                        Cancel
                    </button>
                    <button type="submit" class="sms-btn sms-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                        <i class="fas fa-save"></i> Save Assignments
                    </button>
                </div>
            </form>
        </div>

        @if($assignedClasses->count() > 0)
            <div>
                @foreach($assignedClasses as $class)
                    <div class="list-item" style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <i class="fas fa-layer-group" style="color: var(--sms-primary); margin-right: 0.5rem;"></i>
                            {{ $class->name }}
                        </div>
                        <form action="{{ route('school.staff.remove-class', [$teacher->id, $class->id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Remove {{ $class->name }} from this teacher?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #fee2e2; color: #991b1b; border: none; padding: 0.25rem 0.75rem; border-radius: 6px; cursor: pointer; font-size: 0.8125rem; font-weight: 600;">
                                <i class="fas fa-times"></i> Remove
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 2rem; color: var(--sms-gray-500);">
                <i class="fas fa-info-circle" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <p>No classes assigned yet.</p>
                <p style="font-size: 0.875rem; margin-top: 0.5rem;">Click "Assign Classes" above to assign classes to this teacher.</p>
            </div>
        @endif
    </div>
</div>

<script>
    function selectAllSubjects() {
        document.querySelectorAll('#assign-subjects-form input[name="subject_ids[]"]').forEach(function(cb) {
            cb.checked = true;
        });
    }

    function clearAllSubjects() {
        document.querySelectorAll('#assign-subjects-form input[name="subject_ids[]"]').forEach(function(cb) {
            cb.checked = false;
        });
    }

    function closeAssignSubjectsForm() {
        document.getElementById('assign-subjects-form').style.display = 'none';
        var button = document.querySelector('button[onclick*="assign-subjects-form"]');
        if (button) {
            button.style.display = 'inline-flex';
        }
    }
</script>
@endsection
