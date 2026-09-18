<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Primary Meta Tags -->
    <title>@yield('title', 'Admin Dashboard - ES-SCHOOLS')</title>
    <meta name="description" content="Proprietor &amp; Admin Management Portal for ES-SCHOOLS. Complete management for students, staff, classes, fees, exams, and academic operations.">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- Favicon & Icons -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    
    <!-- Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @include('sms.partials.design-system')
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --bg-body: #f4f6fb;
            --bg-sidebar: #ffffff;
            --bg-header: #ffffff;
            --bg-card: #ffffff;
            --bg-card-header: #f8fafc;
            --border-color: #e2e8f0;
            --border-subtle: #f1f5f9;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --primary: #1e3a8a;
            --primary-dark: #172554;
            --accent-orange: #ff9f43;
            --accent-purple: #a55eea;
            --accent-blue: #4b7bec;
            --accent-cyan: #0fbcf9;
            --accent-green: #10b981;
            --accent-red: #ef4444;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px -2px rgba(0,0,0,0.06);
            --shadow-lg: 0 10px 25px -5px rgba(0,0,0,0.05);
        }

        body.dark-theme {
            --bg-body: #16171d;
            --bg-sidebar: #121318;
            --bg-header: #1a1b22;
            --bg-card: #20222a;
            --bg-card-header: #272933;
            --border-color: #2c2e39;
            --border-subtle: #20222a;
            --text-main: #ffffff;
            --text-muted: #9aa0ac;
            --primary: #3b82f6;
            --primary-dark: #1d4ed8;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.3);
            --shadow-md: 0 4px 12px -2px rgba(0,0,0,0.4);
            --shadow-lg: 0 10px 25px -5px rgba(0,0,0,0.5);
        }

        html, body {
            overflow-x: hidden !important;
            max-width: 100vw !important;
            width: 100% !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 255px;
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .sidebar-header {
            padding: 1.15rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            height: 68px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .brand-logo .grad-cap {
            background: linear-gradient(135deg, #1e3a8a, #10b981);
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
            box-shadow: 0 4px 10px rgba(30,58,138,0.25);
            flex-shrink: 0;
        }

        .brand-text-wrap {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-size: 1.125rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        body.dark-theme .brand-title {
            color: #ffffff;
        }

        .brand-sub {
            font-size: 0.6875rem;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .collapse-btn {
            color: var(--text-muted);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
            padding: 0.25rem;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .collapse-btn:hover {
            color: var(--primary);
            background: var(--border-subtle);
        }

        .mobile-close-btn {
            display: none;
            width: 32px;
            height: 32px;
            background: var(--border-subtle);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 0.95rem;
            cursor: pointer;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0.85rem 0.75rem;
            overflow-y: auto;
            flex: 1;
        }

        .menu-item {
            margin-bottom: 0.25rem;
        }

        .menu-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.7rem 0.85rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .menu-link:hover, .menu-link.active {
            color: var(--primary);
            background: rgba(30, 58, 138, 0.08);
            font-weight: 700;
        }

        body.dark-theme .menu-link:hover, body.dark-theme .menu-link.active {
            color: #3b82f6;
            background: rgba(59, 130, 246, 0.14);
        }

        .menu-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .menu-left i {
            font-size: 1.05rem;
            width: 22px;
            text-align: center;
        }

        .menu-section-header {
            font-size: 0.6875rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            font-weight: 800;
            padding: 0.75rem 0.85rem 0.35rem;
        }

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: 255px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
            background-color: var(--bg-body);
        }

        /* Top Header */
        .top-header {
            height: 68px;
            background-color: var(--bg-header);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.75rem;
            position: sticky;
            top: 0;
            z-index: 900;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .mobile-toggle-btn {
            display: none;
            width: 38px;
            height: 38px;
            background: var(--border-subtle);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.05rem;
            cursor: pointer;
            flex-shrink: 0;
        }

        .header-title-text {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }

        .header-select-pill {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--border-subtle);
            border: 1px solid var(--border-color);
            padding: 0.45rem 0.85rem;
            border-radius: 30px;
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .header-select-pill i {
            color: var(--accent-orange);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            border: 1px solid var(--border-color);
            background-color: var(--bg-card);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .header-icon-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--border-subtle);
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.35rem 0.85rem 0.35rem 0.45rem;
            border-radius: 30px;
            background: var(--border-subtle);
            border: 1px solid var(--border-color);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e3a8a, #10b981);
            color: white;
            font-weight: 800;
            font-size: 0.8125rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .user-name {
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .user-role {
            font-size: 0.6875rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .btn-logout {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.35rem;
            border-radius: 6px;
            transition: color 0.2s;
            display: flex;
            align-items: center;
        }

        .btn-logout:hover {
            color: #ef4444;
        }

        /* Page Content */
        .admin-content {
            padding: 1.75rem;
            flex: 1;
            min-width: 0;
            max-width: 1400px;
            width: 100%;
        }

        /* Flash Messages */
        .sms-alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            box-shadow: var(--shadow-sm);
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

        /* Sidebar Overlay for Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
            }
            .mobile-toggle-btn {
                display: flex;
            }
            .mobile-close-btn {
                display: flex;
            }
            .header-select-pill {
                display: none;
            }
            .user-details {
                display: none;
            }
            .admin-content {
                padding: 1.25rem 1rem;
            }
        }

        @media (max-width: 640px) {
            .top-header {
                padding: 0 1rem;
                height: 60px;
            }
            .header-title-text {
                font-size: 1.05rem;
            }
            .admin-content {
                padding: 1rem 0.75rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>

    <!-- Left Sidebar -->
    <aside class="sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <a href="{{ route('home') }}" class="brand-logo" title="Back to Homepage">
                <div class="grad-cap">
                    <i class="fas fa-school"></i>
                </div>
                <div class="brand-text-wrap">
                    <span class="brand-title">ES-SCHOOLS</span>
                    <span class="brand-sub">Proprietor / Admin</span>
                </div>
            </a>
            <button class="mobile-close-btn" id="closeSidebarMobile" onclick="toggleAdminSidebar()" title="Close Menu">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="{{ route('school.dashboard') }}" class="menu-link {{ request()->routeIs('school.dashboard') ? 'active' : '' }}">
                    <div class="menu-left">
                        <i class="fas fa-tachometer-alt" style="color: #1e3a8a;"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>

            <div class="menu-section-header">Students &amp; Families</div>

            <li class="menu-item">
                <a href="{{ route('school.students.index') }}" class="menu-link {{ request()->routeIs('school.students.*') ? 'active' : '' }}">
                    <div class="menu-left">
                        <i class="fas fa-user-graduate" style="color: #ff9f43;"></i>
                        <span>Student Directory</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.parents.index') }}" class="menu-link {{ request()->routeIs('school.parents.*') ? 'active' : '' }}">
                    <div class="menu-left">
                        <i class="fas fa-users" style="color: #4b7bec;"></i>
                        <span>Parents Management</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admission.create') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-user-plus" style="color: #10b981;"></i>
                        <span>Online Admission</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.students.id-cards') }}" class="menu-link {{ request()->routeIs('school.students.id-cards*') ? 'active' : '' }}">
                    <div class="menu-left">
                        <i class="fas fa-id-card" style="color: #8b5cf6;"></i>
                        <span>Student ID Cards</span>
                    </div>
                </a>
            </li>

            <div class="menu-section-header">Academics &amp; Faculty</div>

            <li class="menu-item">
                <a href="{{ route('school.staff.index') }}" class="menu-link {{ request()->routeIs('school.staff.*') ? 'active' : '' }}">
                    <div class="menu-left">
                        <i class="fas fa-chalkboard-teacher" style="color: #4b7bec;"></i>
                        <span>Teachers &amp; Staff</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.classes.index') }}" class="menu-link {{ request()->routeIs('school.classes.*') ? 'active' : '' }}">
                    <div class="menu-left">
                        <i class="fas fa-layer-group" style="color: #a55eea;"></i>
                        <span>Classes &amp; Sections</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.subjects.index') }}" class="menu-link {{ request()->routeIs('school.subjects.*') ? 'active' : '' }}">
                    <div class="menu-left">
                        <i class="fas fa-book" style="color: #10b981;"></i>
                        <span>Subjects</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.attendance.index') }}" class="menu-link {{ request()->routeIs('school.attendance.*') ? 'active' : '' }}">
                    <div class="menu-left">
                        <i class="fas fa-user-check" style="color: #0fbcf9;"></i>
                        <span>Attendance</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.timetable.index') }}" class="menu-link {{ request()->routeIs('school.timetable.*') ? 'active' : '' }}">
                    <div class="menu-left">
                        <i class="far fa-calendar-alt" style="color: #f59e0b;"></i>
                        <span>Routines &amp; Timetable</span>
                    </div>
                </a>
            </li>

            <div class="menu-section-header">CBT &amp; Evaluation</div>

            <li class="menu-item">
                <a href="{{ route('school.exams.index') }}" class="menu-link {{ request()->routeIs('school.exams.*') ? 'active' : '' }}">
                    <div class="menu-left">
                        <i class="fas fa-laptop-code" style="color: #8b5cf6;"></i>
                        <span>Exams &amp; CBT</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.results.index') }}" class="menu-link {{ request()->routeIs('school.results.*') ? 'active' : '' }}">
                    <div class="menu-left">
                        <i class="fas fa-poll" style="color: #06b6d4;"></i>
                        <span>Results &amp; Grading</span>
                    </div>
                </a>
            </li>

            <div class="menu-section-header">Finance &amp; Fees</div>

            <li class="menu-item">
                <a href="{{ route('school.fees.index') }}" class="menu-link {{ request()->routeIs('school.fees.*') ? 'active' : '' }}">
                    <div class="menu-left">
                        <i class="fas fa-money-bill-wave" style="color: #10b981;"></i>
                        <span>Fees &amp; Invoicing</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.payments.index') }}" class="menu-link {{ request()->routeIs('school.payments.*') ? 'active' : '' }}">
                    <div class="menu-left">
                        <i class="fas fa-credit-card" style="color: #3b82f6;"></i>
                        <span>Payments &amp; Transfers</span>
                    </div>
                </a>
            </li>

            <div class="menu-section-header">Communication &amp; Portal</div>

            <li class="menu-item">
                <a href="{{ route('school.messages.index') }}" class="menu-link {{ request()->routeIs('school.messages.*') ? 'active' : '' }}">
                    <div class="menu-left">
                        <i class="far fa-comments" style="color: #3b82f6;"></i>
                        <span>Parent Messages</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.notices.index') }}" class="menu-link {{ request()->routeIs('school.notices.*') ? 'active' : '' }}">
                    <div class="menu-left">
                        <i class="far fa-bell" style="color: #f59e0b;"></i>
                        <span>Notice Board</span>
                    </div>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" id="adminSidebarOverlay" onclick="toggleAdminSidebar()"></div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-left">
                <button class="mobile-toggle-btn" onclick="toggleAdminSidebar()" aria-label="Toggle Menu">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="header-title-text">@yield('page-title', 'School Admin')</div>
                <div class="header-select-pill">
                    <i class="fas fa-graduation-cap"></i>
                    <span>2026/2027 Academic Session</span>
                </div>
            </div>

            <div class="header-right">
                <!-- Theme Toggle Button -->
                <button class="header-icon-btn" id="themeToggleBtn" onclick="toggleTheme()" title="Switch Light/Dark Mode" aria-label="Switch Theme">
                    <i class="fas fa-moon" id="themeIcon"></i>
                </button>

                <!-- Website Home Link -->
                <a href="{{ route('home') }}" class="header-icon-btn" title="Go to Website Homepage">
                    <i class="fas fa-globe"></i>
                </a>

                <!-- User Profile Pill -->
                <div class="user-pill">
                    <div class="user-avatar">
                        {{ strtoupper(substr(session('sms_user')->name ?? 'Admin', 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <span class="user-name">{{ session('sms_user')->name ?? 'Administrator' }}</span>
                        <span class="user-role">Proprietor / Admin</span>
                    </div>
                    <form method="POST" action="{{ route('sms.logout') }}" style="display: inline; margin-left: 0.25rem;">
                        @csrf
                        <button type="submit" class="btn-logout" title="Sign Out">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="admin-content">
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
                        <strong>Please resolve the following:</strong>
                        <ul style="margin-top: 0.25rem; margin-left: 1.25rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script>
        window.csrfToken = '{{ csrf_token() }}';

        // Mobile drawer toggle
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('adminSidebarOverlay');
            if (sidebar) {
                sidebar.classList.toggle('mobile-open');
            }
            if (overlay) {
                overlay.classList.toggle('active');
            }
        }

        // Theme Toggle
        function toggleTheme() {
            const isDark = document.body.classList.toggle('dark-theme');
            localStorage.setItem('sms_theme', isDark ? 'dark' : 'light');
            updateThemeIcon(isDark);
        }

        function updateThemeIcon(isDark) {
            const icon = document.getElementById('themeIcon');
            if (icon) {
                if (isDark) {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                } else {
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                }
            }
        }

        // Initialize Theme from localStorage
        (function() {
            const savedTheme = localStorage.getItem('sms_theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-theme');
                updateThemeIcon(true);
            }
        })();

        // Auto-dismiss alerts
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
    </script>
    
    @stack('scripts')
</body>
</html>
