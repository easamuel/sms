@extends('layouts.app')

@section('title', 'Mark Attendance - Teacher Dashboard')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page-header {
        background: white;
        padding: 1.25rem 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        margin: -1rem -1rem 1.5rem -1rem;
        border-radius: 0;
    }
    .sms-page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }
    .sms-form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
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
    .sms-form-select, .sms-form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 16px;
        min-height: 44px;
        touch-action: manipulation;
    }
    .sms-attendance-table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin-bottom: 1.5rem;
    }
    .sms-attendance-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
        min-width: 600px;
    }
    .sms-attendance-table thead {
        background: var(--sms-gray-50);
    }
    .sms-attendance-table th {
        padding: 0.75rem 0.5rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--sms-gray-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid var(--sms-gray-200);
        white-space: nowrap;
    }
    .sms-attendance-table td {
        padding: 0.75rem 0.5rem;
        border-bottom: 1px solid var(--sms-gray-200);
        vertical-align: middle;
    }
    .sms-attendance-table tbody tr:hover {
        background: var(--sms-gray-50);
    }
    .student-name {
        font-weight: 600;
        color: var(--sms-gray-900);
        word-break: break-word;
    }
    .student-id {
        font-family: 'Courier New', monospace;
        color: var(--sms-gray-700);
        font-size: 0.8125rem;
        word-break: break-all;
        white-space: nowrap;
    }
    .attendance-toggle {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        justify-content: center;
    }
    .attendance-btn {
        width: 44px;
        height: 44px;
        min-width: 44px;
        min-height: 44px;
        border-radius: 8px;
        border: 2px solid var(--sms-gray-300);
        background: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        transition: all 0.2s;
        touch-action: manipulation;
    }
    .attendance-btn:active {
        transform: scale(0.95);
    }
    .attendance-btn.present {
        background: #d1fae5;
        border-color: #10b981;
        color: #065f46;
    }
    .attendance-btn.absent {
        background: #fee2e2;
        border-color: #ef4444;
        color: #991b1b;
    }
    .attendance-btn:hover {
        transform: scale(1.1);
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
    .sms-btn-primary:active {
        transform: scale(0.98);
    }
    .sms-btn {
        min-height: 44px;
        touch-action: manipulation;
        width: 100%;
    }
    
    /* Mobile Card Layout */
    .mobile-attendance-card {
        display: none;
        background: white;
        border: 1px solid var(--sms-gray-200);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .mobile-student-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
    }
    
    .mobile-student-info {
        flex: 1;
        min-width: 0;
    }
    
    .mobile-student-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
        word-wrap: break-word;
    }
    
    .mobile-student-id {
        font-family: 'Courier New', monospace;
        font-size: 0.8125rem;
        color: var(--sms-gray-600);
        word-break: break-all;
    }
    
    .mobile-attendance-controls {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
        padding: 0.75rem 0;
    }
    
    .mobile-attendance-controls .attendance-btn {
        flex: 1;
        max-width: 150px;
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }
    
    @media (min-width: 640px) {
        .form-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }
    
    @media (max-width: 767px) {
        .sms-attendance-table-wrapper {
            display: none;
        }
        
        .mobile-attendance-card {
            display: block;
        }
        
        .sms-form-card {
            padding: 1rem;
        }
    }
    
    @media (min-width: 640px) {
        .sms-page-header {
            padding: 1.5rem;
            margin: -1.5rem -1.5rem 1.5rem -1.5rem;
        }
        
        .sms-page-title {
            font-size: 1.75rem;
        }
        
        .sms-form-card {
            padding: 1.5rem;
        }
        
        .sms-btn {
            width: auto;
        }
    }
    
    @media (min-width: 768px) {
        .sms-page-header {
            padding: 2rem;
            margin: -2rem -2rem 2rem -2rem;
        }
        
        .sms-page-title {
            font-size: 1.875rem;
        }
        
        .sms-form-card {
            padding: 2rem;
            border-radius: 16px;
        }
        
        .sms-attendance-table th,
        .sms-attendance-table td {
            padding: 0.75rem 1rem;
        }
        
        .mobile-attendance-card {
            display: none;
        }
        
        .sms-attendance-table-wrapper {
            display: block;
        }
    }
</style>

<div style="max-width: 1200px; margin: 0 auto; padding: 1rem;">
    <div class="sms-page-header">
        <h1 class="sms-page-title">Mark Attendance</h1>
        <p style="color: var(--sms-gray-600); font-size: 0.875rem; line-height: 1.5;">Mark attendance for your assigned classes</p>
    </div>

    <form action="{{ route('sms.teacher.attendance.mark') }}" method="POST" id="attendanceForm">
        @csrf

        <div class="sms-form-card">
            <div class="form-grid">
                <div class="sms-form-group">
                    <label class="sms-form-label">Class *</label>
                    <select name="class_id" class="sms-form-select" required id="classSelect">
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="sms-form-group">
                    <label class="sms-form-label">Date *</label>
                    <input type="date" name="date" class="sms-form-input" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>
        </div>

        @if(isset($selectedClass) && $selectedClass->students->count() > 0)
        <div class="sms-form-card">
            <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--sms-gray-900); margin-bottom: 1.5rem;">
                Student Attendance ({{ $selectedClass->students->count() }} students)
            </h2>

            <!-- Desktop Table View -->
            <div class="sms-attendance-table-wrapper">
                <table class="sms-attendance-table">
                    <thead>
                        <tr>
                            <th style="min-width: 200px;">Student Name</th>
                            <th style="min-width: 180px;">Admission Number</th>
                            <th style="min-width: 150px; text-align: center;">Attendance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selectedClass->students as $student)
                        <tr>
                            <td class="student-name">{{ $student->user->name ?? 'N/A' }}</td>
                            <td class="student-id">{{ $student->student_id_number ?? 'N/A' }}</td>
                            <td>
                                <div class="attendance-toggle">
                                    <input type="hidden" name="attendances[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                                    <button type="button" class="attendance-btn present" data-status="present" data-student="{{ $student->id }}" onclick="setAttendance({{ $student->id }}, 'present')" aria-label="Mark Present">
                                        ✔
                                    </button>
                                    <button type="button" class="attendance-btn absent" data-status="absent" data-student="{{ $student->id }}" onclick="setAttendance({{ $student->id }}, 'absent')" aria-label="Mark Absent">
                                        ✖
                                    </button>
                                    <input type="hidden" name="attendances[{{ $student->id }}][status]" value="present" id="status-{{ $student->id }}">
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Mobile Card View -->
            <div id="mobileAttendanceList">
                @foreach($selectedClass->students as $student)
                <div class="mobile-attendance-card">
                    <div class="mobile-student-header">
                        <div class="mobile-student-info">
                            <div class="mobile-student-name">{{ $student->user->name ?? 'N/A' }}</div>
                            <div class="mobile-student-id">{{ $student->student_id_number ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="mobile-attendance-controls">
                        <input type="hidden" name="attendances[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                        <button type="button" class="attendance-btn present" data-status="present" data-student="{{ $student->id }}" onclick="setAttendance({{ $student->id }}, 'present')" aria-label="Mark Present">
                            <span style="font-size: 1.125rem; margin-right: 0.25rem;">✔</span> Present
                        </button>
                        <button type="button" class="attendance-btn absent" data-status="absent" data-student="{{ $student->id }}" onclick="setAttendance({{ $student->id }}, 'absent')" aria-label="Mark Absent">
                            <span style="font-size: 1.125rem; margin-right: 0.25rem;">✖</span> Absent
                        </button>
                        <input type="hidden" name="attendances[{{ $student->id }}][status]" value="present" id="status-mobile-{{ $student->id }}">
                    </div>
                </div>
                @endforeach
            </div>

            <div style="margin-top: 1.5rem; display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="submit" class="sms-btn sms-btn-primary">
                    <i class="fas fa-save"></i> Save Attendance
                </button>
            </div>
        </div>
        @else
        <div class="sms-form-card" style="text-align: center; padding: 3rem;">
            <div style="font-size: 2rem; color: var(--sms-gray-300); margin-bottom: 1rem;">
                <i class="fas fa-users"></i>
            </div>
            <div style="color: var(--sms-gray-600);">
                Select a class to mark attendance
            </div>
        </div>
        @endif
    </form>
</div>

<script>
    function setAttendance(studentId, status) {
        // Update desktop table inputs
        const statusInput = document.getElementById(`status-${studentId}`);
        if (statusInput) {
            statusInput.value = status;
        }
        
        // Update mobile card inputs
        const mobileStatusInput = document.getElementById(`status-mobile-${studentId}`);
        if (mobileStatusInput) {
            mobileStatusInput.value = status;
        }
        
        // Update all buttons for this student (both desktop and mobile)
        const presentBtns = document.querySelectorAll(`.attendance-btn.present[data-student="${studentId}"]`);
        const absentBtns = document.querySelectorAll(`.attendance-btn.absent[data-student="${studentId}"]`);
        
        if (status === 'present') {
            presentBtns.forEach(btn => {
                btn.style.background = '#d1fae5';
                btn.style.borderColor = '#10b981';
                btn.style.color = '#065f46';
            });
            absentBtns.forEach(btn => {
                btn.style.background = 'white';
                btn.style.borderColor = '#e5e7eb';
                btn.style.color = '#6b7280';
            });
        } else {
            absentBtns.forEach(btn => {
                btn.style.background = '#fee2e2';
                btn.style.borderColor = '#ef4444';
                btn.style.color = '#991b1b';
            });
            presentBtns.forEach(btn => {
                btn.style.background = 'white';
                btn.style.borderColor = '#e5e7eb';
                btn.style.color = '#6b7280';
            });
        }
    }

    document.getElementById('classSelect')?.addEventListener('change', function() {
        const classId = this.value;
        if (classId) {
            window.location.href = '{{ route("sms.teacher.attendance") }}?class_id=' + classId;
        }
    });

    // Initialize attendance buttons on page load
    document.addEventListener('DOMContentLoaded', function() {
        @if(isset($selectedClass))
            @foreach($selectedClass->students as $student)
                setAttendance({{ $student->id }}, 'present');
            @endforeach
        @endif
    });
    
    // Update mobile status input when desktop input changes and vice versa
    document.addEventListener('change', function(e) {
        if (e.target.id && e.target.id.startsWith('status-') && !e.target.id.startsWith('status-mobile-')) {
            const studentId = e.target.id.replace('status-', '');
            const mobileInput = document.getElementById(`status-mobile-${studentId}`);
            if (mobileInput) {
                mobileInput.value = e.target.value;
            }
        }
    });
</script>
@endsection
