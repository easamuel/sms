@extends('layouts.admin')

@section('title', 'Students - School Management System')
@section('page-title', 'Students')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
        padding: 0;
        width: 100%;
        overflow-x: hidden;
    }
    
    .page-header {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        padding: 2rem 1rem;
        margin-bottom: 1.5rem;
        border-radius: 0;
        box-shadow: var(--sms-shadow-lg);
        width: 100%;
        box-sizing: border-box;
    }
    
    .page-header-content {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
        width: 100%;
    }
    
    .page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: white;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        width: 100%;
    }
    
    .page-title i {
        font-size: 1.5rem;
        opacity: 0.9;
        flex-shrink: 0;
    }
    
    .page-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
        font-weight: 400;
        width: 100%;
    }
    
    .btn-add {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 0.75rem 1.5rem;
        border-radius: var(--sms-radius);
        font-weight: 600;
        font-size: 0.9375rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s;
        backdrop-filter: blur(10px);
        width: 100%;
        min-height: 44px;
        box-sizing: border-box;
    }
    
    .btn-add:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem 1.5rem;
        width: 100%;
        box-sizing: border-box;
    }
    
    .filters-card {
        background: white;
        border-radius: var(--sms-radius-lg);
        box-shadow: var(--sms-shadow);
        border: 1px solid var(--sms-gray-200);
        padding: 1rem;
        margin-bottom: 1rem;
        width: 100%;
        box-sizing: border-box;
    }
    
    .filters-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        align-items: end;
        width: 100%;
    }
    
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        width: 100%;
    }
    
    .filter-label {
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--sms-gray-700);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .filter-input,
    .filter-select {
        padding: 0.75rem;
        border: 2px solid var(--sms-gray-200);
        border-radius: var(--sms-radius);
        font-size: 16px;
        background: white;
        transition: all 0.2s;
        min-height: 44px;
        font-family: inherit;
        width: 100%;
        box-sizing: border-box;
    }
    
    .filter-input:focus,
    .filter-select:focus {
        outline: none;
        border-color: var(--sms-primary);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
    }
    
    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        width: 100%;
    }
    
    .action-buttons .btn {
        flex: 1;
        min-width: 120px;
    }
    
    .sms-card {
        background: white;
        border-radius: var(--sms-radius-lg);
        box-shadow: var(--sms-shadow);
        border: 1px solid var(--sms-gray-200);
        overflow: hidden;
        margin-bottom: 1rem;
        transition: all 0.2s ease;
        width: 100%;
        box-sizing: border-box;
    }
    
    .sms-card:hover {
        box-shadow: var(--sms-shadow-md);
    }
    
    .card-header {
        padding: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        background: var(--sms-gray-50);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 0.75rem;
        width: 100%;
        box-sizing: border-box;
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
        padding: 1rem;
        width: 100%;
        box-sizing: border-box;
    }
    
    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        width: 100%;
        display: block;
        max-width: 100%;
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
        display: table;
    }
    
    .data-table thead {
        background: var(--sms-gray-50);
    }
    
    .data-table th {
        padding: 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--sms-gray-700);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid var(--sms-gray-200);
        white-space: nowrap;
        max-width: 200px;
    }
    
    .data-table th:first-child {
        max-width: 250px;
    }
    
    .data-table th:last-child {
        max-width: 180px;
    }
    
    .data-table td {
        padding: 0.75rem;
        border-bottom: 1px solid var(--sms-gray-200);
        color: var(--sms-gray-800);
        font-size: 0.875rem;
        word-break: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }
    
    .data-table th {
        padding: 0.75rem;
        font-size: 0.6875rem;
    }
    
    .data-table tbody tr {
        transition: background 0.15s;
    }
    
    .data-table tbody tr:hover {
        background: var(--sms-gray-50);
    }
    
    .student-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 0;
        max-width: 100%;
    }
    
    .student-info > div {
        min-width: 0;
        max-width: 100%;
        overflow: hidden;
        flex: 1;
    }
    
    .student-name {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 100%;
        display: block;
    }
    
    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--sms-gray-200);
        flex-shrink: 0;
    }
    
    .avatar-placeholder {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.875rem;
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent));
        flex-shrink: 0;
    }
    
    .student-name {
        font-weight: 600;
        color: var(--sms-gray-900);
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        font-size: 0.8125rem;
        font-weight: 600;
        border-radius: var(--sms-radius);
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        white-space: nowrap;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        box-shadow: var(--sms-shadow-sm);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--sms-shadow-md);
    }
    
    .btn-secondary {
        background: white;
        color: var(--sms-gray-700);
        border: 2px solid var(--sms-gray-300);
    }
    
    .btn-secondary:hover {
        background: var(--sms-gray-50);
        border-color: var(--sms-gray-400);
    }
    
    .btn-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 2px solid #fecaca;
    }
    
    .btn-danger:hover {
        background: #fecaca;
        border-color: #fca5a5;
    }
    
    .btn-warning {
        background: #fef3c7;
        color: #92400e;
        border: 2px solid #fde68a;
    }
    
    .btn-warning:hover {
        background: #fde68a;
    }
    
    .btn-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        width: 100%;
    }
    
    .btn-actions .btn {
        flex: 1;
        min-width: 80px;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--sms-gray-500);
    }
    
    .empty-state-icon {
        font-size: 3rem;
        color: var(--sms-gray-300);
        margin-bottom: 1rem;
    }
    
    .empty-state-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--sms-gray-700);
        margin-bottom: 0.5rem;
    }
    
    .empty-state-text {
        font-size: 0.9375rem;
        color: var(--sms-gray-500);
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1;
    }
    
    .badge-success {
        background: #d1fae5;
        color: #065f46;
    }
    
    .badge-warning {
        background: #fef3c7;
        color: #92400e;
    }
    
    .badge-muted {
        background: var(--sms-gray-200);
        color: var(--sms-gray-700);
    }
    
    /* Mobile Card Layout */
    .mobile-card-view {
        display: none;
    }
    
    .mobile-student-card {
        background: white;
        border: 1px solid var(--sms-gray-200);
        border-radius: var(--sms-radius);
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: var(--sms-shadow-sm);
    }
    
    .mobile-card-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
    }
    
    .mobile-card-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .mobile-card-field {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .mobile-card-label {
        font-size: 0.75rem;
        color: var(--sms-gray-600);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .mobile-card-value {
        font-size: 0.875rem;
        color: var(--sms-gray-900);
        font-weight: 500;
    }
    
    .mobile-card-actions {
        display: flex;
        gap: 0.5rem;
        padding-top: 1rem;
        border-top: 1px solid var(--sms-gray-200);
    }
    
    .mobile-card-actions .btn {
        flex: 1;
        justify-content: center;
    }
    
    /* Responsive Breakpoints */
    @media (max-width: 1023px) {
        /* Hide table on tablets and below, show cards */
        .table-container {
            display: none !important;
        }
        
        .mobile-card-view {
            display: block !important;
        }
        
        .data-table {
            display: none !important;
        }
    }
    
    @media (min-width: 640px) {
        .filters-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .page-header {
            padding: 2rem 1.5rem;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .page-title i {
            font-size: 1.75rem;
        }
        
        .page-subtitle {
            font-size: 1.125rem;
        }
        
        .btn-add {
            width: auto;
            min-width: 200px;
        }
        
        .container {
            padding: 0 1.5rem 1.5rem;
        }
        
        .filters-card {
            padding: 1.5rem;
        }
        
        .card-header,
        .card-body {
            padding: 1.5rem;
        }
        
        .mobile-card-body {
            grid-template-columns: 1fr 1fr;
        }
    }
    
    @media (min-width: 768px) {
        .filters-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        
        .action-buttons {
            flex-direction: row;
        }
        
        .action-buttons .btn {
            flex: 0 1 auto;
        }
        
        .page-header {
            padding: 2.5rem 2rem;
        }
        
        .page-title {
            font-size: 2.25rem;
        }
        
        .page-title i {
            font-size: 2rem;
        }
        
        .page-header-content {
            align-items: center;
        }
        
        .btn-add {
            width: auto;
        }
    }
    
    @media (min-width: 1024px) {
        /* Show table on desktop */
        .table-container {
            display: block !important;
        }
        
        .mobile-card-view {
            display: none !important;
        }
        
        .data-table {
            display: table !important;
        }
        
        .filters-grid {
            grid-template-columns: repeat(4, 1fr);
        }
        
        .container {
            padding: 0 2rem 2rem;
        }
        
        .data-table td {
            padding: 1rem;
            font-size: 0.9375rem;
        }
        
        .data-table th {
            padding: 1rem;
            font-size: 0.75rem;
        }
    }
    
    @media (max-width: 767px) {
        .page-header-content {
            flex-direction: column;
            align-items: stretch;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .page-title i {
            font-size: 1.25rem;
        }
        
        .page-subtitle {
            font-size: 0.9375rem;
        }
        
        .btn-add {
            width: 100%;
            margin-top: 0.5rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .action-buttons .btn {
            width: 100%;
        }
        
        .card-header {
            flex-direction: column;
            align-items: stretch;
        }
        
        .card-header > div {
            width: 100%;
        }
        
        .card-header > div form {
            width: 100%;
        }
        
        .card-header > div form button {
            width: 100%;
        }
        
        .mobile-card-body {
            grid-template-columns: 1fr;
        }
        
        .mobile-card-field {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        
        .mobile-card-actions {
            flex-direction: column;
        }
        
        .mobile-card-actions .btn {
            width: 100%;
        }
    }
    
    @media (max-width: 480px) {
        .page-header {
            padding: 1.25rem 0.75rem;
        }
        
        .page-title {
            font-size: 1.25rem;
        }
        
        .page-title i {
            font-size: 1rem;
        }
        
        .page-subtitle {
            font-size: 0.875rem;
        }
        
        .container {
            padding: 0 0.75rem 1rem;
        }
        
        .filters-card {
            padding: 0.75rem;
        }
        
        .card-header,
        .card-body {
            padding: 0.75rem;
        }
        
        .mobile-student-card {
            padding: 0.75rem;
        }
        
        .btn {
            font-size: 0.875rem;
            padding: 0.625rem 0.875rem;
        }
        
        .filter-input,
        .filter-select {
            font-size: 16px; /* Prevents zoom on iOS */
        }
    }
    
    /* Ensure no horizontal scroll */
    * {
        box-sizing: border-box;
    }
    
    html, body {
        overflow-x: hidden;
        max-width: 100vw;
    }
    
    .sms-page,
    .container,
    .filters-card,
    .sms-card,
    .table-container {
        max-width: 100%;
        overflow-x: hidden;
    }
    
    img {
        max-width: 100%;
        height: auto;
    }
</style>

<div class="sms-page">
    <div class="page-header">
        <div class="page-header-content">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-user-graduate"></i>
                    Students
                </h1>
                <p class="page-subtitle">Manage all students in your school</p>
            </div>
            <a href="{{ route('school.students.create') }}" class="btn-add">
                <i class="fas fa-plus"></i>
                <span>Add New Student</span>
            </a>
        </div>
    </div>

    <div class="container">
        <!-- Filters -->
        <div class="filters-card">
            <div class="filters-grid">
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-search"></i> Search
                    </label>
                    <input type="text" id="searchInput" class="filter-input" placeholder="Search by name or email...">
                </div>
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-users"></i> Class
                    </label>
                    <select id="classFilter" class="filter-select">
                        <option value="">All Classes</option>
                        @php
                            $classes = \App\Models\Sms\SmsClass::where('school_id', $school->id)->get();
                        @endphp
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-filter"></i> Status
                    </label>
                    <select id="statusFilter" class="filter-select">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label" style="opacity: 0;">Actions</label>
                    <div class="action-buttons">
                        <button class="btn btn-secondary" type="button">
                            <i class="fas fa-download"></i>
                            <span class="d-none d-md-inline">Export</span>
                        </button>
                        <a href="{{ route('school.students.id-cards') }}" class="btn btn-primary">
                            <i class="fas fa-id-card"></i>
                            <span class="d-none d-md-inline">ID Cards</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students List -->
        <div class="sms-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-list"></i>
                    Students List
                </h2>
                <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; width: 100%;">
                    <span class="badge badge-muted" style="flex-shrink: 0;">Total: {{ isset($approvedStudents) ? $approvedStudents->total() : 0 }}</span>
                    <form method="POST" action="{{ route('school.students.cleanup-demo') }}" style="display: inline; flex: 1; min-width: 150px;" onsubmit="return confirm('This will delete all duplicate demo accounts, keeping only one demo account per role. Are you sure?');">
                        @csrf
                        <button type="submit" class="btn btn-warning" style="width: 100%;">
                            <i class="fas fa-broom"></i>
                            <span>Cleanup Demo</span>
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if(isset($approvedStudents) && $approvedStudents->count() > 0)
                    <!-- Desktop Table View -->
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Student ID</th>
                                    <th>Email</th>
                                    <th>Class</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="studentsTable">
                                @foreach($approvedStudents as $student)
                                <tr data-name="{{ strtolower($student->user->name ?? $student->name ?? '') }}"
                                    data-email="{{ strtolower($student->user->email ?? '') }}"
                                    data-class="{{ $student->class_id ?? '' }}"
                                    data-status="{{ strtolower($student->status ?? '') }}">
                                    <td style="max-width: 250px;">
                                        <div class="student-info">
                                            @if($student->photo)
                                                <img src="{{ asset('storage/' . $student->photo) }}" 
                                                     alt="Photo" 
                                                     class="student-avatar"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                <div class="avatar-placeholder" style="display: none;">
                                                    {{ strtoupper(substr($student->user->name ?? $student->name ?? 'N', 0, 1)) }}
                                                </div>
                                            @else
                                                <div class="avatar-placeholder">
                                                    {{ strtoupper(substr($student->user->name ?? $student->name ?? 'N', 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="student-name" title="{{ $student->user->name ?? $student->name ?? 'Unknown' }}">{{ $student->user->name ?? $student->name ?? 'Unknown' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="max-width: 150px;"><strong>{{ $student->student_id_number ?? 'N/A' }}</strong></td>
                                    <td style="max-width: 200px; word-break: break-all;">{{ $student->user->email ?? 'N/A' }}</td>
                                    <td>
                                        @if($student->class)
                                            <span class="badge badge-muted">{{ $student->class->name }}</span>
                                        @else
                                            <span style="color: var(--sms-gray-400);">Not Assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $student->status === 'active' ? 'badge-success' : 'badge-warning' }}">
                                            {{ ucfirst($student->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td style="max-width: 180px;">
                                        <div class="btn-actions" style="flex-wrap: wrap; gap: 0.5rem; justify-content: flex-start;">
                                            <a href="{{ route('school.students.show', $student->id) }}" class="btn btn-secondary" style="flex: 0 0 auto; min-width: 60px;">
                                                <i class="fas fa-eye"></i>
                                                <span class="d-none d-lg-inline">View</span>
                                            </a>
                                            <form method="POST" action="{{ route('school.students.destroy', $student->id) }}" style="display: inline; flex: 0 0 auto;" onsubmit="return confirm('Are you sure you want to delete {{ addslashes($student->user->name ?? 'this student') }}? This action cannot be undone and will delete all associated records (fees, results, attendance, etc.).');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" style="min-width: 60px;">
                                                    <i class="fas fa-trash"></i>
                                                    <span class="d-none d-lg-inline">Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Mobile Card View -->
                    <div class="mobile-card-view" id="mobileStudentsList">
                        @foreach($approvedStudents as $student)
                        <div class="mobile-student-card" 
                             data-name="{{ strtolower($student->user->name ?? $student->name ?? '') }}"
                             data-email="{{ strtolower($student->user->email ?? '') }}"
                             data-class="{{ $student->class_id ?? '' }}"
                             data-status="{{ strtolower($student->status ?? '') }}">
                            <div class="mobile-card-header">
                                @if($student->photo)
                                    <img src="{{ asset('storage/' . $student->photo) }}" 
                                         alt="Photo" 
                                         class="student-avatar"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="avatar-placeholder" style="display: none;">
                                        {{ strtoupper(substr($student->user->name ?? $student->name ?? 'N', 0, 1)) }}
                                    </div>
                                @else
                                    <div class="avatar-placeholder">
                                        {{ strtoupper(substr($student->user->name ?? $student->name ?? 'N', 0, 1)) }}
                                    </div>
                                @endif
                                <div style="flex: 1;">
                                    <div class="student-name" style="font-size: 1rem; margin-bottom: 0.25rem;">{{ $student->user->name ?? $student->name ?? 'Unknown' }}</div>
                                    <span class="badge {{ $student->status === 'active' ? 'badge-success' : 'badge-warning' }}" style="font-size: 0.6875rem;">
                                        {{ ucfirst($student->status ?? 'pending') }}
                                    </span>
                                </div>
                            </div>
                            <div class="mobile-card-body">
                                <div class="mobile-card-field">
                                    <span class="mobile-card-label">Student ID</span>
                                    <span class="mobile-card-value">{{ $student->student_id_number ?? 'N/A' }}</span>
                                </div>
                                <div class="mobile-card-field">
                                    <span class="mobile-card-label">Class</span>
                                    <span class="mobile-card-value">
                                        @if($student->class)
                                            {{ $student->class->name }}
                                        @else
                                            <span style="color: var(--sms-gray-400);">Not Assigned</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="mobile-card-field" style="grid-column: 1 / -1;">
                                    <span class="mobile-card-label">Email</span>
                                    <span class="mobile-card-value" style="word-break: break-all;">{{ $student->user->email ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="mobile-card-actions">
                                <a href="{{ route('school.students.show', $student->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-eye"></i>
                                    <span>View</span>
                                </a>
                                <form method="POST" action="{{ route('school.students.destroy', $student->id) }}" style="display: inline; flex: 1;" onsubmit="return confirm('Are you sure you want to delete {{ addslashes($student->user->name ?? 'this student') }}? This action cannot be undone and will delete all associated records (fees, results, attendance, etc.).');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="width: 100%;">
                                        <i class="fas fa-trash"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div style="margin-top: 1.5rem;">
                        {{ $approvedStudents->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="empty-state-title">No Students Found</div>
                        <div class="empty-state-text">No students have been added to your school yet.</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const classFilter = document.getElementById('classFilter');
    const statusFilter = document.getElementById('statusFilter');
    const tableBody = document.getElementById('studentsTable');
    const mobileList = document.getElementById('mobileStudentsList');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedClass = classFilter.value;
        const selectedStatus = statusFilter.value;
        
        // Filter table rows (desktop)
        if (tableBody) {
            const rows = tableBody.querySelectorAll('tr');
            rows.forEach(row => {
                const name = row.getAttribute('data-name') || '';
                const email = row.getAttribute('data-email') || '';
                const classId = row.getAttribute('data-class') || '';
                const status = row.getAttribute('data-status') || '';
                
                const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                const matchesClass = !selectedClass || classId === selectedClass;
                const matchesStatus = !selectedStatus || status === selectedStatus;
                
                if (matchesSearch && matchesClass && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        // Filter mobile cards
        if (mobileList) {
            const cards = mobileList.querySelectorAll('.mobile-student-card');
            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const email = card.getAttribute('data-email') || '';
                const classId = card.getAttribute('data-class') || '';
                const status = card.getAttribute('data-status') || '';
                
                const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                const matchesClass = !selectedClass || classId === selectedClass;
                const matchesStatus = !selectedStatus || status === selectedStatus;
                
                if (matchesSearch && matchesClass && matchesStatus) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    }
    
    if (searchInput) searchInput.addEventListener('input', filterTable);
    if (classFilter) classFilter.addEventListener('change', filterTable);
    if (statusFilter) statusFilter.addEventListener('change', filterTable);
});
</script>
@endsection
