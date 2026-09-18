<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher Portal - ES-SCHOOLS</title>
    
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
            /* Bright, Clean Light Theme Default (No Black) */
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

        .pro-badge {
            background: #10b981;
            color: white;
            font-size: 0.65rem;
            padding: 0.15rem 0.45rem;
            border-radius: 4px;
            font-weight: 800;
            text-transform: uppercase;
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
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
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

        /* 4 Top Metric Cards (EXACT MATCH TO ONEST SCHOOLED) */
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
            font-size: 1.625rem;
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

        /* Calendar Card Container */
        .calendar-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.75rem;
            box-shadow: var(--shadow-sm);
        }

        .calendar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .cal-nav-group {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .cal-btn {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 0.45rem 0.85rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.8125rem;
            font-weight: 700;
            transition: all 0.2s;
        }

        body.dark-theme .cal-btn {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }

        .cal-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .cal-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.01em;
        }

        .cal-view-group {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 0.2rem;
        }

        body.dark-theme .cal-view-group {
            background: rgba(255, 255, 255, 0.05);
        }

        .cal-view-btn {
            background: none;
            border: none;
            padding: 0.4rem 0.85rem;
            border-radius: 7px;
            color: var(--text-muted);
            font-size: 0.8125rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            text-transform: capitalize;
        }

        .cal-view-btn.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 2px 6px rgba(30,58,138,0.25);
        }

        /* Calendar Grid */
        .calendar-grid {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .calendar-grid th {
            padding: 0.75rem 0.5rem;
            text-align: center;
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border-color);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: #f8fafc;
        }

        body.dark-theme .calendar-grid th {
            background: rgba(255, 255, 255, 0.03);
        }

        .calendar-grid td {
            height: 95px;
            border: 1px solid var(--border-color);
            padding: 0.5rem;
            vertical-align: top;
            transition: background-color 0.2s;
            position: relative;
            cursor: pointer;
        }

        .calendar-grid td:hover {
            background-color: rgba(30, 58, 138, 0.04);
        }

        body.dark-theme .calendar-grid td:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .cal-date-num {
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.35rem;
            display: inline-block;
            width: 22px;
            height: 22px;
            line-height: 22px;
            text-align: center;
            border-radius: 50%;
        }

        .cal-date-num.today {
            background: var(--primary);
            color: white;
        }

        .cal-date-num.muted {
            color: #94a3b8;
            opacity: 0.5;
        }

        .cal-event-pill {
            font-size: 0.6875rem;
            font-weight: 700;
            padding: 0.2rem 0.45rem;
            border-radius: 4px;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
            cursor: pointer;
            transition: transform 0.15s;
        }

        .cal-event-pill:hover {
            transform: scale(1.02);
        }

        .cal-event-orange {
            background: rgba(255, 159, 67, 0.18);
            color: #d97706;
            border-left: 3px solid #ff9f43;
        }

        .cal-event-blue {
            background: rgba(75, 123, 236, 0.18);
            color: #2563eb;
            border-left: 3px solid #4b7bec;
        }

        .cal-event-purple {
            background: rgba(165, 94, 234, 0.18);
            color: #7c3aed;
            border-left: 3px solid #a55eea;
        }

        .cal-event-green {
            background: rgba(16, 185, 129, 0.18);
            color: #059669;
            border-left: 3px solid #10b981;
        }

        /* Lower Grid (Routines & Quick Actions) */
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

        .routine-table {
            width: 100%;
            border-collapse: collapse;
        }

        .routine-table th, .routine-table td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.84rem;
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
            background: rgba(255, 255, 255, 0.02);
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.4rem 0.75rem;
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

        .status-badge {
            display: inline-block;
            padding: 0.2rem 0.55rem;
            border-radius: 4px;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .badge-live {
            background: #dcfce7;
            color: #15803d;
        }

        .quick-tiles-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.875rem;
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

        /* Modal Styles */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 1rem;
        }

        .modal-box {
            background: var(--bg-card);
            border-radius: 16px;
            max-width: 550px;
            width: 100%;
            border: 1px solid var(--border-color);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);
            overflow: hidden;
            animation: modalPop 0.2s ease-out;
        }

        @keyframes modalPop {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-header {
            padding: 1.25rem 1.5rem;
            background: var(--bg-card-header);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-size: 1.125rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            color: var(--text-muted);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            background: var(--bg-card-header);
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
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
            .metric-cards-grid {
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
            .metric-cards-grid, .lower-grid {
                grid-template-columns: 1fr !important;
                gap: 1rem;
            }
            .calendar-grid th, .calendar-grid td {
                padding: 0.25rem;
            }
            .calendar-grid td {
                height: 70px;
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
                <a href="{{ route('sms.teacher.dashboard') }}" class="menu-link active">
                    <div class="menu-left">
                        <i class="fas fa-tachometer-alt" style="color: #1e3a8a;"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.timetable') }}" class="menu-link">
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
                <a href="javascript:void(0)" onclick="openModal('leaveModal')" class="menu-link">
                    <div class="menu-left">
                        <i class="far fa-clock" style="color: #f59e0b;"></i>
                        <span>Leave Request</span>
                    </div>
                    <div class="menu-right">
                        <i class="fas fa-plus" style="font-size: 0.7rem;"></i>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.exams') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-graduation-cap" style="color: #8b5cf6;"></i>
                        <span>Examination</span>
                    </div>
                    <div class="menu-right">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.exams.create') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-laptop-code" style="color: #06b6d4;"></i>
                        <span>Online Exam (CBT)</span>
                    </div>
                    <div class="menu-right">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('sms.teacher.practice-sessions') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-book-reader" style="color: #ec4899;"></i>
                        <span>Study Materials</span>
                    </div>
                    <div class="menu-right">
                        <span class="pro-badge">Active</span>
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
            <li class="menu-item">
                <a href="{{ route('school.dashboard') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-school" style="color: #64748b;"></i>
                        <span>School Admin</span>
                    </div>
                    <div class="menu-right">
                        <i class="fas fa-external-link-alt" style="font-size: 0.7rem;"></i>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0)" onclick="openModal('galleryModal')" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-images" style="color: #14b8a6;"></i>
                        <span>Campus Gallery</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.messages.index') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="far fa-comment-dots" style="color: #3b82f6;"></i>
                        <span>Staff Chat</span>
                    </div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('school.payments.settings') }}" class="menu-link">
                    <div class="menu-left">
                        <i class="fas fa-cog" style="color: #64748b;"></i>
                        <span>Settings</span>
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
                <div class="search-box">
                    <input type="text" placeholder="Search students, classes, exams...">
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

                <a href="{{ route('sms.teacher.notices') }}" class="header-icon-btn" title="School Announcements">
                    <i class="far fa-bell"></i>
                    <span class="notification-badge">3</span>
                </a>

                <div class="profile-badge">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($teacher->user->name ?? 'T', 0, 1)) }}
                    </div>
                    <div class="profile-info">
                        <span class="profile-name">{{ $teacher->user->name ?? 'Teacher Demo' }}</span>
                        <span class="profile-role">Mathematics &amp; Science</span>
                    </div>
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
                        <div class="metric-label">Total Students</div>
                    </div>
                </div>

                <!-- Card 2: Parent -->
                <div class="metric-card">
                    <div class="metric-icon-box icon-purple">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <div class="metric-details">
                        <div class="metric-number">{{ $totalParentsCount ?? 10 }}</div>
                        <div class="metric-label">Registered Parents</div>
                    </div>
                </div>

                <!-- Card 3: Teacher -->
                <div class="metric-card">
                    <div class="metric-icon-box icon-blue">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="metric-details">
                        <div class="metric-number">{{ $totalTeachersCount ?? 14 }}</div>
                        <div class="metric-label">Teaching Staff</div>
                    </div>
                </div>

                <!-- Card 4: Session -->
                <div class="metric-card">
                    <div class="metric-icon-box icon-cyan">
                        <i class="fas fa-laptop-house"></i>
                    </div>
                    <div class="metric-details">
                        <div class="metric-number">{{ $totalSessionsCount ?? 3 }}</div>
                        <div class="metric-label">Academic Terms</div>
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
                            <!-- Populated dynamically via script below -->
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
                            <span>Class Routines &amp; Schedule</span>
                        </div>
                        <a href="{{ route('sms.teacher.timetable') }}" class="btn-action">
                            View Full Routine <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="panel-body" style="padding: 0;">
                        <div class="table-responsive">
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
                                        <td><strong>JSS 2A</strong></td>
                                        <td>Mathematics</td>
                                        <td><span class="status-badge badge-live">Monday</span></td>
                                        <td>08:00 AM - 08:40 AM</td>
                                        <td><a href="{{ route('sms.teacher.attendance') }}" class="btn-action"><i class="fas fa-check"></i> Roll Call</a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>SSS 1 Science</strong></td>
                                        <td>Physics</td>
                                        <td><span class="status-badge badge-live">Monday</span></td>
                                        <td>10:20 AM - 11:00 AM</td>
                                        <td><a href="{{ route('sms.teacher.attendance') }}" class="btn-action"><i class="fas fa-check"></i> Roll Call</a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>JSS 2B</strong></td>
                                        <td>Basic Technology</td>
                                        <td><span class="status-badge badge-live">Wednesday</span></td>
                                        <td>09:20 AM - 10:00 AM</td>
                                        <td><a href="{{ route('sms.teacher.attendance') }}" class="btn-action"><i class="fas fa-check"></i> Roll Call</a></td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
                                <i class="fas fa-clipboard-check" style="color: #10b981;"></i>
                                <span>Roll Call</span>
                            </a>
                            <a href="{{ route('sms.teacher.exams.create') }}" class="quick-tile">
                                <i class="fas fa-laptop-code" style="color: #06b6d4;"></i>
                                <span>Create CBT</span>
                            </a>
                            <a href="{{ route('sms.teacher.results-entry.index') }}" class="quick-tile">
                                <i class="fas fa-edit" style="color: #ff9f43;"></i>
                                <span>Enter Marks</span>
                            </a>
                            <a href="{{ route('sms.teacher.question-bank') }}" class="quick-tile">
                                <i class="fas fa-database" style="color: #8b5cf6;"></i>
                                <span>Question Bank</span>
                            </a>
                        </div>

                        <!-- Notices Snippet -->
                        <div style="margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                            <div style="font-size: 0.8125rem; font-weight: 800; color: var(--text-muted); margin-bottom: 0.6rem; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; justify-content: space-between;">
                                <span>School Notices</span>
                                <a href="{{ route('sms.teacher.notices') }}" style="font-size: 0.75rem; color: var(--primary); text-decoration: none;">View All</a>
                            </div>
                            @forelse($notices as $notice)
                            <div style="padding: 0.75rem; background: var(--border-subtle); border-radius: 8px; margin-bottom: 0.5rem; font-size: 0.8125rem;">
                                <strong style="color: var(--primary); display: block; margin-bottom: 0.2rem;">{{ $notice->title }}</strong>
                                <span style="color: var(--text-muted); font-size: 0.75rem;">{{ Str::limit($notice->content, 75) }}</span>
                            </div>
                            @empty
                            <div style="padding: 0.75rem; background: var(--border-subtle); border-radius: 8px; margin-bottom: 0.5rem; font-size: 0.8125rem;">
                                <strong style="color: var(--primary); display: block; margin-bottom: 0.2rem;">Mid-Term CBT Preparation</strong>
                                <span style="color: var(--text-muted); font-size: 0.75rem;">All subject teachers should upload questions to the CBT portal before Friday.</span>
                            </div>
                            <div style="padding: 0.75rem; background: var(--border-subtle); border-radius: 8px; font-size: 0.8125rem;">
                                <strong style="color: #10b981; display: block; margin-bottom: 0.2rem;">Staff General Meeting</strong>
                                <span style="color: var(--text-muted); font-size: 0.75rem;">Monthly briefing scheduled for 2:00 PM in the school auditorium.</span>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <!-- Teacher Leave Application Modal -->
    <div class="modal-backdrop" id="leaveModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title"><i class="far fa-calendar-plus" style="color: #f59e0b; margin-right: 0.5rem;"></i> Request Staff Leave</h3>
                <button class="modal-close" onclick="closeModal('leaveModal')">&times;</button>
            </div>
            <form onsubmit="handleLeaveSubmit(event)">
                <div class="modal-body">
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.8125rem; font-weight: 700; margin-bottom: 0.35rem;">Leave Category</label>
                        <select id="leaveType" style="width: 100%; padding: 0.6rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-body); color: var(--text-main);" required>
                            <option value="Casual Leave">Casual Leave (Personal / Urgent)</option>
                            <option value="Sick Leave">Sick / Medical Leave</option>
                            <option value="Examination Duty">Official Examination Duty</option>
                            <option value="Maternity/Paternity">Maternity / Paternity Leave</option>
                        </select>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="display: block; font-size: 0.8125rem; font-weight: 700; margin-bottom: 0.35rem;">Start Date</label>
                            <input type="date" id="leaveStart" style="width: 100%; padding: 0.6rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-body); color: var(--text-main);" required>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.8125rem; font-weight: 700; margin-bottom: 0.35rem;">End Date</label>
                            <input type="date" id="leaveEnd" style="width: 100%; padding: 0.6rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-body); color: var(--text-main);" required>
                        </div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.8125rem; font-weight: 700; margin-bottom: 0.35rem;">Reason for Leave</label>
                        <textarea id="leaveReason" rows="3" placeholder="Briefly state reason for leave request..." style="width: 100%; padding: 0.6rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-body); color: var(--text-main);" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-action" onclick="closeModal('leaveModal')">Cancel</button>
                    <button type="submit" class="btn-action" style="background: var(--primary); color: white; border-color: var(--primary);">Submit Application</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Campus Gallery Modal -->
    <div class="modal-backdrop" id="galleryModal">
        <div class="modal-box" style="max-width: 700px;">
            <div class="modal-header">
                <h3 class="modal-title"><i class="fas fa-images" style="color: #14b8a6; margin-right: 0.5rem;"></i> School Campus Facilities</h3>
                <button class="modal-close" onclick="closeModal('galleryModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.875rem;">
                    <div style="border-radius: 10px; overflow: hidden; background: #e2e8f0; text-align: center; padding: 1.5rem 0.5rem;">
                        <i class="fas fa-flask" style="font-size: 2.2rem; color: #3b82f6; margin-bottom: 0.5rem; display: block;"></i>
                        <strong style="font-size: 0.84rem; display: block;">Science Laboratory</strong>
                        <span style="font-size: 0.72rem; color: var(--text-muted);">Equipped for Physics &amp; Chemistry</span>
                    </div>
                    <div style="border-radius: 10px; overflow: hidden; background: #e2e8f0; text-align: center; padding: 1.5rem 0.5rem;">
                        <i class="fas fa-desktop" style="font-size: 2.2rem; color: #10b981; margin-bottom: 0.5rem; display: block;"></i>
                        <strong style="font-size: 0.84rem; display: block;">ICT CBT Center</strong>
                        <span style="font-size: 0.72rem; color: var(--text-muted);">150 Networked Workstations</span>
                    </div>
                    <div style="border-radius: 10px; overflow: hidden; background: #e2e8f0; text-align: center; padding: 1.5rem 0.5rem;">
                        <i class="fas fa-book-open" style="font-size: 2.2rem; color: #f59e0b; margin-bottom: 0.5rem; display: block;"></i>
                        <strong style="font-size: 0.84rem; display: block;">Modern e-Library</strong>
                        <span style="font-size: 0.72rem; color: var(--text-muted);">Over 10,000 Digital Books</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" onclick="closeModal('galleryModal')">Close</button>
            </div>
        </div>
    </div>

    <!-- Calendar Event & Holiday Details Modal -->
    <div class="modal-backdrop" id="calendarEventModal">
        <div class="modal-box" style="max-width: 540px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: 0.6rem;">
                    <div id="calModalIconWrap" style="width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(16, 185, 129, 0.12); color: #10b981; font-size: 1.15rem;">
                        <i class="fas fa-calendar-star" id="calModalIcon"></i>
                    </div>
                    <div>
                        <h3 class="modal-title" id="calModalDateTitle" style="font-size: 1rem; margin-bottom: 2px;">Event Details</h3>
                        <span id="calModalCategoryBadge" class="status-badge badge-paid" style="font-size: 0.72rem;">Holiday</span>
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal('calendarEventModal')">&times;</button>
            </div>
            <div class="modal-body" id="calModalBody" style="padding: 1.25rem;">
                <!-- Dynamically populated -->
            </div>
            <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.75rem; color: var(--text-muted);"><i class="fas fa-school" style="margin-right: 4px;"></i> ES-SCHOOLS Academic Calendar</span>
                <button type="button" class="btn-action" onclick="closeModal('calendarEventModal')">Close</button>
            </div>
        </div>
    </div>

    <!-- Calendar & Dashboard Scripts -->
    <script>
        // Modal Controls
        function openModal(id) {
            const m = document.getElementById(id);
            if (m) m.style.display = 'flex';
        }
        function closeModal(id) {
            const m = document.getElementById(id);
            if (m) m.style.display = 'none';
        }
        function handleLeaveSubmit(e) {
            e.preventDefault();
            alert('Your leave application has been logged successfully and forwarded to the school administrator for approval.');
            closeModal('leaveModal');
        }

        // Theme Toggle (Dark/Light) - Default is Clean Light
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

        // Calendar Generator with Full Holiday & Event Details
        const calData = {
            year: 2026,
            month: 8, // September (0-indexed)
            monthName: 'September 2026',
            events: {
                2: [{ name: 'SS2 Math (08:00 AM)', type: 'blue', category: 'Class Session', time: '08:00 AM - 09:20 AM', location: 'Hall 2A, Senior Secondary Wing', description: 'Advanced calculus, logarithms and trigonometric expressions review.' }],
                3: [{ name: 'Staff Meeting (02:00 PM)', type: 'purple', category: 'Staff Assembly', time: '02:00 PM - 03:30 PM', location: 'Staff Lounge & Zoom Sync', description: 'Monthly teachers review meeting with the Principal on curriculum delivery and CBT preparations.' }],
                4: [{ name: 'Eid-ul-Mawlid (Public Holiday)', type: 'green', isHoliday: true, category: 'Public Holiday', time: 'All Day', location: 'Nationwide / School Closed', description: 'Federal public holiday observed nationwide commemorating the birth of Prophet Muhammad. All lectures, tests, and administrative operations are suspended for the day.' }],
                7: [{ name: 'JSS1 Tech (10:00 AM)', type: 'orange', category: 'Class Session', time: '10:00 AM - 11:20 AM', location: 'Intro Tech Workshop', description: 'Practical introduction to isometric projections and woodwork tools.' }],
                9: [{ name: 'SS1 Physics Pract.', type: 'green', category: 'Laboratory Practical', time: '09:00 AM - 11:00 AM', location: 'Science Laboratory 1', description: 'Hands-on experiment on light optics, focal lengths, and convex lens refraction.' }],
                14: [{ name: 'Continuous Assess. 1', type: 'orange', category: 'Continuous Assessment', time: '08:30 AM - 01:30 PM', location: 'All Classrooms', description: 'First term continuous assessment test across all junior and senior divisions.' }],
                16: [{ name: 'SS3 Mock CBT Exam', type: 'blue', category: 'Examination', time: '08:00 AM - 12:00 PM', location: 'ICT CBT Centre', description: 'Mock computer-based examination preparing SS3 candidates for upcoming external certifications.' }],
                21: [{ name: 'PTA General Meeting', type: 'purple', category: 'Parent & Staff Event', time: '02:00 PM - 04:30 PM', location: 'Main Auditorium', description: 'General assembly of parents, guardians, and academic staff to review student welfare, fees, and campus facility upgrades.' }],
                24: [{ name: 'Inter-House Sports Heat', type: 'green', category: 'Extracurricular', time: '09:00 AM - 01:00 PM', location: 'School Sports Complex', description: 'Preliminary athletic heats and track events among Blue, Red, Yellow, and Green houses.' }],
                25: [{ name: 'Midterm Break (School Holiday)', type: 'green', isHoliday: true, category: 'School Holiday', time: 'All Day', location: 'School Wide', description: 'Official first term mid-term holiday for all students and academic staff. Normal academic activities resume on Monday, September 28.' }],
                28: [{ name: 'Midterm CBT Exam', type: 'orange', category: 'Examination', time: '08:30 AM - 01:00 PM', location: 'CBT Hall A & B', description: 'Mid-term computerized evaluation test for secondary school classes.' }],
                30: [{ name: 'Results Entry Closes', type: 'blue', category: 'Academic Deadline', time: '11:59 PM Deadline', location: 'Teacher Portal', description: 'Strict deadline for all subject teachers to submit midterm score sheets and behavioral remarks.' }]
            }
        };

        window.showCalendarDateDetails = function(day) {
            const events = calData.events[day] || [];
            const dateObj = new Date(calData.year, calData.month, day);
            const dayName = dateObj.toLocaleDateString('en-US', { weekday: 'long' });
            const fullDateStr = `${dayName}, September ${day}, ${calData.year}`;
            
            const dateTitleElem = document.getElementById('calModalDateTitle');
            if (dateTitleElem) dateTitleElem.innerText = fullDateStr;
            const body = document.getElementById('calModalBody');
            const catBadge = document.getElementById('calModalCategoryBadge');
            const iconWrap = document.getElementById('calModalIconWrap');
            const icon = document.getElementById('calModalIcon');

            if (!body) return;

            if (events.length === 0) {
                if (catBadge) {
                    catBadge.innerText = 'Academic Day';
                    catBadge.className = 'status-badge';
                    catBadge.style.background = 'rgba(100, 116, 139, 0.1)';
                    catBadge.style.color = 'var(--text-muted)';
                }
                if (iconWrap) {
                    iconWrap.style.background = 'rgba(100, 116, 139, 0.1)';
                    iconWrap.style.color = '#64748b';
                }
                if (icon) icon.className = 'far fa-calendar-check';

                body.innerHTML = `
                    <div style="text-align: center; padding: 1.5rem 0.5rem;">
                        <div style="width: 52px; height: 52px; border-radius: 50%; background: var(--bg-body); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: var(--text-muted); font-size: 1.4rem;">
                            <i class="far fa-calendar-check"></i>
                        </div>
                        <h4 style="font-size: 1rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.35rem;">Standard Academic Routine</h4>
                        <p style="font-size: 0.84rem; color: var(--text-muted); max-width: 360px; margin: 0 auto; line-height: 1.5;">
                            No public holidays, special events, or school closures scheduled for this date. Normal classroom lectures and routines apply.
                        </p>
                    </div>
                `;
            } else {
                const hasHoliday = events.some(e => e.isHoliday || (e.category && e.category.toLowerCase().includes('holiday')));
                if (hasHoliday) {
                    if (catBadge) {
                        catBadge.innerText = 'Official Holiday';
                        catBadge.className = 'status-badge badge-paid';
                    }
                    if (iconWrap) {
                        iconWrap.style.background = 'rgba(16, 185, 129, 0.15)';
                        iconWrap.style.color = '#10b981';
                    }
                    if (icon) icon.className = 'fas fa-umbrella-beach';
                } else {
                    if (catBadge) {
                        catBadge.innerText = events[0].category || 'Scheduled Event';
                        catBadge.className = 'status-badge badge-live';
                    }
                    if (iconWrap) {
                        iconWrap.style.background = 'rgba(59, 130, 246, 0.15)';
                        iconWrap.style.color = '#3b82f6';
                    }
                    if (icon) icon.className = 'fas fa-calendar-alt';
                }

                let html = '<div style="display: flex; flex-direction: column; gap: 1rem;">';
                events.forEach(ev => {
                    const isHol = ev.isHoliday || (ev.category && ev.category.toLowerCase().includes('holiday'));
                    const borderCol = isHol ? '#10b981' : (ev.type === 'purple' ? '#a855f7' : (ev.type === 'orange' ? '#f97316' : '#3b82f6'));
                    const bgLight = isHol ? 'rgba(16, 185, 129, 0.06)' : 'rgba(59, 130, 246, 0.04)';
                    
                    html += `
                        <div style="border-left: 4px solid ${borderCol}; background: ${bgLight}; border-radius: 0 10px 10px 0; padding: 1rem; border: 1px solid var(--border-color); border-left-width: 4px;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem; gap: 0.5rem; flex-wrap: wrap;">
                                <h4 style="font-size: 1rem; font-weight: 800; color: var(--text-main); line-height: 1.3;">${ev.name}</h4>
                                <span class="status-badge" style="background: white; border: 1px solid var(--border-color); font-size: 0.72rem; color: ${borderCol}; font-weight: 700;">
                                    ${ev.category || 'Event'}
                                </span>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 0.35rem; font-size: 0.8125rem; color: var(--text-muted); margin-bottom: 0.75rem;">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="far fa-clock" style="width: 16px; color: #f59e0b;"></i>
                                    <span><strong>Time:</strong> ${ev.time || 'All Day'}</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-map-marker-alt" style="width: 16px; color: #ef4444;"></i>
                                    <span><strong>Location:</strong> ${ev.location || 'Campus Wide'}</span>
                                </div>
                            </div>
                            <p style="font-size: 0.84rem; color: var(--text-main); line-height: 1.5; background: var(--bg-card); padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border-color); margin: 0;">
                                ${ev.description || 'Official event scheduled on the academic calendar.'}
                            </p>
                        </div>
                    `;
                });
                html += '</div>';
                body.innerHTML = html;
            }

            openModal('calendarEventModal');
        };

        function renderCalendar() {
            const body = document.getElementById('calGridBody');
            if (!body) return;
            body.innerHTML = '';

            // September 1, 2026 is a Tuesday (index 2)
            const firstDay = new Date(calData.year, calData.month, 1).getDay();
            const daysInMonth = 30; // September has 30 days
            const daysInPrevMonth = 31; // August has 31 days

            let currentDay = 1;
            let nextMonthDay = 1;
            let rows = 5;

            for (let r = 0; r < rows; r++) {
                const tr = document.createElement('tr');
                for (let d = 0; d < 7; d++) {
                    const td = document.createElement('td');
                    const cellIndex = r * 7 + d;

                    if (cellIndex < firstDay) {
                        // Previous Month days
                        const pDay = daysInPrevMonth - firstDay + d + 1;
                        td.innerHTML = `<span class="cal-date-num muted">${pDay}</span>`;
                    } else if (currentDay <= daysInMonth) {
                        // Current Month Days
                        const isToday = (currentDay === 17); // demo day
                        const todayClass = isToday ? 'today' : '';
                        const thisDayNum = currentDay;
                        td.setAttribute('onclick', `showCalendarDateDetails(${thisDayNum})`);
                        
                        let cellHtml = `<span class="cal-date-num ${todayClass}">${currentDay}</span>`;

                        if (calData.events[currentDay]) {
                            calData.events[currentDay].forEach(ev => {
                                cellHtml += `<span class="cal-event-pill cal-event-${ev.type}" title="${ev.name}" onclick="event.stopPropagation(); showCalendarDateDetails(${thisDayNum});">${ev.name}</span>`;
                            });
                        }
                        td.innerHTML = cellHtml;
                        currentDay++;
                    } else {
                        // Next Month Days
                        td.innerHTML = `<span class="cal-date-num muted">${nextMonthDay}</span>`;
                        nextMonthDay++;
                    }
                    tr.appendChild(td);
                }
                body.appendChild(tr);
            }
        }

        renderCalendar();

        // Calendar View Switcher
        document.querySelectorAll('.cal-view-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.cal-view-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>
