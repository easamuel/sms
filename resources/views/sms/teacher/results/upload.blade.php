@extends('layouts.app')

@section('title', 'Upload Results - Teacher Dashboard')

@section('content')
@include('sms.partials.design-system')
<style>
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
    }
    .sms-form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        padding: 2rem;
        margin-bottom: 2rem;
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
    .sms-form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 0.9375rem;
        transition: border-color 0.2s;
    }
    .sms-form-input:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .sms-form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 0.9375rem;
        background: white;
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
    .sms-results-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1.5rem;
        font-size: 0.875rem;
    }
    .sms-results-table thead {
        background: var(--sms-gray-50);
    }
    .sms-results-table th {
        padding: 0.875rem 0.75rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--sms-gray-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid var(--sms-gray-200);
    }
    .sms-results-table td {
        padding: 0.875rem 0.75rem;
        border-bottom: 1px solid var(--sms-gray-200);
    }
    .sms-results-table input[type="number"] {
        width: 80px;
        padding: 0.5rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 6px;
        text-align: center;
    }
    .sms-results-table input[type="number"]:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.1);
    }
    .admission-number {
        font-family: monospace;
        font-weight: 600;
        color: var(--sms-gray-700);
    }
</style>

<div style="max-width: 1400px; margin: 0 auto; padding: 2rem;">
    <div class="sms-page-header">
        <h1 class="sms-page-title">Upload Results</h1>
        <p style="color: var(--sms-gray-600);">Upload manual results for offline exams and assessments</p>
    </div>

    <form action="{{ route('sms.teacher.results.upload.store') }}" method="POST">
        @csrf

        <div class="sms-form-card">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--sms-gray-900); margin-bottom: 1.5rem;">
                Assessment Information
            </h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <div class="sms-form-group">
                    <label class="sms-form-label">Class *</label>
                    <select name="class_id" class="sms-form-select" required id="classSelect">
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ (request('class_id') == $class->id || ($exam && $exam->class_id == $class->id)) ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="sms-form-group">
                    <label class="sms-form-label">Subject *</label>
                    <select name="subject_id" class="sms-form-select" required id="subjectSelect">
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ (request('subject_id') == $subject->id || ($exam && $exam->subject_id == $subject->id)) ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                        @endforeach
                    </select>
                </div>


                <div class="sms-form-group">
                    <label class="sms-form-label">Academic Year *</label>
                    <input type="text" name="academic_year" class="sms-form-input" value="{{ date('Y') }}" required>
                </div>

                <div class="sms-form-group">
                    <label class="sms-form-label">Term *</label>
                    <select name="term" class="sms-form-select" required>
                        <option value="">Select Term</option>
                        <option value="First Term">First Term</option>
                        <option value="Second Term">Second Term</option>
                        <option value="Third Term">Third Term</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- CSV Upload Section - Always Visible -->
        <div class="sms-form-card" id="csvUploadSection">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--sms-gray-900);">
                    Upload Results via CSV
                </h2>
                <a href="#" class="sms-btn" style="background: var(--sms-gray-200); color: var(--sms-gray-700); padding: 0.5rem 1rem; font-size: 0.875rem;" id="downloadTemplateBtn" onclick="event.preventDefault(); downloadTemplate();">
                    <i class="fas fa-download"></i> Download CSV Template
                </a>
            </div>
            
            <div style="background: #f0f4ff; border: 1px solid var(--sms-primary); border-radius: 8px; padding: 1.5rem;">
                <p style="color: var(--sms-gray-700); font-size: 0.875rem; margin-bottom: 1rem; font-weight: 600;">
                    <i class="fas fa-info-circle"></i> Select Class and Subject above, then upload your CSV file
                </p>
                <p style="color: var(--sms-gray-600); font-size: 0.8125rem; margin-bottom: 1rem;">
                    CSV Format: <code style="background: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">admission_number,student_name,subject,ca1,ca2,ca3,exam</code>
                </p>
                <p style="color: var(--sms-gray-500); font-size: 0.75rem; margin-bottom: 1rem; font-style: italic;">
                    Note: The subject column is included for reference. The system will use the subject selected above.
                </p>
                <form action="{{ route('sms.teacher.results.upload-csv') }}" method="POST" enctype="multipart/form-data" id="csvUploadForm" style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                    @csrf
                    <input type="hidden" name="class_id" id="csv_class_id" value="{{ request('class_id', $exam->class_id ?? '') }}">
                    <input type="hidden" name="subject_id" id="csv_subject_id" value="{{ request('subject_id', $exam->subject_id ?? '') }}">
                    <input type="hidden" name="academic_year" id="csv_academic_year" value="{{ date('Y') }}">
                    <input type="hidden" name="term" id="csv_term" value="First Term">
                    <input type="file" name="csv_file" accept=".csv" required id="csvFileInput" style="padding: 0.5rem; border: 1px solid var(--sms-gray-300); border-radius: 6px; font-size: 0.875rem; flex: 1; min-width: 200px;">
                    <button type="submit" class="sms-btn sms-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;" id="csvUploadBtn">
                        <i class="fas fa-upload"></i> Upload CSV
                    </button>
                </form>
            </div>
        </div>

        @if(isset($students) && $students->count() > 0)
        <div class="sms-form-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--sms-gray-900);">
                    Or Enter Results Manually
                </h2>
            </div>
            
            <p style="color: var(--sms-gray-600); font-size: 0.875rem; margin-bottom: 1rem;">
                Enter CA1, CA2, CA3, and Exam scores for each student below.
            </p>

            <div style="overflow-x: auto;">
                <table class="sms-results-table">
                    <thead>
                        <tr>
                            <th style="min-width: 200px;">Student Name</th>
                            <th style="min-width: 150px;">Admission Number</th>
                            <th style="min-width: 100px;">CA1 (0-100)</th>
                            <th style="min-width: 100px;">CA2 (0-100)</th>
                            <th style="min-width: 100px;">CA3 (0-100)</th>
                            <th style="min-width: 100px;">Exam (0-100)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td style="font-weight: 600;">{{ $student->user->name ?? 'N/A' }}</td>
                            <td>
                                <span class="admission-number">
                                    {{ $student->student_id_number ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <input type="hidden" name="results[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                                <input type="number" name="results[{{ $student->id }}][ca1_score]" 
                                       min="0" max="100" step="0.01" placeholder="0" value="0">
                            </td>
                            <td>
                                <input type="number" name="results[{{ $student->id }}][ca2_score]" 
                                       min="0" max="100" step="0.01" placeholder="0" value="0">
                            </td>
                            <td>
                                <input type="number" name="results[{{ $student->id }}][ca3_score]" 
                                       min="0" max="100" step="0.01" placeholder="0" value="0">
                            </td>
                            <td>
                                <input type="number" name="results[{{ $student->id }}][exam_score]" 
                                       min="0" max="100" step="0.01" placeholder="0" value="0">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="sms-form-card" style="text-align: center; padding: 3rem;" id="noStudentsMessage">
            <div style="font-size: 2rem; color: var(--sms-gray-300); margin-bottom: 1rem;">
                <i class="fas fa-users"></i>
            </div>
            <div style="color: var(--sms-gray-600); margin-bottom: 1.5rem;">
                @if(request('class_id'))
                    No students found in the selected class. Please select a different class.
                @else
                    Select a class above to load students
                @endif
            </div>
        </div>
        @endif

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('sms.teacher.results') }}" class="sms-btn" style="background: var(--sms-gray-200); color: var(--sms-gray-700);">
                Cancel
            </a>
            <button type="submit" class="sms-btn sms-btn-primary">
                <i class="fas fa-upload"></i> Upload Results
            </button>
        </div>
    </form>
</div>

<script>
    function updateCsvForm() {
        const classId = document.getElementById('classSelect')?.value || '';
        const subjectId = document.getElementById('subjectSelect')?.value || '';
        const term = document.querySelector('select[name="term"]')?.value || 'First Term';
        const academicYear = document.querySelector('input[name="academic_year"]')?.value || '{{ date("Y") }}';
        
        if (classId) {
            document.getElementById('csv_class_id').value = classId;
        }
        if (subjectId) {
            document.getElementById('csv_subject_id').value = subjectId;
        }
        if (term) {
            document.getElementById('csv_term').value = term;
        }
        if (academicYear) {
            document.getElementById('csv_academic_year').value = academicYear;
        }
        
        // Enable/disable CSV upload button
        const csvUploadBtn = document.getElementById('csvUploadBtn');
        const csvFileInput = document.getElementById('csvFileInput');
        if (csvUploadBtn && csvFileInput) {
            if (classId && subjectId) {
                csvUploadBtn.disabled = false;
                csvFileInput.disabled = false;
            } else {
                csvUploadBtn.disabled = true;
                csvFileInput.disabled = true;
            }
        }
    }
    
    function downloadTemplate() {
        const classId = document.getElementById('classSelect')?.value || '';
        const subjectId = document.getElementById('subjectSelect')?.value || '';
        
        if (!classId) {
            alert('Please select a class first to download the template.');
            return;
        }
        
        let url = '{{ route("sms.teacher.results.download-template") }}?class_id=' + classId;
        if (subjectId) {
            url += '&subject_id=' + subjectId;
        }
        
        window.location.href = url;
    }
    
    document.getElementById('classSelect')?.addEventListener('change', function() {
        const classId = this.value;
        const subjectId = document.getElementById('subjectSelect')?.value || '';
        updateCsvForm();
        
        if (classId) {
            // Show loading message
            const noStudentsMsg = document.getElementById('noStudentsMessage');
            if (noStudentsMsg) {
                noStudentsMsg.innerHTML = '<div style="font-size: 1.5rem; color: var(--sms-primary); margin-bottom: 1rem;"><i class="fas fa-spinner fa-spin"></i></div><div style="color: var(--sms-gray-600);">Loading students...</div>';
            }
            
            // Reload page with class_id to load students
            window.location.href = '{{ route("sms.teacher.results.upload") }}?class_id=' + classId + (subjectId ? '&subject_id=' + subjectId : '');
        } else {
            // Clear students if no class selected
            const studentsSection = document.querySelector('.sms-form-card:has(.sms-results-table)');
            if (studentsSection) {
                studentsSection.style.display = 'none';
            }
        }
    });
    
    document.getElementById('subjectSelect')?.addEventListener('change', function() {
        updateCsvForm();
    });
    
    document.querySelector('select[name="term"]')?.addEventListener('change', function() {
        updateCsvForm();
    });
    
    document.querySelector('input[name="academic_year"]')?.addEventListener('change', function() {
        updateCsvForm();
    });
    
    // CSV form validation
    document.getElementById('csvUploadForm')?.addEventListener('submit', function(e) {
        const classId = document.getElementById('csv_class_id').value;
        const subjectId = document.getElementById('csv_subject_id').value;
        const file = document.getElementById('csvFileInput').files[0];
        
        if (!classId || !subjectId) {
            e.preventDefault();
            alert('Please select both Class and Subject before uploading CSV.');
            return false;
        }
        
        if (!file) {
            e.preventDefault();
            alert('Please select a CSV file to upload.');
            return false;
        }
    });
    
    // Initialize on page load
    updateCsvForm();
</script>
@endsection
