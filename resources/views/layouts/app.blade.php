<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Primary Meta Tags -->
    <title>@yield('title', 'ES-SCHOOLS | Stop Chasing Fees & Run on Autopilot')</title>
    <meta name="title" content="@yield('meta_title', 'ES-SCHOOLS | Stop Chasing Fees & Run on Autopilot')">
    <meta name="description" content="@yield('meta_description', 'Automate tuition fee recovery, 1-click terminal report cards, and parent billing for Nigerian schools. Test-drive live interactive demos today.')">
    <meta name="keywords" content="@yield('meta_keywords', 'school management system, school administration, student management, teacher portal, attendance tracking, result management, fee management, online school system, education software')">
    <meta name="author" content="ExtremeSolutions Nigeria">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="revisit-after" content="7 days">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', 'ES-SCHOOLS: Automate Tuition & School Operations')">
    <meta property="og:description" content="@yield('og_description', 'Automate tuition recovery, 1-click report cards & parent billing for Nigerian schools. Try live interactive demos now!')">
    <meta property="og:image" content="@yield('og_image', asset('og-preview.png'))">
    <meta property="og:site_name" content="ES-SCHOOLS">
    <meta property="og:locale" content="en_NG">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('twitter_title', 'ES-SCHOOLS: Automate Tuition & School Operations')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Automate tuition recovery, 1-click report cards & parent billing for Nigerian schools. Try live interactive demos now!')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('og-preview.png'))">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": "School Management System",
        "applicationCategory": "EducationalApplication",
        "operatingSystem": "Web",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "USD"
        },
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.8",
            "ratingCount": "150"
        },
        "description": "Comprehensive school management system for administrators, teachers, and students. Manage attendance, results, fees, assignments, and more with ease.",
        "featureList": [
            "Student Management",
            "Teacher Portal",
            "Attendance Tracking",
            "Result Management",
            "Fee Management",
            "Assignment Management",
            "Mobile-Friendly Interface"
        ]
    }
    </script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    
    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            max-width: 100vw !important;
            overflow-x: hidden !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f4f6fb;
            color: #0f172a;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        
        /* Navigation */
        .sms-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 1.25rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }
        
        .sms-navbar-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }
        
        .sms-navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: #0f172a;
            flex-shrink: 0;
        }
        
        .sms-navbar-brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(30, 58, 138, 0.2);
        }
        
        .sms-navbar-brand-text {
            display: flex;
            flex-direction: column;
        }

        .sms-navbar-brand-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
        }

        .sms-navbar-brand-sub {
            font-size: 0.65rem;
            color: #ff9f43;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        
        .sms-navbar-actions {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            flex-shrink: 0;
        }

        .sms-nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.85rem;
            border-radius: 8px;
            font-size: 0.8125rem;
            font-weight: 700;
            text-decoration: none;
            background: rgba(30, 58, 138, 0.06);
            color: #1e3a8a;
            border: 1px solid rgba(30, 58, 138, 0.12);
            transition: all 0.2s;
        }

        .sms-nav-btn:hover {
            background: #1e3a8a;
            color: white;
        }
        
        .sms-user-menu {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.75rem 0.35rem 0.35rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            font-size: 0.8125rem;
            color: #0f172a;
            font-weight: 600;
        }
        
        .sms-user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 0.75rem;
            flex-shrink: 0;
        }
        
        .sms-logout-btn {
            padding: 0.45rem 0.85rem;
            background: rgba(239, 68, 68, 0.08);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 8px;
            font-size: 0.8125rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .sms-logout-btn:hover {
            background: #ef4444;
            color: white;
        }
            border-radius: 8px;
            font-size: 0.8125rem;
            color: #374151;
        }
        
        .sms-user-menu span {
            display: none;
        }
        
        .sms-user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
            flex-shrink: 0;
        }
        
        .sms-logout-btn {
            padding: 0.5rem 0.75rem;
            background: #fee2e2;
            color: #991b1b;
            border: none;
            border-radius: 6px;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.375rem;
            min-height: 36px;
            touch-action: manipulation;
        }
        
        .sms-logout-btn:hover,
        .sms-logout-btn:active {
            background: #fecaca;
            transform: scale(0.98);
        }
        
        .sms-logout-btn i {
            font-size: 0.875rem;
        }
        
        .sms-logout-btn span {
            display: none;
        }
        
        /* Main Content */
        .sms-main-content {
            min-height: calc(100vh - 70px);
            padding: 1rem;
        }
        
        .sms-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        /* Flash Messages */
        .sms-alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
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
        
        /* Mobile Menu Toggle */
        .sms-mobile-menu-toggle {
            display: none;
            background: transparent;
            border: none;
            padding: 0.5rem;
            cursor: pointer;
            color: #374151;
            font-size: 1.25rem;
            touch-action: manipulation;
        }
        
        /* Responsive */
        @media (min-width: 640px) {
            .sms-user-menu span {
                display: inline;
            }
            
            .sms-logout-btn span {
                display: inline;
            }
            
            .sms-navbar-brand-text {
                display: inline;
                font-size: 1.125rem;
            }
        }
        
        @media (min-width: 768px) {
            .sms-navbar {
                padding: 1rem 2rem;
            }
            
            .sms-main-content {
                padding: 2rem;
            }
            
            .sms-navbar-brand-text {
                font-size: 1.25rem;
            }
            
            .sms-user-menu {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
            
            .sms-user-avatar {
                width: 32px;
                height: 32px;
                font-size: 0.875rem;
            }
            
            .sms-logout-btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
        }
        
        @media (max-width: 767px) {
            .sms-navbar-brand-text {
                display: none !important;
            }
            
            .sms-navbar-brand-icon {
                width: 36px;
                height: 36px;
            }
            
            .sms-navbar {
                padding: 0.75rem 1rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="sms-navbar">
        <div class="sms-navbar-content">
            @php
                $role = session('sms_role');
                $dashboardRoute = match($role) {
                    'student' => 'sms.student.dashboard',
                    'teacher' => 'sms.teacher.dashboard',
                    'parent' => 'sms.parent.dashboard',
                    default => 'home',
                };
                $roleLabel = match($role) {
                    'student' => 'Student Portal',
                    'teacher' => 'Teacher Portal',
                    'parent' => 'Parent Portal',
                    default => 'School Portal',
                };
            @endphp
            <a href="{{ route($dashboardRoute) }}" class="sms-navbar-brand" title="Go to Dashboard">
                <div class="sms-navbar-brand-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="sms-navbar-brand-text">
                    <span class="sms-navbar-brand-title">ES-SCHOOLS</span>
                    <span class="sms-navbar-brand-sub">{{ $roleLabel }}</span>
                </div>
            </a>
            
            <div class="sms-navbar-actions">
                <a href="{{ route($dashboardRoute) }}" class="sms-nav-btn" title="Back to Main Dashboard">
                    <i class="fas fa-arrow-left"></i>
                    <span>Dashboard</span>
                </a>

                @if(session('sms_user'))
                <div class="sms-user-menu">
                    <div class="sms-user-avatar">
                        {{ strtoupper(substr(session('sms_user')->name ?? 'U', 0, 1)) }}
                    </div>
                    <span style="font-weight: 700;">{{ session('sms_user')->name ?? 'User' }}</span>
                </div>
                <form method="POST" action="{{ route('sms.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="sms-logout-btn" aria-label="Logout" title="Logout of Portal">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
                @endif
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="sms-main-content">
        <div class="sms-container">
            <!-- Flash Messages -->
            @if(session('success'))
            <div class="sms-alert sms-alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
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
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            
            <!-- Page Content -->
            @yield('content')
        </div>
    </main>
    
    <!-- Scripts -->
    <script>
        // CSRF Token for AJAX requests
        window.csrfToken = '{{ csrf_token() }}';
        
        // Auto-hide flash messages after 5 seconds
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
