@extends('layouts.app')

@section('title', 'Create Practice Session - Teacher Dashboard')

@section('content')
@include('sms.partials.design-system')
<style>
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
    .sms-form-input, .sms-form-select, .sms-form-textarea {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 16px;
        min-height: 44px;
        touch-action: manipulation;
        transition: border-color 0.2s;
    }
    .sms-form-textarea {
        min-height: 100px;
        resize: vertical;
        font-size: 16px;
    }
    .sms-form-input:focus, .sms-form-select:focus, .sms-form-textarea:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .sms-grid {
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
    
    @media (min-width: 640px) {
        .sms-form-card {
            padding: 1.5rem;
        }
        
        .sms-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .sms-btn {
            width: auto;
            padding: 0.625rem 1.25rem;
        }
    }
    
    @media (min-width: 768px) {
        .sms-form-card {
            padding: 2rem;
            border-radius: 16px;
        }
        
        .sms-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
    }
    .sms-btn-secondary {
        background: var(--sms-gray-200);
        color: var(--sms-gray-700);
    }
    .sms-btn-danger {
        background: #fee2e2;
        color: #991b1b;
    }
    .question-item {
        background: var(--sms-gray-50);
        border: 1px solid var(--sms-gray-200);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        position: relative;
    }
    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .question-number {
        font-weight: 700;
        color: var(--sms-gray-900);
        font-size: 1rem;
    }
    .options-container {
        margin-top: 1rem;
    }
    .option-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }
    .option-input {
        flex: 1;
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 6px;
    }
    .add-option-btn {
        padding: 0.5rem 1rem;
        background: var(--sms-gray-200);
        color: var(--sms-gray-700);
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 600;
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3); }
        50% { transform: scale(1.05); box-shadow: 0 4px 16px rgba(16, 185, 129, 0.6); }
    }
</style>

<div style="max-width: 1200px; margin: 0 auto; padding: 1rem;">
    <div style="margin-bottom: 1.5rem;">
        <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--sms-gray-900); margin-bottom: 0.5rem; line-height: 1.2;">
            Create Practice Session
        </h1>
        <p style="color: var(--sms-gray-600); font-size: 0.875rem; line-height: 1.5;">Create practice sessions with questions for students to practice</p>
    </div>

    <!-- CSV Upload Form (MUST BE OUTSIDE manual form) -->
    <div style="background: #f0f4ff; border: 1px solid var(--sms-primary); border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
        <h3 style="color: var(--sms-gray-900); font-size: 1rem; font-weight: 700; margin-bottom: 1rem;">
            <i class="fas fa-file-csv"></i> Quick Upload via CSV (Recommended for 10+ questions)
        </h3>
        <p style="color: var(--sms-gray-600); font-size: 0.875rem; margin-bottom: 1rem;">
            Upload a CSV file with all questions. The practice session will be created automatically with all questions loaded.
        </p>
        <form action="{{ route('sms.teacher.practice-sessions.upload-csv') }}" method="POST" enctype="multipart/form-data" id="csvUploadForm" style="margin-bottom: 1rem;">
            @csrf
            <input type="hidden" name="title" id="csv_title" value="">
            <input type="hidden" name="description" id="csv_description" value="">
            <input type="hidden" name="subject_id" id="csv_subject_id" value="">
            <input type="hidden" name="class_id" id="csv_class_id" value="">
            <input type="hidden" name="availability" id="csv_availability" value="">
            <input type="hidden" name="start_date" id="csv_start_date" value="">
            <input type="hidden" name="end_date" id="csv_end_date" value="">
            <input type="hidden" name="show_answers_immediately" id="csv_show_answers" value="1">
            
            <div style="display: flex; gap: 0.75rem; align-items: flex-end;">
                <div style="flex: 1;">
                    <input type="file" name="csv_file" id="csvFileInput" accept=".csv" required style="padding: 0.5rem; border: 2px solid var(--sms-primary); border-radius: 6px; font-size: 0.875rem; width: 100%;">
                </div>
                <button type="submit" class="sms-btn sms-btn-primary" id="csvUploadBtn" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #10b981, #059669); font-size: 1rem; font-weight: 700; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);">
                    <i class="fas fa-upload"></i> Upload & Create Practice Session
                </button>
            </div>
            <div id="csvFileStatus" style="margin-top: 0.5rem; padding: 0.75rem; background: #d1fae5; border: 1px solid #10b981; border-radius: 6px; display: none;">
                <p style="font-size: 0.875rem; color: #065f46; font-weight: 600; margin: 0;">
                    <i class="fas fa-check-circle"></i> CSV file selected! Click the green button above to upload.
                </p>
            </div>
            <p style="font-size: 0.75rem; color: var(--sms-primary); margin-top: 0.5rem; font-weight: 600;">
                <i class="fas fa-info-circle"></i> After selecting your CSV file, click the green "Upload & Create Practice Session" button above to process all questions.
            </p>
            <p style="font-size: 0.75rem; color: var(--sms-gray-600); margin-top: 0.5rem;">
                <strong>CSV Format:</strong> question,option_a,option_b,option_c,option_d,correct_answer,marks
            </p>
        </form>
    </div>

    <div style="text-align: center; margin: 1.5rem 0; color: var(--sms-gray-500); font-weight: 600;">
        <span style="background: white; padding: 0 1rem;">OR</span>
    </div>

    <form action="{{ route('sms.teacher.practice-sessions.store') }}" method="POST" id="practiceForm">
        @csrf

        <div class="sms-form-card">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--sms-gray-900); margin-bottom: 1.5rem;">
                Practice Session Details
            </h2>

            <div class="sms-form-group">
                <label class="sms-form-label">Session Title *</label>
                <input type="text" name="title" class="sms-form-input" required placeholder="e.g., Mathematics Practice - Algebra">
            </div>

            <div class="sms-form-group">
                <label class="sms-form-label">Description</label>
                <textarea name="description" class="sms-form-textarea" placeholder="Optional description"></textarea>
            </div>

            <div class="sms-grid">
                <div class="sms-form-group">
                    <label class="sms-form-label">Subject *</label>
                    <select name="subject_id" class="sms-form-select" required id="subject-select">
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ $subjects->count() === 1 ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @if($subjects->count() === 0)
                        <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">
                            No subjects assigned. Please contact administrator to assign subjects.
                        </div>
                    @elseif($subjects->count() === 1)
                        <div style="color: var(--sms-primary); font-size: 0.8125rem; margin-top: 0.25rem;">
                            <i class="fas fa-info-circle"></i> Subject automatically selected (only one assigned)
                        </div>
                    @endif
                </div>

                <div class="sms-form-group">
                    <label class="sms-form-label">Class *</label>
                    <select name="class_id" class="sms-form-select" required>
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sms-form-group">
                    <label class="sms-form-label">Availability *</label>
                    <select name="availability" class="sms-form-select" required id="availabilitySelect" onchange="toggleDateFields()">
                        <option value="">Select Availability</option>
                        <option value="always_open">Always Open</option>
                        <option value="date_based">Date Based</option>
                    </select>
                </div>

                <div class="sms-form-group" id="startDateGroup" style="display: none;">
                    <label class="sms-form-label">Start Date *</label>
                    <input type="date" name="start_date" class="sms-form-input">
                </div>

                <div class="sms-form-group" id="endDateGroup" style="display: none;">
                    <label class="sms-form-label">End Date *</label>
                    <input type="date" name="end_date" class="sms-form-input">
                </div>
            </div>

            <div class="sms-form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="show_answers_immediately" value="1" checked>
                    <span class="sms-form-label" style="margin: 0;">Show Answers Immediately After Submission</span>
                </label>
            </div>
        </div>

        <div class="sms-form-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--sms-gray-900);">
                    Practice Questions
                </h2>
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <a href="{{ route('sms.teacher.practice-sessions.download-template') }}" class="sms-btn" style="background: var(--sms-gray-200); color: var(--sms-gray-700); padding: 0.5rem 1rem; font-size: 0.875rem;">
                        <i class="fas fa-download"></i> Download CSV Template
                    </a>
                    <a href="{{ route('sms.teacher.practice-sessions.download-english-questions') }}" class="sms-btn" style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 0.5rem 1rem; font-size: 0.875rem;">
                        <i class="fas fa-file-download"></i> Download 100 English Questions
                    </a>
                    <button type="button" class="sms-btn sms-btn-primary" onclick="addQuestion()">
                        <i class="fas fa-plus"></i> Add Question
                    </button>
                </div>
            </div>
            

            <div id="questionsContainer">
                <!-- Questions will be added here dynamically -->
            </div>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('sms.teacher.practice-sessions') }}" class="sms-btn sms-btn-secondary">
                Cancel
            </a>
            <button type="submit" class="sms-btn sms-btn-primary" id="manualSubmitBtn">
                <i class="fas fa-save"></i> Create Practice Session (Manual Entry)
            </button>
        </div>
        <div style="margin-top: 0.5rem; text-align: right;">
            <p style="font-size: 0.75rem; color: var(--sms-gray-600);" id="manualSubmitHelp">
                <i class="fas fa-info-circle"></i> Use this button only if you added questions manually. For CSV upload, use "Upload & Create" above.
            </p>
        </div>
    </form>
</div>

<script>
    let questionCount = 0;

    function toggleDateFields() {
        const availability = document.getElementById('availabilitySelect').value;
        const startDateGroup = document.getElementById('startDateGroup');
        const endDateGroup = document.getElementById('endDateGroup');
        
        if (availability === 'date_based') {
            startDateGroup.style.display = 'block';
            endDateGroup.style.display = 'block';
            startDateGroup.querySelector('input').required = true;
            endDateGroup.querySelector('input').required = true;
        } else {
            startDateGroup.style.display = 'none';
            endDateGroup.style.display = 'none';
            startDateGroup.querySelector('input').required = false;
            endDateGroup.querySelector('input').required = false;
        }
    }

    function addQuestion() {
        questionCount++;
        const container = document.getElementById('questionsContainer');
        const questionDiv = document.createElement('div');
        questionDiv.className = 'question-item';
        questionDiv.id = `question-${questionCount}`;
        
        questionDiv.innerHTML = `
            <div class="question-header">
                <span class="question-number">Question ${questionCount}</span>
                <button type="button" class="sms-btn sms-btn-danger" onclick="removeQuestion(${questionCount})" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
            
            <div class="sms-form-group">
                <label class="sms-form-label">Question Text *</label>
                <textarea name="questions[${questionCount}][question_text]" class="sms-form-textarea" required placeholder="Enter your question here"></textarea>
            </div>
            
            <div class="sms-form-group">
                <label class="sms-form-label">Question Type *</label>
                <select name="questions[${questionCount}][question_type]" class="sms-form-select" required onchange="toggleOptions(${questionCount}, this.value)">
                    <option value="">Select Type</option>
                    <option value="objective">Objective (Multiple Choice)</option>
                    <option value="theory">Theory (Essay)</option>
                    <option value="mixed">Mixed</option>
                </select>
            </div>
            
            <div id="options-${questionCount}" class="options-container" style="display: none;">
                <label class="sms-form-label">Options (for Objective questions)</label>
                <div id="options-list-${questionCount}">
                    <div class="option-item">
                        <input type="text" class="option-input" name="questions[${questionCount}][options][]" placeholder="Option A">
                        <input type="radio" name="questions[${questionCount}][correct_option]" value="0" required>
                        <span>Correct</span>
                    </div>
                    <div class="option-item">
                        <input type="text" class="option-input" name="questions[${questionCount}][options][]" placeholder="Option B">
                        <input type="radio" name="questions[${questionCount}][correct_option]" value="1">
                        <span>Correct</span>
                    </div>
                </div>
                <button type="button" class="add-option-btn" onclick="addOption(${questionCount})">
                    <i class="fas fa-plus"></i> Add Option
                </button>
            </div>
            
            <div class="sms-form-group">
                <label class="sms-form-label">Correct Answer</label>
                <input type="text" name="questions[${questionCount}][correct_answer]" class="sms-form-input" placeholder="Correct answer (will be auto-filled for objective)">
            </div>
            
            <div class="sms-form-group">
                <label class="sms-form-label">Explanation</label>
                <textarea name="questions[${questionCount}][explanation]" class="sms-form-textarea" placeholder="Explanation shown after student answers"></textarea>
            </div>
            
            <div class="sms-form-group">
                <label class="sms-form-label">Instructions</label>
                <textarea name="questions[${questionCount}][instructions]" class="sms-form-textarea" placeholder="Optional instructions"></textarea>
            </div>
            
            <div class="sms-form-group">
                <label class="sms-form-label">Marks *</label>
                <input type="number" name="questions[${questionCount}][marks]" class="sms-form-input" required min="1" value="1">
            </div>
        `;
        
        container.appendChild(questionDiv);
    }

    function removeQuestion(id) {
        const questionDiv = document.getElementById(`question-${id}`);
        if (questionDiv) {
            questionDiv.remove();
            updateQuestionNumbers();
        }
    }

    function toggleOptions(questionId, questionType) {
        const optionsContainer = document.getElementById(`options-${questionId}`);
        if (questionType === 'objective' || questionType === 'mixed') {
            optionsContainer.style.display = 'block';
        } else {
            optionsContainer.style.display = 'none';
        }
    }

    function addOption(questionId) {
        const optionsList = document.getElementById(`options-list-${questionId}`);
        const optionCount = optionsList.children.length;
        const optionDiv = document.createElement('div');
        optionDiv.className = 'option-item';
        optionDiv.innerHTML = `
            <input type="text" class="option-input" name="questions[${questionId}][options][]" placeholder="Option ${String.fromCharCode(65 + optionCount)}">
            <input type="radio" name="questions[${questionId}][correct_option]" value="${optionCount}">
            <span>Correct</span>
            <button type="button" class="sms-btn sms-btn-danger" onclick="this.parentElement.remove()" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                <i class="fas fa-times"></i>
            </button>
        `;
        optionsList.appendChild(optionDiv);
    }

    function updateQuestionNumbers() {
        const questions = document.querySelectorAll('.question-item');
        questions.forEach((question, index) => {
            const numberSpan = question.querySelector('.question-number');
            if (numberSpan) {
                numberSpan.textContent = `Question ${index + 1}`;
            }
        });
    }

    // Sync form data to CSV upload form
    function syncFormDataToCsv() {
        const mainForm = document.getElementById('practiceForm');
        const csvForm = document.getElementById('csvUploadForm');
        
        if (!mainForm || !csvForm) return;
        
        // Sync all form fields
        const title = mainForm.querySelector('input[name="title"]')?.value || '';
        const description = mainForm.querySelector('textarea[name="description"]')?.value || '';
        const subjectId = mainForm.querySelector('select[name="subject_id"]')?.value || '';
        const classId = mainForm.querySelector('select[name="class_id"]')?.value || '';
        const availability = mainForm.querySelector('select[name="availability"]')?.value || '';
        const startDate = mainForm.querySelector('input[name="start_date"]')?.value || '';
        const endDate = mainForm.querySelector('input[name="end_date"]')?.value || '';
        const showAnswers = mainForm.querySelector('input[name="show_answers_immediately"]')?.checked ? '1' : '0';
        
        // Set hidden field values
        const csvTitle = csvForm.querySelector('#csv_title');
        const csvDescription = csvForm.querySelector('#csv_description');
        const csvSubjectId = csvForm.querySelector('#csv_subject_id');
        const csvClassId = csvForm.querySelector('#csv_class_id');
        const csvAvailability = csvForm.querySelector('#csv_availability');
        const csvStartDate = csvForm.querySelector('#csv_start_date');
        const csvEndDate = csvForm.querySelector('#csv_end_date');
        const csvShowAnswers = csvForm.querySelector('#csv_show_answers');
        
        if (csvTitle) csvTitle.value = title;
        if (csvDescription) csvDescription.value = description;
        if (csvSubjectId) csvSubjectId.value = subjectId;
        if (csvClassId) csvClassId.value = classId;
        if (csvAvailability) csvAvailability.value = availability;
        if (csvStartDate) csvStartDate.value = startDate;
        if (csvEndDate) csvEndDate.value = endDate;
        if (csvShowAnswers) csvShowAnswers.value = showAnswers;
        
        // Always enable the button - validation will happen on server side
        const csvUploadBtn = csvForm.querySelector('#csvUploadBtn');
        if (csvUploadBtn) {
            csvUploadBtn.disabled = false;
            csvUploadBtn.style.opacity = '1';
            csvUploadBtn.style.cursor = 'pointer';
        }
    }
    
    // Update CSV form when main form changes
    document.getElementById('practiceForm')?.addEventListener('input', syncFormDataToCsv);
    document.getElementById('practiceForm')?.addEventListener('change', syncFormDataToCsv);
    document.getElementById('csvFileInput')?.addEventListener('change', syncFormDataToCsv);
    
    // Validate CSV form before submit
    document.getElementById('csvUploadForm')?.addEventListener('submit', function(e) {
        // Get values directly from main form (more reliable) - DO THIS SYNCHRONOUSLY
        const mainForm = document.getElementById('practiceForm');
        const title = mainForm?.querySelector('input[name="title"]')?.value || '';
        const description = mainForm?.querySelector('textarea[name="description"]')?.value || '';
        const subjectId = mainForm?.querySelector('select[name="subject_id"]')?.value || '';
        const classId = mainForm?.querySelector('select[name="class_id"]')?.value || '';
        const availability = mainForm?.querySelector('select[name="availability"]')?.value || '';
        const startDate = mainForm?.querySelector('input[name="start_date"]')?.value || '';
        const endDate = mainForm?.querySelector('input[name="end_date"]')?.value || '';
        const showAnswers = mainForm?.querySelector('input[name="show_answers_immediately"]')?.checked ? '1' : '0';
        const csvFile = document.getElementById('csvFileInput')?.files[0];
        
        // Update hidden fields with current values IMMEDIATELY
        document.getElementById('csv_title').value = title;
        document.getElementById('csv_description').value = description;
        document.getElementById('csv_subject_id').value = subjectId;
        document.getElementById('csv_class_id').value = classId;
        document.getElementById('csv_availability').value = availability;
        document.getElementById('csv_start_date').value = startDate;
        document.getElementById('csv_end_date').value = endDate;
        document.getElementById('csv_show_answers').value = showAnswers;
        
        // Validate
        if (!title || !subjectId || !classId || !availability) {
            e.preventDefault();
            e.stopPropagation();
            alert('Please fill in all required fields (Title, Subject, Class, Availability) in the form above before uploading CSV.');
            return false;
        }
        
        if (!csvFile) {
            e.preventDefault();
            e.stopPropagation();
            alert('Please select a CSV file to upload.');
            return false;
        }
        
        if (availability === 'date_based' && (!startDate || !endDate)) {
            e.preventDefault();
            e.stopPropagation();
            alert('Please select Start Date and End Date for date-based availability.');
            return false;
        }
        
        // Show loading state
        const btn = document.getElementById('csvUploadBtn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
        }
        
        // Allow form to submit - don't prevent default
        console.log('CSV form submitting with:', { title, subjectId, classId, availability, csvFile: csvFile?.name });
        return true;
    });

    // Disable manual submit button when CSV is selected
    function updateManualSubmitButton() {
        const csvFile = document.getElementById('csvFileInput')?.files.length > 0;
        const manualBtn = document.getElementById('manualSubmitBtn');
        const helpText = document.getElementById('manualSubmitHelp');
        
        if (csvFile && manualBtn) {
            manualBtn.disabled = true;
            manualBtn.style.opacity = '0.5';
            manualBtn.style.cursor = 'not-allowed';
            if (helpText) {
                helpText.innerHTML = '<span style="color: #dc2626; font-weight: 600;"><i class="fas fa-exclamation-triangle"></i> CSV file selected! Use the green "Upload & Create Practice Session" button above instead.</span>';
            }
        } else if (manualBtn) {
            manualBtn.disabled = false;
            manualBtn.style.opacity = '1';
            manualBtn.style.cursor = 'pointer';
            if (helpText) {
                helpText.innerHTML = '<i class="fas fa-info-circle"></i> Use this button only if you added questions manually. For CSV upload, use "Upload & Create" above.';
            }
        }
    }
    
    // Add first question on page load
    document.addEventListener('DOMContentLoaded', function() {
        addQuestion();
        syncFormDataToCsv();
        updateManualSubmitButton();
        
        // Sync on any form change
        const mainForm = document.getElementById('practiceForm');
        if (mainForm) {
            mainForm.addEventListener('input', function() {
                syncFormDataToCsv();
                updateManualSubmitButton();
            });
            mainForm.addEventListener('change', function() {
                syncFormDataToCsv();
                updateManualSubmitButton();
            });
        }
        
        // Sync when CSV file is selected
        const csvFileInput = document.getElementById('csvFileInput');
        if (csvFileInput) {
            csvFileInput.addEventListener('change', function() {
                syncFormDataToCsv();
                updateManualSubmitButton();
                
                // Show status message
                const statusDiv = document.getElementById('csvFileStatus');
                if (statusDiv && this.files.length > 0) {
                    statusDiv.style.display = 'block';
                    statusDiv.querySelector('p').innerHTML = '<i class="fas fa-check-circle"></i> CSV file selected: <strong>' + this.files[0].name + '</strong> - Click the green button above to upload.';
                } else if (statusDiv) {
                    statusDiv.style.display = 'none';
                }
                
                console.log('CSV file selected, form data synced, manual button disabled');
            });
        }
    });

    // Form submission handler for manual form
    document.getElementById('practiceForm').addEventListener('submit', function(e) {
        const questions = document.querySelectorAll('.question-item');
        const csvFile = document.getElementById('csvFileInput')?.files.length > 0;
        const manualBtn = document.getElementById('manualSubmitBtn');
        
        // If CSV file is selected OR manual button is disabled, prevent manual form submission
        if (csvFile || (manualBtn && manualBtn.disabled)) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            // Scroll to CSV upload section
            document.getElementById('csvUploadForm')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Highlight the CSV upload button
            const csvBtn = document.getElementById('csvUploadBtn');
            if (csvBtn) {
                csvBtn.style.animation = 'pulse 2s infinite';
                csvBtn.style.border = '3px solid #10b981';
                csvBtn.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    csvBtn.style.animation = '';
                    csvBtn.style.border = '';
                    csvBtn.style.transform = '';
                }, 3000);
            }
            
            alert('You have selected a CSV file. Please scroll up and click the green "Upload & Create Practice Session" button in the CSV Upload section to process your file. Do NOT use the "Create Practice Session (Manual Entry)" button at the bottom.');
            return false;
        }
        
        // If no CSV and no questions, show error
        if (questions.length === 0) {
            e.preventDefault();
            e.stopPropagation();
            alert('Please add at least one question manually using "Add Question" button, OR upload a CSV file using the "Upload & Create Practice Session" button above.');
            return false;
        }
        
        // Process options for objective questions
        questions.forEach((question, index) => {
            const questionType = question.querySelector('select[name*="[question_type]"]')?.value;
            if (questionType === 'objective' || questionType === 'mixed') {
                const options = question.querySelectorAll('input[name*="[options][]"]');
                const correctOption = question.querySelector('input[name*="[correct_option]"]:checked');
                if (correctOption) {
                    const correctIndex = parseInt(correctOption.value);
                    const correctAnswer = options[correctIndex]?.value;
                    if (correctAnswer) {
                        // Set correct answer
                        const correctAnswerInput = question.querySelector('input[name*="[correct_answer]"]');
                        if (correctAnswerInput) {
                            correctAnswerInput.value = correctAnswer;
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
