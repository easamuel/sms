<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exam Results - {{ $student->user->name ?? 'Student' }} - Parent Portal</title>
    
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
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
            --accent-purple: #a55eea;
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
        }
        html, body { overflow-x: hidden !important; max-width: 100vw !important; width: 100% !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-body); color: var(--text-main); min-height: 100vh; display: flex; }
        .sidebar { width: 255px; background: var(--bg-sidebar); border-right: 1px solid var(--border-color); display: flex; flex-direction: column; position: fixed; top: 0; bottom: 0; left: 0; z-index: 100; transition: all 0.3s ease; }
        .sidebar-header { padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border-color); }
        .brand-logo { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; }
        .brand-logo .grad-cap { background: linear-gradient(135deg, #a55eea, #4b7bec); color: white; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.125rem; }
        .brand-title { font-size: 1.125rem; font-weight: 800; color: var(--primary); }
        body.dark-theme .brand-title { color: #ffffff; }
        .brand-sub { font-size: 0.6875rem; font-weight: 700; color: var(--accent-purple); text-transform: uppercase; }
        .sidebar-menu { list-style: none; padding: 1rem 0.75rem; overflow-y: auto; flex: 1; }
        .menu-item { margin-bottom: 0.25rem; }
        .menu-link { display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 0.875rem; color: var(--text-muted); text-decoration: none; border-radius: 10px; font-size: 0.875rem; font-weight: 600; transition: all 0.2s; }
        .menu-link:hover, .menu-link.active { color: var(--primary); background: rgba(30, 58, 138, 0.08); font-weight: 700; }
        .menu-left { display: flex; align-items: center; gap: 0.75rem; }
        .main-wrapper { margin-left: 255px; flex: 1; display: flex; flex-direction: column; min-width: 0; min-height: 100vh; }
        .top-header { height: 64px; background: var(--bg-header); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 1.75rem; position: sticky; top: 0; z-index: 90; }
        .page-content { padding: 1.75rem; flex: 1; min-width: 0; max-width: 1200px; width: 100%; }
        .panel-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; overflow: hidden; box-shadow: var(--shadow-sm); margin-top: 1.25rem; }
        .panel-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }
        .table-responsive { width: 100% !important; overflow-x: auto !important; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; min-width: 520px; }
        th { padding: 0.875rem 1.25rem; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; background: var(--border-subtle); text-align: left; }
        td { padding: 1rem 1.25rem; border-bottom: 1px solid var(--border-color); font-size: 0.875rem; }
        .grade-badge { display: inline-block; padding: 0.25rem 0.6rem; border-radius: 6px; font-weight: 800; font-size: 0.75rem; }
        .grade-a { background: #dcfce7; color: #15803d; }
        .grade-b { background: #eff6ff; color: #1e40af; }
        .grade-c { background: #fef3c7; color: #b45309; }
        .grade-f { background: #fee2e2; color: #b91c1c; }
        .mobile-toggle-btn { display: none; width: 38px; height: 38px; background: var(--border-subtle); border: 1px solid var(--border-color); border-radius: 10px; align-items: center; justify-content: center; color: var(--primary); cursor: pointer; }
        .mobile-close-btn { display: none; width: 32px; height: 32px; background: var(--border-subtle); border: 1px solid var(--border-color); border-radius: 8px; align-items: center; justify-content: center; cursor: pointer; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 999; }
        .sidebar-overlay.active { display: block; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); z-index: 1000; width: 280px; }
            .sidebar.mobile-open { transform: translateX(0); }
            .mobile-close-btn, .mobile-toggle-btn { display: flex; }
            .main-wrapper { margin-left: 0; width: 100% !important; max-width: 100vw !important; }
            .page-content { padding: 1rem 0.85rem; }
            .top-header { padding: 0 1rem; }
        }
    </style>
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('home') }}" class="brand-logo">
                <div class="grad-cap"><i class="fas fa-users"></i></div>
                <div><span class="brand-title">ES-SCHOOLS</span><span class="brand-sub">Parent Portal</span></div>
            </a>
            <button class="mobile-close-btn" id="closeSidebarMobile"><i class="fas fa-times"></i></button>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-item"><a href="{{ route('sms.parent.dashboard') }}" class="menu-link"><div class="menu-left"><i class="fas fa-tachometer-alt" style="color: #a55eea;"></i><span>Parent Dashboard</span></div></a></li>
            <li class="menu-item"><a href="{{ route('sms.parent.children') }}" class="menu-link active"><div class="menu-left"><i class="fas fa-child" style="color: #3b82f6;"></i><span>My Children</span></div></a></li>
            <li class="menu-item"><a href="{{ route('sms.parent.fees') }}" class="menu-link"><div class="menu-left"><i class="fas fa-receipt" style="color: #10b981;"></i><span>School Fees &amp; Pay</span></div></a></li>
            <li class="menu-item"><a href="{{ route('sms.parent.notices') }}" class="menu-link"><div class="menu-left"><i class="far fa-bell" style="color: #f59e0b;"></i><span>Notice Board</span></div></a></li>
        </ul>
    </aside>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="main-wrapper">
        <header class="top-header">
            <button class="mobile-toggle-btn" id="mobileSidebarToggle"><i class="fas fa-bars"></i></button>
            <a href="{{ route('sms.parent.children') }}" style="display: flex; align-items: center; gap: 0.5rem; text-decoration: none; color: var(--primary); font-weight: 700; font-size: 0.875rem;">
                <i class="fas fa-arrow-left"></i> Back to My Children
            </a>
            <button id="themeToggleBtn" style="background: none; border: none; cursor: pointer; color: var(--text-muted); font-size: 1.1rem;"><i class="far fa-moon"></i></button>
        </header>

        <main class="page-content">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h1 style="font-size: 1.5rem; font-weight: 800;">{{ $student->user->name ?? 'Student' }} - Continuous Assessments &amp; Results</h1>
                    <p style="font-size: 0.875rem; color: var(--text-muted);">Class: {{ $student->class->name ?? 'N/A' }} | Student ID: {{ $student->student_id_number }}</p>
                </div>
                <a href="{{ route('sms.parent.view-child', $student->id) }}" style="background: var(--primary); color: white; padding: 0.6rem 1.25rem; border-radius: 8px; text-decoration: none; font-size: 0.8125rem; font-weight: 700;">
                    <i class="fas fa-external-link-alt"></i> View Child Portal
                </a>
            </div>

            <div class="panel-card">
                <div class="panel-header"><h3 style="font-size: 1rem; font-weight: 700;">Published Examination Scores</h3></div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Exam Title</th>
                                <th>Subject</th>
                                <th>Score</th>
                                <th>Grade</th>
                                <th>Remarks</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results as $res)
                            @php
                                $score = $res->marks_obtained ?? 0;
                                $total = $res->total_marks ?? 100;
                                $percent = $total > 0 ? ($score / $total) * 100 : 0;
                                $gradeClass = $percent >= 70 ? 'grade-a' : ($percent >= 60 ? 'grade-b' : ($percent >= 50 ? 'grade-c' : 'grade-f'));
                                $grade = $res->grade ?? ($percent >= 70 ? 'A' : ($percent >= 60 ? 'B' : ($percent >= 50 ? 'C' : 'F')));
                            @endphp
                            <tr>
                                <td><strong>{{ $res->exam->title ?? 'Continuous Assessment' }}</strong></td>
                                <td>{{ $res->exam->subject->name ?? 'Subject' }}</td>
                                <td><strong>{{ number_format($score, 1) }}</strong> / {{ number_format($total, 1) }}</td>
                                <td><span class="grade-badge {{ $gradeClass }}">{{ $grade }}</span></td>
                                <td style="color: var(--text-muted);">{{ $res->remarks ?? 'Good effort' }}</td>
                                <td style="color: var(--text-muted);">{{ $res->created_at ? $res->created_at->format('M d, Y') : 'N/A' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-muted);">No exam results published yet for this student.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($results->hasPages())
                <div style="padding: 1rem 1.5rem;">{{ $results->links() }}</div>
                @endif
            </div>
        </main>
    </div>

    <script>
        document.getElementById('themeToggleBtn')?.addEventListener('click', () => {
            document.body.classList.toggle('dark-theme');
        });
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        document.getElementById('mobileSidebarToggle')?.addEventListener('click', () => {
            sidebar.classList.add('mobile-open');
            overlay.classList.add('active');
        });
        document.getElementById('closeSidebarMobile')?.addEventListener('click', () => {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        });
        overlay?.addEventListener('click', () => {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        });
    </script>
</body>
</html>
