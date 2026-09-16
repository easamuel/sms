@extends('layouts.app')

@section('title', 'Create Assignment - Teacher Dashboard')

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
</style>

<div style="max-width: 1200px; margin: 0 auto; padding: 1rem;">
    <div style="margin-bottom: 1.5rem;">
        <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--sms-gray-900); margin-bottom: 0.5rem; line-height: 1.2;">
            Create Assignment
        </h1>
        <p style="color: var(--sms-gray-600); font-size: 0.875rem; line-height: 1.5;">Create online or offline assignments with questions</p>
    </div>

    <form action="{{ route('sms.teacher.assignments.store') }}" method="POST" id="assignmentForm">
        @csrf

        <div class="sms-form-card">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--sms-gray-900); margin-bottom: 1.5rem;">
                Assignment Details
            </h2>

            <div class="sms-form-group">
                <label class="sms-form-label">Assignment Title *</label>
                <input type="text" name="title" class="sms-form-input" required placeholder="e.g., Mathematics Homework - Chapter 5">
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
                    <label class="sms-form-label">Submission Type *</label>
                    <select name="submission_type" class="sms-form-select" required id="submission-type">
                        <option value="">Select Type</option>
                        @if($teacher->teacher_type === 'secondary')
                            <option value="online">Online</option>
                            <option value="offline">Offline/Manual</option>
                            <option value="both">Both</option>
                        @else
                            <option value="offline">Offline/Manual</option>
                        @endif
                    </select>
                    @if($teacher->teacher_type === 'primary')
                        <div style="color: var(--sms-gray-600); font-size: 0.8125rem; margin-top: 0.25rem;">
                            <i class="fas fa-info-circle"></i> Primary teachers can only create offline assignments
                        </div>
                    @endif
                </div>

                <div class="sms-form-group">
                    <label class="sms-form-label">Due Date *</label>
                    <input type="date" name="due_date" class="sms-form-input" required>
                </div>

                <div class="sms-form-group">
                    <label class="sms-form-label">Due Time</label>
                    <input type="time" name="due_time" class="sms-form-input">
                </div>

                <div class="sms-form-group">
                    <label class="sms-form-label">Total Marks *</label>
                    <input type="number" name="total_marks" class="sms-form-input" required min="1" value="100">
                </div>
            </div>
        </div>

        <div class="sms-form-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--sms-gray-900);">
                    Questions
                </h2>
                <div style="display: flex; gap: 0.75rem;">
                    <a href="#" class="sms-btn" style="background: var(--sms-gray-200); color: var(--sms-gray-700); padding: 0.5rem 1rem; font-size: 0.875rem;" onclick="downloadCsvTemplate()">
                        <i class="fas fa-download"></i> Download CSV Template
                    </a>
                    <button type="button" class="sms-btn sms-btn-primary" onclick="addQuestion()">
                        <i class="fas fa-plus"></i> Add Question
                    </button>
                </div>
            </div>
            
            <div style="background: #f0f4ff; border: 1px solid var(--sms-primary); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                <p style="color: var(--sms-gray-700); font-size: 0.875rem; margin-bottom: 0.75rem; font-weight: 600;">
                    <i class="fas fa-info-circle"></i> Upload Questions via CSV (CBE Only)
                </p>
                <input type="file" id="csvFileInput" accept=".csv" style="padding: 0.5rem; border: 1px solid var(--sms-gray-300); border-radius: 6px; font-size: 0.875rem; width: 100%; margin-bottom: 0.5rem;">
                <p style="font-size: 0.75rem; color: var(--sms-gray-600);">
                    CSV Format: question,option_a,option_b,option_c,option_d,correct_answer,marks
                </p>
            </div>

            <div id="questionsContainer">
                <!-- Questions will be added here dynamically -->
            </div>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('sms.teacher.assignments') }}" class="sms-btn sms-btn-secondary">
                Cancel
            </a>
            <button type="submit" class="sms-btn sms-btn-primary">
                <i class="fas fa-save"></i> Create Assignment
            </button>
        </div>
    </form>
</div>

<script>
    let questionCount = 0;

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
                <label class="sms-form-label">Correct Answer (for Theory/Mixed)</label>
                <input type="text" name="questions[${questionCount}][correct_answer]" class="sms-form-input" placeholder="Optional correct answer or marking guide">
            </div>
            
            <div class="sms-form-group">
                <label class="sms-form-label">Instructions</label>
                <textarea name="questions[${questionCount}][instructions]" class="sms-form-textarea" placeholder="Optional instructions for students"></textarea>
            </div>
            
            <div class="sms-form-group">
                <label class="sms-form-label">Marks *</label>
                <input type="number" name="questions[${questionCount}][marks]" class="sms-form-input" required min="1" value="10">
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

    // Add first question on page load
    document.addEventListener('DOMContentLoaded', function() {
        addQuestion();
    });

    function downloadCsvTemplate() {
        const csvContent = 'question,option_a,option_b,option_c,option_d,correct_answer,marks\n' +
            'What is 2+2?,2,3,4,5,C,5\n' +
            'What is the capital of Nigeria?,Lagos,Abuja,Kano,Port Harcourt,B,5';
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'assignment_questions_template.csv';
        a.click();
    }

    // CSV file input handler
    document.getElementById('csvFileInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(event) {
            const text = event.target.result;
            const lines = text.split('\n');
            
            // Clear existing questions
            document.getElementById('questionsContainer').innerHTML = '';
            questionCount = 0;

            // Parse CSV and add questions
            for (let i = 1; i < lines.length; i++) {
                if (!lines[i].trim()) continue;
                const values = lines[i].split(',');
                if (values.length < 7) continue;

                addQuestion();
                const questionDiv = document.getElementById(`question-${questionCount}`);
                questionDiv.querySelector('textarea[name*="[question_text]"]').value = values[0].trim();
                questionDiv.querySelector('select[name*="[question_type]"]').value = 'objective';
                toggleOptions(questionCount, 'objective');
                questionDiv.querySelectorAll('input[name*="[options][]"]')[0].value = values[1].trim();
                questionDiv.querySelectorAll('input[name*="[options][]"]')[1].value = values[2].trim();
                questionDiv.querySelectorAll('input[name*="[options][]"]')[2].value = values[3].trim();
                questionDiv.querySelectorAll('input[name*="[options][]"]')[3].value = values[4].trim();
                questionDiv.querySelector('input[name*="[correct_answer]"]').value = values[5].trim();
                questionDiv.querySelector('input[name*="[marks]"]').value = values[6].trim() || '5';
            }
        };
        reader.readAsText(file);
    });

    // Form submission handler
    document.getElementById('assignmentForm').addEventListener('submit', function(e) {
        const questions = document.querySelectorAll('.question-item');
        if (questions.length === 0) {
            e.preventDefault();
            alert('Please add at least one question or upload a CSV file.');
            return false;
        }
        
        // Process options for objective questions
        questions.forEach((question, index) => {
            const questionType = question.querySelector('select[name*="[question_type]"]').value;
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
