<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher Dashboard - ONEST SCHOOL</title>
    
    <!-- Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-body: #16171d;
            --bg-sidebar: #121318;
            --bg-header: #1a1b22;
            --bg-card: #20222a;
            --bg-card-header: #272933;
            --border-color: #2c2e39;
            --text-main: #ffffff;
            --text-muted: #9aa0ac;
            --accent-orange: #ff9f43;
            --accent-purple: #a55eea;
            --accent-blue: #4b7bec;
            --accent-cyan: #0fbcf9;
            --accent-green: #10b981;
            --accent-red: #ef4444;
        }

        body.light-theme {
            --bg-body: #f4f6fb;
            --bg-sidebar: #ffffff;
            --bg-header: #ffffff;
            --bg-card: #ffffff;
            --bg-card-header: #f8fafc;
            --border-color: #e5e7eb;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
            transition: background-color 0.3s ease;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
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
            gap: 0.5rem;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.125rem;
            color: #ffffff;
            letter-spacing: -0.02em;
        }

        .brand-logo .grad-cap {
            background: linear-gradient(135deg, #ff9f43, #ff6b6b);
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        .brand-logo span.white {
            color: #ffffff;
        }

        .brand-logo span.highlight {
            color: #ff9f43;
        }

        .collapse-btn {
            color: #ff6b6b;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 700;
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
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .menu-link:hover, .menu-link.active {
            background: rgba(255, 255, 255, 0.06);
            color: #ffffff;
        }

        .menu-link.active {
            color: #ff9f43;
            background: rgba(255, 159, 67, 0.12);
            font-weight: 600;
        }

        .menu-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .menu-left i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        .menu-right {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .pro-badge {
            background: #ff7675;
            color: white;
            font-size: 0.65rem;
            padding: 0.15rem 0.4rem;
            border-radius: 4px;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: 250px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
        }

        /* Top Header */
        .top-header {
            height: 65px;
            background-color: var(--bg-header);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .home-btn {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .home-btn:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .search-box {
            position: relative;
            width: 260px;
        }

        .search-box input {
            width: 100%;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.5rem 2.25rem 0.5rem 1rem;
            color: #ffffff;
            font-size: 0.8125rem;
            outline: none;
            transition: all 0.2s;
        }

        .search-box input:focus {
            border-color: var(--accent-orange);
            background: rgba(255, 255, 255, 0.1);
        }

        .search-box i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .header-select-pill {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border-color);
            padding: 0.4rem 0.75rem;
            border-radius: 8px;
            font-size: 0.8125rem;
            color: #ffffff;
            cursor: pointer;
        }

        .flag-icon {
            font-size: 1rem;
        }

        .header-icon-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1.05rem;
            position: relative;
            transition: color 0.2s;
        }

        .header-icon-btn:hover {
            color: #ffffff;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -6px;
            background: #ff4757;
            color: white;
            font-size: 0.6rem;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-badge {
            width: 38px;
            height: 38px;
            background: #6c5ce7;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.875rem;
            cursor: pointer;
        }

        /* Content Container */
        .page-content {
            padding: 1.75rem 1.5rem 3rem;
            flex: 1;
        }

        /* Top 4 Metric Cards Grid */
        .metric-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.75rem;
        }

        .metric-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s, border-color 0.2s;
        }

        .metric-card:hover {
            transform: translateY(-3px);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .metric-icon-box {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .icon-orange {
            background: linear-gradient(135deg, #ff9f43, #ff793f);
        }

        .icon-purple {
            background: linear-gradient(135deg, #a55eea, #8854d0);
        }

        .icon-blue {
            background: linear-gradient(135deg, #4b7bec, #3867d6);
        }

        .icon-cyan {
            background: linear-gradient(135deg, #0fbcf9, #00d2d3);
        }

        .metric-details {
            display: flex;
            flex-direction: column;
        }

        .metric-number {
            font-family: 'Poppins', sans-serif;
            font-size: 2.25rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.1;
            margin-bottom: 0.25rem;
        }

        .metric-label {
            font-size: 1.1rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Calendar Section Card */
        .calendar-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            margin-bottom: 2rem;
        }

        .calendar-header {
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-card-header);
        }

        .cal-nav-group {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .cal-btn {
            background: #2b2e38;
            border: 1px solid var(--border-color);
            color: #ffffff;
            padding: 0.45rem 0.85rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8125rem;
            font-weight: 600;
            transition: background 0.2s;
        }

        .cal-btn:hover {
            background: #363a47;
        }

        .cal-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
        }

        .cal-view-group {
            display: flex;
            align-items: center;
            background: #1b1c23;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 0.2rem;
        }

        .cal-view-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            padding: 0.4rem 0.85rem;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .cal-view-btn.active {
            background: #272a34;
            color: #ffffff;
        }

        /* Calendar Grid */
        .calendar-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .calendar-grid th {
            width: 14.285%;
            padding: 0.85rem 0.5rem;
            text-align: center;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            border: 1px solid var(--border-color);
            background: rgba(0, 0, 0, 0.1);
        }

        .calendar-grid td {
            height: 100px;
            vertical-align: top;
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            position: relative;
            background: var(--bg-card);
            transition: background 0.15s;
        }

        .calendar-grid td:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .calendar-grid td.other-month {
            opacity: 0.35;
        }

        .calendar-grid td.is-today {
            background: rgba(255, 159, 67, 0.05);
            border-color: rgba(255, 159, 67, 0.4);
        }

        .day-num {
            display: inline-block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.35rem;
        }

        .is-today .day-num {
            color: #ff9f43;
            background: rgba(255, 159, 67, 0.2);
            padding: 2px 6px;
            border-radius: 4px;
        }

        .cal-events {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .cal-event-pill {
            font-size: 0.6875rem;
            font-weight: 600;
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
            transition: transform 0.15s;
        }

        .cal-event-pill:hover {
            transform: scale(1.02);
        }

        .event-blue {
            background: rgba(75, 123, 236, 0.2);
            border-left: 3px solid #4b7bec;
            color: #a5b4fc;
        }

        .event-green {
            background: rgba(16, 185, 129, 0.2);
            border-left: 3px solid #10b981;
            color: #6ee7b7;
        }

        .event-orange {
            background: rgba(255, 159, 67, 0.2);
            border-left: 3px solid #ff9f43;
            color: #fcd34d;
        }

        .event-purple {
            background: rgba(165, 94, 234, 0.2);
            border-left: 3px solid #a55eea;
            color: #d8b4fe;
        }

        /* Lower Details Grid (Routines, Quick Actions, Notices) */
        .lower-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.25rem;
        }

        .panel-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .panel-header {
            padding: 1.125rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-card-header);
        }

        .panel-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .panel-body {
            padding: 1.25rem 1.5rem;
        }

        /* Table */
        .routine-table {
            width: 100%;
            border-collapse: collapse;
        }

        .routine-table th {
            text-align: left;
            padding: 0.75rem 0.85rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }

        .routine-table td {
            padding: 0.85rem;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.85rem;
            color: #ffffff;
        }

        .routine-table tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-live {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.4rem 0.75rem;
            background: #2b2e38;
            color: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.775rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-action:hover {
            background: #ff9f43;
            color: #ffffff;
            border-color: #ff9f43;
        }

        /* Quick Action Tiles */
        .quick-tiles-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .quick-tile {
            background: #272933;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 0.5rem;
            text-decoration: none;
            color: #ffffff;
            transition: all 0.2s;
        }

        .quick-tile:hover {
            background: rgba(255, 159, 67, 0.15);
            border-color: #ff9f43;
            transform: translateY(-2px);
        }

        .quick-tile i {
            font-size: 1.5rem;
            color: #ff9f43;
        }

        .quick-tile span {
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .metric-cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .lower-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
            }
            .metric-cards-grid {
                grid-template-columns: 1fr;
            }
            .search-box {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- Left Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('home') }}" class="brand-logo">
                <div class="grad-cap">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <span class="white">ONEST</span><span class="highlight">SCHOOL</span>
                </div>
            </a>
            <button class="collapse-btn" id="collapseSidebarBtn" title="Toggle Sidebar">
                <i class="fas fa-angle-double-left"></i>
            </button>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="{{ route('sms.teacher.dashboard') }}" class="menu-link active">
                    <div class="menu-left">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.timetable') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="far fa-calendar-alt"></i>
                        <span>Routines</span>
                    </div>
                    <div class="menu-right">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.attendance') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-calendar-plus"></i>
                        <span>Attendance</span>
                    </div>
                    <div class="menu-right">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link" onclick="alert('Leave management module'); return false;">
                    <div class="menu-left">
                        <i class="far fa-clock"></i>
                        <span>Leave</span>
                    </div>
                    <div class="menu-right">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.exams') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Examination</span>
                    </div>
                    <div class="menu-right">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.exams') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-laptop-code"></i>
                        <span>Online Examination</span>
                    </div>
                    <div class="menu-right">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.assignments') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-book-reader"></i>
                        <span>Study Materials</span>
                    </div>
                    <div class="menu-right">
                        <span class="pro-badge">Pro</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.results') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="far fa-file-alt"></i>
                        <span>Report</span>
                    </div>
                    <div class="menu-right">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.dashboard') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-tools"></i>
                        <span>Website Setup</span>
                    </div>
                    <div class="menu-right">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link" onclick="alert('Gallery module'); return false;">
                    <div class="menu-left">
                        <i class="fas fa-images"></i>
                        <span>Gallery</span>
                    </div>
                    <div class="menu-right">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.messages.index') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="far fa-comment-dots"></i>
                        <span>Live Chat</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.payments.settings') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-cog"></i>
                        <span>App Settings</span>
                    </div>
                    <div class="menu-right">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="menu-item" style="margin-top: 1.5rem; border-top: 1px solid var(--border-color); padding-top: 0.5rem;">
                <a href="{{ route('school.logout') }}" class="menu-link" style="color: #ff6b6b;">
                    <div class="menu-left">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </div>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content Area -->
    <div class="main-wrapper">
        
        <!-- Top Navbar -->
        <header class="top-header">
            <div class="header-left">
                <a href="{{ route('sms.teacher.dashboard') }}" class="home-btn" title="Dashboard Home">
                    <i class="fas fa-home"></i>
                </a>
                <div class="search-box">
                    <input type="text" placeholder="Search Page">
                    <i class="fas fa-search"></i>
                </div>
            </div>

            <div class="header-right">
                <div class="header-select-pill" title="Language">
                    <span class="flag-icon">🇺🇸</span>
                    <span>English</span>
                    <i class="fas fa-angle-down" style="font-size: 0.7rem; color: var(--text-muted);"></i>
                </div>

                <div class="header-select-pill" title="Academic Session">
                    <span>2026</span>
                    <i class="fas fa-angle-down" style="font-size: 0.7rem; color: var(--text-muted);"></i>
                </div>

                <button class="header-icon-btn" id="themeToggleBtn" title="Toggle Dark/Light Mode">
                    <i class="far fa-moon"></i>
                </button>

                <button class="header-icon-btn" id="fullscreenBtn" title="Toggle Fullscreen">
                    <i class="fas fa-expand"></i>
                </button>

                <button class="header-icon-btn" title="Notifications">
                    <i class="far fa-bell"></i>
                    <span class="notification-badge">3</span>
                </button>

                <div class="profile-badge" title="{{ $teacher->user->name ?? 'Teacher' }}">
                    TC
                </div>
            </div>
        </header>

        <!-- Page Main Content -->
        <main class="page-content">

            <!-- 4 Top Metric Cards (EXACT MATCH TO ONEST SCHOOLED) -->
            <div class="metric-cards-grid">
                
                <!-- Card 1: Student -->
                <div class="metric-card">
                    <div class="metric-icon-box icon-orange">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="metric-details">
                        <div class="metric-number">{{ $totalStudentsCount ?? 84 }}</div>
                        <div class="metric-label">Student</div>
                    </div>
                </div>

                <!-- Card 2: Parent -->
                <div class="metric-card">
                    <div class="metric-icon-box icon-purple">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <div class="metric-details">
                        <div class="metric-number">{{ $totalParentsCount ?? 10 }}</div>
                        <div class="metric-label">Parent</div>
                    </div>
                </div>

                <!-- Card 3: Teacher -->
                <div class="metric-card">
                    <div class="metric-icon-box icon-blue">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="metric-details">
                        <div class="metric-number">{{ $totalTeachersCount ?? 14 }}</div>
                        <div class="metric-label">Teacher</div>
                    </div>
                </div>

                <!-- Card 4: Session -->
                <div class="metric-card">
                    <div class="metric-icon-box icon-cyan">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="metric-details">
                        <div class="metric-number">{{ $totalSessionsCount ?? 3 }}</div>
                        <div class="metric-label">Session</div>
                    </div>
                </div>

            </div>

            <!-- Main Interactive Calendar (EXACT MATCH TO ONEST SCHOOLED) -->
            <div class="calendar-card">
                <div class="calendar-header">
                    <div class="cal-nav-group">
                        <button class="cal-btn" id="calPrevBtn"><i class="fas fa-chevron-left"></i></button>
                        <button class="cal-btn" id="calNextBtn"><i class="fas fa-chevron-right"></i></button>
                        <button class="cal-btn" id="calTodayBtn">today</button>
                    </div>

                    <div class="cal-title" id="calMonthTitle">
                        September 2026
                    </div>

                    <div class="cal-view-group">
                        <button class="cal-view-btn active" data-view="month">month</button>
                        <button class="cal-view-btn" data-view="week">week</button>
                        <button class="cal-view-btn" data-view="day">day</button>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="calendar-grid">
                        <thead>
                            <tr>
                                <th>Sun</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                            </tr>
                        </thead>
                        <tbody id="calGridBody">
                            <!-- Dynamic Interactive Month Grid Populated via JS -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Lower Grid: Today's Routine & Quick Actions -->
            <div class="lower-grid">
                
                <!-- Left: Routine Schedule -->
                <div class="panel-card">
                    <div class="panel-header">
                        <div class="panel-title">
                            <i class="far fa-calendar-check" style="color: #ff9f43;"></i>
                            <span>Class Routines & Schedule</span>
                        </div>
                        <a href="{{ route('sms.teacher.timetable') }}" class="btn-action">
                            View Full Routine <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="panel-body" style="padding: 0;">
                        <table class="routine-table">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Day</th>
                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($upcomingClasses as $routine)
                                <tr>
                                    <td><strong>{{ $routine->class->name ?? 'JSS2' }}</strong></td>
                                    <td>{{ $routine->subject->name ?? 'Mathematics' }}</td>
                                    <td><span class="status-badge badge-live">{{ ucfirst($routine->day ?? 'Monday') }}</span></td>
                                    <td>{{ $routine->start_time ?? '08:00 AM' }} - {{ $routine->end_time ?? '09:20 AM' }}</td>
                                    <td>
                                        <a href="{{ route('sms.teacher.attendance') }}" class="btn-action" title="Mark Attendance">
                                            <i class="fas fa-check"></i> Roll Call
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td><strong>JSS2</strong></td>
                                    <td>Mathematics</td>
                                    <td><span class="status-badge badge-live">Monday</span></td>
                                    <td>08:00 AM - 08:40 AM</td>
                                    <td><a href="{{ route('sms.teacher.attendance') }}" class="btn-action">Roll Call</a></td>
                                </tr>
                                <tr>
                                    <td><strong>SS1</strong></td>
                                    <td>Physics</td>
                                    <td><span class="status-badge badge-live">Monday</span></td>
                                    <td>10:20 AM - 11:00 AM</td>
                                    <td><a href="{{ route('sms.teacher.attendance') }}" class="btn-action">Roll Call</a></td>
                                </tr>
                                <tr>
                                    <td><strong>JSS2</strong></td>
                                    <td>Mathematics</td>
                                    <td><span class="status-badge badge-live">Wednesday</span></td>
                                    <td>09:20 AM - 10:00 AM</td>
                                    <td><a href="{{ route('sms.teacher.attendance') }}" class="btn-action">Roll Call</a></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right: Quick Actions & Notices -->
                <div class="panel-card">
                    <div class="panel-header">
                        <div class="panel-title">
                            <i class="fas fa-bolt" style="color: #4b7bec;"></i>
                            <span>Quick Actions</span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="quick-tiles-grid">
                            <a href="{{ route('sms.teacher.attendance') }}" class="quick-tile">
                                <i class="fas fa-clipboard-check"></i>
                                <span>Roll Call</span>
                            </a>
                            <a href="{{ route('sms.teacher.exams.create') }}" class="quick-tile">
                                <i class="fas fa-file-medical"></i>
                                <span>Create CBT</span>
                            </a>
                            <a href="{{ route('sms.teacher.results-entry.index') }}" class="quick-tile">
                                <i class="fas fa-edit"></i>
                                <span>Enter Marks</span>
                            </a>
                            <a href="{{ route('sms.teacher.question-bank') }}" class="quick-tile">
                                <i class="fas fa-database"></i>
                                <span>Question Bank</span>
                            </a>
                        </div>

                        <!-- Notices Snippet -->
                        <div style="margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                            <div style="font-size: 0.8125rem; font-weight: 700; color: var(--text-muted); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                School Announcements
                            </div>
                            @forelse($notices as $notice)
                            <div style="padding: 0.6rem; background: rgba(255,255,255,0.03); border-radius: 6px; margin-bottom: 0.5rem; font-size: 0.8125rem;">
                                <strong style="color: #ff9f43; display: block; margin-bottom: 0.2rem;">{{ $notice->title }}</strong>
                                <span style="color: var(--text-muted); font-size: 0.75rem;">{{ Str::limit($notice->content, 75) }}</span>
                            </div>
                            @empty
                            <div style="padding: 0.6rem; background: rgba(255,255,255,0.03); border-radius: 6px; font-size: 0.8125rem;">
                                <strong style="color: #ff9f43;">First Term CA1 Schedule</strong>
                                <span style="color: var(--text-muted); font-size: 0.75rem; display: block;">CA1 continuous assessments commence across all classes.</span>
                            </div>
                            @endforelse
                        </div>

                    </div>
                </div>

            </div>

        </main>
    </div>

    <!-- Calendar Interactive Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Theme toggle
            const themeBtn = document.getElementById('themeToggleBtn');
            if (themeBtn) {
                themeBtn.addEventListener('click', function() {
                    document.body.classList.toggle('light-theme');
                    const icon = this.querySelector('i');
                    if (document.body.classList.contains('light-theme')) {
                        icon.className = 'far fa-sun';
                    } else {
                        icon.className = 'far fa-moon';
                    }
                });
            }

            // Fullscreen toggle
            const fsBtn = document.getElementById('fullscreenBtn');
            if (fsBtn) {
                fsBtn.addEventListener('click', function() {
                    if (!document.fullscreenElement) {
                        document.documentElement.requestFullscreen().catch(() => {});
                    } else {
                        document.exitFullscreen().catch(() => {});
                    }
                });
            }

            // Calendar state
            let currentDate = new Date(2026, 8, 16); // Default: September 2026 matching screenshot

            const monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            const scheduleEvents = {
                1: [{ title: 'Staff Meeting 09:00 AM', type: 'event-purple' }],
                4: [{ title: 'Lesson Plan Review', type: 'event-blue' }],
                7: [{ title: 'JSS2 Mathematics', type: 'event-blue' }, { title: 'SS1 Physics', type: 'event-green' }],
                9: [{ title: 'JSS2 Mathematics', type: 'event-blue' }],
                11: [{ title: 'Sports Practice 02:00 PM', type: 'event-orange' }],
                14: [{ title: 'JSS2 Mathematics', type: 'event-blue' }, { title: 'SS1 Physics', type: 'event-green' }],
                16: [{ title: 'CA1 Exam Math', type: 'event-orange' }],
                18: [{ title: 'Physics Lab Session', type: 'event-green' }],
                21: [{ title: 'JSS2 Mathematics', type: 'event-blue' }],
                23: [{ title: 'Continuous Assessment', type: 'event-orange' }],
                28: [{ title: 'JSS2 Mathematics', type: 'event-blue' }, { title: 'SS1 Physics', type: 'event-green' }]
            };

            function renderCalendar() {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();

                // Update Title
                document.getElementById('calMonthTitle').textContent = `${monthNames[month]} ${year}`;

                const firstDayIndex = new Date(year, month, 1).getDay(); // Day of week for 1st
                const lastDate = new Date(year, month + 1, 0).getDate(); // Days in current month
                const prevLastDate = new Date(year, month, 0).getDate(); // Days in prev month

                const tbody = document.getElementById('calGridBody');
                tbody.innerHTML = '';

                let dayCounter = 1;
                let nextMonthCounter = 1;
                let totalCells = 35;
                if (firstDayIndex + lastDate > 35) {
                    totalCells = 42;
                }

                let currentWeekTr = document.createElement('tr');

                for (let i = 0; i < totalCells; i++) {
                    const td = document.createElement('td');

                    if (i < firstDayIndex) {
                        // Previous Month Days
                        td.classList.add('other-month');
                        const prevDateNum = prevLastDate - firstDayIndex + i + 1;
                        td.innerHTML = `<span class="day-num">${prevDateNum}</span>`;
                    } else if (dayCounter <= lastDate) {
                        // Current Month Days
                        const isToday = (dayCounter === 16 && month === 8 && year === 2026);
                        if (isToday) td.classList.add('is-today');

                        let eventsHtml = '';
                        if (scheduleEvents[dayCounter]) {
                            eventsHtml = '<div class="cal-events">';
                            scheduleEvents[dayCounter].forEach(ev => {
                                eventsHtml += `<div class="cal-event-pill ${ev.type}" title="${ev.title}">${ev.title}</div>`;
                            });
                            eventsHtml += '</div>';
                        }

                        td.innerHTML = `
                            <span class="day-num">${dayCounter}</span>
                            ${eventsHtml}
                        `;
                        dayCounter++;
                    } else {
                        // Next Month Days
                        td.classList.add('other-month');
                        td.innerHTML = `<span class="day-num">${nextMonthCounter}</span>`;
                        nextMonthCounter++;
                    }

                    currentWeekTr.appendChild(td);

                    if ((i + 1) % 7 === 0) {
                        tbody.appendChild(currentWeekTr);
                        currentWeekTr = document.createElement('tr');
                    }
                }
            }

            // Calendar Navigation Listeners
            document.getElementById('calPrevBtn').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });

            document.getElementById('calNextBtn').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });

            document.getElementById('calTodayBtn').addEventListener('click', function() {
                currentDate = new Date(2026, 8, 16);
                renderCalendar();
            });

            // Initial render
            renderCalendar();
        });
    </script>
</body>
</html>
