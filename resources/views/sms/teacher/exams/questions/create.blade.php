@extends('layouts.app')

@section('title', 'Add Questions - Teacher Dashboard')

@section('content')
@include('sms.partials.design-system')
<style>
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
    .sms-form-input, .sms-form-select, .sms-form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 0.9375rem;
        transition: border-color 0.2s;
    }
    .sms-form-input:focus, .sms-form-select:focus, .sms-form-textarea:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .sms-form-textarea {
        min-height: 100px;
        resize: vertical;
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
    .csv-upload-section {
        background: var(--sms-gray-50);
        border: 2px dashed var(--sms-gray-300);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        margin-bottom: 2rem;
    }
    .csv-upload-section:hover {
        border-color: var(--sms-primary);
        background: #f0f4ff;
    }
</style>

<div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.875rem; font-weight: 800; color: var(--sms-gray-900); margin-bottom: 0.5rem;">
            Add Questions to Exam
        </h1>
        <p style="color: var(--sms-gray-600);">
            Exam: <strong>{{ $exam->title ?? $exam->name }}</strong> | 
            Subject: <strong>{{ $exam->subject->name ?? 'N/A' }}</strong> | 
            Class: <strong>{{ $exam->class->name ?? 'N/A' }}</strong>
        </p>
    </div>

    <!-- CSV Upload Section -->
    <div class="sms-form-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--sms-gray-900);">
                <i class="fas fa-file-csv"></i> Upload Questions via CSV (CBE Only)
            </h2>
            <a href="{{ route('sms.teacher.exams.questions.download-template', $exam->id) }}" class="sms-btn" style="background: var(--sms-gray-200); color: var(--sms-gray-700); padding: 0.5rem 1rem; font-size: 0.875rem;">
                <i class="fas fa-download"></i> Download CSV Template
            </a>
        </div>
        <div class="csv-upload-section">
            <form action="{{ route('sms.teacher.exams.questions.upload-csv', $exam->id) }}" method="POST" enctype="multipart/form-data" id="csvUploadForm">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <i class="fas fa-file-csv" style="font-size: 3rem; color: var(--sms-gray-400); margin-bottom: 1rem;"></i>
                    <p style="color: var(--sms-gray-600); margin-bottom: 1rem;">
                        Upload a CSV file with questions. Format: Question, Option A, Option B, Option C, Option D, Correct Answer, Marks
                    </p>
                    <input type="file" name="csv_file" accept=".csv" required style="margin-bottom: 1rem;">
                </div>
                <button type="submit" class="sms-btn sms-btn-primary">
                    <i class="fas fa-upload"></i> Upload CSV
                </button>
            </form>
            <div style="margin-top: 1rem; padding: 1rem; background: white; border-radius: 8px; text-align: left;">
                <p style="font-size: 0.875rem; color: var(--sms-gray-600); margin-bottom: 0.5rem;"><strong>CSV Format Example:</strong></p>
                <pre style="font-size: 0.75rem; color: var(--sms-gray-700); background: var(--sms-gray-100); padding: 0.75rem; border-radius: 6px; overflow-x: auto;">Question,Option A,Option B,Option C,Option D,Correct Answer,Marks
What is 2+2?,2,3,4,5,C,5
What is the capital of Nigeria?,Lagos,Abuja,Kano,Port Harcourt,B,5</pre>
            </div>
        </div>
    </div>

    <!-- Manual Question Entry -->
    <form action="{{ route('sms.teacher.exams.questions.store', $exam->id) }}" method="POST" id="questionsForm">
        @csrf

        <div class="sms-form-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--sms-gray-900);">
                    Or Add Questions Manually
                </h2>
                <button type="button" class="sms-btn sms-btn-primary" onclick="addQuestion()">
                    <i class="fas fa-plus"></i> Add Question
                </button>
            </div>

            <div id="questionsContainer">
                <!-- Questions will be added here dynamically -->
            </div>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('sms.teacher.exams') }}" class="sms-btn sms-btn-secondary">
                Cancel
            </a>
            <button type="submit" class="sms-btn sms-btn-primary">
                <i class="fas fa-save"></i> Save Questions
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
                    <option value="multiple_choice">Multiple Choice</option>
                    <option value="true_false">True/False</option>
                    <option value="theory">Theory/Essay</option>
                </select>
            </div>
            
            <div id="options-${questionCount}" class="options-container" style="display: none;">
                <label class="sms-form-label">Options (for Multiple Choice)</label>
                <div id="options-list-${questionCount}">
                    <div class="option-item">
                        <input type="text" class="option-input" name="questions[${questionCount}][options][]" placeholder="Option A" required>
                    </div>
                    <div class="option-item">
                        <input type="text" class="option-input" name="questions[${questionCount}][options][]" placeholder="Option B" required>
                    </div>
                    <div class="option-item">
                        <input type="text" class="option-input" name="questions[${questionCount}][options][]" placeholder="Option C" required>
                    </div>
                    <div class="option-item">
                        <input type="text" class="option-input" name="questions[${questionCount}][options][]" placeholder="Option D" required>
                    </div>
                </div>
                <button type="button" class="add-option-btn" onclick="addOption(${questionCount})">
                    <i class="fas fa-plus"></i> Add Option
                </button>
            </div>
            
            <div class="sms-form-group">
                <label class="sms-form-label">Correct Answer *</label>
                <input type="text" name="questions[${questionCount}][correct_answer]" class="sms-form-input" required placeholder="Enter correct answer (e.g., 'C' for option C, 'True' for true/false)">
            </div>
            
            <div class="sms-form-group">
                <label class="sms-form-label">Points *</label>
                <input type="number" name="questions[${questionCount}][points]" class="sms-form-input" required min="1" value="5">
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
        if (questionType === 'multiple_choice') {
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
            <input type="text" class="option-input" name="questions[${questionId}][options][]" placeholder="Option ${String.fromCharCode(65 + optionCount)}" required>
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

    // Form submission handler
    document.getElementById('questionsForm').addEventListener('submit', function(e) {
        const questions = document.querySelectorAll('.question-item');
        if (questions.length === 0) {
            e.preventDefault();
            alert('Please add at least one question or upload a CSV file.');
            return false;
        }
    });
</script>
@endsection
