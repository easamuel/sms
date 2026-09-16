@extends('layouts.admin')

@section('title', 'Add New Student - School Management System')
@section('page-title', 'Add New Student')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
    }
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
        letter-spacing: -0.02em;
        line-height: 1.2;
    }
    .sms-page-subtitle {
        color: var(--sms-gray-600);
        font-size: 0.875rem;
        line-height: 1.5;
    }
    
    @media (min-width: 768px) {
        .sms-page-header {
            padding: 2rem;
            margin: -2rem -2rem 2rem -2rem;
        }
        
        .sms-page-title {
            font-size: 1.875rem;
        }
        
        .sms-page-subtitle {
            font-size: 1rem;
        }
    }
    .sms-form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        padding: 1.25rem;
        max-width: 800px;
        margin: 0 auto;
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
    .sms-form-label .required {
        color: #dc2626;
    }
    .sms-form-input,
    .sms-form-select {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.2s;
        background: white;
        min-height: 44px;
        touch-action: manipulation;
    }
    .sms-form-input:focus,
    .sms-form-select:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .sms-form-row {
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
    .sms-btn-secondary {
        background: white;
        color: var(--sms-gray-700);
        border: 1px solid var(--sms-gray-300);
    }
    .sms-btn-secondary:active {
        transform: scale(0.98);
        background: var(--sms-gray-50);
    }
    .form-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--sms-gray-200);
    }
    
    @media (min-width: 640px) {
        .sms-form-card {
            padding: 2rem;
            border-radius: 16px;
        }
        
        .sms-form-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .form-actions {
            flex-direction: row;
            justify-content: flex-end;
            gap: 1rem;
        }
        
        .sms-btn {
            width: auto;
            padding: 0.625rem 1.25rem;
        }
    }
    .form-help-text {
        font-size: 0.8125rem;
        color: var(--sms-gray-500);
        margin-top: 0.25rem;
    }
    @media (max-width: 768px) {
        .sms-form-card {
            padding: 1.5rem;
        }
        .sms-form-row {
            grid-template-columns: 1fr;
        }
        .form-actions {
            flex-direction: column-reverse;
        }
        .form-actions .sms-btn {
            width: 100%;
        }
    }
    #photo-preview img {
        object-fit: cover;
    }
</style>

<script>
    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('photo-preview').style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function clearPhoto() {
        document.getElementById('photo-input').value = '';
        document.getElementById('photo-preview').style.display = 'none';
        document.getElementById('preview-image').src = '';
    }

    // Show/hide club position field based on club selection
    document.addEventListener('DOMContentLoaded', function() {
        const clubSelect = document.querySelector('select[name="club_id"]');
        const clubPositionGroup = document.getElementById('club-position-group');
        const clubPositionSelect = document.querySelector('select[name="club_position"]');
        
        if (clubSelect && clubPositionGroup) {
            clubSelect.addEventListener('change', function() {
                if (this.value) {
                    clubPositionGroup.style.display = 'block';
                    // Set default to "Member" if no value is set
                    if (!clubPositionSelect.value || clubPositionSelect.value === '') {
                        clubPositionSelect.value = 'Member';
                    }
                } else {
                    clubPositionGroup.style.display = 'none';
                    clubPositionSelect.value = '';
                }
            });
            
            // Check initial value
            if (clubSelect.value) {
                clubPositionGroup.style.display = 'block';
                if (!clubPositionSelect.value || clubPositionSelect.value === '') {
                    clubPositionSelect.value = 'Member';
                }
            }
        }
    });
</script>

<div>
        <div class="sms-form-card">
            <form action="{{ route('school.students.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="sms-form-group">
                    <label class="sms-form-label">
                        Full Name <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           class="sms-form-input" 
                           value="{{ old('name') }}" 
                           required 
                           placeholder="Enter student's full name">
                    @error('name')
                        <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="background: #f0f4ff; border: 1px solid var(--sms-primary); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                        <i class="fas fa-info-circle" style="color: var(--sms-primary); font-size: 1.25rem;"></i>
                        <div style="font-weight: 600; color: var(--sms-gray-900);">Auto-Generated Credentials</div>
                    </div>
                    <div style="color: var(--sms-gray-700); font-size: 0.9375rem; line-height: 1.6;">
                        <p style="margin-bottom: 0.5rem;">
                            <strong>Student ID:</strong> Will be automatically generated (e.g., STU-2026-0001)
                        </p>
                        <p>
                            <strong>Default Password:</strong> <code style="background: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-family: monospace;">password123</code>
                        </p>
                        <p style="margin-top: 0.75rem; font-size: 0.875rem; color: var(--sms-gray-600);">
                            The student will use their Student ID and password to login to the portal.
                        </p>
                    </div>
                </div>

                <div class="sms-form-row">
                    <div class="sms-form-group">
                        <label class="sms-form-label">
                            Class <span class="required">*</span>
                        </label>
                        <select name="class_id" class="sms-form-select" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sms-form-group">
                        <label class="sms-form-label">
                            Gender <span class="required">*</span>
                        </label>
                        <select name="gender" class="sms-form-select" required>
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="sms-form-row">
                    <div class="sms-form-group">
                        <label class="sms-form-label">
                            Date of Birth <span class="required">*</span>
                        </label>
                        <input type="date" 
                               name="date_of_birth" 
                               class="sms-form-input" 
                               value="{{ old('date_of_birth') }}" 
                               required 
                               max="{{ date('Y-m-d', strtotime('-5 years')) }}">
                        <div class="form-help-text">Student must be at least 5 years old</div>
                        @error('date_of_birth')
                            <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sms-form-group">
                        <label class="sms-form-label">
                            Student Photo <span class="required">*</span>
                        </label>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <div style="position: relative;">
                                <input type="file" 
                                       name="photo" 
                                       id="photo-input" 
                                       accept="image/*" 
                                       capture="environment"
                                       class="sms-form-input" 
                                       style="padding: 0.5rem;"
                                       onchange="previewPhoto(this)">
                                <div class="form-help-text">You can take a photo with your camera or upload an existing image</div>
                            </div>
                            <div id="photo-preview" style="display: none; margin-top: 0.5rem;">
                                <img id="preview-image" src="" alt="Photo Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid var(--sms-gray-200);">
                                <button type="button" onclick="clearPhoto()" style="display: block; margin-top: 0.5rem; padding: 0.5rem 1rem; background: #fee2e2; color: #991b1b; border: none; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">
                                    <i class="fas fa-times"></i> Remove Photo
                                </button>
                            </div>
                        </div>
                        @error('photo')
                            <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sms-form-group">
                        <label class="sms-form-label">
                            Club (Optional)
                        </label>
                        <select name="club_id" class="sms-form-select">
                            <option value="">No Club</option>
                            @foreach($clubs as $club)
                                <option value="{{ $club->id }}" {{ old('club_id') == $club->id ? 'selected' : '' }}>
                                    {{ $club->name }}
                                    @if($club->category)
                                        ({{ $club->category }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('club_id')
                            <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sms-form-group" id="club-position-group" style="display: none;">
                        <label class="sms-form-label">
                            Position in Club
                        </label>
                        <select name="club_position" class="sms-form-select">
                            <option value="Member" {{ old('club_position') == 'Member' ? 'selected' : '' }}>Member</option>
                            <option value="Captain" {{ old('club_position') == 'Captain' ? 'selected' : '' }}>Captain</option>
                            <option value="Vice Captain" {{ old('club_position') == 'Vice Captain' ? 'selected' : '' }}>Vice Captain</option>
                            <option value="Secretary" {{ old('club_position') == 'Secretary' ? 'selected' : '' }}>Secretary</option>
                            <option value="Treasurer" {{ old('club_position') == 'Treasurer' ? 'selected' : '' }}>Treasurer</option>
                            <option value="Public Relations Officer" {{ old('club_position') == 'Public Relations Officer' ? 'selected' : '' }}>Public Relations Officer</option>
                        </select>
                        @error('club_position')
                            <div style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('school.students.index') }}" class="sms-btn sms-btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="sms-btn sms-btn-primary">
                        <i class="fas fa-save"></i> Create Student
                    </button>
                </div>
            </form>
        </div>
</div>
@endsection
