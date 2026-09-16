@extends('layouts.admin')

@section('title', 'Subjects Management - School Management System')
@section('page-title', 'Subjects Management')

@section('content')
@include('sms.partials.design-system')
<style>
    .page-header {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        line-height: 1.2;
    }
    .sms-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .sms-card-header {
        padding: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        background: var(--sms-gray-50);
    }
    .sms-card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .sms-card-body {
        padding: 1rem;
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
    .sms-form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 16px;
        min-height: 44px;
        touch-action: manipulation;
    }
    .sms-form-input:focus {
        outline: none;
        border-color: #1e3a8a;
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
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
        text-decoration: none;
        min-height: 44px;
        touch-action: manipulation;
        width: 100%;
        transition: all 0.2s;
    }
    .sms-btn-primary {
        background: linear-gradient(135deg, #1e3a8a, #10b981);
        color: white;
    }
    .sms-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.4);
    }
    .sms-table {
        width: 100%;
        border-collapse: collapse;
    }
    .sms-table thead {
        background: var(--sms-gray-50);
    }
    .sms-table th {
        padding: 0.875rem 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--sms-gray-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid var(--sms-gray-200);
    }
    .sms-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
        color: var(--sms-gray-800);
        font-size: 0.9375rem;
    }
    .sms-table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .sms-table {
        min-width: 600px;
    }
    .sms-table tbody tr:hover {
        background: var(--sms-gray-50);
    }
    
    /* Mobile Card Layout for Table */
    .subject-card {
        display: none;
    }
    
    @media (max-width: 767px) {
        .sms-table-wrapper {
            display: none;
        }
        
        .subject-card {
            display: block;
            background: white;
            border: 1px solid var(--sms-gray-200);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .subject-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--sms-gray-200);
        }
        
        .subject-card-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--sms-gray-900);
            margin: 0;
        }
        
        .subject-card-body {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .subject-card-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
        }
        
        .subject-card-label {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--sms-gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .subject-card-value {
            font-size: 0.9375rem;
            color: var(--sms-gray-800);
            text-align: right;
            flex: 1;
            margin-left: 1rem;
        }
        
        .subject-card-description {
            font-size: 0.875rem;
            color: var(--sms-gray-600);
            line-height: 1.5;
            padding-top: 0.5rem;
            border-top: 1px solid var(--sms-gray-200);
        }
    }
    .sms-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    @media (min-width: 640px) {
        .page-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 1.75rem;
        }
        
        .sms-card-header,
        .sms-card-body {
            padding: 1.5rem;
        }
        
        .sms-form-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .sms-btn {
            width: auto;
            padding: 0.625rem 1.25rem;
        }
    }
    
    @media (min-width: 768px) {
        .page-title {
            font-size: 1.875rem;
        }
        
        .subject-card {
            display: none !important;
        }
        
        .sms-table-wrapper {
            display: block !important;
        }
    }
    
    @media (max-width: 640px) {
        .page-header {
            margin-bottom: 1rem;
        }
        
        .page-title {
            font-size: 1.375rem;
        }
        
        .sms-card {
            margin-bottom: 1rem;
        }
        
        .sms-card-header,
        .sms-card-body {
            padding: 1rem;
        }
        
        .sms-form-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .sms-btn {
            width: 100%;
            padding: 0.875rem 1.5rem;
        }
        
        .nerdc-buttons-grid {
            grid-template-columns: 1fr !important;
            gap: 1rem;
        }
        
        .nerdc-buttons-grid form {
            width: 100%;
        }
        
        .nerdc-buttons-grid .sms-btn {
            width: 100%;
            padding: 0.875rem 1rem;
        }
        
        .nerdc-buttons-grid div[style*="font-size: 0.75rem"] {
            font-size: 0.6875rem !important;
            line-height: 1.4;
            margin-top: 0.375rem;
        }
    }
    .sms-badge-success {
        background: #d1fae5;
        color: #065f46;
    }
    
    /* Pagination Styling - Compact & Mobile-Friendly */
    .pagination {
        margin-top: 1.5rem;
    }
    
    .pagination nav {
        width: 100%;
    }
    
    /* Override all pagination elements */
    .pagination * {
        box-sizing: border-box;
    }
    
    .pagination .flex {
        display: flex !important;
        align-items: center;
        justify-content: center;
        gap: 0.375rem !important;
        flex-wrap: wrap;
    }
    
    /* Arrow buttons - make them smaller */
    .pagination .relative.inline-flex.items-center {
        min-width: 32px !important;
        width: 32px !important;
        height: 32px !important;
        padding: 0.375rem !important;
        margin: 0 !important;
    }
    
    .pagination svg {
        width: 14px !important;
        height: 14px !important;
    }
    
    /* Page number buttons */
    .pagination a[aria-label*="page"],
    .pagination span[aria-label*="page"] {
        min-width: 32px !important;
        height: 32px !important;
        padding: 0.375rem 0.625rem !important;
        font-size: 0.8125rem !important;
        font-weight: 500;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .pagination a {
        background: white !important;
        border: 1px solid var(--sms-gray-300) !important;
        color: var(--sms-gray-700) !important;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .pagination a:hover {
        background: var(--sms-gray-50) !important;
        border-color: #1e3a8a !important;
        color: #1e3a8a !important;
        transform: translateY(-1px);
    }
    
    .pagination span[aria-disabled="true"],
    .pagination span.cursor-default {
        background: var(--sms-gray-100) !important;
        border: 1px solid var(--sms-gray-300) !important;
        color: var(--sms-gray-400) !important;
        cursor: not-allowed;
    }
    
    /* Pagination info text */
    .pagination .text-sm {
        font-size: 0.8125rem !important;
        color: var(--sms-gray-600);
    }
    
    /* Mobile: Compact arrows, hide page numbers if too many */
    @media (max-width: 640px) {
        .pagination .hidden.sm\:flex {
            display: none !important;
        }
        
        .pagination .flex.sm\:hidden {
            display: flex !important;
            width: 100%;
            justify-content: space-between;
            gap: 0.5rem;
        }
        
        .pagination .relative.inline-flex.items-center {
            min-width: 40px !important;
            width: 40px !important;
            height: 40px !important;
        }
        
        .pagination svg {
            width: 18px !important;
            height: 18px !important;
        }
        
        /* Hide middle page numbers on very small screens */
        .pagination a[aria-label*="page"]:not([aria-label*="1"]):not([aria-label*="2"]):not([aria-label*="3"]) {
            display: none;
        }
    }
    
    /* Desktop: Very compact */
    @media (min-width: 641px) {
        .pagination .relative.z-0 {
            gap: 0.25rem !important;
        }
        
        .pagination .relative.inline-flex.items-center {
            min-width: 28px !important;
            width: 28px !important;
            height: 28px !important;
            padding: 0.25rem !important;
        }
        
        .pagination svg {
            width: 12px !important;
            height: 12px !important;
        }
        
        .pagination a[aria-label*="page"],
        .pagination span[aria-label*="page"] {
            min-width: 28px !important;
            height: 28px !important;
            padding: 0.25rem 0.5rem !important;
            font-size: 0.75rem !important;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">Subjects Management</h1>
</div>

<!-- Bulk Create NERDC Subjects -->
<div class="sms-card" style="background: linear-gradient(135deg, #1e3a8a 0%, #10b981 100%); color: white; margin-bottom: 1.5rem;">
    <div class="sms-card-header" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.2);">
        <h2 class="sms-card-title" style="color: white;">
            <i class="fas fa-graduation-cap"></i> Create NERDC-Approved Subjects (Bulk)
        </h2>
    </div>
    <div class="sms-card-body" style="color: white;">
        <p style="margin-bottom: 1.5rem; opacity: 0.95; font-size: 0.9375rem; line-height: 1.6;">
            Quickly create all Nigerian Educational Research and Development Council (NERDC) approved subjects for your school. 
            Subjects are organized by educational level. Existing subjects will be skipped.
        </p>
        <div class="nerdc-buttons-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
            <form action="{{ route('school.subjects.bulk-create') }}" method="POST" onsubmit="return confirm('This will create all NERDC-approved subjects for Primary level (Basic 1-6). Continue?');">
                @csrf
                <input type="hidden" name="level" value="primary">
                <button type="submit" class="sms-btn" style="width: 100%; background: white; color: #667eea; font-weight: 600; padding: 0.75rem 1rem; font-size: 0.875rem;">
                    <i class="fas fa-school"></i> Create Primary Subjects (12)
                </button>
                <div style="font-size: 0.75rem; margin-top: 0.5rem; opacity: 0.9;">
                    English, Mathematics, Basic Science, Social Studies, CCA, PHE, CRS, IS, Nigerian Languages, French, Arabic, Basic Technology
                </div>
            </form>
            
            <form action="{{ route('school.subjects.bulk-create') }}" method="POST" onsubmit="return confirm('This will create all NERDC-approved subjects for Junior Secondary (JSS1-3). Continue?');">
                @csrf
                <input type="hidden" name="level" value="jss">
                <button type="submit" class="sms-btn" style="width: 100%; background: white; color: #667eea; font-weight: 600; padding: 0.75rem 1rem; font-size: 0.875rem;">
                    <i class="fas fa-user-graduate"></i> Create JSS Subjects (20)
                </button>
                <div style="font-size: 0.75rem; margin-top: 0.5rem; opacity: 0.9;">
                    Core subjects + Trade subjects (Solar, Fashion, Livestock, Beauty, Computer Hardware, Horticulture)
                </div>
            </form>
            
            <form action="{{ route('school.subjects.bulk-create') }}" method="POST" onsubmit="return confirm('This will create all NERDC-approved subjects for Senior Secondary (SS1-3). Continue?');">
                @csrf
                <input type="hidden" name="level" value="ss">
                <button type="submit" class="sms-btn" style="width: 100%; background: white; color: #667eea; font-weight: 600; padding: 0.75rem 1rem; font-size: 0.875rem;">
                    <i class="fas fa-university"></i> Create SS Subjects (38)
                </button>
                <div style="font-size: 0.75rem; margin-top: 0.5rem; opacity: 0.9;">
                    Core + Trade + Science + Humanities + Business electives
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Subject Form -->
<div class="sms-card">
    <div class="sms-card-header">
        <h2 class="sms-card-title">Add New Subject</h2>
    </div>
    <div class="sms-card-body">
        <form action="{{ route('school.subjects.store') }}" method="POST">
            @csrf
            <div class="sms-form-row">
                <div class="sms-form-group">
                    <label class="sms-form-label">Subject Name *</label>
                    <input type="text" name="name" class="sms-form-input" required placeholder="e.g. Mathematics">
                </div>
                <div class="sms-form-group">
                    <label class="sms-form-label">Subject Code</label>
                    <input type="text" name="code" class="sms-form-input" placeholder="e.g. MAT">
                </div>
            </div>
            <div class="sms-form-group">
                <label class="sms-form-label">Description</label>
                <textarea name="description" class="sms-form-input" rows="3" placeholder="Optional description"></textarea>
            </div>
            <button type="submit" class="sms-btn sms-btn-primary">
                <i class="fas fa-plus"></i> Add Subject
            </button>
        </form>
    </div>
</div>

<!-- Subjects List -->
<div class="sms-card">
    <div class="sms-card-header">
        <h2 class="sms-card-title">All Subjects</h2>
    </div>
    <div class="sms-card-body">
        @if($subjects->count() > 0)
        <!-- Desktop Table View -->
        <div class="sms-table-wrapper">
            <table class="sms-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $subject)
                    <tr>
                        <td style="font-weight: 600;">{{ $subject->name }}</td>
                        <td>{{ $subject->code ?? '—' }}</td>
                        <td>{{ $subject->description ?? '—' }}</td>
                        <td>
                            <span class="sms-badge sms-badge-success">
                                {{ $subject->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Mobile Card View -->
        <div class="subjects-mobile-list">
            @foreach($subjects as $subject)
            <div class="subject-card">
                <div class="subject-card-header">
                    <h3 class="subject-card-title">{{ $subject->name }}</h3>
                    <span class="sms-badge sms-badge-success">
                        {{ $subject->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="subject-card-body">
                    @if($subject->code)
                    <div class="subject-card-row">
                        <span class="subject-card-label">Code</span>
                        <span class="subject-card-value">{{ $subject->code }}</span>
                    </div>
                    @endif
                    @if($subject->description)
                    <div class="subject-card-description">
                        {{ $subject->description }}
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="pagination">
            {{ $subjects->links() }}
        </div>
        @else
        <div style="text-align: center; padding: 3rem;">
            <div style="font-size: 3rem; color: var(--sms-gray-300); margin-bottom: 1rem;">
                <i class="fas fa-book-open"></i>
            </div>
            <div style="font-size: 1.125rem; font-weight: 600; color: var(--sms-gray-700); margin-bottom: 0.5rem;">
                No Subjects Yet
            </div>
            <div style="color: var(--sms-gray-500);">
                Add your first subject above
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
