@extends('layouts.admin')

@section('title', 'New Message - School Management System')
@section('page-title', 'New Message')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
        padding: 2rem 0;
    }
    
    .page-header {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        border-radius: 0;
        box-shadow: var(--sms-shadow-lg);
    }
    
    .page-header-content {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .page-title {
        font-size: 2rem;
        font-weight: 800;
        color: white;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .page-title i {
        font-size: 1.75rem;
        opacity: 0.9;
    }
    
    .page-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
        font-weight: 400;
    }
    
    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 2rem 2rem;
    }
    
    .sms-card {
        background: white;
        border-radius: var(--sms-radius-lg);
        box-shadow: var(--sms-shadow);
        border: 1px solid var(--sms-gray-200);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .card-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--sms-gray-200);
        background: var(--sms-gray-50);
    }
    
    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--sms-gray-700);
        font-size: 0.875rem;
    }
    
    .form-label .required {
        color: #dc2626;
        margin-left: 0.25rem;
    }
    
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 0.875rem;
        border: 2px solid var(--sms-gray-200);
        border-radius: var(--sms-radius);
        font-size: 0.9375rem;
        transition: all 0.2s;
        min-height: 44px;
        font-family: inherit;
        box-sizing: border-box;
    }
    
    .form-textarea {
        min-height: 150px;
        resize: vertical;
    }
    
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--sms-gray-200);
    }
    
    .btn {
        padding: 0.875rem 2rem;
        border-radius: var(--sms-radius);
        font-weight: 600;
        font-size: 0.9375rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        min-height: 44px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        box-shadow: var(--sms-shadow-sm);
        flex: 1;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--sms-shadow-md);
    }
    
    .btn-secondary {
        background: white;
        color: var(--sms-gray-700);
        border: 2px solid var(--sms-gray-300);
        flex: 1;
    }
    
    .btn-secondary:hover {
        background: var(--sms-gray-50);
        border-color: var(--sms-gray-400);
    }
    
    .parent-option {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0;
    }
    
    .parent-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.875rem;
        flex-shrink: 0;
    }
    
    .parent-info {
        flex: 1;
        min-width: 0;
    }
    
    .parent-name {
        font-weight: 600;
        color: var(--sms-gray-900);
        margin-bottom: 0.125rem;
    }
    
    .parent-email {
        font-size: 0.8125rem;
        color: var(--sms-gray-500);
    }
    
    .help-text {
        font-size: 0.8125rem;
        color: var(--sms-gray-500);
        margin-top: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .sms-page {
            padding: 1rem 0;
        }
        
        .page-header {
            padding: 2rem 1.5rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .page-title i {
            font-size: 1.25rem;
        }
        
        .container {
            padding: 0 1rem 1.5rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
    }
    
    @media (max-width: 480px) {
        .page-header {
            padding: 1.5rem 1rem;
        }
        
        .page-title {
            font-size: 1.25rem;
        }
        
        .card-header,
        .card-body {
            padding: 1rem;
        }
        
        .form-select,
        .form-textarea {
            font-size: 16px; /* Prevents zoom on iOS */
        }
    }
</style>

<div class="sms-page">
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">
                <i class="fas fa-paper-plane"></i>
                New Message
            </h1>
            <p class="page-subtitle">Send a message to a parent</p>
        </div>
    </div>

    <div class="container">
        <div class="sms-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-envelope"></i>
                    Compose Message
                </h2>
            </div>
            
            <form method="POST" action="{{ route('school.messages.store') }}" class="card-body">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">
                        Select Parent <span class="required">*</span>
                    </label>
                    <select name="parent_id" id="parent_id" class="form-select" required>
                        <option value="">Choose a parent...</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}">
                                {{ $parent->user->name ?? 'Unknown' }} - {{ $parent->user->email ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                    <div class="help-text">Select the parent you want to send a message to</div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Message <span class="required">*</span>
                    </label>
                    <textarea 
                        name="message" 
                        id="message" 
                        class="form-textarea" 
                        placeholder="Type your message here..."
                        required
                        rows="8"
                    ></textarea>
                    <div class="help-text">Maximum 5000 characters</div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('school.messages.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageTextarea = document.getElementById('message');
    const charCount = document.createElement('div');
    charCount.className = 'help-text';
    charCount.style.marginTop = '0.5rem';
    charCount.style.textAlign = 'right';
    messageTextarea.parentNode.appendChild(charCount);
    
    function updateCharCount() {
        const length = messageTextarea.value.length;
        const maxLength = 5000;
        charCount.textContent = `${length} / ${maxLength} characters`;
        
        if (length > maxLength * 0.9) {
            charCount.style.color = '#dc2626';
        } else {
            charCount.style.color = 'var(--sms-gray-500)';
        }
    }
    
    messageTextarea.addEventListener('input', updateCharCount);
    updateCharCount();
});
</script>
@endsection
