<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Parent Portal - ES-SCHOOLS</title>
    
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
            background: linear-gradient(135deg, #a55eea, #4b7bec);
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
            box-shadow: 0 4px 10px rgba(165,94,234,0.25);
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
            color: #a55eea;
            background: rgba(165, 94, 234, 0.14);
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
            background: linear-gradient(135deg, #a55eea, #6366f1);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.9375rem;
            box-shadow: 0 2px 8px rgba(165,94,234,0.25);
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

        /* 4 Top Metric Cards (EXACT MATCH TO TEACHER DASHBOARD) */
        .metric-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.75rem;
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

        /* Children Section Cards */
        .children-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.25rem;
            margin-bottom: 1.75rem;
        }

        .child-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.2s;
        }

        .child-card:hover {
            box-shadow: var(--shadow-md);
            border-color: var(--primary);
        }

        .child-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .child-avatar {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, #1e3a8a, #10b981);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        .child-name {
            font-size: 1.0625rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .child-id-badge {
            display: inline-block;
            background: #eff6ff;
            color: #1e40af;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.72rem;
            font-weight: 700;
            margin-top: 0.25rem;
        }

        .child-info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--border-subtle);
            font-size: 0.8125rem;
        }

        .child-info-label {
            color: var(--text-muted);
            font-weight: 600;
        }

        .child-info-val {
            color: var(--text-main);
            font-weight: 700;
        }

        .btn-child-portal {
            margin-top: 1.25rem;
            background: linear-gradient(135deg, #1e3a8a, #1e40af);
            color: white;
            text-decoration: none;
            padding: 0.65rem 1rem;
            border-radius: 8px;
            font-size: 0.84rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }

        .btn-child-portal:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30,58,138,0.3);
        }

        /* Lower Grid (Results & Notices & Fees) */
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

        .grade-badge {
            display: inline-block;
            padding: 0.2rem 0.55rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 800;
        }

        .grade-a { background: #dcfce7; color: #15803d; }
        .grade-b { background: #eff6ff; color: #1e40af; }
        .grade-c { background: #fef3c7; color: #b45309; }

        /* Quick Action Tiles */
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

        /* Responsive */
        @media (max-width: 1024px) {
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
        }
    </style>
</head>
<body>

    <!-- Left Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('home') }}" class="brand-logo" title="Back to Homepage">
                <div class="grad-cap">
                    <i class="fas fa-users"></i>
                </div>
                <div class="brand-text-wrap">
                    <span class="brand-title">ES-SCHOOLS</span>
                    <span class="brand-sub">Parent Portal</span>
                </div>
            </a>
            <button class="collapse-btn" id="collapseSidebarBtn" title="Toggle Sidebar">
                <i class="fas fa-angle-left"></i>
            </button>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="{{ route('sms.parent.dashboard') }}" class="menu-link active">
                    <div class="menu-left">
                        <i class="fas fa-tachometer-alt" style="color: #a55eea;"></i>
                        <span>Parent Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.parent.children') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-child" style="color: #3b82f6;"></i>
                        <span>My Children</span>
                    </div>
                    <div class="menu-right">
                        <span class="count-badge">{{ $children->count() }}</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.parent.fees') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-receipt" style="color: #10b981;"></i>
                        <span>School Fees &amp; Pay</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.parent.messages') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="far fa-comments" style="color: #0fbcf9;"></i>
                        <span>Messages to School</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.parent.notices') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="far fa-bell" style="color: #f59e0b;"></i>
                        <span>Notice Board</span>
                    </div>
                    <div class="menu-right">
                        <span class="count-badge">New</span>
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
            <li class="menu-item" style="margin-top: 1.5rem; border-top: 1px solid var(--border-color); padding-top: 0.5rem;">
                <form id="parentLogoutForm" method="POST" action="{{ route('sms.logout') }}" style="display: none;">
                    @csrf
                </form>
                <a href="javascript:void(0)" onclick="document.getElementById('parentLogoutForm').submit();" class="menu-link" style="color: #ef4444;">
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
                <a href="{{ route('home') }}" class="home-btn" title="Homepage">
                    <i class="fas fa-home"></i>
                </a>
                <div class="search-box">
                    <input type="text" placeholder="Search children, results, notices...">
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

                <a href="{{ route('sms.parent.notices') }}" class="header-icon-btn" title="Announcements">
                    <i class="far fa-bell"></i>
                    <span class="notification-badge">2</span>
                </a>

                <div class="profile-badge">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($parent->user->name ?? 'P', 0, 1)) }}
                    </div>
                    <div class="profile-info">
                        <span class="profile-name">{{ $parent->user->name ?? 'Mr. & Mrs. Parent' }}</span>
                        <span class="profile-role">Parent / Guardian</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Main Content -->
        <main class="page-content">

            <!-- 4 Top Metric Cards (EXACT MATCH TO TEACHER DASHBOARD) -->
            <div class="metric-cards-grid">
                
                <!-- Card 1: Children -->
                <div class="metric-card">
                    <div class="metric-icon-box icon-orange">
                        <i class="fas fa-child"></i>
                    </div>
                    <div class="metric-details">
                        <div class="metric-number">{{ $stats['children_count'] ?? $children->count() }}</div>
                        <div class="metric-label">Enrolled Children</div>
                    </div>
                </div>

                <!-- Card 2: Attendance Rate -->
                <div class="metric-card">
                    <div class="metric-icon-box icon-purple">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="metric-details">
                        <div class="metric-number">{{ $stats['attendance_rate'] ?? 100 }}%</div>
                        <div class="metric-label">Attendance Rate</div>
                    </div>
                </div>

                <!-- Card 3: Pending Fees -->
                <div class="metric-card">
                    <div class="metric-icon-box icon-blue">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="metric-details">
                        <div class="metric-number" style="font-size: 1.25rem;">₦{{ number_format($stats['pending_fees'] ?? 65983, 2) }}</div>
                        <div class="metric-label">Pending School Fees</div>
                    </div>
                </div>

                <!-- Card 4: Academic Session -->
                <div class="metric-card">
                    <div class="metric-icon-box icon-cyan">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="metric-details">
                        <div class="metric-number" style="font-size: 1.25rem;">Term 1</div>
                        <div class="metric-label">2026/2027 Session</div>
                    </div>
                </div>

            </div>

            <!-- Children Cards Section -->
            <div style="margin-bottom: 1rem; display: flex; align-items: center; justify-content: space-between;">
                <h2 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-graduation-cap" style="color: var(--primary);"></i>
                    <span>My Enrolled Children</span>
                </h2>
                <a href="{{ route('sms.parent.fees') }}" class="btn-action">
                    <i class="fas fa-credit-card"></i> Pay Termly Fees
                </a>
            </div>

            <div class="children-grid">
                @forelse($children as $child)
                <div class="child-card">
                    <div>
                        <div class="child-header">
                            <div class="child-avatar">
                                {{ strtoupper(substr($child->user->name ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                                <div class="child-name">{{ $child->user->name ?? 'Student' }}</div>
                                <span class="child-id-badge">{{ $child->student_id_number ?? ('STU-000' . $child->id) }}</span>
                            </div>
                        </div>

                        <div class="child-info-row">
                            <span class="child-info-label">Class Level</span>
                            <span class="child-info-val">{{ $child->class->name ?? 'Basic 3' }}</span>
                        </div>
                        <div class="child-info-row">
                            <span class="child-info-label">Class Teacher</span>
                            <span class="child-info-val">{{ $child->class->classTeacher->user->name ?? 'Assigned Teacher' }}</span>
                        </div>
                        <div class="child-info-row">
                            <span class="child-info-label">Status</span>
                            <span class="child-info-val" style="color: #10b981;"><i class="fas fa-check-circle"></i> Active &amp; Enrolled</span>
                        </div>
                    </div>

                    <a href="{{ route('sms.parent.view-child', $child->id) }}" class="btn-child-portal">
                        <span>Open {{ explode(' ', $child->user->name ?? 'Child')[0] }}'s Portal</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                @empty
                <div class="child-card" style="grid-column: 1 / -1; text-align: center; padding: 2rem;">
                    <p style="color: var(--text-muted);">No children registered yet under this parent account.</p>
                </div>
                @endforelse
            </div>

            <!-- Lower Grid: Recent Exam Results & Quick Actions / Notices -->
            <div class="lower-grid">
                
                <!-- Left: Recent Exam Results & Fees Overview -->
                <div>
                    <!-- Recent Exam Results -->
                    <div class="panel-card">
                        <div class="panel-header">
                            <div class="panel-title">
                                <i class="fas fa-poll-h" style="color: #4b7bec;"></i>
                                <span>Recent Exam &amp; Assessment Results</span>
                            </div>
                        </div>
                        <div class="panel-body" style="padding: 0;">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Child</th>
                                        <th>Exam / Assessment</th>
                                        <th>Subject</th>
                                        <th>Score</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentResults as $result)
                                    <tr>
                                        <td><strong>{{ $result->student->user->name ?? 'Child' }}</strong></td>
                                        <td>{{ $result->exam->name ?? 'CA1 Test' }}</td>
                                        <td>{{ $result->exam->subject->name ?? 'Mathematics' }}</td>
                                        <td><strong>{{ number_format($result->marks_obtained, 1) }}</strong> / {{ number_format($result->exam->total_marks ?? 100, 0) }}</td>
                                        <td>
                                            @php
                                                $pct = ($result->exam->total_marks > 0) ? ($result->marks_obtained / $result->exam->total_marks) * 100 : 70;
                                                $gradeClass = ($pct >= 70) ? 'grade-a' : (($pct >= 50) ? 'grade-b' : 'grade-c');
                                            @endphp
                                            <span class="grade-badge {{ $gradeClass }}">{{ $result->grade ?? 'B' }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td><strong>Chukwu Obi</strong></td>
                                        <td>CA1 Continuous Assessment</td>
                                        <td>Mathematics</td>
                                        <td><strong>42.0</strong> / 50</td>
                                        <td><span class="grade-badge grade-a">A</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Chukwu Okoro</strong></td>
                                        <td>CA1 Continuous Assessment</td>
                                        <td>English Language</td>
                                        <td><strong>38.5</strong> / 50</td>
                                        <td><span class="grade-badge grade-b">B</span></td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Fee Summary Card -->
                    <div class="panel-card">
                        <div class="panel-header">
                            <div class="panel-title">
                                <i class="fas fa-file-invoice-dollar" style="color: #10b981;"></i>
                                <span>Fee Payment Breakdown</span>
                            </div>
                            <a href="{{ route('sms.parent.fees') }}" class="btn-action">
                                View Receipts &amp; Pay <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="panel-body">
                            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; text-align: center;">
                                <div style="padding: 1rem; background: var(--border-subtle); border-radius: 10px;">
                                    <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Total Billed</span>
                                    <h4 style="font-size: 1.125rem; font-weight: 800; margin-top: 0.25rem;">₦{{ number_format($feeSummary['total_fees'] ?? 136000, 2) }}</h4>
                                </div>
                                <div style="padding: 1rem; background: #dcfce7; border-radius: 10px; color: #15803d;">
                                    <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Amount Paid</span>
                                    <h4 style="font-size: 1.125rem; font-weight: 800; margin-top: 0.25rem;">₦{{ number_format($feeSummary['paid_fees'] ?? 70017, 2) }}</h4>
                                </div>
                                <div style="padding: 1rem; background: #fee2e2; border-radius: 10px; color: #b91c1c;">
                                    <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Outstanding</span>
                                    <h4 style="font-size: 1.125rem; font-weight: 800; margin-top: 0.25rem;">₦{{ number_format($feeSummary['pending_fees'] ?? 65983, 2) }}</h4>
                                </div>
                            </div>
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
                                <span>Parent Quick Actions</span>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="quick-tiles-grid">
                                <a href="{{ route('sms.parent.fees') }}" class="quick-tile">
                                    <i class="fas fa-credit-card" style="color: #10b981;"></i>
                                    <span>Pay Fees</span>
                                </a>
                                <a href="{{ route('sms.parent.children') }}" class="quick-tile">
                                    <i class="fas fa-calendar-check" style="color: #3b82f6;"></i>
                                    <span>Attendance</span>
                                </a>
                                <a href="{{ route('sms.parent.messages') }}" class="quick-tile">
                                    <i class="far fa-comments" style="color: #8b5cf6;"></i>
                                    <span>Chat School</span>
                                </a>
                                <a href="{{ route('admission.create') }}" class="quick-tile">
                                    <i class="fas fa-user-plus" style="color: #ff9f43;"></i>
                                    <span>Add Child</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- School Notices -->
                    <div class="panel-card">
                        <div class="panel-header">
                            <div class="panel-title">
                                <i class="fas fa-bullhorn" style="color: #0fbcf9;"></i>
                                <span>School Notices</span>
                            </div>
                            <a href="{{ route('sms.parent.notices') }}" style="font-size: 0.75rem; color: var(--primary); text-decoration: none; font-weight: 700;">View All</a>
                        </div>
                        <div class="panel-body">
                            @forelse($notices as $notice)
                            <div style="padding: 0.75rem; background: var(--border-subtle); border-radius: 8px; margin-bottom: 0.75rem; font-size: 0.8125rem;">
                                <strong style="color: var(--primary); display: block; margin-bottom: 0.2rem;">{{ $notice->title }}</strong>
                                <span style="color: var(--text-muted); font-size: 0.75rem;">{{ Str::limit($notice->content, 90) }}</span>
                                <div style="font-size: 0.6875rem; color: #94a3b8; margin-top: 0.35rem;">
                                    <i class="far fa-calendar-alt"></i> {{ $notice->published_at ? \Carbon\Carbon::parse($notice->published_at)->format('M d, Y') : 'Recent' }}
                                </div>
                            </div>
                            @empty
                            <div style="padding: 0.75rem; background: var(--border-subtle); border-radius: 8px; margin-bottom: 0.75rem; font-size: 0.8125rem;">
                                <strong style="color: var(--primary); display: block; margin-bottom: 0.2rem;">First Term Continuous Assessment (CA1) Schedule</strong>
                                <span style="color: var(--text-muted); font-size: 0.75rem;">The examination window opens next Monday. Kindly ensure all students are prepared.</span>
                                <div style="font-size: 0.6875rem; color: #94a3b8; margin-top: 0.35rem;">Sep 14, 2026</div>
                            </div>
                            <div style="padding: 0.75rem; background: var(--border-subtle); border-radius: 8px; font-size: 0.8125rem;">
                                <strong style="color: #10b981; display: block; margin-bottom: 0.2rem;">Upcoming PTA Meeting &amp; Fee Clearance</strong>
                                <span style="color: var(--text-muted); font-size: 0.75rem;">General meeting holds next Saturday at 10:00 AM in the school auditorium.</span>
                                <div style="font-size: 0.6875rem; color: #94a3b8; margin-top: 0.35rem;">Sep 13, 2026</div>
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

        // Sidebar Collapse
        const collapseBtn = document.getElementById('collapseSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        if (collapseBtn && sidebar) {
            collapseBtn.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
            });
        }
    </script>
</body>
</html>
