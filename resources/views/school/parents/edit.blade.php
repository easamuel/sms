@extends('layouts.admin')

@section('title', 'Edit Parent - School Management System')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
        padding: 1rem;
    }
    .sms-page-header {
        margin-bottom: 1.5rem;
    }
    .sms-page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }
    .sms-page-subtitle {
        color: var(--sms-gray-600);
        font-size: 0.875rem;
        line-height: 1.5;
    }
    .sms-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--sms-gray-200);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .sms-card-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--sms-gray-200);
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .sms-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin: 0;
        line-height: 1.3;
        display: block;
        width: 100%;
    }
    .sms-card-subtitle {
        color: var(--sms-gray-600);
        font-size: 0.875rem;
        line-height: 1.5;
        word-wrap: break-word;
        overflow-wrap: break-word;
        margin: 0;
        display: block;
        width: 100%;
    }
    .form-group {
        margin-bottom: 1.25rem;
    }
    .form-label {
        display: block;
        font-weight: 600;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        line-height: 1.4;
        word-wrap: break-word;
    }
    .form-control {
        width: 100%;
        padding: 0.75rem 0.875rem;
        border: 2px solid var(--sms-gray-300);
        border-radius: 10px;
        font-size: 0.9375rem;
        transition: all 0.2s;
        box-sizing: border-box;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    .help-text {
        font-size: 0.75rem;
        color: var(--sms-gray-500);
        margin-top: 0.5rem;
        line-height: 1.5;
        word-wrap: break-word;
        display: block;
    }
    .student-suggestions {
        background: var(--sms-gray-50);
        border: 2px dashed var(--sms-gray-300);
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1rem;
    }
    .student-suggestion-item {
        background: white;
        border: 1px solid var(--sms-gray-200);
        border-radius: 8px;
        padding: 0.875rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
        word-wrap: break-word;
    }
    .student-suggestion-item:hover {
        border-color: var(--sms-primary);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .student-suggestion-item.selected {
        background: var(--sms-blue-50);
        border-color: var(--sms-primary);
    }
    .student-info {
        flex: 1;
    }
    .student-name {
        font-weight: 600;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
        line-height: 1.4;
    }
    .student-details {
        font-size: 0.75rem;
        color: var(--sms-gray-600);
        line-height: 1.4;
    }
    .btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent));
        color: white;
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        border: none;
        font-weight: 700;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }
    .selected-students-list {
        margin-top: 1.5rem;
    }
    .selected-student-card {
        background: linear-gradient(135deg, var(--sms-blue-50), var(--sms-green-50));
        border: 2px solid var(--sms-primary);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .selected-student-info {
        flex: 1;
    }
    .selected-student-name {
        font-weight: 700;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
    }
    .remove-student-btn {
        background: #fee2e2;
        color: #991b1b;
        border: none;
        padding: 0.5rem 0.875rem;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.8125rem;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    .selected-student-card-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .alert {
        padding: 0.875rem 1rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
    }
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .form-check input {
        width: auto;
    }
    
    @media (min-width: 640px) {
        .sms-page {
            padding: 2rem;
        }
        .sms-page-title {
            font-size: 2rem;
        }
        .sms-card {
            padding: 2rem;
        }
        .sms-card-header {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
        }
        .sms-card-title {
            font-size: 1.5rem;
        }
        .selected-student-card {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        .selected-student-card-actions {
            flex-wrap: nowrap;
        }
        .btn-primary {
            padding: 1rem 2rem;
            font-size: 1rem;
            width: auto;
        }
    }
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <h1 class="sms-page-title">Edit Parent</h1>
        <p class="sms-page-subtitle">Update parent information and manage linked children</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('school.parents.update', $parent->id) }}" id="editParentForm">
        @csrf
        @method('PUT')

        <!-- Parent Information -->
        <div class="sms-card">
            <div class="sms-card-header">
                <h3 class="sms-card-title" style="display: block; width: 100%; margin: 0 0 0.5rem 0;">Parent Information</h3>
                <p class="sms-card-subtitle" style="display: block; width: 100%; margin: 0;">Update the parent's personal details below. Required fields are marked with *.</p>
            </div>

            <div class="form-group">
                <label class="form-label">Full Name *</label>
                <input type="text" name="name" class="form-control" 
                       value="{{ old('name', $parent->user->name) }}" required 
                       placeholder="e.g., John Bola">
            </div>

            <div class="form-group">
                <label class="form-label">Email Address *</label>
                <input type="email" name="email" class="form-control" 
                       value="{{ old('email', $parent->user->email) }}" required 
                       placeholder="parent@example.com">
                @error('email')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control" 
                       value="{{ old('phone', $parent->phone ?? $parent->user->phone) }}" 
                       placeholder="+234 801 234 5678">
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" 
                       placeholder="Leave blank to keep current password">
                <small class="help-text">Only enter a new password if you want to change it.</small>
                @error('password')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Occupation</label>
                <input type="text" name="occupation" class="form-control" 
                       value="{{ old('occupation', $parent->occupation) }}" 
                       placeholder="e.g., Engineer, Teacher">
            </div>

            <div class="form-group">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="3" 
                          placeholder="Residential address">{{ old('address', $parent->address) }}</textarea>
            </div>

            <div class="form-check">
                <input type="checkbox" name="is_active" id="is_active" value="1" 
                       {{ old('is_active', $parent->user->is_active ?? true) ? 'checked' : '' }}>
                <label for="is_active" class="form-label" style="margin: 0;">Active Account</label>
            </div>
        </div>

        <!-- Link Children -->
        <div class="sms-card">
            <div class="sms-card-header">
                <h3 class="sms-card-title" style="display: block; width: 100%; margin: 0 0 0.5rem 0;">Link Children</h3>
                <p class="sms-card-subtitle" style="display: block; width: 100%; margin: 0;">Select children to link to this parent</p>
            </div>

            <div class="form-group">
                <label class="form-label">Search Students</label>
                <input type="text" id="student_search" class="form-control" 
                       placeholder="Type student name, ID, or class...">
                <small class="help-text">Search by name, ID, or class.</small>
            </div>

            <div id="all_students_list" class="student-suggestions" style="display: none;">
                <h4 style="font-size: 0.9375rem; font-weight: 600; margin-bottom: 0.875rem; color: var(--sms-gray-700); line-height: 1.4;">
                    All Students
                    <span id="all_students_count" style="font-size: 0.8125rem; font-weight: 400; color: var(--sms-gray-500); margin-left: 0.5rem;"></span>
                </h4>
                <div id="all_students_container"></div>
            </div>

            <div id="student_suggestions" class="student-suggestions" style="display: none;">
                <h4 style="font-size: 0.9375rem; font-weight: 600; margin-bottom: 0.875rem; color: var(--sms-gray-700); line-height: 1.4;">
                    <span id="suggestions_title">Matching Students</span>
                    <span id="suggestions_count" style="font-size: 0.8125rem; font-weight: 400; color: var(--sms-gray-500); margin-left: 0.5rem;"></span>
                </h4>
                <div id="suggestions_list"></div>
            </div>

            <div id="selected_students" class="selected-students-list" style="display: none;">
                <h4 style="font-size: 0.9375rem; font-weight: 600; margin-bottom: 0.875rem; color: var(--sms-gray-700); line-height: 1.4;">Selected Children:</h4>
                <div id="selected_list"></div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="sms-card">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <button type="submit" class="btn-primary" style="flex: 1; min-width: 200px;">
                    <i class="fas fa-save"></i> Update Parent
                </button>
                <a href="{{ route('school.parents.index') }}" class="sms-btn sms-btn-secondary" style="flex: 1; min-width: 200px; text-align: center; justify-content: center;">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </div>
    </form>
</div>

<script>
let selectedStudents = @json($allLinkedIds ?? []);
let allStudents = @json($studentsData ?? []);

// Initialize: Show all students and mark selected ones
document.addEventListener('DOMContentLoaded', function() {
    if (allStudents.length > 0) {
        displayAllStudents();
        updateSelectedList();
    }
});

// Student search handler
document.getElementById('student_search').addEventListener('input', function() {
    const searchTerm = this.value.trim().toLowerCase();
    
    if (searchTerm.length === 0) {
        document.getElementById('student_suggestions').style.display = 'none';
        if (allStudents.length > 0) {
            displayAllStudents();
        }
        return;
    }

    const filtered = allStudents.filter(student => {
        if (!student.name) return false;
        const nameMatch = student.name.toLowerCase().includes(searchTerm);
        const idMatch = (student.student_id || '').toLowerCase().includes(searchTerm);
        const classMatch = (student.class || '').toLowerCase().includes(searchTerm);
        return nameMatch || idMatch || classMatch;
    });

    displaySuggestions(filtered, 'Search Results');
});

function displayAllStudents() {
    const container = document.getElementById('all_students_container');
    const allStudentsDiv = document.getElementById('all_students_list');
    
    document.getElementById('student_suggestions').style.display = 'none';
    
    if (allStudents.length === 0) {
        allStudentsDiv.style.display = 'block';
        container.innerHTML = '';
        document.getElementById('all_students_count').textContent = '(0 total)';
        return;
    }

    allStudentsDiv.style.display = 'block';
    document.getElementById('all_students_count').textContent = `(${allStudents.length} total)`;
    container.innerHTML = '';

    allStudents.forEach(student => {
        if (!student.name || student.name.trim() === '') return;

        const isSelected = selectedStudents.includes(student.id);
        const item = document.createElement('div');
        item.className = 'student-suggestion-item' + (isSelected ? ' selected' : '');
        item.innerHTML = `
            <input type="checkbox" class="student-checkbox" data-student-id="${student.id}" 
                   data-student-name="${escapeHtml(student.name)}" 
                   data-student-class="${escapeHtml(student.class || 'N/A')}"
                   ${isSelected ? 'checked' : ''}>
            <div class="student-info">
                <div class="student-name">${escapeHtml(student.name)}</div>
                <div class="student-details">${escapeHtml(student.student_id || 'N/A')} | ${escapeHtml(student.class || 'N/A')}</div>
            </div>
        `;
        
        item.addEventListener('click', function(e) {
            if (e.target.type !== 'checkbox') {
                const checkbox = this.querySelector('.student-checkbox');
                checkbox.checked = !checkbox.checked;
                handleStudentSelection(checkbox);
            }
        });

        const checkbox = item.querySelector('.student-checkbox');
        checkbox.addEventListener('change', function() {
            handleStudentSelection(this);
        });

        container.appendChild(item);
    });
}

function displaySuggestions(suggestions, title = 'Matching Students') {
    const container = document.getElementById('suggestions_list');
    const suggestionsDiv = document.getElementById('student_suggestions');
    
    document.getElementById('all_students_list').style.display = 'none';
    
    if (suggestions.length === 0) {
        suggestionsDiv.style.display = 'block';
        document.getElementById('suggestions_title').textContent = title;
        document.getElementById('suggestions_count').textContent = '(0 found)';
        container.innerHTML = '';
        return;
    }

    suggestionsDiv.style.display = 'block';
    document.getElementById('suggestions_title').textContent = title;
    document.getElementById('suggestions_count').textContent = `(${suggestions.length} found)`;
    container.innerHTML = '';

    suggestions.forEach(student => {
        if (!student.name || student.name.trim() === '') return;

        const isSelected = selectedStudents.includes(student.id);
        const item = document.createElement('div');
        item.className = 'student-suggestion-item' + (isSelected ? ' selected' : '');
        item.innerHTML = `
            <input type="checkbox" class="student-checkbox" data-student-id="${student.id}" 
                   data-student-name="${escapeHtml(student.name)}" 
                   data-student-class="${escapeHtml(student.class || 'N/A')}"
                   ${isSelected ? 'checked' : ''}>
            <div class="student-info">
                <div class="student-name">${escapeHtml(student.name)}</div>
                <div class="student-details">${escapeHtml(student.student_id || 'N/A')} | ${escapeHtml(student.class || 'N/A')}</div>
            </div>
        `;
        
        item.addEventListener('click', function(e) {
            if (e.target.type !== 'checkbox') {
                const checkbox = this.querySelector('.student-checkbox');
                checkbox.checked = !checkbox.checked;
                handleStudentSelection(checkbox);
            }
        });

        const checkbox = item.querySelector('.student-checkbox');
        checkbox.addEventListener('change', function() {
            handleStudentSelection(this);
        });

        container.appendChild(item);
    });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function handleStudentSelection(checkbox) {
    const studentId = parseInt(checkbox.dataset.studentId);
    const studentName = checkbox.dataset.studentName;
    const studentClass = checkbox.dataset.studentClass;

    if (checkbox.checked) {
        if (!selectedStudents.includes(studentId)) {
            selectedStudents.push(studentId);
        }
    } else {
        selectedStudents = selectedStudents.filter(id => id !== studentId);
    }

    updateSelectedList();
    updateFormInputs();
    
    // Update checkbox states in visible lists
    document.querySelectorAll('.student-checkbox').forEach(cb => {
        if (parseInt(cb.dataset.studentId) === studentId) {
            cb.checked = selectedStudents.includes(studentId);
            const item = cb.closest('.student-suggestion-item');
            if (item) {
                if (selectedStudents.includes(studentId)) {
                    item.classList.add('selected');
                } else {
                    item.classList.remove('selected');
                }
            }
        }
    });
}

function updateSelectedList() {
    const container = document.getElementById('selected_list');
    const selectedDiv = document.getElementById('selected_students');

    if (selectedStudents.length === 0) {
        selectedDiv.style.display = 'none';
        return;
    }

    selectedDiv.style.display = 'block';
    container.innerHTML = '';

    selectedStudents.forEach((studentId, index) => {
        const student = allStudents.find(s => s.id === studentId);
        if (!student) return;

        const card = document.createElement('div');
        card.className = 'selected-student-card';
        card.innerHTML = `
            <div class="selected-student-info">
                <div class="selected-student-name">${escapeHtml(student.name || 'N/A')}</div>
                <div style="font-size: 0.8125rem; color: var(--sms-gray-600); line-height: 1.4;">${escapeHtml(student.class || 'N/A')}</div>
            </div>
            <div class="selected-student-card-actions">
                <button type="button" class="remove-student-btn" onclick="removeStudent(${studentId})">
                    <i class="fas fa-times"></i> <span class="remove-text">Remove</span>
                </button>
            </div>
        `;
        container.appendChild(card);
    });
}

function removeStudent(studentId) {
    selectedStudents = selectedStudents.filter(id => id !== studentId);
    updateSelectedList();
    updateFormInputs();
    
    document.querySelectorAll('.student-checkbox').forEach(cb => {
        if (parseInt(cb.dataset.studentId) === studentId) {
            cb.checked = false;
            const item = cb.closest('.student-suggestion-item');
            if (item) {
                item.classList.remove('selected');
            }
        }
    });
}

function updateFormInputs() {
    document.querySelectorAll('input[name^="student_ids"]').forEach(input => {
        if (input.type === 'hidden') input.remove();
    });

    selectedStudents.forEach((studentId, index) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = `student_ids[${index}]`;
        input.value = studentId;
        document.getElementById('editParentForm').appendChild(input);
    });
}
</script>
@endsection
