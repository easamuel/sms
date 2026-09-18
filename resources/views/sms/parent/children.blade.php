<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Children - Parent Portal - ES-SCHOOLS</title>
    
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
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
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
            line-height: 1.15;
            letter-spacing: -0.02em;
        }

        body.dark-theme .brand-title {
            color: #ffffff;
        }

        .brand-sub {
            font-size: 0.6875rem;
            font-weight: 700;
            color: var(--accent-purple);
            text-transform: uppercase;
            letter-spacing: 0.05em;
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
            height: 64px;
            background-color: var(--bg-header);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.75rem;
            position: sticky;
            top: 0;
            z-index: 90;
            box-shadow: var(--shadow-sm);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .home-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--border-subtle);
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.2s;
            font-size: 1rem;
        }

        .home-btn:hover {
            background: var(--primary);
            color: white;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }

        .header-icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
            text-decoration: none;
        }

        .header-icon-btn:hover {
            color: var(--primary);
            border-color: var(--primary);
        }

        .profile-badge {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.35rem 0.65rem 0.35rem 0.35rem;
            border-radius: 40px;
            border: 1px solid var(--border-color);
            background: var(--bg-card);
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #a55eea, #4b7bec);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 700;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-name {
            font-size: 0.8125rem;
            font-weight: 700;
            line-height: 1.15;
        }

        .profile-role {
            font-size: 0.6875rem;
            color: var(--text-muted);
        }

        /* Page Content */
        .page-content {
            padding: 1.75rem;
            flex: 1;
            min-width: 0;
            max-width: 1400px;
            width: 100%;
        }

        .page-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-header-title {
            font-size: 1.625rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .page-header-subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        /* Metric Cards */
        .metric-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.75rem;
        }

        .metric-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 1.25rem 1.15rem;
            display: flex;
            align-items: center;
            gap: 1.1rem;
            box-shadow: var(--shadow-sm);
        }

        .metric-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
        }

        .icon-purple { background: rgba(165, 94, 234, 0.12); color: #a55eea; }
        .icon-green { background: rgba(16, 185, 129, 0.12); color: #10b981; }
        .icon-orange { background: rgba(255, 159, 67, 0.12); color: #ff9f43; }

        .metric-number {
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .metric-label {
            font-size: 0.8125rem;
            color: var(--text-muted);
            margin-top: 0.2rem;
            font-weight: 600;
        }

        /* Children Cards Grid */
        .children-cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 1.5rem;
        }

        .child-large-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            position: relative;
            overflow: hidden;
            transition: all 0.25s ease;
        }

        .child-large-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .child-card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .child-avatar-big {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
            box-shadow: 0 4px 10px rgba(30, 58, 138, 0.2);
            flex-shrink: 0;
        }

        .child-header-details {
            flex: 1;
            min-width: 0;
        }

        .child-full-name {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text-main);
            word-break: break-word;
        }

        .child-sub-tag {
            font-size: 0.8125rem;
            color: var(--text-muted);
            margin-top: 0.15rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .status-pill-active {
            background: #dcfce7;
            color: #15803d;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 0.15rem 0.5rem;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .child-metrics-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--border-subtle);
            border-radius: 12px;
        }

        .metric-mini-box {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .metric-mini-label {
            font-size: 0.72rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .metric-mini-value {
            font-size: 1.1rem;
            font-weight: 800;
        }

        .child-actions-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.65rem;
        }

        .btn-action-tile {
            padding: 0.65rem 0.75rem;
            border-radius: 8px;
            font-size: 0.8125rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            transition: all 0.2s;
            text-align: center;
        }

        .btn-portal {
            background: var(--primary);
            color: white;
            grid-column: 1 / -1;
            padding: 0.75rem;
            font-size: 0.875rem;
        }
        .btn-portal:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-outline-action {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }
        .btn-outline-action:hover {
            background: var(--border-subtle);
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-fee-action {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .btn-fee-action:hover {
            background: #10b981;
            color: white;
        }

        /* Mobile Drawer & Overlay */
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
            .metric-cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1000;
                width: 280px;
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .mobile-close-btn, .mobile-toggle-btn {
                display: flex;
            }
            .collapse-btn {
                display: none;
            }
            .main-wrapper {
                margin-left: 0;
                width: 100% !important;
                max-width: 100vw !important;
                overflow-x: hidden !important;
            }
            .page-content {
                padding: 1rem 0.85rem;
            }
            .metric-cards-grid {
                grid-template-columns: 1fr;
                gap: 0.85rem;
            }
            .children-cards-container {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            .child-large-card {
                padding: 1.15rem;
            }
            .top-header {
                padding: 0 1rem;
            }
            .profile-role {
                display: none;
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
            <button class="mobile-close-btn" id="closeSidebarMobile" title="Close Menu">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="{{ route('sms.parent.dashboard') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-tachometer-alt" style="color: #a55eea;"></i>
                        <span>Parent Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.parent.children') }}" class="menu-link active">
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
            </div>

            <div class="header-right">
                <button class="header-icon-btn" id="themeToggleBtn" title="Toggle Dark/Light Mode">
                    <i class="far fa-moon" id="themeIcon"></i>
                </button>

                <div class="profile-badge">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($parent->user->name ?? 'P', 0, 1)) }}
                    </div>
                    <div class="profile-info">
                        <span class="profile-name">{{ $parent->user->name ?? 'Parent' }}</span>
                        <span class="profile-role">Verified Parent</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Main Content -->
        <main class="page-content">

            <div class="page-header-row">
                <div>
                    <h1 class="page-header-title">
                        <i class="fas fa-child" style="color: #3b82f6;"></i>
                        <span>My Children</span>
                    </h1>
                    <p class="page-header-subtitle">
                        Monitor your children's profiles, attendance history, term results, and fee balances.
                    </p>
                </div>
                <a href="{{ route('admission.create') }}" class="btn-action-tile btn-portal" style="grid-column: auto; padding: 0.65rem 1.25rem;">
                    <i class="fas fa-user-plus"></i> Enroll Another Child
                </a>
            </div>

            @if(session('success'))
            <div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 0.85rem 1.25rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: 0.875rem;">
                <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 0.85rem 1.25rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: 0.875rem;">
                <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i> {{ session('error') }}
            </div>
            @endif

            <!-- Metric Summary Cards -->
            <div class="metric-cards-grid">
                <div class="metric-card">
                    <div class="metric-icon-box icon-purple">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div>
                        <div class="metric-number">{{ $children->count() }}</div>
                        <div class="metric-label">Enrolled Children</div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-icon-box icon-green">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        @php
                            $avgAttendance = $childrenDetails->avg('attendance_rate') ?? 100;
                        @endphp
                        <div class="metric-number">{{ round($avgAttendance, 1) }}%</div>
                        <div class="metric-label">Average Attendance</div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-icon-box icon-orange">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div>
                        @php
                            $totalOutstanding = $childrenDetails->sum(function($item) {
                                return $item['fee_summary']['balance'] ?? 0;
                            });
                        @endphp
                        <div class="metric-number">₦{{ number_format($totalOutstanding, 2) }}</div>
                        <div class="metric-label">Pending School Fees</div>
                    </div>
                </div>
            </div>

            <!-- Children Cards List -->
            <div class="children-cards-container">
                @forelse($childrenDetails as $detail)
                    @php
                        $child = $detail['student'];
                        $attendanceRate = $detail['attendance_rate'];
                        $feeSummary = $detail['fee_summary'];
                        $recentResults = $detail['recent_results'];
                    @endphp
                    <div class="child-large-card">
                        <div class="child-card-header">
                            <div class="child-avatar-big">
                                {{ strtoupper(substr($child->user->name ?? 'S', 0, 1)) }}
                            </div>
                            <div class="child-header-details">
                                <div class="child-full-name">{{ $child->user->name ?? 'Student Name' }}</div>
                                <div class="child-sub-tag">
                                    <span><strong>ID:</strong> {{ $child->student_id_number ?? 'STU-000' }}</span>
                                    <span>•</span>
                                    <span><strong>Class:</strong> {{ $child->class->name ?? 'N/A' }}</span>
                                    <span class="status-pill-active">{{ ucfirst($child->status ?? 'active') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Metrics Row -->
                        <div class="child-metrics-row">
                            <div class="metric-mini-box">
                                <span class="metric-mini-label">Attendance Rate</span>
                                <span class="metric-mini-value" style="color: #10b981;">
                                    <i class="fas fa-check-circle" style="font-size: 0.85rem;"></i> {{ $attendanceRate }}%
                                </span>
                            </div>
                            <div class="metric-mini-box">
                                <span class="metric-mini-label">Fee Balance</span>
                                <span class="metric-mini-value" style="color: {{ ($feeSummary['balance'] ?? 0) > 0 ? '#ef4444' : '#10b981' }};">
                                    ₦{{ number_format($feeSummary['balance'] ?? 0, 2) }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="child-actions-grid">
                            <a href="{{ route('sms.parent.view-child', $child->id) }}" class="btn-action-tile btn-portal" title="Switch view to child portal">
                                <i class="fas fa-external-link-alt"></i>
                                <span>Switch to Child Dashboard</span>
                            </a>
                            <a href="{{ route('sms.parent.children.attendance', $child->id) }}" class="btn-action-tile btn-outline-action">
                                <i class="fas fa-calendar-alt" style="color: #3b82f6;"></i>
                                <span>Attendance</span>
                            </a>
                            <a href="{{ route('sms.parent.children.results', $child->id) }}" class="btn-action-tile btn-outline-action">
                                <i class="fas fa-graduation-cap" style="color: #a55eea;"></i>
                                <span>Exam Results</span>
                            </a>
                            <a href="{{ route('sms.parent.fees') }}" class="btn-action-tile btn-fee-action" style="grid-column: 1 / -1;">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Pay Outstanding Fees</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 1.5rem; background: var(--bg-card); border-radius: 16px; border: 1px dashed var(--border-color);">
                        <i class="fas fa-user-graduate" style="font-size: 3rem; color: var(--text-muted); opacity: 0.5; margin-bottom: 1rem;"></i>
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">No Children Found</h3>
                        <p style="color: var(--text-muted); font-size: 0.9rem; max-width: 400px; margin: 0 auto 1.5rem;">
                            You currently do not have any linked student profiles. You can submit an online admission application.
                        </p>
                        <a href="{{ route('admission.create') }}" class="btn-action-tile btn-portal" style="display: inline-flex; width: auto; padding: 0.75rem 1.5rem;">
                            <i class="fas fa-plus"></i> Submit Online Admission
                        </a>
                    </div>
                @endforelse
            </div>

        </main>
    </div>

    <!-- Theme & Fullscreen Scripts -->
    <script>
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

        const collapseBtn = document.getElementById('collapseSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        if (collapseBtn && sidebar) {
            collapseBtn.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
            });
        }

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

