<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Primary Meta Tags -->
    <title>@yield('title', 'School Management System - Simplify School Administration')</title>
    <meta name="title" content="@yield('meta_title', 'School Management System - Simplify School Administration')">
    <meta name="description" content="@yield('meta_description', 'Comprehensive school management system for administrators, teachers, and students. Manage attendance, results, fees, assignments, and more with ease. Mobile-friendly platform for modern education.')">
    <meta name="keywords" content="@yield('meta_keywords', 'school management system, school administration, student management, teacher portal, attendance tracking, result management, fee management, online school system, education software')">
    <meta name="author" content="School Management System">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="revisit-after" content="7 days">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', 'School Management System - Simplify School Administration')">
    <meta property="og:description" content="@yield('og_description', 'Comprehensive school management system for administrators, teachers, and students. Manage attendance, results, fees, assignments, and more with ease.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:site_name" content="School Management System">
    <meta property="og:locale" content="en_US">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('twitter_title', 'School Management System - Simplify School Administration')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Comprehensive school management system for administrators, teachers, and students.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/og-image.jpg'))">
    
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            line-height: 1.7;
            -webkit-font-smoothing: antialiased;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        
        /* Navigation */
        .sms-navbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.875rem 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
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
            gap: 0.625rem;
            font-size: 1rem;
            font-weight: 700;
            color: #111827;
            text-decoration: none;
            flex-shrink: 0;
        }
        
        .sms-navbar-brand-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }
        
        .sms-navbar-brand span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .sms-navbar-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }
        
        .sms-user-menu {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.75rem;
            background: #f3f4f6;
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
            @endphp
            <a href="{{ route($dashboardRoute) }}" class="sms-navbar-brand" title="Go to {{ $role ? ucfirst($role) . ' Dashboard' : 'Homepage' }}">
                <svg class="sms-navbar-brand-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="32" cy="32" r="30" fill="url(#logoGradient)"/>
                    <path d="M32 18L20 24L32 30L44 24L32 18Z" fill="white" opacity="0.95"/>
                    <path d="M20 24V36C20 36 24 40 32 40C40 40 44 36 44 36V24" stroke="white" stroke-width="2" fill="none"/>
                    <rect x="24" y="38" width="16" height="12" rx="2" fill="white" opacity="0.9"/>
                    <line x1="28" y1="42" x2="36" y2="42" stroke="#10b981" stroke-width="1.5"/>
                    <line x1="28" y1="45" x2="36" y2="45" stroke="#10b981" stroke-width="1.5"/>
                    <defs>
                        <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#1e3a8a;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#10b981;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                </svg>
                <span class="sms-navbar-brand-text">ES-SCHOOLS</span>
            </a>
            
            <div class="sms-navbar-actions">
                @if(session('sms_user'))
                    @if(session('sms_role') === 'parent')
                        <a href="{{ route('sms.parent.messages') }}" class="sms-navbar-link" style="position: relative; text-decoration: none; color: var(--sms-gray-700); padding: 0.5rem 1rem; border-radius: 6px; transition: all 0.2s;">
                            <i class="fas fa-comments"></i>
                            <span style="margin-left: 0.5rem;">Messages</span>
                            @php
                                $parent = \App\Models\Sms\SmsParent::where('user_id', session('sms_user')->id)->first();
                                $unreadCount = 0;
                                if ($parent) {
                                    $thread = \App\Models\MessageThread::where('parent_id', $parent->id)->first();
                                    if ($thread) {
                                        $unreadCount = $thread->unreadCount(session('sms_user')->id, 'parent');
                                    }
                                }
                            @endphp
                            @if($unreadCount > 0)
                                <span style="position: absolute; top: -2px; right: -2px; background: #dc2626; color: white; border-radius: 9999px; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 600;">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    @endif
                <div class="sms-user-menu">
                    <div class="sms-user-avatar">
                        {{ strtoupper(substr(session('sms_user')->name ?? 'U', 0, 1)) }}
                    </div>
                    <span>{{ session('sms_user')->name ?? 'User' }}</span>
                </div>
                <form method="POST" action="{{ route('sms.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="sms-logout-btn" aria-label="Logout">
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
