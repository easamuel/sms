@extends('layouts.admin')

@section('title', 'Assign Parent to Student - School Management System')
@section('page-title', 'Assign Parent to Student')

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
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
    }
    .sms-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--sms-gray-700);
    }
    .form-control {
        width: 100%;
        padding: 0.625rem 0.75rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 6px;
        font-size: 0.875rem;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--sms-blue-500);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .btn-primary {
        background: var(--sms-blue-600);
        color: white;
        padding: 0.625rem 1.5rem;
        border-radius: 6px;
        border: none;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-primary:hover {
        background: var(--sms-blue-700);
    }
    .btn-danger {
        background: #dc2626;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        font-size: 0.875rem;
    }
    .sms-table {
        width: 100%;
        border-collapse: collapse;
    }
    .sms-table th {
        padding: 0.75rem 1rem;
        text-align: left;
        font-size: 0.8125rem;
        font-weight: 600;
        background: var(--sms-gray-50);
        border-bottom: 2px solid var(--sms-gray-200);
    }
    .sms-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
    }
    .sms-badge {
        display: inline-flex;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.8125rem;
        font-weight: 600;
    }
    .sms-badge-info {
        background: #dbeafe;
        color: #1e40af;
    }
    .alert {
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 1.5rem;
    }
    .alert-success {
        background: #d1fae5;
        color: #065f46;
    }
    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }
</style>

<div class="sms-page">
    <div class="container-fluid py-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Assign Parent Form -->
        <div class="sms-card">
            <div class="sms-card-header">
                <h3 class="sms-card-title">Assign Parent to Student</h3>
            </div>
            <form action="{{ route('school.students.assign-parent') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Select Student</label>
                        <select name="student_id" class="form-control" required>
                            <option value="">Choose a student...</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->user->name }} ({{ $student->student_id_number }}) - {{ $student->class->name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Select Parent</label>
                        <select name="parent_id" id="parent_select" class="form-control" required onchange="checkParentChildCount(this)">
                            <option value="">Choose a parent...</option>
                            @foreach($parents as $parent)
                                @php
                                    $childCount = DB::table('parent_student')->where('parent_id', $parent->id)->count() + 
                                                 \App\Models\Sms\SmsStudent::where('parent_id', $parent->id)->where('school_id', $school->id)->count();
                                @endphp
                                <option value="{{ $parent->id }}" data-child-count="{{ $childCount }}">
                                    {{ $parent->user->name }} ({{ $parent->user->email }}) 
                                    @if($childCount >= 2)
                                        - ⚠️ MAX ({{ $childCount }}/2)
                                    @elseif($childCount > 0)
                                        - ({{ $childCount }}/2)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <div id="parent_warning" style="display: none; margin-top: 0.5rem; padding: 0.75rem; background: #fef3c7; border-radius: 6px; color: #92400e; font-size: 0.875rem;">
                            <i class="fas fa-exclamation-triangle"></i> This parent already has 2 children assigned. Cannot assign more.
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Relationship</label>
                        <select name="relationship" class="form-control" required>
                            <option value="father">Father</option>
                            <option value="mother">Mother</option>
                            <option value="guardian">Guardian</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-primary">Assign Parent</button>
            </form>
        </div>

        <!-- Students with Parents -->
        <div class="sms-card">
            <div class="sms-card-header">
                <h3 class="sms-card-title">Students and Their Parents</h3>
            </div>
            <div style="overflow-x: auto;">
                <table class="sms-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Parents</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>
                                    <strong>{{ $student->user->name }}</strong><br>
                                    <small style="color: var(--sms-gray-600);">{{ $student->student_id_number }}</small>
                                </td>
                                <td>{{ $student->class->name ?? 'N/A' }}</td>
                                <td>
                                    @if($student->linkedParents->count() > 0)
                                        @foreach($student->linkedParents as $parent)
                                            <div style="margin-bottom: 0.5rem;">
                                                <span class="sms-badge sms-badge-info">
                                                    {{ ucfirst($parent->pivot->relationship) }}
                                                </span>
                                                {{ $parent->user->name }}
                                            </div>
                                        @endforeach
                                    @elseif($student->parent)
                                        <div>
                                            <span class="sms-badge sms-badge-info">Parent</span>
                                            {{ $student->parent->user->name }}
                                        </div>
                                    @else
                                        <span style="color: var(--sms-gray-400);">No parent assigned</span>
                                    @endif
                                </td>
                                <td>
                                    @if($student->linkedParents->count() > 0)
                                        @foreach($student->linkedParents as $parent)
                                            <form method="POST" action="{{ route('school.students.remove-parent', [$student->id, $parent->id]) }}" style="display: inline;" onsubmit="return confirm('Remove this parent-student relationship?')">
                                                @csrf
                                                <button type="submit" class="btn-danger" style="margin-right: 0.5rem; margin-bottom: 0.25rem;">
                                                    Remove
                                                </button>
                                            </form>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 1.5rem;">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
