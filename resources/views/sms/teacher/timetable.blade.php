<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teaching Routine &amp; Timetable - ES-SCHOOLS</title>
    
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
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.2);
            --shadow-md: 0 4px 12px -2px rgba(0,0,0,0.3);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            transition: background-color 0.3s, color 0.3s;
            max-width: 100vw;
            overflow-x: hidden !important;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 255px;
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, width 0.3s ease;
        }

        .sidebar.collapsed {
            width: 78px;
        }

        .sidebar.collapsed .brand-text-wrap,
        .sidebar.collapsed .menu-link span,
        .sidebar.collapsed .menu-right,
        .sidebar.collapsed .pro-badge {
            display: none !important;
        }

        .sidebar.collapsed .menu-link {
            justify-content: center;
            padding: 0.85rem 0;
        }

        .sidebar-header {
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.25rem;
            border-bottom: 1px solid var(--border-color);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--text-main);
        }

        .grad-cap {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.15rem;
            box-shadow: 0 4px 10px rgba(30, 58, 138, 0.25);
            flex-shrink: 0;
        }

        .brand-text-wrap {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--text-main);
            line-height: 1.1;
        }

        .brand-sub {
            font-size: 0.65rem;
            color: var(--accent-orange);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 1px;
        }

        .collapse-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1.1rem;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .collapse-btn:hover {
            background: rgba(30, 58, 138, 0.08);
            color: var(--primary);
        }

        .mobile-close-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        .sidebar-menu {
            list-style: none;
            padding: 1.25rem 0.875rem;
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
            padding: 0.75rem 0.875rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .menu-link:hover {
            background: rgba(30, 58, 138, 0.05);
            color: var(--primary);
        }

        body.dark-theme .menu-link:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #ffffff;
        }

        .menu-link.active {
            color: var(--primary);
            background: rgba(30, 58, 138, 0.09);
            font-weight: 700;
        }

        body.dark-theme .menu-link.active {
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

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: 255px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
            max-width: 100vw;
            overflow-x: hidden !important;
        }

        .sidebar.collapsed ~ .main-wrapper {
            margin-left: 78px;
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
            z-index: 90;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .mobile-toggle-btn {
            display: none;
            background: none;
            border: none;
            color: var(--text-main);
            font-size: 1.25rem;
            cursor: pointer;
        }

        .home-btn {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            background: rgba(30, 58, 138, 0.06);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .home-btn:hover {
            background: var(--primary);
            color: white;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .header-select-pill {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 0.85rem;
            border-radius: 20px;
            background-color: var(--bg-body);
            border: 1px solid var(--border-color);
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text-main);
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
            font-size: 1rem;
            transition: all 0.2s;
        }

        .header-icon-btn:hover {
            background-color: var(--bg-body);
            border-color: var(--primary);
            color: var(--primary);
        }

        .profile-pill {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.35rem 0.75rem 0.35rem 0.35rem;
            border-radius: 30px;
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            text-decoration: none;
            color: var(--text-main);
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff9f43 0%, #ff5252 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
        }

        .profile-name {
            font-size: 0.84rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .profile-role {
            font-size: 0.6875rem;
            color: var(--text-muted);
        }

        /* Main Content Container */
        .content-container {
            padding: 1.75rem;
            flex: 1;
            max-width: 100vw;
            overflow-x: hidden !important;
        }

        .page-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .page-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
            margin-bottom: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .page-subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
            line-height: 1.4;
        }

        .action-btns-group {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.55rem 1rem;
            border-radius: 8px;
            font-size: 0.8125rem;
            font-weight: 700;
            text-decoration: none;
            background: rgba(30, 58, 138, 0.08);
            color: var(--primary);
            border: 1px solid rgba(30, 58, 138, 0.15);
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-action:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            color: white;
        }

        /* Stats Summary Row */
        .routine-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.75rem;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 1.15rem 1.25rem;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .stat-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin-bottom: 0.2rem;
        }

        .stat-val {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.1;
        }

        /* Day Filter Tabs */
        .day-tabs-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 0.5rem;
            margin-bottom: 1.5rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .day-tab-btn {
            border: none;
            background: none;
            padding: 0.6rem 1.1rem;
            border-radius: 8px;
            font-size: 0.84rem;
            font-weight: 700;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .day-tab-btn:hover {
            color: var(--primary);
            background: rgba(30, 58, 138, 0.05);
        }

        .day-tab-btn.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 2px 8px rgba(30, 58, 138, 0.25);
        }

        /* Day Schedule Cards */
        .day-schedule-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
        }

        .day-schedule-header {
            padding: 1rem 1.25rem;
            background: var(--bg-card-header);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .day-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .day-count-badge {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            background: rgba(30, 58, 138, 0.08);
            color: var(--primary);
        }

        /* Routine Slots Table & Grid */
        .routine-table {
            width: 100%;
            border-collapse: collapse;
        }

        .routine-table th, .routine-table td {
            padding: 0.9rem 1.25rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.86rem;
        }

        .routine-table th {
            background: #f8fafc;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.75rem;
        }

        body.dark-theme .routine-table th {
            background: rgba(255, 255, 255, 0.03);
        }

        .routine-table tr:hover td {
            background: rgba(30, 58, 138, 0.02);
        }

        body.dark-theme .routine-table tr:hover td {
            background: rgba(255, 255, 255, 0.03);
        }

        .time-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.65rem;
            border-radius: 8px;
            background: rgba(59, 130, 246, 0.08);
            color: #3b82f6;
            font-weight: 700;
            font-size: 0.78rem;
        }

        .subject-tag {
            font-size: 0.92rem;
            font-weight: 800;
            color: var(--text-main);
            display: block;
        }

        .class-pill {
            display: inline-block;
            font-size: 0.74rem;
            font-weight: 700;
            padding: 0.2rem 0.55rem;
            border-radius: 6px;
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            margin-top: 0.25rem;
        }

        .period-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            font-weight: 800;
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        /* Mobile Schedule Cards */
        .mobile-routine-card {
            display: none;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .mobile-routine-card:last-child {
            border-bottom: none;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 95;
        }

        .sidebar-overlay.active {
            display: block;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0 !important;
            }

            .mobile-toggle-btn {
                display: block;
            }

            .mobile-close-btn {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .content-container {
                padding: 1rem;
            }

            .top-header {
                padding: 0 1rem;
            }

            .routine-table-wrap {
                display: none;
            }

            .mobile-routine-card {
                display: block;
            }

            .page-title {
                font-size: 1.25rem;
            }
        }

        @media print {
            .sidebar, .top-header, .btn-action, .day-tabs-container, .mobile-toggle-btn {
                display: none !important;
            }
            .main-wrapper {
                margin-left: 0 !important;
            }
            .content-container {
                padding: 0 !important;
            }
            body {
                background: white !important;
                color: black !important;
            }
        }
    </style>
</head>
<body>

    <!-- Left Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('home') }}" class="brand-logo" title="Back to Homepage">
                <div class="grad-cap">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="brand-text-wrap">
                    <span class="brand-title">ES-SCHOOLS</span>
                    <span class="brand-sub">Teacher Portal</span>
                </div>
            </a>
            <button class="collapse-btn" id="collapseSidebarBtn" title="Toggle Sidebar">
                <i class="fas fa-angle-left"></i>
            </button>
            <button class="mobile-close-btn" id="closeSidebarMobile" title="Close Menu">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="{{ route('sms.teacher.dashboard') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-tachometer-alt" style="color: #1e3a8a;"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.timetable') }}" class="menu-link active">
                    <div class="menu-left">
                        <i class="far fa-calendar-alt" style="color: #3b82f6;"></i>
                        <span>Routines</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.attendance') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-user-check" style="color: #10b981;"></i>
                        <span>Attendance</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.exams') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-graduation-cap" style="color: #8b5cf6;"></i>
                        <span>Examination</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.exams.create') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-laptop-code" style="color: #06b6d4;"></i>
                        <span>Online Exam (CBT)</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.practice-sessions') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-book-reader" style="color: #ec4899;"></i>
                        <span>Study Materials</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.assignments') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-tasks" style="color: #f97316;"></i>
                        <span>Assignments</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.results-entry.index') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="far fa-file-alt" style="color: #10b981;"></i>
                        <span>Enter Results</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.results') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-poll" style="color: #6366f1;"></i>
                        <span>Report Cards</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.question-bank') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-database" style="color: #0ea5e9;"></i>
                        <span>Question Bank</span>
                    </div>
                </a>
            </li>
            <li class="menu-item" style="margin-top: 1.5rem; border-top: 1px solid var(--border-color); padding-top: 0.5rem;">
                <form id="teacherLogoutForm" method="POST" action="{{ route('sms.logout') }}" style="display: none;">
                    @csrf
                </form>
                <a href="javascript:void(0)" onclick="document.getElementById('teacherLogoutForm').submit();" class="menu-link" style="color: #ef4444;">
                    <div class="menu-left">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </div>
                </a>
            </li>
        </ul>
    </aside>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content Area -->
    <div class="main-wrapper">
        
        <!-- Top Navbar -->
        <header class="top-header">
            <div class="header-left">
                <button class="mobile-toggle-btn" id="mobileSidebarToggle" title="Open Menu">
                    <i class="fas fa-bars"></i>
                </button>
                <a href="{{ route('sms.teacher.dashboard') }}" class="home-btn" title="Dashboard Home">
                    <i class="fas fa-home"></i>
                </a>
                <div style="font-size: 0.88rem; font-weight: 700; color: var(--text-muted);">
                    <a href="{{ route('sms.teacher.dashboard') }}" style="color: var(--text-muted); text-decoration: none;">Dashboard</a>
                    <span style="margin: 0 0.35rem;">/</span>
                    <span style="color: var(--primary);">Routines</span>
                </div>
            </div>

            <div class="header-right">
                <div class="header-select-pill" title="Academic Session">
                    <i class="far fa-calendar-check" style="color: #10b981;"></i>
                    <span>{{ $currentYear ?? '2026/2027' }}</span>
                </div>

                <button class="header-icon-btn" id="themeToggleBtn" title="Toggle Light/Dark Theme">
                    <i class="far fa-moon" id="themeIcon"></i>
                </button>

                <div class="profile-pill">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($teacher->user->first_name ?? ($teacher->user->name ?? 'T'), 0, 1)) }}
                    </div>
                    <div class="brand-text-wrap" style="text-align: left;">
                        <span class="profile-name">{{ $teacher->user->full_name ?? ($teacher->user->name ?? 'Demo Teacher') }}</span>
                        <span class="profile-role">{{ $teacher->specialization ?? 'Faculty Tutor' }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="content-container">
            
            <!-- Page Header -->
            <div class="page-header-row">
                <div>
                    <h1 class="page-title">
                        <i class="far fa-calendar-alt" style="color: #3b82f6;"></i>
                        <span>Teaching Routine &amp; Schedule</span>
                    </h1>
                    <p class="page-subtitle">
                        Weekly lecture periods, classroom allocations, and instructional schedule for {{ $currentYear ?? '2026/2027' }} ({{ $currentTerm ?? 'First Term' }}).
                    </p>
                </div>
                <div class="action-btns-group">
                    <button class="btn-action" onclick="window.print();" title="Print Routine">
                        <i class="fas fa-print"></i> Print Schedule
                    </button>
                    <a href="{{ route('sms.teacher.attendance') }}" class="btn-action btn-primary" title="Roll Call">
                        <i class="fas fa-clipboard-check"></i> Roll Call
                    </a>
                </div>
            </div>

            <!-- Stats Overview Cards -->
            <div class="routine-stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(59, 130, 246, 0.12); color: #3b82f6;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="stat-title">Weekly Periods</div>
                        <div class="stat-val">{{ $timetables->count() }} Periods</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    <div>
                        <div class="stat-title">Active Days</div>
                        <div class="stat-val">{{ count($timetableByDay) > 0 ? count($timetableByDay) : 5 }} Days / Wk</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(255, 159, 67, 0.12); color: #ff9f43;">
                        <i class="fas fa-chalkboard"></i>
                    </div>
                    <div>
                        <div class="stat-title">Current Term</div>
                        <div class="stat-val">{{ $currentTerm ?? 'First Term' }}</div>
                    </div>
                </div>
            </div>

            <!-- Day Selector Tabs -->
            @php
                $weekDays = [
                    'monday' => 'Monday',
                    'tuesday' => 'Tuesday',
                    'wednesday' => 'Wednesday',
                    'thursday' => 'Thursday',
                    'friday' => 'Friday',
                ];
            @endphp

            <div class="day-tabs-container">
                <button class="day-tab-btn active" data-day="all" onclick="filterDayRoutines('all', this)">
                    <i class="fas fa-layer-group" style="margin-right: 4px;"></i> All Days
                </button>
                @foreach($weekDays as $key => $dayLabel)
                @php
                    $dayCount = isset($timetableByDay[$key]) ? $timetableByDay[$key]->count() : 0;
                @endphp
                <button class="day-tab-btn" data-day="{{ $key }}" onclick="filterDayRoutines('{{ $key }}', this)">
                    {{ $dayLabel }} ({{ $dayCount }})
                </button>
                @endforeach
            </div>

            <!-- Day-by-Day Routine Cards -->
            @foreach($weekDays as $dayKey => $dayLabel)
            @php
                $daySlots = $timetableByDay[$dayKey] ?? collect();
            @endphp
            <div class="day-schedule-card day-section-item" id="day-section-{{ $dayKey }}">
                <div class="day-schedule-header">
                    <div class="day-title">
                        <i class="far fa-calendar-day" style="color: var(--primary);"></i>
                        <span>{{ $dayLabel }}</span>
                    </div>
                    <span class="day-count-badge">
                        {{ $daySlots->count() }} {{ \Illuminate\Support\Str::plural('Class', $daySlots->count()) }}
                    </span>
                </div>

                @if($daySlots->isEmpty())
                <div style="padding: 2rem; text-align: center; color: var(--text-muted);">
                    <i class="far fa-calendar-times" style="font-size: 2rem; margin-bottom: 0.5rem; display: block; opacity: 0.4;"></i>
                    <p style="font-size: 0.88rem; font-weight: 600;">No lectures scheduled for {{ $dayLabel }}.</p>
                    <span style="font-size: 0.78rem;">Free period for lesson planning, grading, or department consultations.</span>
                </div>
                @else
                <!-- Desktop Table View -->
                <div class="routine-table-wrap">
                    <table class="routine-table">
                        <thead>
                            <tr>
                                <th style="width: 70px;">Period</th>
                                <th style="width: 170px;">Time Slot</th>
                                <th>Subject</th>
                                <th>Class &amp; Section</th>
                                <th style="width: 130px; text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daySlots as $idx => $slot)
                            @php
                                $startTimeStr = is_a($slot->start_time, \Carbon\Carbon::class) 
                                    ? $slot->start_time->format('h:i A') 
                                    : date('h:i A', strtotime($slot->start_time ?? '08:00'));
                                $endTimeStr = is_a($slot->end_time, \Carbon\Carbon::class) 
                                    ? $slot->end_time->format('h:i A') 
                                    : date('h:i A', strtotime($slot->end_time ?? '09:20'));
                            @endphp
                            <tr>
                                <td>
                                    <span class="period-pill">{{ $slot->period_number ?? ($idx + 1) }}</span>
                                </td>
                                <td>
                                    <span class="time-badge">
                                        <i class="far fa-clock"></i> {{ $startTimeStr }} - {{ $endTimeStr }}
                                    </span>
                                </td>
                                <td>
                                    <span class="subject-tag">{{ $slot->subject->name ?? 'Mathematics' }}</span>
                                    <span style="font-size: 0.75rem; color: var(--text-muted);">Code: {{ $slot->subject->code ?? 'MTH101' }}</span>
                                </td>
                                <td>
                                    <strong style="color: var(--text-main);">{{ $slot->class->name ?? 'JSS 2' }}</strong>
                                    @if($slot->class && $slot->class->section)
                                        <span class="class-pill">Sec {{ $slot->class->section }}</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <a href="{{ route('sms.teacher.attendance') }}" class="btn-action" title="Take Roll Call">
                                        <i class="fas fa-check"></i> Roll Call
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                @foreach($daySlots as $idx => $slot)
                @php
                    $mStartTime = is_a($slot->start_time, \Carbon\Carbon::class) 
                        ? $slot->start_time->format('h:i A') 
                        : date('h:i A', strtotime($slot->start_time ?? '08:00'));
                    $mEndTime = is_a($slot->end_time, \Carbon\Carbon::class) 
                        ? $slot->end_time->format('h:i A') 
                        : date('h:i A', strtotime($slot->end_time ?? '09:20'));
                @endphp
                <div class="mobile-routine-card">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.4rem;">
                        <span class="time-badge">
                            <i class="far fa-clock"></i> {{ $mStartTime }} - {{ $mEndTime }}
                        </span>
                        <span class="period-pill">P{{ $slot->period_number ?? ($idx + 1) }}</span>
                    </div>
                    <h4 style="font-size: 0.95rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.2rem;">
                        {{ $slot->subject->name ?? 'Mathematics' }}
                    </h4>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                        <div>
                            <span class="class-pill">{{ $slot->class->name ?? 'JSS 2' }}{{ $slot->class && $slot->class->section ? ' (' . $slot->class->section . ')' : '' }}</span>
                        </div>
                        <a href="{{ route('sms.teacher.attendance') }}" class="btn-action" style="padding: 0.35rem 0.65rem; font-size: 0.75rem;">
                            <i class="fas fa-check"></i> Roll Call
                        </a>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            @endforeach

        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Theme Toggle (Dark/Light)
        const themeBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeIcon');
        
        if (themeBtn) {
            themeBtn.addEventListener('click', () => {
                document.body.classList.toggle('dark-theme');
                const isDark = document.body.classList.contains('dark-theme');
                if (themeIcon) {
                    themeIcon.className = isDark ? 'far fa-sun' : 'far fa-moon';
                }
            });
        }

        // Sidebar Collapse (Desktop)
        const collapseBtn = document.getElementById('collapseSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        if (collapseBtn && sidebar) {
            collapseBtn.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
            });
        }

        // Mobile Sidebar Drawer
        const mobileToggle = document.getElementById('mobileSidebarToggle');
        const mobileClose = document.getElementById('closeSidebarMobile');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function openMobileSidebar() {
            if (sidebar) sidebar.classList.add('mobile-open');
            if (sidebarOverlay) sidebarOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileSidebar() {
            if (sidebar) sidebar.classList.remove('mobile-open');
            if (sidebarOverlay) sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (mobileToggle) mobileToggle.addEventListener('click', openMobileSidebar);
        if (mobileClose) mobileClose.addEventListener('click', closeMobileSidebar);
        if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeMobileSidebar);

        // Filter Day Routines Tab
        function filterDayRoutines(day, btnElem) {
            document.querySelectorAll('.day-tab-btn').forEach(b => b.classList.remove('active'));
            if (btnElem) btnElem.classList.add('active');

            const sections = document.querySelectorAll('.day-section-item');
            sections.forEach(sec => {
                if (day === 'all') {
                    sec.style.display = 'block';
                } else {
                    if (sec.id === 'day-section-' + day) {
                        sec.style.display = 'block';
                    } else {
                        sec.style.display = 'none';
                    }
                }
            });
        }
    </script>
</body>
</html>
