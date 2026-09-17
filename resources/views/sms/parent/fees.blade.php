<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School Fees &amp; Billing - Parent Portal - ES-SCHOOLS</title>
    
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
            margin-bottom: 1.5rem;
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

        .icon-blue { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
        .icon-green { background: rgba(16, 185, 129, 0.12); color: #10b981; }
        .icon-red { background: rgba(239, 68, 68, 0.12); color: #ef4444; }

        .metric-number {
            font-size: 1.45rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .metric-label {
            font-size: 0.8125rem;
            color: var(--text-muted);
            margin-top: 0.2rem;
            font-weight: 600;
        }

        /* School Bank Details Card */
        .bank-info-card {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.04) 0%, rgba(59, 130, 246, 0.08) 100%);
            border: 2px solid rgba(59, 130, 246, 0.25);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.75rem;
        }

        body.dark-theme .bank-info-card {
            background: rgba(30, 58, 138, 0.15);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .bank-info-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .bank-info-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        body.dark-theme .bank-info-title {
            color: #93c5fd;
        }

        .bank-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem 1.25rem;
        }

        .bank-item-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .bank-item-val {
            font-size: 1.05rem;
            font-weight: 800;
            margin-top: 0.2rem;
            word-break: break-word;
        }

        .account-num-pill {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-copy {
            background: var(--border-subtle);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            cursor: pointer;
            color: var(--text-muted);
            transition: all 0.2s;
        }

        .btn-copy:hover {
            color: var(--primary);
            border-color: var(--primary);
        }

        /* Children Fee Cards */
        .child-fee-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
        }

        .child-fee-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1rem;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .child-fee-student {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .child-mini-avatar {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.15rem;
            flex-shrink: 0;
        }

        .child-fee-name {
            font-size: 1.1rem;
            font-weight: 800;
        }

        .child-fee-sub {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.15rem;
        }

        .child-totals-bar {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .child-total-item {
            display: flex;
            flex-direction: column;
        }

        .child-total-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--text-muted);
        }

        .child-total-val {
            font-size: 1.15rem;
            font-weight: 800;
        }

        /* Fee Table */
        .table-responsive {
            width: 100% !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
        }

        table.fee-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 580px;
            margin-bottom: 1.25rem;
        }

        table.fee-table th {
            padding: 0.75rem 1rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--text-muted);
            background: var(--border-subtle);
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        table.fee-table td {
            padding: 0.85rem 1rem;
            font-size: 0.875rem;
            border-bottom: 1px solid var(--border-color);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.65rem;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .status-paid { background: #dcfce7; color: #15803d; }
        .status-partial { background: #fef3c7; color: #b45309; }
        .status-pending { background: #fee2e2; color: #b91c1c; }

        .btn-pay-now {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
            transition: all 0.2s;
        }

        .btn-pay-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
        }

        .paid-card-banner {
            background: #dcfce7;
            border: 1px solid #86efac;
            color: #15803d;
            padding: 0.85rem 1.25rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* Transaction History */
        .history-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
        }

        .history-card-header {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Modals */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-card {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 1.75rem;
            width: 100%;
            max-width: 520px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-close-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 1.25rem;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 700;
            margin-bottom: 0.35rem;
            color: var(--text-main);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: var(--border-subtle);
            color: var(--text-main);
            font-family: inherit;
            font-size: 0.875rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--bg-card);
        }

        .btn-modal-submit {
            width: 100%;
            padding: 0.85rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9375rem;
            cursor: pointer;
            margin-top: 0.5rem;
        }

        .btn-modal-submit:hover {
            background: var(--primary-dark);
        }

        /* Mobile Toggle & Drawer */
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

        /* Responsive */
        @media (max-width: 1024px) {
            .bank-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
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
                gap: 0.75rem;
            }
            .top-header {
                padding: 0 1rem;
            }
            .child-fee-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .child-totals-bar {
                width: 100%;
                justify-content: space-between;
            }
            .btn-pay-now {
                width: 100%;
                justify-content: center;
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
                <a href="{{ route('sms.parent.fees') }}" class="menu-link active">
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
                        {{ strtoupper(substr(optional(session('sms_user'))->name ?? 'P', 0, 1)) }}
                    </div>
                    <div class="profile-info">
                        <span class="profile-name">{{ optional(session('sms_user'))->name ?? 'Parent' }}</span>
                        <span class="profile-role">Parent Portal</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Main Content -->
        <main class="page-content">

            <div class="page-header-row">
                <h1 class="page-header-title">
                    <i class="fas fa-receipt" style="color: #10b981;"></i>
                    <span>School Fees &amp; Billing</span>
                </h1>
                <p class="page-header-subtitle">
                    Review assigned fees, make secure card/online payments, or submit bank transfer payment proofs.
                </p>
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

            <!-- 3 Summary Metric Cards -->
            <div class="metric-cards-grid">
                <div class="metric-card">
                    <div class="metric-icon-box icon-blue">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <div>
                        <div class="metric-number">₦{{ number_format($totalFees, 2) }}</div>
                        <div class="metric-label">Total Fees Billed</div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-icon-box icon-green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <div class="metric-number" style="color: #10b981;">₦{{ number_format($totalPaid, 2) }}</div>
                        <div class="metric-label">Total Amount Paid</div>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-icon-box icon-red">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <div class="metric-number" style="color: {{ $totalBalance > 0 ? '#ef4444' : '#10b981' }};">₦{{ number_format($totalBalance, 2) }}</div>
                        <div class="metric-label">Outstanding Balance</div>
                    </div>
                </div>
            </div>

            <!-- School Bank Account Details Card -->
            @php
                $bankName = $paymentSettings->bank_name ?? 'First Bank of Nigeria';
                $accountName = $paymentSettings->account_name ?? 'ES-SCHOOLS ACADEMY';
                $accountNumber = $paymentSettings->account_number ?? '3012984512';
            @endphp
            <div class="bank-info-card">
                <div class="bank-info-header">
                    <div class="bank-info-title">
                        <i class="fas fa-university"></i>
                        <span>Official School Bank Transfer Account</span>
                    </div>
                    <span style="font-size: 0.78rem; color: var(--text-muted);">After transferring, click "Submit Bank Proof" below</span>
                </div>
                <div class="bank-grid">
                    <div>
                        <div class="bank-item-label">Bank Name</div>
                        <div class="bank-item-val">{{ $bankName }}</div>
                    </div>
                    <div>
                        <div class="bank-item-label">Account Name</div>
                        <div class="bank-item-val">{{ $accountName }}</div>
                    </div>
                    <div>
                        <div class="bank-item-label">Account Number</div>
                        <div class="account-num-pill">
                            <span class="bank-item-val" id="bankAccNo" style="letter-spacing: 0.05em; color: var(--primary);">{{ $accountNumber }}</span>
                            <button type="button" class="btn-copy" onclick="copyAccountNo()" title="Copy Account Number">
                                <i class="far fa-copy"></i> Copy
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fee Breakdown per Child -->
            @forelse($feesByChild as $childData)
                @php
                    $student = $childData['student'];
                    $childFees = $childData['fees'];
                    $childTotalAmount = $childData['total_amount'];
                    $childTotalPaid = $childData['total_paid'];
                    $childTotalBalance = $childData['total_balance'];
                    $hasPending = $childData['has_pending_transfer'] ?? false;
                @endphp
                <div class="child-fee-card">
                    <div class="child-fee-header">
                        <div class="child-fee-student">
                            <div class="child-mini-avatar">
                                {{ strtoupper(substr($student->user->name ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                                <div class="child-fee-name">{{ $student->user->name ?? 'Student' }}</div>
                                <div class="child-fee-sub">Class: {{ $student->class->name ?? 'N/A' }} | ID: {{ $student->student_id_number }}</div>
                            </div>
                        </div>

                        <div class="child-totals-bar">
                            <div class="child-total-item">
                                <span class="child-total-label">Billed</span>
                                <span class="child-total-val">₦{{ number_format($childTotalAmount, 2) }}</span>
                            </div>
                            <div class="child-total-item">
                                <span class="child-total-label">Paid</span>
                                <span class="child-total-val" style="color: #10b981;">₦{{ number_format($childTotalPaid, 2) }}</span>
                            </div>
                            <div class="child-total-item">
                                <span class="child-total-label">Balance</span>
                                <span class="child-total-val" style="color: {{ $childTotalBalance > 0 ? '#ef4444' : '#10b981' }};">₦{{ number_format($childTotalBalance, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Individual Fees Table -->
                    <div class="table-responsive">
                        <table class="fee-table">
                            <thead>
                                <tr>
                                    <th>Fee Item</th>
                                    <th>Total Amount</th>
                                    <th>Amount Paid</th>
                                    <th>Balance</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($childFees as $item)
                                    @php
                                        $fBalance = max(0, $item->amount - $item->paid_amount);
                                        $feeId = $item->id ?? ('virtual_' . $student->id . '_' . ($item->fee_id ?? 1));
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $item->fee->name ?? 'Tuition Fee' }}</strong></td>
                                        <td>₦{{ number_format($item->amount, 2) }}</td>
                                        <td style="color: #10b981;">₦{{ number_format($item->paid_amount, 2) }}</td>
                                        <td style="color: {{ $fBalance > 0 ? '#ef4444' : '#10b981' }}; font-weight: 700;">₦{{ number_format($fBalance, 2) }}</td>
                                        <td>
                                            @if($fBalance <= 0)
                                                <span class="status-badge status-paid"><i class="fas fa-check"></i> Paid</span>
                                            @elseif($item->paid_amount > 0)
                                                <span class="status-badge status-partial"><i class="fas fa-clock"></i> Partial</span>
                                            @else
                                                <span class="status-badge status-pending"><i class="fas fa-exclamation"></i> Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($fBalance > 0)
                                                <button type="button" class="btn-pay-now" style="padding: 0.4rem 0.85rem; font-size: 0.75rem;" onclick="openPaymentModal('{{ $feeId }}', '{{ $fBalance }}', '{{ $student->user->name ?? 'Student' }} - {{ $item->fee->name ?? 'Fee' }}')">
                                                    <i class="fas fa-credit-card"></i> Pay Fee
                                                </button>
                                            @else
                                                <span style="color: #10b981; font-size: 0.8rem; font-weight: 700;"><i class="fas fa-check-circle"></i> Cleared</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($childTotalBalance > 0)
                        <div style="display: flex; gap: 1rem; align-items: center; justify-content: flex-end; flex-wrap: wrap;">
                            @if($hasPending)
                                <span style="background: #fef3c7; color: #92400e; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.8125rem; font-weight: 700;">
                                    <i class="fas fa-clock"></i> Payment Proof Submitted — Awaiting Approval
                                </span>
                            @endif
                            @php
                                $firstFee = $childFees->first();
                                $firstFeeId = $firstFee ? ($firstFee->id ?? ('virtual_' . $student->id . '_' . ($firstFee->fee_id ?? 1))) : '';
                            @endphp
                            <button type="button" class="btn-pay-now" onclick="openPaymentModal('{{ $firstFeeId }}', '{{ $childTotalBalance }}', '{{ $student->user->name ?? 'Student' }} - Total Outstanding')">
                                <i class="fas fa-money-bill-wave"></i> Pay Total Outstanding (₦{{ number_format($childTotalBalance, 2) }})
                            </button>
                        </div>
                    @else
                        <div class="paid-card-banner">
                            <i class="fas fa-check-circle" style="font-size: 1.25rem;"></i>
                            <span>All registered school fees are fully settled for {{ $student->user->name ?? 'this child' }}.</span>
                        </div>
                    @endif
                </div>
            @empty
                <div style="text-align: center; padding: 3rem 1.5rem; background: var(--bg-card); border-radius: 16px; border: 1px dashed var(--border-color);">
                    <i class="fas fa-receipt" style="font-size: 3rem; color: var(--text-muted); opacity: 0.5; margin-bottom: 1rem;"></i>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">No Fees Assigned</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">There are currently no active fee records assigned to your children.</p>
                </div>
            @endforelse

            <!-- Transaction & Payment History -->
            @if(isset($transactionHistory) && $transactionHistory->count() > 0)
            <div class="history-card">
                <div class="history-card-header">
                    <i class="fas fa-history" style="color: var(--primary);"></i>
                    <span>Payment History &amp; Receipts</span>
                </div>
                <div class="table-responsive">
                    <table class="fee-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Student / Description</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Receipt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactionHistory as $tx)
                                @php
                                    $item = $tx['data'];
                                    $student = $item->student ?? null;
                                    $fee = $item->fee ?? ($item->studentFee->fee ?? null);
                                    $status = $tx['status'] ?? 'completed';
                                @endphp
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($tx['date'])->format('M d, Y h:i A') }}</td>
                                    <td>
                                        <strong>{{ $student && $student->user ? $student->user->name : 'Child' }}</strong>
                                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $fee ? $fee->name : 'Tuition Payment' }}</div>
                                    </td>
                                    <td><span style="text-transform: capitalize;">{{ str_replace('_', ' ', $tx['method'] ?? 'online') }}</span></td>
                                    <td><strong>₦{{ number_format($tx['amount'], 2) }}</strong></td>
                                    <td>
                                        @if($status === 'completed' || $status === 'approved')
                                            <span class="status-badge status-paid"><i class="fas fa-check"></i> Approved</span>
                                        @elseif($status === 'pending')
                                            <span class="status-badge status-partial"><i class="fas fa-clock"></i> In Review</span>
                                        @else
                                            <span class="status-badge status-pending"><i class="fas fa-times"></i> {{ ucfirst($status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($tx['type'] === 'payment' && isset($item->id))
                                            <a href="{{ route('sms.parent.fees.receipt', $item->id) }}" style="color: var(--primary); font-weight: 700; text-decoration: none; font-size: 0.8125rem;">
                                                <i class="fas fa-download"></i> Receipt
                                            </a>
                                        @else
                                            <span style="color: var(--text-muted); font-size: 0.75rem;">Offline Transfer</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </main>
    </div>

    <!-- Payment Choice Modal -->
    <div class="modal-overlay" id="paymentMethodModal">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-credit-card" style="color: var(--primary);"></i>
                    <span>Select Payment Option</span>
                </div>
                <button type="button" class="modal-close-btn" onclick="closeModal('paymentMethodModal')">&times;</button>
            </div>
            <div style="margin-bottom: 1.25rem;">
                <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.5rem;" id="modalTargetDesc">Fee Payment</p>
                <div style="font-size: 1.35rem; font-weight: 800; color: var(--primary);" id="modalTargetAmount">₦0.00</div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <button type="button" class="btn-pay-now" style="width: 100%; justify-content: flex-start; padding: 1rem; border-radius: 12px; background: linear-gradient(135deg, #1e3a8a, #3b82f6);" onclick="openOnlineForm()">
                    <i class="fas fa-credit-card" style="font-size: 1.25rem;"></i>
                    <div style="text-align: left;">
                        <div style="font-weight: 800;">Pay Online (Debit Card / USSD)</div>
                        <div style="font-size: 0.75rem; opacity: 0.9;">Instant automated credit &amp; receipt generation</div>
                    </div>
                </button>

                <button type="button" class="btn-pay-now" style="width: 100%; justify-content: flex-start; padding: 1rem; border-radius: 12px; background: linear-gradient(135deg, #059669, #10b981);" onclick="openManualForm()">
                    <i class="fas fa-university" style="font-size: 1.25rem;"></i>
                    <div style="text-align: left;">
                        <div style="font-weight: 800;">Direct Bank Transfer (Manual)</div>
                        <div style="font-size: 0.75rem; opacity: 0.9;">Transfer to school bank account and upload receipt</div>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Online Payment Modal -->
    <div class="modal-overlay" id="onlineModal">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-credit-card" style="color: var(--primary);"></i>
                    <span>Pay Online via Gateway</span>
                </div>
                <button type="button" class="modal-close-btn" onclick="closeModal('onlineModal')">&times;</button>
            </div>
            <form action="{{ route('sms.parent.fees.initiate') }}" method="POST">
                @csrf
                <input type="hidden" name="student_fee_id" id="online_fee_id">
                <div class="form-group">
                    <label class="form-label">Payment Mode</label>
                    <select name="payment_type" class="form-control">
                        <option value="full">Full Settlement</option>
                        <option value="partial">Partial Payment</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Amount to Pay (₦)</label>
                    <input type="number" name="amount" id="online_amount" class="form-control" step="0.01" min="1" required>
                </div>
                <button type="submit" class="btn-modal-submit">Proceed to Secure Gateway</button>
            </form>
        </div>
    </div>

    <!-- Manual Transfer Proof Upload Modal -->
    <div class="modal-overlay" id="manualModal">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-university" style="color: #10b981;"></i>
                    <span>Submit Bank Transfer Proof</span>
                </div>
                <button type="button" class="modal-close-btn" onclick="closeModal('manualModal')">&times;</button>
            </div>
            <form action="{{ route('sms.parent.fees.manual-transfer') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="student_fee_id" id="manual_fee_id">
                <div class="form-group">
                    <label class="form-label">Amount Transferred (₦) *</label>
                    <input type="number" name="amount" id="manual_amount" class="form-control" step="0.01" min="1" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Depositor / Sender Account Name</label>
                    <input type="text" name="account_name" class="form-control" placeholder="e.g. John Doe">
                </div>
                <div class="form-group">
                    <label class="form-label">Bank Name Used</label>
                    <input type="text" name="bank_name" class="form-control" placeholder="e.g. GTBank, Kuda, Zenith">
                </div>
                <div class="form-group">
                    <label class="form-label">Transaction Reference / Session ID</label>
                    <input type="text" name="transaction_reference" class="form-control" placeholder="Optional transfer ref">
                </div>
                <div class="form-group">
                    <label class="form-label">Payment Receipt / Screenshot (JPG, PNG, PDF) *</label>
                    <input type="file" name="proof_document" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                </div>
                <button type="submit" class="btn-modal-submit" style="background: #10b981;">Submit Payment for Verification</button>
            </form>
        </div>
    </div>

    <!-- Toast message for copy -->
    <div id="copyToast" style="display: none; position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white; padding: 0.75rem 1.25rem; border-radius: 8px; font-weight: 700; font-size: 0.875rem; box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 1100;">
        Account Number Copied!
    </div>

    <!-- Theme & Modal Scripts -->
    <script>
        // Theme Toggle
        document.getElementById('themeToggleBtn')?.addEventListener('click', () => {
            document.body.classList.toggle('dark-theme');
            const isDark = document.body.classList.contains('dark-theme');
            const icon = document.getElementById('themeIcon');
            if (icon) icon.className = isDark ? 'far fa-sun' : 'far fa-moon';
        });

        // Sidebar Desktop & Mobile
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        document.getElementById('collapseSidebarBtn')?.addEventListener('click', () => sidebar.classList.toggle('collapsed'));
        document.getElementById('mobileSidebarToggle')?.addEventListener('click', () => {
            sidebar.classList.add('mobile-open');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        document.getElementById('closeSidebarMobile')?.addEventListener('click', () => {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        });
        overlay?.addEventListener('click', () => {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        });

        // Copy Account No
        function copyAccountNo() {
            const acc = document.getElementById('bankAccNo')?.innerText?.trim() || '';
            navigator.clipboard.writeText(acc).then(() => {
                const toast = document.getElementById('copyToast');
                if (toast) {
                    toast.style.display = 'block';
                    setTimeout(() => { toast.style.display = 'none'; }, 2500);
                }
            }).catch(() => {});
        }

        // Modal Controls
        let activeFeeId = '';
        let activeAmount = 0;

        function openPaymentModal(feeId, amount, description) {
            activeFeeId = feeId;
            activeAmount = parseFloat(amount) || 0;
            document.getElementById('modalTargetDesc').innerText = description;
            document.getElementById('modalTargetAmount').innerText = '₦' + activeAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('paymentMethodModal').classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id)?.classList.remove('active');
        }

        function openOnlineForm() {
            closeModal('paymentMethodModal');
            document.getElementById('online_fee_id').value = activeFeeId;
            document.getElementById('online_amount').value = activeAmount.toFixed(2);
            document.getElementById('onlineModal').classList.add('active');
        }

        function openManualForm() {
            closeModal('paymentMethodModal');
            document.getElementById('manual_fee_id').value = activeFeeId;
            document.getElementById('manual_amount').value = activeAmount.toFixed(2);
            document.getElementById('manualModal').classList.add('active');
        }
    </script>
</body>
</html>
