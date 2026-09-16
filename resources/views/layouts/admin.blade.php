<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Primary Meta Tags -->
    <title>@yield('title', 'Admin Dashboard - School Management System')</title>
    <meta name="title" content="@yield('meta_title', 'Admin Dashboard - School Management System')">
    <meta name="description" content="@yield('meta_description', 'Admin dashboard for comprehensive school management. Manage students, staff, classes, fees, and all school operations from one centralized platform.')">
    <meta name="keywords" content="@yield('meta_keywords', 'school admin dashboard, school administration, student management, staff management, school management system')">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @include('sms.partials.design-system')
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--sms-gray-50);
            color: var(--sms-gray-900);
            line-height: 1.6;
        }
        
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background: white;
            border-right: 1px solid var(--sms-gray-200);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
        }
        
        .admin-sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--sms-gray-200);
            background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
            color: white;
        }
        
        .admin-sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.125rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            transition: opacity 0.2s ease;
        }
        
        .admin-sidebar-logo:hover {
            opacity: 0.9;
        }
        
        .admin-sidebar-logo-icon {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .admin-sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-section {
            margin-bottom: 1.5rem;
        }
        
        .nav-section-title {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--sms-gray-500);
            font-weight: 700;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: var(--sms-gray-700);
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.9375rem;
            font-weight: 500;
        }
        
        .nav-item:hover {
            background: var(--sms-gray-50);
            color: var(--sms-primary);
        }
        
        .nav-item.active {
            background: rgba(99, 102, 241, 0.1);
            color: var(--sms-primary);
            border-right: 3px solid var(--sms-primary);
        }
        
        .nav-item i {
            width: 20px;
            text-align: center;
        }
        
        .nav-submenu {
            padding-left: 2.5rem;
        }
        
        .nav-submenu .nav-item {
            padding: 0.625rem 1.5rem;
            font-size: 0.875rem;
        }
        
        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 280px;
            display: flex;
            flex-direction: column;
        }
        
        .admin-topbar {
            background: white;
            border-bottom: 1px solid var(--sms-gray-200);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .admin-topbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--sms-gray-900);
        }
        
        .admin-topbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .admin-user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: var(--sms-gray-50);
            border-radius: 8px;
        }
        
        .admin-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .admin-content {
            flex: 1;
            padding: 1rem;
        }
        
        @media (min-width: 640px) {
            .admin-content {
                padding: 1.5rem;
            }
        }
        
        @media (min-width: 768px) {
            .admin-content {
                padding: 2rem;
            }
        }
        
        /* Flash Messages */
        .sms-alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .sms-alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        .sms-alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        
        .sms-alert-warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        
        .sms-alert-info {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
        
        .sms-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
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
            background: white;
            color: var(--sms-gray-700);
            border: 1px solid var(--sms-gray-300);
        }
        
        .sms-btn-secondary:hover {
            background: var(--sms-gray-50);
        }
        
        /* Mobile Menu Toggle */
        .admin-menu-toggle {
            display: none;
            background: transparent;
            border: none;
            padding: 0.5rem;
            cursor: pointer;
            color: var(--sms-gray-700);
            font-size: 1.25rem;
            touch-action: manipulation;
            margin-right: 0.5rem;
        }
        
        .admin-menu-toggle:active {
            transform: scale(0.95);
        }
        
        /* Mobile Overlay */
        .admin-sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        
        .admin-sidebar-overlay.active {
            display: block;
        }
        
        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .admin-menu-toggle {
                display: block;
            }
            
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 280px;
            }
            
            .admin-sidebar.open {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .admin-topbar {
                padding: 0.875rem 1rem;
            }
            
            .admin-topbar-title {
                font-size: 1.25rem;
            }
            
            .admin-user-menu {
                padding: 0.375rem 0.75rem;
                gap: 0.5rem;
            }
            
            .admin-user-menu > div:last-child {
                display: none;
            }
            
            .admin-content {
                padding: 1rem;
            }
        }
        
        @media (max-width: 640px) {
            .admin-sidebar {
                width: 260px;
            }
            
            .admin-topbar-actions {
                gap: 0.5rem;
            }
            
            .sms-btn {
                padding: 0.5rem 0.75rem;
                font-size: 0.8125rem;
            }
            
            .sms-btn i {
                margin: 0;
            }
            
            .sms-btn span {
                display: none;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar-header">
                <a href="{{ route('school.dashboard') }}" class="admin-sidebar-logo" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 0.75rem; cursor: pointer;" title="Go to Admin Dashboard">
                    <div class="admin-sidebar-logo-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <span>School Admin</span>
                </a>
            </div>
            
            <nav class="admin-sidebar-nav">
                <!-- Dashboard -->
                <div class="nav-section">
                    <a href="{{ route('school.dashboard') }}" class="nav-item {{ request()->routeIs('school.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <!-- Students -->
                <div class="nav-section">
                    <div class="nav-section-title">Students</div>
                    <a href="{{ route('school.students.index') }}" class="nav-item {{ request()->routeIs('school.students.*') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate"></i>
                        <span>Student Info</span>
                    </a>
                    <a href="{{ route('school.students.create') }}" class="nav-item nav-submenu">
                        <i class="fas fa-user-plus"></i>
                        <span>Register Student</span>
                    </a>
                    <a href="{{ route('school.parents.index') }}" class="nav-item nav-submenu {{ request()->routeIs('school.parents.index') || request()->routeIs('school.parents.show') || request()->routeIs('school.parents.edit') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Parents Management</span>
                    </a>
                    <a href="{{ route('school.parents.register') }}" class="nav-item nav-submenu {{ request()->routeIs('school.parents.register') ? 'active' : '' }}">
                        <i class="fas fa-user-plus"></i>
                        <span>Register Parent</span>
                    </a>
                    <a href="{{ route('school.students.id-cards') }}" class="nav-item nav-submenu {{ request()->routeIs('school.students.id-cards*') ? 'active' : '' }}">
                        <i class="fas fa-id-card"></i>
                        <span>ID Cards</span>
                    </a>
                    <a href="{{ route('school.students.index') }}?action=certificates" class="nav-item nav-submenu">
                        <i class="fas fa-certificate"></i>
                        <span>Certificates</span>
                    </a>
                </div>
                
                <!-- Academic -->
                <div class="nav-section">
                    <div class="nav-section-title">Academic</div>
                    <a href="{{ route('school.timetable.index') }}" class="nav-item {{ request()->routeIs('school.timetable.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Routines (Timetable)</span>
                    </a>
                    <a href="{{ route('school.attendance.index') }}" class="nav-item {{ request()->routeIs('school.attendance.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Attendance</span>
                    </a>
                </div>
                
                <!-- Fees -->
                <div class="nav-section">
                    <div class="nav-section-title">Fees</div>
                    <a href="{{ route('school.fees.index') }}" class="nav-item {{ request()->routeIs('school.fees.index') || request()->routeIs('school.fees.edit') || request()->routeIs('school.fees.create') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>Fee Structures</span>
                    </a>
                    <a href="{{ route('school.fees.student-fees') }}" class="nav-item nav-submenu {{ request()->routeIs('school.fees.student-fees') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate"></i>
                        <span>Student Fees</span>
                    </a>
                </div>
                
                <!-- Payments -->
                <div class="nav-section">
                    <div class="nav-section-title">Payments</div>
                    <a href="{{ route('school.payments.index') }}" class="nav-item {{ request()->routeIs('school.payments.index') ? 'active' : '' }}">
                        <i class="fas fa-credit-card"></i>
                        <span>Payment Dashboard</span>
                    </a>
                    <a href="{{ route('school.payments.manual-transfers') }}" class="nav-item nav-submenu {{ request()->routeIs('school.payments.manual-transfers*') ? 'active' : '' }}">
                        <i class="fas fa-university"></i>
                        <span>Manual Transfers</span>
                    </a>
                    <a href="{{ route('school.payments.settings') }}" class="nav-item nav-submenu {{ request()->routeIs('school.payments.settings*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Payment Settings</span>
                    </a>
                </div>
                
                <!-- Examination -->
                <div class="nav-section">
                    <div class="nav-section-title">Examination</div>
                    <a href="{{ route('school.exams.index') }}" class="nav-item {{ request()->routeIs('school.exams.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i>
                        <span>Examination</span>
                    </a>
                    <a href="{{ route('school.exams.index') }}?type=online" class="nav-item">
                        <i class="fas fa-laptop"></i>
                        <span>Online Examination</span>
                    </a>
                </div>
                
                <!-- Academic Activities -->
                <div class="nav-section">
                    <div class="nav-section-title">Academic Activities</div>
                </div>
                
                <!-- Communication -->
                <div class="nav-section">
                    <div class="nav-section-title">Communication</div>
                    <a href="{{ route('school.messages.index') }}" class="nav-item {{ request()->routeIs('school.messages.*') ? 'active' : '' }}">
                        <i class="fas fa-comments"></i>
                        <span>Parent Messages</span>
                    </a>
                    <a href="{{ route('school.notices.index') }}" class="nav-item {{ request()->routeIs('school.notices.*') ? 'active' : '' }}">
                        <i class="fas fa-bullhorn"></i>
                        <span>Notice Board</span>
                    </a>
                </div>
                
                <!-- Staff -->
                <div class="nav-section">
                    <div class="nav-section-title">Staff</div>
                    <a href="{{ route('school.staff.index') }}" class="nav-item {{ request()->routeIs('school.staff.*') ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Staff Management</span>
                    </a>
                </div>
                
                <!-- Classes & Subjects -->
                <div class="nav-section">
                    <div class="nav-section-title">Academic Setup</div>
                    <a href="{{ route('school.classes.index') }}" class="nav-item {{ request()->routeIs('school.classes.*') ? 'active' : '' }}">
                        <i class="fas fa-layer-group"></i>
                        <span>Classes</span>
                    </a>
                    <a href="{{ route('school.subjects.index') }}" class="nav-item {{ request()->routeIs('school.subjects.*') ? 'active' : '' }}">
                        <i class="fas fa-book-open"></i>
                        <span>Subjects</span>
                    </a>
                </div>
                
                <!-- Accounts & Reports -->
                <div class="nav-section">
                    <div class="nav-section-title">Finance & Reports</div>
                    <a href="{{ route('school.results.index') }}" class="nav-item {{ request()->routeIs('school.results.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Reports</span>
                    </a>
                </div>
                
                <!-- Settings -->
                <div class="nav-section">
                    <div class="nav-section-title">Settings</div>
                </div>
            </nav>
        </aside>
        
        <!-- Mobile Overlay -->
        <div class="admin-sidebar-overlay" id="adminOverlay" onclick="toggleSidebar()"></div>
        
        <!-- Main Content -->
        <div class="admin-main">
            <div class="admin-topbar">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <button class="admin-menu-toggle" onclick="toggleSidebar()" aria-label="Toggle Menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="admin-topbar-title">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="admin-topbar-actions">
                    @if(session('sms_user'))
                    <div class="admin-user-menu">
                        <div class="admin-user-avatar">
                            {{ strtoupper(substr(session('sms_user')->name ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 600; font-size: 0.875rem;">{{ session('sms_user')->name ?? 'Admin' }}</div>
                            <div style="font-size: 0.75rem; color: var(--sms-gray-500);">School Administrator</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('sms.logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="sms-btn sms-btn-secondary" aria-label="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            
            <div class="admin-content">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="sms-alert sms-alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{!! session('success') !!}</span>
                    </div>
                @endif
                
                @if(session('error'))
                <div class="sms-alert sms-alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif
                
                @if(session('warning'))
                <div class="sms-alert sms-alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ session('warning') }}</span>
                </div>
                @endif
                
                @if(session('info'))
                <div class="sms-alert sms-alert-info">
                    <i class="fas fa-info-circle"></i>
                    <span>{{ session('info') }}</span>
                </div>
                @endif
                
                @if(isset($errors) && $errors->any())
                <div class="sms-alert sms-alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>Please fix the following errors:</strong>
                        <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                
                <!-- Page Content -->
                @yield('content')
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script>
        window.csrfToken = '{{ csrf_token() }}';
        
        // Auto-hide flash messages
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.sms-alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.3s';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });
        
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('adminOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('adminOverlay');
            const toggle = document.querySelector('.admin-menu-toggle');
            
            if (window.innerWidth <= 1024 && 
                sidebar.classList.contains('open') &&
                !sidebar.contains(event.target) &&
                !toggle.contains(event.target)) {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
