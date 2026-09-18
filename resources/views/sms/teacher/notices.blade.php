<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Faculty Notices &amp; Announcements - ES-SCHOOLS</title>
    
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg-body: #f4f6fb;
            --bg-sidebar: #ffffff;
            --bg-header: #ffffff;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --border-subtle: #f1f5f9;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --primary: #1e3a8a;
            --primary-dark: #172554;
            --accent-orange: #ff9f43;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px -2px rgba(0,0,0,0.06);
        }
        body.dark-theme {
            --bg-body: #16171d;
            --bg-sidebar: #121318;
            --bg-header: #1a1b22;
            --bg-card: #20222a;
            --border-color: #2c2e39;
            --border-subtle: #20222a;
            --text-main: #ffffff;
            --text-muted: #9aa0ac;
            --primary: #3b82f6;
            --primary-dark: #1d4ed8;
        }
        html, body { overflow-x: hidden !important; max-width: 100vw !important; width: 100% !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-body); color: var(--text-main); min-height: 100vh; display: flex; }
        
        .sidebar { width: 255px; background: var(--bg-sidebar); border-right: 1px solid var(--border-color); display: flex; flex-direction: column; position: fixed; top: 0; bottom: 0; left: 0; z-index: 100; transition: all 0.3s ease; }
        .sidebar-header { padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border-color); height: 68px; }
        .brand-logo { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; }
        .brand-logo .grad-cap { background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.125rem; }
        .brand-title { font-size: 1.125rem; font-weight: 800; color: var(--text-main); }
        .brand-sub { font-size: 0.6875rem; font-weight: 700; color: var(--accent-orange); text-transform: uppercase; }
        .collapse-btn { background: none; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.1rem; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .mobile-close-btn { display: none; background: none; border: none; font-size: 1.25rem; color: var(--text-muted); cursor: pointer; }
        
        .sidebar-menu { list-style: none; padding: 1rem 0.75rem; overflow-y: auto; flex: 1; }
        .menu-item { margin-bottom: 0.25rem; }
        .menu-link { display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 0.875rem; color: var(--text-muted); text-decoration: none; border-radius: 10px; font-size: 0.875rem; font-weight: 600; transition: all 0.2s; }
        .menu-link:hover, .menu-link.active { color: var(--primary); background: rgba(30, 58, 138, 0.08); font-weight: 700; }
        body.dark-theme .menu-link:hover, body.dark-theme .menu-link.active { color: #3b82f6; background: rgba(59, 130, 246, 0.14); }
        .menu-left { display: flex; align-items: center; gap: 0.75rem; }
        .menu-left i { font-size: 1.05rem; width: 22px; text-align: center; }
        
        .main-wrapper { margin-left: 255px; flex: 1; display: flex; flex-direction: column; min-width: 0; min-height: 100vh; }
        .top-header { height: 68px; background: var(--bg-header); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 1.75rem; position: sticky; top: 0; z-index: 90; }
        .header-left { display: flex; align-items: center; gap: 1rem; }
        .mobile-toggle-btn { display: none; background: none; border: none; color: var(--text-main); font-size: 1.25rem; cursor: pointer; }
        .home-btn { width: 38px; height: 38px; border-radius: 9px; background: rgba(30, 58, 138, 0.06); color: var(--primary); display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1rem; }
        .header-right { display: flex; align-items: center; gap: 0.85rem; }
        .header-icon-btn { width: 38px; height: 38px; border-radius: 9px; border: 1px solid var(--border-color); background-color: var(--bg-card); color: var(--text-main); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 1rem; }
        
        .page-content { padding: 1.75rem; flex: 1; min-width: 0; max-width: 1200px; width: 100%; }
        .page-header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
        .page-title { font-size: 1.5rem; font-weight: 800; color: var(--text-main); }
        .page-subtitle { font-size: 0.875rem; color: var(--text-muted); }
        
        .notice-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 1.5rem; margin-bottom: 1.25rem; box-shadow: var(--shadow-sm); transition: transform 0.2s ease; border-left: 4px solid #1e3a8a; }
        body.dark-theme .notice-card { border-left-color: #3b82f6; }
        .notice-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .notice-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-bottom: 0.85rem; flex-wrap: wrap; }
        .notice-title { font-size: 1.1rem; font-weight: 800; color: var(--text-main); line-height: 1.3; }
        .notice-date { font-size: 0.8125rem; color: var(--text-muted); background: var(--bg-body); padding: 0.25rem 0.65rem; border-radius: 20px; white-space: nowrap; }
        .notice-content { font-size: 0.92rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1rem; }
        .notice-footer { display: flex; align-items: center; gap: 1rem; font-size: 0.8rem; color: var(--text-muted); padding-top: 0.75rem; border-top: 1px solid var(--border-subtle); flex-wrap: wrap; }
        .notice-badge { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.2rem 0.55rem; border-radius: 6px; font-size: 0.75rem; font-weight: 700; background: rgba(30, 58, 138, 0.08); color: var(--primary); }
        
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 95; }
        .sidebar-overlay.active { display: block; }
        
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .mobile-toggle-btn { display: block; }
            .mobile-close-btn { display: block; }
        }
        @media (max-width: 768px) {
            .page-content { padding: 1rem; }
            .top-header { padding: 0 1rem; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('home') }}" class="brand-logo">
                <div class="grad-cap"><i class="fas fa-graduation-cap"></i></div>
                <div style="display: flex; flex-direction: column;">
                    <span class="brand-title">ES-SCHOOLS</span>
                    <span class="brand-sub">Teacher Portal</span>
                </div>
            </a>
            <button class="mobile-close-btn" id="closeSidebarMobile"><i class="fas fa-times"></i></button>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-item"><a href="{{ route('sms.teacher.dashboard') }}" class="menu-link"><div class="menu-left"><i class="fas fa-tachometer-alt" style="color: #1e3a8a;"></i><span>Dashboard</span></div></a></li>
            <li class="menu-item"><a href="{{ route('sms.teacher.timetable') }}" class="menu-link"><div class="menu-left"><i class="far fa-calendar-alt" style="color: #3b82f6;"></i><span>Routines</span></div></a></li>
            <li class="menu-item"><a href="{{ route('sms.teacher.attendance') }}" class="menu-link"><div class="menu-left"><i class="fas fa-user-check" style="color: #10b981;"></i><span>Attendance</span></div></a></li>
            <li class="menu-item"><a href="{{ route('sms.teacher.exams') }}" class="menu-link"><div class="menu-left"><i class="fas fa-graduation-cap" style="color: #8b5cf6;"></i><span>Examination</span></div></a></li>
            <li class="menu-item"><a href="{{ route('sms.teacher.exams.create') }}" class="menu-link"><div class="menu-left"><i class="fas fa-laptop-code" style="color: #06b6d4;"></i><span>Online Exam (CBT)</span></div></a></li>
            <li class="menu-item"><a href="{{ route('sms.teacher.practice-sessions') }}" class="menu-link"><div class="menu-left"><i class="fas fa-book-reader" style="color: #ec4899;"></i><span>Study Materials</span></div></a></li>
            <li class="menu-item"><a href="{{ route('sms.teacher.assignments') }}" class="menu-link"><div class="menu-left"><i class="fas fa-tasks" style="color: #f97316;"></i><span>Assignments</span></div></a></li>
            <li class="menu-item"><a href="{{ route('sms.teacher.results-entry.index') }}" class="menu-link"><div class="menu-left"><i class="far fa-file-alt" style="color: #10b981;"></i><span>Enter Results</span></div></a></li>
            <li class="menu-item"><a href="{{ route('sms.teacher.results') }}" class="menu-link"><div class="menu-left"><i class="fas fa-poll" style="color: #6366f1;"></i><span>Report Cards</span></div></a></li>
            <li class="menu-item"><a href="{{ route('school.dashboard') }}" class="menu-link"><div class="menu-left"><i class="fas fa-school" style="color: #64748b;"></i><span>School Admin</span></div></a></li>
            <li class="menu-item" style="margin-top: 1.5rem; border-top: 1px solid var(--border-color); padding-top: 0.5rem;">
                <form id="teacherLogoutForm" method="POST" action="{{ route('sms.logout') }}" style="display: none;">@csrf</form>
                <a href="javascript:void(0)" onclick="document.getElementById('teacherLogoutForm').submit();" class="menu-link" style="color: #ef4444;"><div class="menu-left"><i class="fas fa-sign-out-alt"></i><span>Logout</span></div></a>
            </li>
        </ul>
    </aside>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <header class="top-header">
            <div class="header-left">
                <button class="mobile-toggle-btn" id="mobileSidebarToggle"><i class="fas fa-bars"></i></button>
                <a href="{{ route('sms.teacher.dashboard') }}" class="home-btn"><i class="fas fa-home"></i></a>
                <div style="font-size: 0.88rem; font-weight: 700; color: var(--text-muted);">
                    <a href="{{ route('sms.teacher.dashboard') }}" style="color: var(--text-muted); text-decoration: none;">Dashboard</a>
                    <span style="margin: 0 0.35rem;">/</span>
                    <span style="color: var(--primary);">Notice Board</span>
                </div>
            </div>
            <div class="header-right">
                <button class="header-icon-btn" id="themeToggleBtn"><i class="far fa-moon" id="themeIcon"></i></button>
            </div>
        </header>

        <main class="page-content">
            <div class="page-header-row">
                <div>
                    <h1 class="page-title"><i class="far fa-bell" style="color: #f59e0b; margin-right: 0.5rem;"></i> Notice Board</h1>
                    <p class="page-subtitle">Official administrative announcements, memos, and faculty notices.</p>
                </div>
                <div style="font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">
                    {{ $notices->total() }} Announcements
                </div>
            </div>

            @forelse($notices as $notice)
            <article class="notice-card">
                <div class="notice-header">
                    <h3 class="notice-title">{{ $notice->title }}</h3>
                    <time class="notice-date">
                        @php
                            $pubDate = is_string($notice->published_at) ? \Carbon\Carbon::parse($notice->published_at) : ($notice->published_at ?? now());
                        @endphp
                        <i class="far fa-calendar-alt" style="margin-right: 4px;"></i> {{ $pubDate->format('M d, Y') }}
                    </time>
                </div>
                <p class="notice-content">{{ $notice->content }}</p>
                <div class="notice-footer">
                    <span class="notice-badge"><i class="fas fa-bullhorn"></i> Faculty Notice</span>
                    @if($notice->expires_at)
                    @php
                        $expDate = is_string($notice->expires_at) ? \Carbon\Carbon::parse($notice->expires_at) : $notice->expires_at;
                    @endphp
                    <span style="color: #f97316;"><i class="far fa-clock" style="margin-right: 4px;"></i> Active until {{ $expDate->format('M d, Y') }}</span>
                    @endif
                </div>
            </article>
            @empty
            <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 3rem 1.5rem; text-align: center;">
                <i class="far fa-bell-slash" style="font-size: 2.5rem; color: var(--text-muted); opacity: 0.4; margin-bottom: 1rem; display: block;"></i>
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.35rem;">No Notices at This Time</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Check back later for new administrative announcements.</p>
            </div>
            @endforelse

            <div style="margin-top: 1.5rem;">
                {{ $notices->links() }}
            </div>
        </main>
    </div>

    <script>
        const themeBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeIcon');
        if (themeBtn) {
            themeBtn.addEventListener('click', () => {
                document.body.classList.toggle('dark-theme');
                if (themeIcon) themeIcon.className = document.body.classList.contains('dark-theme') ? 'far fa-sun' : 'far fa-moon';
            });
        }

        const mobileToggle = document.getElementById('mobileSidebarToggle');
        const mobileClose = document.getElementById('closeSidebarMobile');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebar = document.getElementById('sidebar');

        function openSidebar() {
            if (sidebar) sidebar.classList.add('mobile-open');
            if (sidebarOverlay) sidebarOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            if (sidebar) sidebar.classList.remove('mobile-open');
            if (sidebarOverlay) sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (mobileToggle) mobileToggle.addEventListener('click', openSidebar);
        if (mobileClose) mobileClose.addEventListener('click', closeSidebar);
        if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);
    </script>
</body>
</html>
