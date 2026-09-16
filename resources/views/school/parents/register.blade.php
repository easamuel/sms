@extends('layouts.admin')

@section('title', 'Register Parent - School Management System')

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
        overflow-wrap: break-word;
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
        overflow-wrap: break-word;
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
        overflow-wrap: break-word;
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
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    .student-details {
        font-size: 0.75rem;
        color: var(--sms-gray-600);
        line-height: 1.4;
        word-wrap: break-word;
        overflow-wrap: break-word;
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
    .btn-primary:active {
        transform: translateY(0);
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
    .selected-student-card-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
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
    .remove-text {
        display: inline;
    }
    @media (max-width: 480px) {
        .remove-text {
            display: none;
        }
    }
    .remove-student-btn:hover {
        background: #fecaca;
    }
    .alert {
        padding: 0.875rem 1rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    /* Mobile Responsive Styles */
    @media (min-width: 640px) {
        .sms-page {
            padding: 2rem;
        }
        .sms-page-title {
            font-size: 2rem;
        }
        .sms-page-subtitle {
            font-size: 1rem;
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
        .sms-card-subtitle {
            font-size: 0.9375rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-size: 0.9375rem;
        }
        .help-text {
            font-size: 0.8125rem;
        }
        .selected-student-card {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        .selected-student-card-actions {
            flex-wrap: nowrap;
        }
        .student-suggestions {
            padding: 1.5rem;
        }
        .btn-primary {
            padding: 1rem 2rem;
            font-size: 1rem;
            width: auto;
        }
    }
    
    @media (min-width: 768px) {
        .sms-page-title {
            font-size: 2.25rem;
        }
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
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <h1 class="sms-page-title">Register New Parent</h1>
        <p class="sms-page-subtitle">Create a new parent account and link their children automatically</p>
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

    <form method="POST" action="{{ route('school.parents.register') }}" id="registerParentForm">
        @csrf

        <!-- Parent Information -->
        <div class="sms-card">
            <div class="sms-card-header">
                <h3 class="sms-card-title" style="display: block; width: 100%; margin: 0 0 0.5rem 0;">Parent Information</h3>
                <p class="sms-card-subtitle" style="display: block; width: 100%; margin: 0;">Enter the parent's personal details below. Required fields are marked with *.</p>
            </div>

            <div class="form-group">
                <label class="form-label">Full Name *</label>
                <input type="text" name="name" id="parent_name" class="form-control" 
                       value="{{ old('name') }}" required 
                       placeholder="e.g., John Bola">
                <small class="help-text">Enter parent's full name. Students with matching names will appear below.</small>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address *</label>
                <input type="email" name="email" class="form-control" 
                       value="{{ old('email') }}" required 
                       placeholder="parent@example.com">
                @error('email')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control" 
                       value="{{ old('phone') }}" 
                       placeholder="+234 801 234 5678">
            </div>

            <div class="form-group">
                <label class="form-label">Password *</label>
                <input type="password" name="password" class="form-control" required 
                       placeholder="Minimum 8 characters">
                @error('password')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Occupation</label>
                <input type="text" name="occupation" class="form-control" 
                       value="{{ old('occupation') }}" 
                       placeholder="e.g., Engineer, Teacher">
            </div>

            <div class="form-group">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="3" 
                          placeholder="Residential address">{{ old('address') }}</textarea>
            </div>
        </div>

        <!-- Student Suggestions -->
        <div class="sms-card">
            <div class="sms-card-header">
                <h3 class="sms-card-title" style="display: block; width: 100%; margin: 0 0 0.5rem 0;">Link Children</h3>
                <p class="sms-card-subtitle" style="display: block; width: 100%; margin: 0;">Select children to link to this parent</p>
            </div>

            <div class="form-group">
                <label class="form-label">Search Students</label>
                <input type="text" id="student_search" class="form-control" 
                       placeholder="Type student name, ID, or class...">
                <small class="help-text">Search by name, ID, or class. Or type the parent's name above for suggestions.</small>
            </div>

            <div id="student_suggestions" class="student-suggestions" style="display: none;">
                <h4 style="font-size: 0.9375rem; font-weight: 600; margin-bottom: 0.875rem; color: var(--sms-gray-700); line-height: 1.4; word-wrap: break-word;">
                    <span id="suggestions_title">Matching Students</span>
                    <span id="suggestions_count" style="font-size: 0.8125rem; font-weight: 400; color: var(--sms-gray-500); margin-left: 0.5rem; display: inline-block;"></span>
                </h4>
                <div id="suggestions_list"></div>
                <div id="no_suggestions_message" style="display: none; text-align: center; padding: 1.5rem 1rem; color: var(--sms-gray-500);">
                    <i class="fas fa-search" style="font-size: 1.75rem; margin-bottom: 0.5rem; opacity: 0.5;"></i>
                    <p style="font-size: 0.875rem; line-height: 1.5; margin: 0;">No matching students found. Try a different search term.</p>
                </div>
            </div>
            
            <div id="all_students_list" class="student-suggestions" style="display: none;">
                <h4 style="font-size: 0.9375rem; font-weight: 600; margin-bottom: 0.875rem; color: var(--sms-gray-700); line-height: 1.4; word-wrap: break-word;">
                    All Students
                    <span id="all_students_count" style="font-size: 0.8125rem; font-weight: 400; color: var(--sms-gray-500); margin-left: 0.5rem; display: inline-block;"></span>
                </h4>
                <div id="all_students_container"></div>
                <div id="no_students_message" style="display: none; text-align: center; padding: 1.5rem 1rem; color: var(--sms-gray-500);">
                    <i class="fas fa-user-graduate" style="font-size: 1.75rem; margin-bottom: 0.5rem; opacity: 0.5;"></i>
                    <p style="font-size: 0.875rem; line-height: 1.5; margin: 0;">No students available in the system.</p>
                </div>
            </div>

            <div id="selected_students" class="selected-students-list" style="display: none;">
                <h4 style="font-size: 0.9375rem; font-weight: 600; margin-bottom: 0.875rem; color: var(--sms-gray-700); line-height: 1.4;">Selected Children:</h4>
                <div id="selected_list"></div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="sms-card">
            <button type="submit" class="btn-primary">
                <i class="fas fa-user-plus"></i> Register Parent
            </button>
        </div>
    </form>
</div>

<script>
let selectedStudents = [];
let allStudents = @json($studentsData ?? []);

// Initialize: Show all students on page load
document.addEventListener('DOMContentLoaded', function() {
    if (allStudents.length > 0) {
        displayAllStudents();
    }
});

// Parent name input handler - shows matching students based on parent name
document.getElementById('parent_name').addEventListener('input', function() {
    const parentName = this.value.trim();
    const studentSearch = document.getElementById('student_search').value.trim();
    
    // If student search has value, don't override it
    if (studentSearch.length > 0) {
        return;
    }
    
    if (parentName.length < 2) {
        document.getElementById('student_suggestions').style.display = 'none';
        // Show all students if parent name is cleared
        if (parentName.length === 0 && allStudents.length > 0) {
            displayAllStudents();
        }
        return;
    }

    // Extract first name and last name
    const nameParts = parentName.split(' ').filter(part => part.length > 0);
    const firstName = nameParts[0] || '';
    const lastName = nameParts[nameParts.length - 1] || '';

    // Search students by matching parent's first or last name
    const suggestions = allStudents.filter(student => {
        if (!student.name) return false;
        const studentName = student.name.toLowerCase();
        const searchFirstName = firstName.toLowerCase();
        const searchLastName = lastName.toLowerCase();
        
        return studentName.includes(searchFirstName) || 
               studentName.includes(searchLastName) ||
               (searchFirstName.length > 2 && studentName.startsWith(searchFirstName)) ||
               (searchLastName.length > 2 && studentName.includes(searchLastName));
    });

    displaySuggestions(suggestions, 'Students matching parent name');
});

// Student search input handler - direct search by student name, ID, or class
document.getElementById('student_search').addEventListener('input', function() {
    const searchTerm = this.value.trim().toLowerCase();
    
    if (searchTerm.length === 0) {
        // Show all students when search is cleared
        document.getElementById('student_suggestions').style.display = 'none';
        if (allStudents.length > 0) {
            displayAllStudents();
        }
        return;
    }

    // Search students by name, student ID, or class
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
    const noStudentsMsg = document.getElementById('no_students_message');
    
    // Hide suggestions div
    document.getElementById('student_suggestions').style.display = 'none';
    
    if (allStudents.length === 0) {
        allStudentsDiv.style.display = 'block';
        container.innerHTML = '';
        noStudentsMsg.style.display = 'block';
        document.getElementById('all_students_count').textContent = '(0 total)';
        return;
    }

    noStudentsMsg.style.display = 'none';
    allStudentsDiv.style.display = 'block';
    document.getElementById('all_students_count').textContent = `(${allStudents.length} total)`;
    container.innerHTML = '';

    let displayedCount = 0;
    allStudents.forEach(student => {
        // Skip if already selected
        if (selectedStudents.find(s => s.id === student.id)) {
            return;
        }

        if (!student.name || student.name.trim() === '') {
            return; // Skip students without names
        }

        displayedCount++;
        const item = document.createElement('div');
        item.className = 'student-suggestion-item';
        item.innerHTML = `
            <input type="checkbox" class="student-checkbox" data-student-id="${student.id}" 
                   data-student-name="${escapeHtml(student.name)}" 
                   data-student-class="${escapeHtml(student.class || 'N/A')}">
            <div class="student-info">
                <div class="student-name">${escapeHtml(student.name)}</div>
                <div class="student-details">${escapeHtml(student.student_id || 'N/A')} | ${escapeHtml(student.class || 'N/A')}</div>
            </div>
        `;
        
        item.addEventListener('click', function(e) {
            if (e.target.type !== 'checkbox' && e.target.tagName !== 'BUTTON') {
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
    
    if (displayedCount === 0 && allStudents.length > 0) {
        // All students are already selected
        container.innerHTML = '<p style="text-align: center; padding: 1rem; color: var(--sms-gray-500);">All available students have been selected.</p>';
    }
}

function displaySuggestions(suggestions, title = 'Matching Students') {
    const container = document.getElementById('suggestions_list');
    const suggestionsDiv = document.getElementById('student_suggestions');
    const noSuggestionsMsg = document.getElementById('no_suggestions_message');
    
    // Hide all students list when showing suggestions
    document.getElementById('all_students_list').style.display = 'none';
    
    if (suggestions.length === 0) {
        suggestionsDiv.style.display = 'block';
        document.getElementById('suggestions_title').textContent = title;
        document.getElementById('suggestions_count').textContent = '(0 found)';
        container.innerHTML = '';
        noSuggestionsMsg.style.display = 'block';
        
        // If no suggestions and search is empty, show all students
        const searchTerm = document.getElementById('student_search').value.trim();
        const parentName = document.getElementById('parent_name').value.trim();
        if (searchTerm.length === 0 && parentName.length === 0 && allStudents.length > 0) {
            displayAllStudents();
        }
        return;
    }

    noSuggestionsMsg.style.display = 'none';
    suggestionsDiv.style.display = 'block';
    document.getElementById('suggestions_title').textContent = title;
    document.getElementById('suggestions_count').textContent = `(${suggestions.length} found)`;
    container.innerHTML = '';

    let displayedCount = 0;
    suggestions.forEach(student => {
        // Skip if already selected
        if (selectedStudents.find(s => s.id === student.id)) {
            return;
        }

        if (!student.name || student.name.trim() === '') {
            return; // Skip students without names
        }

        displayedCount++;
        const item = document.createElement('div');
        item.className = 'student-suggestion-item';
        item.innerHTML = `
            <input type="checkbox" class="student-checkbox" data-student-id="${student.id}" 
                   data-student-name="${escapeHtml(student.name)}" 
                   data-student-class="${escapeHtml(student.class || 'N/A')}">
            <div class="student-info">
                <div class="student-name">${escapeHtml(student.name)}</div>
                <div class="student-details">${escapeHtml(student.student_id || 'N/A')} | ${escapeHtml(student.class || 'N/A')}</div>
            </div>
        `;
        
        item.addEventListener('click', function(e) {
            if (e.target.type !== 'checkbox' && e.target.tagName !== 'BUTTON') {
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
    
    if (displayedCount === 0 && suggestions.length > 0) {
        // All matching students are already selected
        container.innerHTML = '<p style="text-align: center; padding: 1rem; color: var(--sms-gray-500);">All matching students have been selected.</p>';
    }
}

// Helper function to escape HTML
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
        selectedStudents.push({
            id: studentId,
            name: studentName,
            class: studentClass,
        });
    } else {
        selectedStudents = selectedStudents.filter(s => s.id !== studentId);
    }

    updateSelectedList();
    updateFormInputs();
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

    selectedStudents.forEach((student, index) => {
        const card = document.createElement('div');
        card.className = 'selected-student-card';
        card.innerHTML = `
            <div class="selected-student-info">
                <div class="selected-student-name">${escapeHtml(student.name || 'N/A')}</div>
                <div style="font-size: 0.8125rem; color: var(--sms-gray-600); line-height: 1.4; word-wrap: break-word;">${escapeHtml(student.class || 'N/A')}</div>
            </div>
            <div class="selected-student-card-actions">
                <button type="button" class="remove-student-btn" onclick="removeStudent(${student.id})">
                    <i class="fas fa-times"></i> <span class="remove-text">Remove</span>
                </button>
            </div>
        `;
        container.appendChild(card);
    });
    
    // Refresh the suggestions/all students list to update checkboxes
    const searchTerm = document.getElementById('student_search').value.trim();
    const parentName = document.getElementById('parent_name').value.trim();
    
    if (searchTerm.length > 0) {
        document.getElementById('student_search').dispatchEvent(new Event('input'));
    } else if (parentName.length >= 2) {
        document.getElementById('parent_name').dispatchEvent(new Event('input'));
    } else {
        displayAllStudents();
    }
}

function removeStudent(studentId) {
    selectedStudents = selectedStudents.filter(s => s.id !== studentId);
    updateSelectedList();
    updateFormInputs();
    
    // Uncheck checkbox if visible
    document.querySelectorAll('.student-checkbox').forEach(cb => {
        if (parseInt(cb.dataset.studentId) === studentId) {
            cb.checked = false;
        }
    });
}

function updateFormInputs() {
    // Remove existing hidden inputs
    document.querySelectorAll('input[name^="student_ids"]').forEach(input => {
        if (input.type === 'hidden') input.remove();
    });

    // Add new hidden inputs
    selectedStudents.forEach((student, index) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = `student_ids[${index}]`;
        input.value = student.id;
        document.getElementById('registerParentForm').appendChild(input);
    });
}
</script>
@endsection
