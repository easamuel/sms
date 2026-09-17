<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School Admin Portal - ES-SCHOOLS</title>
    
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
            /* Bright, Clean Light Theme Default */
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
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.3);
            --shadow-md: 0 4px 12px -2px rgba(0,0,0,0.4);
            --shadow-lg: 0 10px 25px -5px rgba(0,0,0,0.5);
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
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
            z-index: 100;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .sidebar-header {
            padding: 1.25rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
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

        .sidebar-menu {
            list-style: none;
            padding: 1rem 0.75rem;
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
            color: #ff9f43;
            background: rgba(255, 159, 67, 0.14);
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

        .menu-right {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .count-badge {
            background: #10b981;
            color: white;
            font-size: 0.65rem;
            padding: 0.15rem 0.45rem;
            border-radius: 4px;
            font-weight: 800;
        }

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: 255px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
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

        .home-btn {
            width: 38px;
            height: 38px;
            background: #f1f5f9;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        body.dark-theme .home-btn {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }

        .home-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .search-box {
            position: relative;
            width: 280px;
        }

        .search-box input {
            width: 100%;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 0.55rem 2.25rem 0.55rem 1rem;
            color: var(--text-main);
            font-size: 0.84rem;
            font-family: inherit;
            outline: none;
            transition: all 0.2s;
        }

        body.dark-theme .search-box input {
            background: rgba(255, 255, 255, 0.06);
            color: #ffffff;
        }

        .search-box input:focus {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(30,58,138,0.1);
        }

        .search-box i {
            position: absolute;
            right: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.85rem;
            pointer-events: none;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }

        .header-select-pill {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            padding: 0.45rem 0.875rem;
            border-radius: 8px;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text-main);
            cursor: pointer;
            transition: all 0.2s;
        }

        body.dark-theme .header-select-pill {
            background: rgba(255, 255, 255, 0.06);
            color: #ffffff;
        }

        .header-select-pill:hover {
            border-color: var(--primary);
        }

        .header-icon-btn {
            width: 38px;
            height: 38px;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
        }

        body.dark-theme .header-icon-btn {
            background: rgba(255, 255, 255, 0.06);
            color: #ffffff;
        }

        .header-icon-btn:hover {
            background: #f1f5f9;
            color: var(--primary);
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ef4444;
            color: white;
            font-size: 0.65rem;
            font-weight: 800;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--bg-header);
        }

        .profile-badge {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
            padding: 0.25rem 0.5rem;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .profile-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #1e3a8a, #10b981);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.9375rem;
            box-shadow: 0 2px 8px rgba(30,58,138,0.25);
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .profile-name {
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.2;
        }

        .profile-role {
            font-size: 0.6875rem;
            color: var(--text-muted);
        }

        /* Page Content Area */
        .page-content {
            padding: 1.75rem;
            flex: 1;
        }

        /* 4 Top Metric Cards (EXACT MATCH TO TEACHER & PARENT DASHBOARDS) */
        .metric-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .metric-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--shadow-sm);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .metric-icon-box {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
        }

        .icon-orange {
            background: rgba(255, 159, 67, 0.14);
            color: var(--accent-orange);
        }

        .icon-purple {
            background: rgba(165, 94, 234, 0.14);
            color: var(--accent-purple);
        }

        .icon-blue {
            background: rgba(75, 123, 236, 0.14);
            color: var(--accent-blue);
        }

        .icon-cyan {
            background: rgba(15, 188, 249, 0.14);
            color: var(--accent-cyan);
        }

        .icon-green {
            background: rgba(16, 185, 129, 0.14);
            color: var(--accent-green);
        }

        .metric-details {
            display: flex;
            flex-direction: column;
        }

        .metric-number {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.1;
            letter-spacing: -0.02em;
        }

        .metric-label {
            font-size: 0.8125rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-top: 0.25rem;
        }

        /* Financial Metric Row */
        .financial-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.75rem;
        }

        .fin-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-sm);
        }

        .fin-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.35rem;
        }

        .fin-amount {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .fin-sub {
            font-size: 0.6875rem;
            margin-top: 0.25rem;
            font-weight: 600;
        }

        /* Lower Grid (Recent Activities & Quick Actions) */
        .lower-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
        }

        .panel-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
        }

        .panel-header {
            padding: 1.125rem 1.5rem;
            background-color: var(--bg-card-header);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .panel-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .panel-body {
            padding: 1.25rem;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th, .data-table td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.84rem;
        }

        .data-table th {
            background: #f8fafc;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.75rem;
        }

        body.dark-theme .data-table th {
            background: rgba(255, 255, 255, 0.03);
        }

        .data-table tr:hover td {
            background: rgba(30, 58, 138, 0.02);
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.45rem 0.85rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            text-decoration: none;
            background: rgba(30, 58, 138, 0.08);
            color: var(--primary);
            border: 1px solid rgba(30, 58, 138, 0.15);
            transition: all 0.2s;
        }

        .btn-action:hover {
            background: var(--primary);
            color: white;
        }

        .quick-tiles-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.875rem;
            margin-bottom: 1.25rem;
        }

        .quick-tile {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.125rem 0.875rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
            color: var(--text-main);
            font-size: 0.8125rem;
            font-weight: 700;
            transition: all 0.2s;
        }

        body.dark-theme .quick-tile {
            background: rgba(255, 255, 255, 0.04);
            color: #ffffff;
        }

        .quick-tile:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30,58,138,0.2);
        }

        .quick-tile i {
            font-size: 1.35rem;
        }

        /* Mobile Toggle & Overlay */
        .mobile-toggle-btn {
            display: none;
            width: 38px;
            height: 38px;
            background: #f1f5f9;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.05rem;
            cursor: pointer;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        body.dark-theme .mobile-toggle-btn {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }

        .mobile-close-btn {
            display: none;
            width: 32px;
            height: 32px;
            background: #f1f5f9;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        body.dark-theme .mobile-close-btn {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }

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

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive > table {
            min-width: 520px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .metric-cards-grid, .financial-cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .lower-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                width: 280px;
                max-width: 82vw;
                z-index: 1050;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 0 25px rgba(0,0,0,0.25);
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                min-width: 0 !important;
            }
            .mobile-toggle-btn {
                display: flex !important;
            }
            .mobile-close-btn {
                display: flex !important;
            }
            .collapse-btn {
                display: none !important;
            }
            .search-box, .header-select-pill, #fullscreenBtn, .profile-info {
                display: none !important;
            }
            .top-header {
                padding: 0 1rem;
                height: 60px;
            }
            .page-content {
                padding: 1rem 0.85rem;
            }
            .metric-cards-grid, .financial-cards-grid, .lower-grid {
                grid-template-columns: 1fr !important;
                gap: 1rem;
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
                    <i class="fas fa-school"></i>
                </div>
                <div class="brand-text-wrap">
                    <span class="brand-title">ES-SCHOOLS</span>
                    <span class="brand-sub">Admin Portal</span>
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
                <a href="{{ route('school.dashboard') }}" class="menu-link active">
                    <div class="menu-left">
                        <i class="fas fa-tachometer-alt" style="color: #1e3a8a;"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.students.index') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-user-graduate" style="color: #ff9f43;"></i>
                        <span>Students</span>
                    </div>
                    <div class="menu-right">
                        <span class="count-badge">{{ $stats['total_students'] ?? 84 }}</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.staff.index') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-chalkboard-teacher" style="color: #4b7bec;"></i>
                        <span>Teachers &amp; Staff</span>
                    </div>
                    <div class="menu-right">
                        <span class="count-badge">{{ $stats['total_teachers'] ?? 14 }}</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.classes.index') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-layer-group" style="color: #a55eea;"></i>
                        <span>Classes &amp; Sections</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.subjects.index') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-book" style="color: #10b981;"></i>
                        <span>Subjects</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.attendance.index') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-user-check" style="color: #0fbcf9;"></i>
                        <span>Attendance</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.timetable.index') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="far fa-calendar-alt" style="color: #f59e0b;"></i>
                        <span>Routines &amp; Timetable</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.exams.index') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-laptop-code" style="color: #8b5cf6;"></i>
                        <span>Exams &amp; CBT</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.results.index') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-poll" style="color: #06b6d4;"></i>
                        <span>Results &amp; Grading</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.fees.index') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-money-bill-wave" style="color: #10b981;"></i>
                        <span>Fees &amp; Billing</span>
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
                <a href="{{ route('school.messages.index') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="far fa-comments" style="color: #3b82f6;"></i>
                        <span>Parent Messages</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.notices.index') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="far fa-bell" style="color: #f59e0b;"></i>
                        <span>Notice Board</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.payments.settings') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-cog" style="color: #64748b;"></i>
                        <span>App Settings</span>
                    </div>
                </a>
            </li>
            <li class="menu-item" style="margin-top: 1.5rem; border-top: 1px solid var(--border-color); padding-top: 0.5rem;">
                <form id="adminLogoutForm" method="POST" action="{{ route('sms.logout') }}" style="display: none;">
                    @csrf
                </form>
                <a href="javascript:void(0)" onclick="document.getElementById('adminLogoutForm').submit();" class="menu-link" style="color: #ef4444;">
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
                <a href="{{ route('home') }}" class="home-btn" title="Homepage">
                    <i class="fas fa-home"></i>
                </a>
                <div class="search-box">
                    <input type="text" placeholder="Search students, staff, classes...">
                    <i class="fas fa-search"></i>
                </div>
            </div>

            <div class="header-right">
                <div class="header-select-pill" title="Language">
                    <span style="font-size: 1rem;">🇳🇬</span>
                    <span>English</span>
                </div>

                <div class="header-select-pill" title="Academic Session">
                    <i class="far fa-calendar-check" style="color: #10b981;"></i>
                    <span>2026/2027</span>
                </div>

                <button class="header-icon-btn" id="themeToggleBtn" title="Toggle Dark/Light Mode">
                    <i class="far fa-moon" id="themeIcon"></i>
                </button>

                <button class="header-icon-btn" id="fullscreenBtn" title="Toggle Fullscreen">
                    <i class="fas fa-expand"></i>
                </button>

                <a href="{{ route('school.notices.index') }}" class="header-icon-btn" title="Announcements">
                    <i class="far fa-bell"></i>
                    <span class="notification-badge">5</span>
                </a>

                <div class="profile-badge">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(session('sms_user')->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="profile-info">
                        <span class="profile-name">{{ session('sms_user')->name ?? 'Super Admin' }}</span>
                        <span class="profile-role">School Administrator</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Main Content -->
        <main class="page-content">

            <!-- 4 Top Metric Cards (EXACT MATCH TO TEACHER DASHBOARD) -->
            <div class="metric-cards-grid">
                
                <!-- Card 1: Students -->
                <div class="metric-card">
                    <div class="metric-icon-box icon-orange">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="metric-details">
                        <div class="metric-number">{{ $stats['total_students'] ?? 84 }}</div>
                        <div class="metric-label">Enrolled Students</div>
                    </div>
                </div>

                <!-- Card 2: Parents -->
                <div class="metric-card">
                    <div class="metric-icon-box icon-purple">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <div class="metric-details">
                        <div class="metric-number">{{ $stats['total_parents'] ?? 10 }}</div>
                        <div class="metric-label">Registered Parents</div>
                    </div>
                </div>

                <!-- Card 3: Teachers -->
                <div class="metric-card">
                    <div class="metric-icon-box icon-blue">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="metric-details">
                        <div class="metric-number">{{ $stats['total_teachers'] ?? 14 }}</div>
                        <div class="metric-label">Teaching Staff</div>
                    </div>
                </div>

                <!-- Card 4: Sessions -->
                <div class="metric-card">
                    <div class="metric-icon-box icon-cyan">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="metric-details">
                        <div class="metric-number">{{ $stats['total_sessions'] ?? 3 }}</div>
                        <div class="metric-label">Academic Sessions</div>
                    </div>
                </div>

            </div>

            <!-- Financial Metrics Grid -->
            <div class="financial-cards-grid">
                <div class="fin-card">
                    <div class="fin-label">Fees Collection ({{ date('Y') }})</div>
                    <div class="fin-amount" style="color: #10b981;">₦{{ number_format($stats['fees_collected'] ?? 1450000, 2) }}</div>
                    <div class="fin-sub" style="color: #059669;"><i class="fas fa-arrow-up"></i> +18.4% vs last term</div>
                </div>

                <div class="fin-card">
                    <div class="fin-label">This Month Collections</div>
                    <div class="fin-amount" style="color: #3b82f6;">₦{{ number_format($feesCollectedThisMonth ?? 406000, 2) }}</div>
                    <div class="fin-sub" style="color: #2563eb;"><i class="fas fa-check-circle"></i> On-track</div>
                </div>

                <div class="fin-card">
                    <div class="fin-label">Total School Revenue</div>
                    <div class="fin-amount" style="color: #6366f1;">₦{{ number_format($stats['revenue'] ?? 1450000, 2) }}</div>
                    <div class="fin-sub" style="color: #4f46e5;">Term 1 Total</div>
                </div>

                <div class="fin-card">
                    <div class="fin-label">Net Operational Balance</div>
                    <div class="fin-amount" style="color: #059669;">₦{{ number_format($balance ?? 899000, 2) }}</div>
                    <div class="fin-sub" style="color: #15803d;"><i class="fas fa-shield-alt"></i> Healthy Reserve</div>
                </div>
            </div>

            <!-- Lower Grid (Recent Enrollments & Quick Actions / Notices) -->
            <div class="lower-grid">
                
                <!-- Left: Recent Enrollments Table -->
                <div class="panel-card">
                    <div class="panel-header">
                        <div class="panel-title">
                            <i class="fas fa-users" style="color: #1e3a8a;"></i>
                            <span>Recent Student Enrollments</span>
                        </div>
                        <a href="{{ route('school.students.index') }}" class="btn-action">
                            View All Students <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="panel-body" style="padding: 0;">
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Student ID</th>
                                        <th>Class</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentActivities as $student)
                                    <tr>
                                        <td><strong>{{ $student->name }}</strong></td>
                                        <td><span style="background: #f1f5f9; padding: 0.2rem 0.5rem; border-radius: 4px; font-weight: 700; font-size: 0.75rem;">{{ $student->student_id }}</span></td>
                                        <td>{{ $student->class ?? 'Basic 1' }}</td>
                                        <td><span style="background: #dcfce7; color: #15803d; padding: 0.2rem 0.55rem; border-radius: 4px; font-size: 0.72rem; font-weight: 700;">Active</span></td>
                                        <td>
                                            <a href="{{ route('school.students.show', $student->id) }}" class="btn-action">
                                                Profile
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td><strong>Adebayo Oluwaseun</strong></td>
                                        <td><span style="background: #f1f5f9; padding: 0.2rem 0.5rem; border-radius: 4px; font-weight: 700; font-size: 0.75rem;">STU-00001</span></td>
                                        <td>SSS 2 Science</td>
                                        <td><span style="background: #dcfce7; color: #15803d; padding: 0.2rem 0.55rem; border-radius: 4px; font-size: 0.72rem; font-weight: 700;">Active</span></td>
                                        <td><a href="{{ route('school.students.index') }}" class="btn-action">Profile</a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Chukwu Obi</strong></td>
                                        <td><span style="background: #f1f5f9; padding: 0.2rem 0.5rem; border-radius: 4px; font-weight: 700; font-size: 0.75rem;">STU-00033</span></td>
                                        <td>Basic 3</td>
                                        <td><span style="background: #dcfce7; color: #15803d; padding: 0.2rem 0.55rem; border-radius: 4px; font-size: 0.72rem; font-weight: 700;">Active</span></td>
                                        <td><a href="{{ route('school.students.index') }}" class="btn-action">Profile</a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Fatima Mohammed</strong></td>
                                        <td><span style="background: #f1f5f9; padding: 0.2rem 0.5rem; border-radius: 4px; font-weight: 700; font-size: 0.75rem;">STU-00055</span></td>
                                        <td>JSS 1</td>
                                        <td><span style="background: #dcfce7; color: #15803d; padding: 0.2rem 0.55rem; border-radius: 4px; font-size: 0.72rem; font-weight: 700;">Active</span></td>
                                        <td><a href="{{ route('school.students.index') }}" class="btn-action">Profile</a></td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right: Quick Actions & Notices -->
                <div>
                    <!-- Quick Actions -->
                    <div class="panel-card">
                        <div class="panel-header">
                            <div class="panel-title">
                                <i class="fas fa-bolt" style="color: #f59e0b;"></i>
                                <span>Administrative Actions</span>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="quick-tiles-grid">
                                <a href="{{ route('school.students.create') }}" class="quick-tile">
                                    <i class="fas fa-user-plus" style="color: #10b981;"></i>
                                    <span>Enroll Student</span>
                                </a>
                                <a href="{{ route('school.staff.create') }}" class="quick-tile">
                                    <i class="fas fa-chalkboard-teacher" style="color: #3b82f6;"></i>
                                    <span>Add Teacher</span>
                                </a>
                                <a href="{{ route('school.fees.index') }}" class="quick-tile">
                                    <i class="fas fa-receipt" style="color: #ff9f43;"></i>
                                    <span>Record Fee</span>
                                </a>
                                <a href="{{ route('school.notices.index') }}" class="quick-tile">
                                    <i class="fas fa-bullhorn" style="color: #8b5cf6;"></i>
                                    <span>Send Notice</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Events & Notices -->
                    <div class="panel-card">
                        <div class="panel-header">
                            <div class="panel-title">
                                <i class="far fa-calendar-check" style="color: #10b981;"></i>
                                <span>Upcoming School Events</span>
                            </div>
                        </div>
                        <div class="panel-body">
                            @forelse($upcomingEvents as $event)
                            <div style="padding: 0.75rem; background: var(--border-subtle); border-radius: 8px; margin-bottom: 0.75rem; font-size: 0.8125rem;">
                                <strong style="color: var(--primary); display: block; margin-bottom: 0.2rem;">{{ $event->title }}</strong>
                                <span style="color: var(--text-muted); font-size: 0.75rem;">{{ $event->description }}</span>
                                <div style="font-size: 0.6875rem; color: #94a3b8; margin-top: 0.35rem;">{{ $event->date }}</div>
                            </div>
                            @empty
                            <div style="padding: 0.75rem; background: var(--border-subtle); border-radius: 8px; margin-bottom: 0.75rem; font-size: 0.8125rem;">
                                <strong style="color: var(--primary); display: block; margin-bottom: 0.2rem;">First Term Continuous Assessment (CA1)</strong>
                                <span style="color: var(--text-muted); font-size: 0.75rem;">Examination portal goes live for all registered students.</span>
                                <div style="font-size: 0.6875rem; color: #94a3b8; margin-top: 0.35rem;">Sep 21, 2026</div>
                            </div>
                            <div style="padding: 0.75rem; background: var(--border-subtle); border-radius: 8px; font-size: 0.8125rem;">
                                <strong style="color: #10b981; display: block; margin-bottom: 0.2rem;">General PTA Meeting &amp; Termly Briefing</strong>
                                <span style="color: var(--text-muted); font-size: 0.75rem;">Interactive parent-teacher discussion in the main auditorium.</span>
                                <div style="font-size: 0.6875rem; color: #94a3b8; margin-top: 0.35rem;">Sep 26, 2026</div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <!-- Theme & Fullscreen Scripts -->
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

        // Fullscreen Toggle
        const fullBtn = document.getElementById('fullscreenBtn');
        if (fullBtn) {
            fullBtn.addEventListener('click', () => {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen().catch(() => {});
                } else {
                    document.exitFullscreen().catch(() => {});
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
    </script>
</body>
</html>
