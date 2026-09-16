@extends('layouts.app')

@section('title', 'Results Entry - Teacher Dashboard')

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
    .filter-section {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .filter-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--sms-gray-700);
        font-size: 0.875rem;
    }
    .form-control {
        width: 100%;
        padding: 0.875rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 16px;
        min-height: 44px;
        touch-action: manipulation;
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
    }
    .sms-btn-primary:active {
        transform: scale(0.98);
    }
    .sms-btn-secondary {
        background: var(--sms-gray-100);
        color: var(--sms-gray-700);
    }
    .results-section {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .results-table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin-top: 1rem;
    }
    .results-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }
    .results-table th,
    .results-table td {
        padding: 0.75rem 0.5rem;
        text-align: left;
        border-bottom: 1px solid var(--sms-gray-200);
        font-size: 0.875rem;
    }
    .results-table th {
        background: var(--sms-gray-50);
        font-weight: 600;
        color: var(--sms-gray-700);
        font-size: 0.75rem;
        white-space: nowrap;
    }
    .results-table input[type="number"] {
        width: 70px;
        padding: 0.5rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 6px;
        font-size: 16px;
        min-height: 44px;
        touch-action: manipulation;
    }
    
    @media (min-width: 640px) {
        .sms-page-header {
            padding: 1.5rem;
            margin: -1.5rem -1.5rem 1.5rem -1.5rem;
        }
        
        .sms-page-title {
            font-size: 1.75rem;
        }
        
        .filter-section {
            padding: 1.5rem;
        }
        
        .filter-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .sms-btn {
            width: auto;
            padding: 0.625rem 1.25rem;
        }
        
        .results-section {
            padding: 1.5rem;
        }
        
        .results-table th,
        .results-table td {
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
        }
        
        .results-table input[type="number"] {
            width: 80px;
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
        
        .filter-section {
            border-radius: 16px;
            padding: 1.5rem;
        }
        
        .filter-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
        
        .results-section {
            border-radius: 16px;
            padding: 1.5rem;
        }
    }
    .csv-upload-section {
        background: var(--sms-gray-50);
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 2rem;
        border: 2px dashed var(--sms-gray-300);
    }
    .tab-buttons {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid var(--sms-gray-200);
    }
    .tab-button {
        padding: 0.75rem 1.5rem;
        background: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        font-weight: 600;
        color: var(--sms-gray-600);
        transition: all 0.2s;
    }
    .tab-button.active {
        color: var(--sms-primary);
        border-bottom-color: var(--sms-primary);
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
</style>

<div class="sms-dashboard">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 1rem;">
        <div class="sms-page-header">
            <h1 class="sms-page-title">Results Entry</h1>
            <p class="text-muted" style="color: var(--sms-gray-600); font-size: 0.875rem; line-height: 1.5;">Enter student scores for CA and Exams. The system will automatically calculate totals, grades, remarks, and positions. All results are connected to student dashboards and admin reports.</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" action="{{ route('sms.teacher.results-entry.index') }}" id="filterForm">
                <div class="filter-grid">
                    <div class="form-group">
                        <label>Class *</label>
                        <select name="class_id" class="form-control" required onchange="document.getElementById('filterForm').submit()">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Subject *</label>
                        <select name="subject_id" class="form-control" required onchange="document.getElementById('filterForm').submit()">
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $selectedSubjectId == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Academic Year</label>
                        <input type="text" name="academic_year" class="form-control" value="{{ $selectedYear }}" placeholder="2024/2025" required>
                    </div>

                    <div class="form-group">
                        <label>Term</label>
                        <select name="term" class="form-control" required>
                            <option value="First Term" {{ $selectedTerm == 'First Term' ? 'selected' : '' }}>First Term</option>
                            <option value="Second Term" {{ $selectedTerm == 'Second Term' ? 'selected' : '' }}>Second Term</option>
                            <option value="Third Term" {{ $selectedTerm == 'Third Term' ? 'selected' : '' }}>Third Term</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Exam Type</label>
                        <select name="exam_type" class="form-control" required>
                            <option value="CA1" {{ $selectedExamType == 'CA1' ? 'selected' : '' }}>CA1</option>
                            <option value="CA2" {{ $selectedExamType == 'CA2' ? 'selected' : '' }}>CA2</option>
                            <option value="Test" {{ $selectedExamType == 'Test' ? 'selected' : '' }}>Test</option>
                            <option value="Exam" {{ $selectedExamType == 'Exam' ? 'selected' : '' }}>Exam</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="sms-btn sms-btn-primary">Load Students</button>
            </form>
        </div>

        @if($selectedClassId && $selectedSubjectId && $students->count() > 0)
        <div class="results-section">
            <div class="tab-buttons">
                <button class="tab-button active" onclick="showTab('manual', this)">Manual Entry</button>
                <button class="tab-button" onclick="showTab('csv', this)">CSV Upload</button>
            </div>

            <!-- Manual Entry Tab -->
            <div id="manual-tab" class="tab-content active">
                <form method="POST" action="{{ route('sms.teacher.results-entry.store') }}" id="resultsForm">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                    <input type="hidden" name="subject_id" value="{{ $selectedSubjectId }}">
                    <input type="hidden" name="academic_year" value="{{ $selectedYear }}">
                    <input type="hidden" name="term" value="{{ $selectedTerm }}">
                    <input type="hidden" name="exam_type" value="{{ $selectedExamType }}">

                    <div class="results-table-wrapper">
                        <table class="results-table">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>CA1 (0-100)</th>
                                    <th>CA2 (0-100)</th>
                                    <th>Exam (0-100)</th>
                                    <th>Total</th>
                                    <th>Grade</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $index => $student)
                                @php
                                    $existingResult = $existingResults->get($student->id);
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->student_id_number }}</td>
                                    <td>{{ $student->user->name ?? 'N/A' }}</td>
                                    <td>
                                        <input type="number" 
                                               name="results[{{ $index }}][ca1_score]" 
                                               value="{{ ($existingResult && $existingResult->ca1_score >= 1) ? number_format($existingResult->ca1_score, 2) : '' }}"
                                               min="0" 
                                               max="100" 
                                               step="0.01"
                                               class="ca1-score"
                                               data-index="{{ $index }}"
                                               onchange="calculateTotal({{ $index }})"
                                               style="width: 70px; padding: 0.5rem; font-size: 0.875rem;"
                                               placeholder="">
                                        <input type="hidden" name="results[{{ $index }}][student_id]" value="{{ $student->id }}">
                                    </td>
                                    <td>
                                        <input type="number" 
                                               name="results[{{ $index }}][ca2_score]" 
                                               value="{{ ($existingResult && $existingResult->ca2_score >= 1) ? number_format($existingResult->ca2_score, 2) : '' }}"
                                               min="0" 
                                               max="100" 
                                               step="0.01"
                                               class="ca2-score"
                                               data-index="{{ $index }}"
                                               onchange="calculateTotal({{ $index }})"
                                               style="width: 70px; padding: 0.5rem; font-size: 0.875rem;"
                                               placeholder="">
                                    </td>
                                    <td>
                                        <input type="number" 
                                               name="results[{{ $index }}][exam_score]" 
                                               value="{{ ($existingResult && $existingResult->exam_score >= 1) ? number_format($existingResult->exam_score, 2) : '' }}"
                                               min="0" 
                                               max="100" 
                                               step="0.01"
                                               class="exam-score"
                                               data-index="{{ $index }}"
                                               onchange="calculateTotal({{ $index }})"
                                               style="width: 70px; padding: 0.5rem; font-size: 0.875rem;"
                                               placeholder="">
                                    </td>
                                    <td>
                                        <span class="total-score" data-index="{{ $index }}">
                                            {{ $existingResult ? number_format($existingResult->total_score, 2) : '0.00' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="grade" data-index="{{ $index }}">
                                            {{ $existingResult->grade ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="remark" data-index="{{ $index }}">
                                            {{ $existingResult->remark ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                        <button type="submit" class="sms-btn sms-btn-primary">Save All Results</button>
                        <button type="button" class="sms-btn sms-btn-secondary" onclick="clearAllScores()">Clear All</button>
                    </div>
                </form>
                
                <div style="margin-top: 2rem; padding: 1rem; background: var(--sms-gray-50); border-radius: 8px; border-left: 4px solid var(--sms-primary);">
                    <p style="font-size: 0.875rem; color: var(--sms-gray-700); margin-bottom: 0.5rem;">
                        <strong>Note:</strong> Psychomotor and Affective Domain assessments are typically entered once per term for all students. These assessments are separate from exam scores and are used in comprehensive student reports.
                    </p>
                    <p style="font-size: 0.8125rem; color: var(--sms-gray-600);">
                        All entered results are automatically:
                    </p>
                    <ul style="font-size: 0.8125rem; color: var(--sms-gray-600); margin-top: 0.5rem; padding-left: 1.5rem;">
                        <li>Calculated (totals, grades, remarks, positions)</li>
                        <li>Connected to student dashboards</li>
                        <li>Available in admin reports</li>
                        <li>Included in report cards with attendance data</li>
                    </ul>
                </div>
            </div>

            <!-- CSV Upload Tab -->
            <div id="csv-tab" class="tab-content">
                <div class="csv-upload-section">
                    <h4 style="margin-bottom: 1rem;">Upload Results via CSV</h4>
                    <p style="color: var(--sms-gray-600); margin-bottom: 1rem;">
                        Download the CSV template, fill in the scores, and upload it here.
                    </p>

                    <div style="display: flex; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                        <a href="{{ route('sms.teacher.results-entry.download-template', ['class_id' => $selectedClassId, 'subject_id' => $selectedSubjectId]) }}" 
                           class="sms-btn sms-btn-secondary">
                            <i class="fas fa-download"></i> Download CSV Template
                        </a>
                    </div>

                    <form method="POST" action="{{ route('sms.teacher.results-entry.upload-csv') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                        <input type="hidden" name="subject_id" value="{{ $selectedSubjectId }}">
                        <input type="hidden" name="academic_year" value="{{ $selectedYear }}">
                        <input type="hidden" name="term" value="{{ $selectedTerm }}">
                        <input type="hidden" name="exam_type" value="{{ $selectedExamType }}">

                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label>CSV File</label>
                            <input type="file" name="csv_file" class="form-control" accept=".csv,.txt" required>
                            <small style="color: var(--sms-gray-600);">CSV Format: Student ID, Fullname, Class, Subject, CA1, CA2, Exam</small>
                        </div>

                        <button type="submit" class="sms-btn sms-btn-primary">Upload & Process CSV</button>
                    </form>
                </div>
            </div>
        @endif

        <!-- Psychomotor & Affective Assessments Section (No subject required) -->
        @if($selectedClassId && $students->count() > 0)
        <div class="results-section" style="margin-top: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--sms-gray-900); margin-bottom: 1.5rem;">
                Psychomotor & Affective Domain Assessments
            </h2>
            <p style="color: var(--sms-gray-600); font-size: 0.875rem; margin-bottom: 1.5rem;">
                Enter psychomotor skills and affective domain assessments for all students in this class. These are entered once per term and apply to all subjects.
            </p>

            <div class="tab-buttons">
                <button class="tab-button active" onclick="showTab('psychomotor-manual', this)">Manual Entry</button>
                <button class="tab-button" onclick="showTab('psychomotor-csv', this)">CSV Upload</button>
            </div>

            <!-- Manual Psychomotor Entry Tab -->
            <div id="psychomotor-manual-tab" class="tab-content active">
                <form method="POST" action="{{ route('sms.teacher.results-entry.store-assessments') }}" id="psychomotorForm">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                    <input type="hidden" name="academic_year" value="{{ $selectedYear }}">
                    <input type="hidden" name="term" value="{{ $selectedTerm }}">

                    <div class="results-table-wrapper">
                        <table class="results-table" style="min-width: 1600px;">
                            <thead>
                                <tr>
                                    <th rowspan="2">S/N</th>
                                    <th rowspan="2">Student ID</th>
                                    <th rowspan="2">Student Name</th>
                                    <th colspan="3" style="text-align: center; background: #d1fae5;">Attendance</th>
                                    <th colspan="7" style="text-align: center; background: #dbeafe;">Affective Domain (1-4)</th>
                                    <th colspan="6" style="text-align: center; background: #fef3c7;">Psychomotor Skills (1-4)</th>
                                    <th rowspan="2">Teacher Remark</th>
                                </tr>
                                <tr>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Late</th>
                                    <th>Punctuality</th>
                                    <th>Honesty</th>
                                    <th>Neatness</th>
                                    <th>Politeness</th>
                                    <th>Obedience</th>
                                    <th>Self Control</th>
                                    <th>Relationship</th>
                                    <th>Handling Tools</th>
                                    <th>Drawing/Painting</th>
                                    <th>Handwriting</th>
                                    <th>Musical</th>
                                    <th>Public Speaking</th>
                                    <th>Sports/Gaming</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $index => $student)
                                @php
                                    $assessment = $existingAssessments->get($student->id) ?? null;
                                    $attendance = $attendanceStats[$student->id] ?? ['present' => 0, 'absent' => 0, 'late' => 0];
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->student_id_number }}</td>
                                    <td>{{ $student->user->name ?? 'N/A' }}</td>
                                    <!-- Attendance -->
                                    <td>
                                        <input type="number" 
                                               name="assessments[{{ $index }}][no_of_times_present]" 
                                               value="{{ $assessment->no_of_times_present ?? $attendance['present'] }}" 
                                               min="0" 
                                               class="form-control" 
                                               style="width: 70px; padding: 0.5rem; font-size: 0.875rem;">
                                    </td>
                                    <td>
                                        <input type="number" 
                                               name="assessments[{{ $index }}][no_of_times_absent]" 
                                               value="{{ $assessment->no_of_times_absent ?? $attendance['absent'] }}" 
                                               min="0" 
                                               class="form-control" 
                                               style="width: 70px; padding: 0.5rem; font-size: 0.875rem;">
                                    </td>
                                    <td>
                                        <input type="number" 
                                               name="assessments[{{ $index }}][no_of_times_late]" 
                                               value="{{ $assessment->no_of_times_late ?? $attendance['late'] }}" 
                                               min="0" 
                                               class="form-control" 
                                               style="width: 70px; padding: 0.5rem; font-size: 0.875rem;">
                                    </td>
                                    <!-- Affective Domain -->
                                    <td><input type="number" name="assessments[{{ $index }}][punctuality]" value="{{ $assessment->punctuality ?? 4 }}" min="1" max="4" class="form-control" style="width: 60px; padding: 0.5rem; font-size: 0.875rem;" required></td>
                                    <td><input type="number" name="assessments[{{ $index }}][honesty]" value="{{ $assessment->honesty ?? 4 }}" min="1" max="4" class="form-control" style="width: 60px; padding: 0.5rem; font-size: 0.875rem;" required></td>
                                    <td><input type="number" name="assessments[{{ $index }}][neatness]" value="{{ $assessment->neatness ?? 4 }}" min="1" max="4" class="form-control" style="width: 60px; padding: 0.5rem; font-size: 0.875rem;" required></td>
                                    <td><input type="number" name="assessments[{{ $index }}][politeness]" value="{{ $assessment->politeness ?? 4 }}" min="1" max="4" class="form-control" style="width: 60px; padding: 0.5rem; font-size: 0.875rem;" required></td>
                                    <td><input type="number" name="assessments[{{ $index }}][obedience]" value="{{ $assessment->obedience ?? 4 }}" min="1" max="4" class="form-control" style="width: 60px; padding: 0.5rem; font-size: 0.875rem;" required></td>
                                    <td><input type="number" name="assessments[{{ $index }}][self_control]" value="{{ $assessment->self_control ?? 4 }}" min="1" max="4" class="form-control" style="width: 60px; padding: 0.5rem; font-size: 0.875rem;" required></td>
                                    <td><input type="number" name="assessments[{{ $index }}][relationship_with_others]" value="{{ $assessment->relationship_with_others ?? 4 }}" min="1" max="4" class="form-control" style="width: 60px; padding: 0.5rem; font-size: 0.875rem;" required></td>
                                    <!-- Psychomotor Skills -->
                                    <td><input type="number" name="assessments[{{ $index }}][handling_of_tools]" value="{{ $assessment->handling_of_tools ?? 4 }}" min="1" max="4" class="form-control" style="width: 60px; padding: 0.5rem; font-size: 0.875rem;" required></td>
                                    <td><input type="number" name="assessments[{{ $index }}][drawing_painting]" value="{{ $assessment->drawing_painting ?? 4 }}" min="1" max="4" class="form-control" style="width: 60px; padding: 0.5rem; font-size: 0.875rem;" required></td>
                                    <td><input type="number" name="assessments[{{ $index }}][handwriting]" value="{{ $assessment->handwriting ?? 4 }}" min="1" max="4" class="form-control" style="width: 60px; padding: 0.5rem; font-size: 0.875rem;" required></td>
                                    <td><input type="number" name="assessments[{{ $index }}][musical_skill]" value="{{ $assessment->musical_skill ?? 4 }}" min="1" max="4" class="form-control" style="width: 60px; padding: 0.5rem; font-size: 0.875rem;" required></td>
                                    <td><input type="number" name="assessments[{{ $index }}][public_speaking]" value="{{ $assessment->public_speaking ?? 4 }}" min="1" max="4" class="form-control" style="width: 60px; padding: 0.5rem; font-size: 0.875rem;" required></td>
                                    <td><input type="number" name="assessments[{{ $index }}][sports_gaming]" value="{{ $assessment->sports_gaming ?? 4 }}" min="1" max="4" class="form-control" style="width: 60px; padding: 0.5rem; font-size: 0.875rem;" required></td>
                                    <!-- Teacher Remark -->
                                    <td>
                                        <textarea name="assessments[{{ $index }}][teacher_remark]" 
                                                  class="form-control" 
                                                  rows="2" 
                                                  style="width: 150px; padding: 0.5rem; font-size: 0.875rem; min-height: 44px; resize: vertical;">{{ $assessment->teacher_remark ?? '' }}</textarea>
                                    </td>
                                    <input type="hidden" name="assessments[{{ $index }}][student_id]" value="{{ $student->id }}">
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                        <button type="submit" class="sms-btn sms-btn-primary">Save All Assessments</button>
                    </div>
                </form>
            </div>

            <!-- CSV Upload Tab for Psychomotor -->
            <div id="psychomotor-csv-tab" class="tab-content">
                <div class="csv-upload-section">
                    <h4 style="margin-bottom: 1rem;">Upload Psychomotor & Affective Assessments via CSV</h4>
                    <p style="color: var(--sms-gray-600); margin-bottom: 1rem;">
                        Download the CSV template, fill in the assessments (1-4 scale), and upload it here.
                    </p>

                    <div style="display: flex; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                        <a href="{{ route('sms.teacher.results-entry.download-psychomotor-template', ['class_id' => $selectedClassId, 'academic_year' => $selectedYear, 'term' => $selectedTerm]) }}" 
                           class="sms-btn sms-btn-secondary">
                            <i class="fas fa-download"></i> Download CSV Template
                        </a>
                    </div>

                    <form method="POST" action="{{ route('sms.teacher.results-entry.upload-psychomotor-csv') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                        <input type="hidden" name="academic_year" value="{{ $selectedYear }}">
                        <input type="hidden" name="term" value="{{ $selectedTerm }}">

                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label>CSV File</label>
                            <input type="file" name="csv_file" class="form-control" accept=".csv,.txt" required>
                            <small style="color: var(--sms-gray-600); display: block; margin-top: 0.5rem;">
                                CSV Format: Student ID, Fullname, Class, No of Times Present, No of Times Absent, No of Times Late, Punctuality (1-4), Honesty (1-4), Neatness (1-4), Politeness (1-4), Obedience (1-4), Self Control (1-4), Relationship with Others (1-4), Handling of Tools (1-4), Drawing/Painting (1-4), Handwriting (1-4), Musical Skill (1-4), Public Speaking (1-4), Sports/Gaming (1-4), Teacher Remark
                            </small>
                        </div>

                        <button type="submit" class="sms-btn sms-btn-primary">Upload & Process CSV</button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        @if($selectedClassId && $selectedSubjectId && $students->count() == 0)
            <div class="alert alert-info">
                No active students found in the selected class.
            </div>
        @else
            <div class="alert alert-info">
                Please select a class and subject to begin entering results.
            </div>
        @endif
    </div>
</div>

<script>
function showTab(tabName, element) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active');
    });

    // Show selected tab
    const targetTab = document.getElementById(tabName + '-tab');
    if (targetTab) {
        targetTab.classList.add('active');
    }
    if (element) {
        element.classList.add('active');
    } else if (event && event.target) {
        event.target.classList.add('active');
    }
}

function calculateTotal(index) {
    const caInput = document.querySelector(`.ca-score[data-index="${index}"]`);
    const examInput = document.querySelector(`.exam-score[data-index="${index}"]`);
    const totalSpan = document.querySelector(`.total-score[data-index="${index}"]`);
    const gradeSpan = document.querySelector(`.grade[data-index="${index}"]`);
    const remarkSpan = document.querySelector(`.remark[data-index="${index}"]`);

    const caScore = parseFloat(caInput.value) || 0;
    const examScore = parseFloat(examInput.value) || 0;
    const total = caScore + examScore;

    totalSpan.textContent = total.toFixed(2);

    // Calculate grade and remark
    let grade = '-';
    let remark = '-';

    if (total > 0) {
        if (total >= 75) {
            grade = 'A';
            remark = 'Excellent';
        } else if (total >= 70) {
            grade = 'B';
            remark = 'Very Good';
        } else if (total >= 65) {
            grade = 'C';
            remark = 'Good';
        } else if (total >= 60) {
            grade = 'D';
            remark = 'Credit';
        } else if (total >= 50) {
            grade = 'E';
            remark = 'Pass';
        } else {
            grade = 'F';
            remark = 'Fail';
        }
    }

    gradeSpan.textContent = grade;
    remarkSpan.textContent = remark;
}

function clearAllScores() {
    if (confirm('Are you sure you want to clear all scores?')) {
        document.querySelectorAll('.ca-score, .exam-score').forEach(input => {
            input.value = '';
        });
        document.querySelectorAll('.total-score').forEach(span => {
            span.textContent = '0.00';
        });
        document.querySelectorAll('.grade').forEach(span => {
            span.textContent = '-';
        });
        document.querySelectorAll('.remark').forEach(span => {
            span.textContent = '-';
        });
    }
}

// Calculate totals on page load for existing results
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.ca-score').forEach(input => {
        const index = input.getAttribute('data-index');
        calculateTotal(index);
    });
});
</script>
@endsection
