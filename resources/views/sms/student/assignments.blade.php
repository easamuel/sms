@extends('layouts.app')

@section('title', 'Assignments - School Management System')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
    }
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
        letter-spacing: -0.02em;
    }
    .sms-page-subtitle {
        color: var(--sms-gray-600);
        font-size: 1rem;
    }
    .sms-assignments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }
    .sms-assignment-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        transition: all 0.3s ease;
    }
    .sms-assignment-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.15);
    }
    .sms-assignment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
    }
    .sms-assignment-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
    }
    .sms-assignment-subject {
        font-size: 0.875rem;
        color: var(--sms-primary);
        font-weight: 600;
    }
    .sms-assignment-status {
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .sms-assignment-status.pending {
        background: #fef3c7;
        color: #92400e;
    }
    .sms-assignment-status.submitted {
        background: #d1fae5;
        color: #065f46;
    }
    .sms-assignment-status.graded {
        background: #dbeafe;
        color: #1e40af;
    }
    .sms-assignment-body {
        margin-bottom: 1rem;
    }
    .sms-assignment-instructions {
        font-size: 0.9375rem;
        color: var(--sms-gray-700);
        line-height: 1.6;
        margin-bottom: 1rem;
    }
    .sms-assignment-meta {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--sms-gray-600);
    }
    .sms-assignment-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .sms-assignment-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--sms-gray-200);
    }
    .sms-btn {
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .sms-btn-primary {
        background: var(--sms-primary);
        color: white;
    }
    .sms-btn-primary:hover {
        background: var(--sms-primary-dark);
    }
    .sms-btn-secondary {
        background: var(--sms-gray-200);
        color: var(--sms-gray-700);
    }
    .sms-btn-secondary:hover {
        background: var(--sms-gray-300);
    }
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <h1 class="sms-page-title">Assignments</h1>
        <p class="sms-page-subtitle">
            Class: {{ $student->class?->name ?? 'N/A' }}
        </p>
    </div>

    <div style="max-width: 1400px; margin: 0 auto; padding: 0 2rem 2rem;">
        <div class="sms-assignments-grid">
            <!-- Demo Assignment 1: English Language -->
            <div class="sms-assignment-card">
                <div class="sms-assignment-header">
                    <div>
                        <div class="sms-assignment-title">Essay Writing: My School</div>
                        <div class="sms-assignment-subject">English Language</div>
                    </div>
                    <span class="sms-assignment-status pending">Pending</span>
                </div>
                <div class="sms-assignment-body">
                    <div class="sms-assignment-instructions">
                        Write a 500-word essay about your school. Include information about:
                        <ul style="margin: 0.5rem 0 0 1.5rem; padding: 0;">
                            <li>School facilities</li>
                            <li>Your favorite subjects</li>
                            <li>Extracurricular activities</li>
                            <li>What you like most about your school</li>
                        </ul>
                    </div>
                    <div class="sms-assignment-meta">
                        <div class="sms-assignment-meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span><strong>Deadline:</strong> {{ now()->addDays(7)->format('M j, Y') }}</span>
                        </div>
                        <div class="sms-assignment-meta-item">
                            <i class="fas fa-file-alt"></i>
                            <span>Online submission (CBE format)</span>
                        </div>
                    </div>
                </div>
                <div class="sms-assignment-actions">
                    <a href="#" class="sms-btn sms-btn-primary" onclick="alert('Assignment submission form will open here. This is a demo.'); return false;">
                        <i class="fas fa-upload"></i> Submit Assignment
                    </a>
                </div>
            </div>

            <!-- Demo Assignment 2: Mathematics -->
            <div class="sms-assignment-card">
                <div class="sms-assignment-header">
                    <div>
                        <div class="sms-assignment-title">Algebra Practice Questions</div>
                        <div class="sms-assignment-subject">Mathematics</div>
                    </div>
                    <span class="sms-assignment-status submitted">Submitted</span>
                </div>
                <div class="sms-assignment-body">
                    <div class="sms-assignment-instructions">
                        Solve the following algebraic equations:
                        <ol style="margin: 0.5rem 0 0 1.5rem; padding: 0;">
                            <li>2x + 5 = 15</li>
                            <li>3y - 7 = 8</li>
                            <li>4z + 3 = 2z + 11</li>
                            <li>5a - 2 = 3a + 10</li>
                        </ol>
                        Show your working clearly.
                    </div>
                    <div class="sms-assignment-meta">
                        <div class="sms-assignment-meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span><strong>Deadline:</strong> {{ now()->subDays(2)->format('M j, Y') }}</span>
                        </div>
                        <div class="sms-assignment-meta-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Submitted on {{ now()->subDays(3)->format('M j, Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="sms-assignment-actions">
                    <a href="#" class="sms-btn sms-btn-secondary" onclick="alert('View your submitted assignment. This is a demo.'); return false;">
                        <i class="fas fa-eye"></i> View Submission
                    </a>
                </div>
            </div>

            <!-- Demo Assignment 3: Basic Science -->
            <div class="sms-assignment-card">
                <div class="sms-assignment-header">
                    <div>
                        <div class="sms-assignment-title">Photosynthesis Process</div>
                        <div class="sms-assignment-subject">Basic Science</div>
                    </div>
                    <span class="sms-assignment-status graded">Graded</span>
                </div>
                <div class="sms-assignment-body">
                    <div class="sms-assignment-instructions">
                        Explain the process of photosynthesis in plants. Answer the following:
                        <ul style="margin: 0.5rem 0 0 1.5rem; padding: 0;">
                            <li>What is photosynthesis?</li>
                            <li>What are the raw materials needed?</li>
                            <li>What are the products?</li>
                            <li>Why is it important?</li>
                        </ul>
                    </div>
                    <div class="sms-assignment-meta">
                        <div class="sms-assignment-meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span><strong>Deadline:</strong> {{ now()->subDays(5)->format('M j, Y') }}</span>
                        </div>
                        <div class="sms-assignment-meta-item">
                            <i class="fas fa-star"></i>
                            <span><strong>Score:</strong> 18/20</span>
                        </div>
                    </div>
                </div>
                <div class="sms-assignment-actions">
                    <a href="#" class="sms-btn sms-btn-secondary" onclick="alert('View graded assignment and feedback. This is a demo.'); return false;">
                        <i class="fas fa-eye"></i> View Result
                    </a>
                </div>
            </div>

            <!-- Demo Assignment 4: Social Studies -->
            <div class="sms-assignment-card">
                <div class="sms-assignment-header">
                    <div>
                        <div class="sms-assignment-title">Nigerian States and Capitals</div>
                        <div class="sms-assignment-subject">Social Studies</div>
                    </div>
                    <span class="sms-assignment-status pending">Pending</span>
                </div>
                <div class="sms-assignment-body">
                    <div class="sms-assignment-instructions">
                        List 10 Nigerian states and their capitals. Use the online form to submit your answers.
                    </div>
                    <div class="sms-assignment-meta">
                        <div class="sms-assignment-meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span><strong>Deadline:</strong> {{ now()->addDays(3)->format('M j, Y') }}</span>
                        </div>
                        <div class="sms-assignment-meta-item">
                            <i class="fas fa-file-alt"></i>
                            <span>Online submission (CBE format)</span>
                        </div>
                    </div>
                </div>
                <div class="sms-assignment-actions">
                    <a href="#" class="sms-btn sms-btn-primary" onclick="alert('Assignment submission form will open here. This is a demo.'); return false;">
                        <i class="fas fa-upload"></i> Submit Assignment
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
