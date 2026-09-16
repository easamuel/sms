@extends('layouts.admin')

@section('page-title', 'Student ID Cards')

@section('content')
<style>
    .admin-page-wrapper {
        padding: 1rem;
    }
    
    .admin-page-header {
        margin-bottom: 1.5rem;
    }
    
    .admin-page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }
    
    .admin-page-subtitle {
        color: var(--sms-gray-600);
        font-size: 0.875rem;
        line-height: 1.5;
    }
    
    .admin-page-actions {
        margin-top: 1rem;
    }
    
    .admin-table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .admin-table {
        width: 100%;
        min-width: 600px;
    }
    
    .admin-search-box {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 8px;
        font-size: 16px;
        min-height: 44px;
        touch-action: manipulation;
    }
    
    /* Mobile Card Layout */
    .mobile-student-card {
        display: none;
        background: white;
        border: 1px solid var(--sms-gray-200);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .mobile-student-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--sms-gray-200);
    }
    
    .mobile-student-photo {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid var(--sms-gray-200);
        flex-shrink: 0;
    }
    
    .mobile-student-info {
        flex: 1;
        min-width: 0;
    }
    
    .mobile-student-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
        word-wrap: break-word;
    }
    
    .mobile-student-id {
        font-size: 0.8125rem;
        color: var(--sms-gray-600);
        font-weight: 600;
    }
    
    .mobile-student-details {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .mobile-detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
    }
    
    .mobile-detail-label {
        font-size: 0.8125rem;
        color: var(--sms-gray-600);
        font-weight: 600;
    }
    
    .mobile-detail-value {
        font-size: 0.875rem;
        color: var(--sms-gray-900);
        text-align: right;
        flex: 1;
        margin-left: 1rem;
    }
    
    .mobile-download-btn {
        width: 100%;
        min-height: 44px;
        padding: 0.875rem 1rem;
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.9375rem;
        font-weight: 600;
        cursor: pointer;
        touch-action: manipulation;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .mobile-download-btn:active {
        transform: scale(0.98);
    }
    
    /* Hide table on mobile, show cards */
    @media (max-width: 767px) {
        .admin-table-wrapper {
            display: none;
        }
        
        .mobile-student-card {
            display: block;
        }
        
        .sms-card {
            padding: 1rem;
        }
    }
    
    @media (min-width: 640px) {
        .admin-page-wrapper {
            padding: 1.5rem;
        }
        
        .admin-page-title {
            font-size: 1.75rem;
        }
        
        .admin-page-subtitle {
            font-size: 1rem;
        }
        
        .admin-page-actions {
            margin-top: 0;
        }
    }
    
    @media (min-width: 768px) {
        .admin-page-wrapper {
            padding: 2rem;
        }
        
        .admin-page-title {
            font-size: 1.875rem;
        }
        
        .mobile-student-card {
            display: none;
        }
        
        .admin-table-wrapper {
            display: block;
        }
    }
</style>

<div class="admin-page-wrapper">
    <div class="admin-page-header">
        <h1 class="admin-page-title">Student ID Cards</h1>
        <p class="admin-page-subtitle">Generate and download student ID cards</p>
        <div class="admin-page-actions">
            <a href="{{ route('school.students.id-cards.download-all') }}" class="sms-btn sms-btn-primary" style="text-decoration: none; width: 100%; min-height: 44px;">
                <i class="fas fa-download"></i> Download All ID Cards (PDF)
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="sms-alert sms-alert-success" style="margin-bottom: 1.5rem;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="sms-alert sms-alert-danger" style="margin-bottom: 1.5rem;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if($students->isEmpty())
        <div class="sms-card" style="text-align: center; padding: 3rem;">
            <i class="fas fa-id-card" style="font-size: 3rem; color: var(--sms-gray-400); margin-bottom: 1rem;"></i>
            <h3 style="color: var(--sms-gray-700); margin-bottom: 0.5rem;">No Students Found</h3>
            <p style="color: var(--sms-gray-500);">You haven't registered any students yet. <a href="{{ route('school.students.create') }}" style="color: var(--sms-primary); text-decoration: none;">Register a student</a> to generate ID cards.</p>
        </div>
    @else
        <div class="sms-card" style="padding: 1rem;">
            <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--sms-gray-200);">
                <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--sms-gray-900); margin-bottom: 1rem;">All Students ({{ $students->count() }})</h2>
                <input type="text" id="searchInput" placeholder="Search by name or ID..." 
                       class="admin-search-box">
            </div>

            <!-- Desktop Table View -->
            <div class="admin-table-wrapper">
                <table class="sms-table admin-table">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Club/Position</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentsTable">
                        @foreach($students as $student)
                        <tr data-name="{{ strtolower($student->user->name ?? '') }}" data-id="{{ strtolower($student->student_id_number) }}">
                            <td>
                                @if($student->photo)
                                    <img src="{{ asset('storage/' . $student->photo) }}" 
                                         alt="Student Photo" 
                                         style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover; border: 2px solid var(--sms-gray-200);"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div style="display: none; width: 50px; height: 50px; border-radius: 8px; background: var(--sms-gray-100); align-items: center; justify-content: center; color: var(--sms-gray-400); font-size: 0.75rem;">
                                        No Photo
                                    </div>
                                @else
                                    <div style="width: 50px; height: 50px; border-radius: 8px; background: var(--sms-gray-100); display: flex; align-items: center; justify-content: center; color: var(--sms-gray-400); font-size: 0.75rem;">
                                        No Photo
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $student->student_id_number }}</strong></td>
                            <td>{{ $student->user->name ?? 'N/A' }}</td>
                            <td>
                                @if($student->class)
                                    <span class="sms-badge sms-badge-primary">{{ $student->class->name }}</span>
                                @else
                                    <span style="color: var(--sms-gray-400);">Not Assigned</span>
                                @endif
                            </td>
                            <td>
                                @if($student->club)
                                    <div style="font-size: 0.875rem;">
                                        <strong>{{ $student->club->name }}</strong>
                                        @if($student->club_position)
                                            <br><span style="color: var(--sms-gray-600); font-size: 0.8125rem;">{{ $student->club_position }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span style="color: var(--sms-gray-400);">No Club</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('school.students.id-cards.download', $student->id) }}" 
                                   class="sms-btn sms-btn-primary" 
                                   style="text-decoration: none; padding: 0.75rem 1rem; font-size: 0.875rem; min-height: 44px; white-space: nowrap;">
                                    <i class="fas fa-download"></i> <span style="display: inline;">Download</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Mobile Card View -->
            <div id="mobileStudentsList">
                @foreach($students as $student)
                <div class="mobile-student-card" data-name="{{ strtolower($student->user->name ?? '') }}" data-id="{{ strtolower($student->student_id_number) }}">
                    <div class="mobile-student-header">
                        @if($student->photo)
                            <img src="{{ asset('storage/' . $student->photo) }}" 
                                 alt="Student Photo" 
                                 class="mobile-student-photo"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div style="display: none; width: 60px; height: 60px; border-radius: 8px; background: var(--sms-gray-100); display: flex; align-items: center; justify-content: center; color: var(--sms-gray-400); font-size: 0.75rem; flex-shrink: 0;">
                                No Photo
                            </div>
                        @else
                            <div style="width: 60px; height: 60px; border-radius: 8px; background: var(--sms-gray-100); display: flex; align-items: center; justify-content: center; color: var(--sms-gray-400); font-size: 0.75rem; flex-shrink: 0;">
                                No Photo
                            </div>
                        @endif
                        <div class="mobile-student-info">
                            <div class="mobile-student-name">{{ $student->user->name ?? 'N/A' }}</div>
                            <div class="mobile-student-id">{{ $student->student_id_number }}</div>
                        </div>
                    </div>
                    
                    <div class="mobile-student-details">
                        <div class="mobile-detail-item">
                            <span class="mobile-detail-label">Class</span>
                            <span class="mobile-detail-value">
                                @if($student->class)
                                    <span class="sms-badge sms-badge-primary">{{ $student->class->name }}</span>
                                @else
                                    <span style="color: var(--sms-gray-400);">Not Assigned</span>
                                @endif
                            </span>
                        </div>
                        <div class="mobile-detail-item">
                            <span class="mobile-detail-label">Club</span>
                            <span class="mobile-detail-value">
                                @if($student->club)
                                    <div style="font-size: 0.875rem; text-align: right;">
                                        <strong>{{ $student->club->name }}</strong>
                                        @if($student->club_position)
                                            <br><span style="color: var(--sms-gray-600); font-size: 0.8125rem;">{{ $student->club_position }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span style="color: var(--sms-gray-400);">No Club</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <a href="{{ route('school.students.id-cards.download', $student->id) }}" class="mobile-download-btn">
                        <i class="fas fa-download"></i>
                        <span>Download ID Card</span>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('studentsTable');
        const mobileList = document.getElementById('mobileStudentsList');
        const tableRows = tableBody ? tableBody.querySelectorAll('tr') : [];
        const mobileCards = mobileList ? mobileList.querySelectorAll('.mobile-student-card') : [];

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                
                // Filter table rows (desktop)
                tableRows.forEach(row => {
                    const name = row.getAttribute('data-name') || '';
                    const id = row.getAttribute('data-id') || '';
                    
                    if (name.includes(searchTerm) || id.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                // Filter mobile cards
                mobileCards.forEach(card => {
                    const name = card.getAttribute('data-name') || '';
                    const id = card.getAttribute('data-id') || '';
                    
                    if (name.includes(searchTerm) || id.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection
