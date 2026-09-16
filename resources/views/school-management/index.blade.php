<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School Management System - Complete School Administration Platform</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        :root {
            --sms-primary: #6366f1;
            --sms-primary-dark: #4f46e5;
            --sms-primary-light: #818cf8;
            --sms-accent: #8b5cf6;
            --sms-success: #10b981;
            --sms-warning: #f59e0b;
            --sms-danger: #ef4444;
            --sms-gray-50: #f9fafb;
            --sms-gray-100: #f3f4f6;
            --sms-gray-200: #e5e7eb;
            --sms-gray-300: #d1d5db;
            --sms-gray-500: #6b7280;
            --sms-gray-600: #4b5563;
            --sms-gray-700: #374151;
            --sms-gray-800: #1f2937;
            --sms-gray-900: #111827;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #ffffff;
            color: var(--sms-gray-800);
            line-height: 1.6;
            overflow-x: hidden;
        }
        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--sms-gray-200);
            padding: 1rem 2rem;
            z-index: 1000;
            transition: all 0.3s;
        }
        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--sms-gray-900);
            text-decoration: none;
        }
        .nav-logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .nav-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        .nav-btn {
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.9375rem;
        }
        .nav-btn-secondary {
            color: var(--sms-gray-700);
            border: 1px solid var(--sms-gray-300);
        }
        .nav-btn-secondary:hover {
            background: var(--sms-gray-50);
            border-color: var(--sms-gray-400);
        }
        .nav-btn-primary {
            background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        .nav-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            color: white;
            padding: 8rem 2rem 6rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            margin-top: 73px;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        .hero-content {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            letter-spacing: -0.02em;
        }
        .hero p {
            font-size: 1.375rem;
            opacity: 0.95;
            margin-bottom: 2.5rem;
            font-weight: 400;
            line-height: 1.6;
        }
        .trust-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 999px;
            font-size: 0.9375rem;
            font-weight: 600;
            margin-bottom: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .hero-cta {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            padding: 1rem 2rem;
            border-radius: 12px;
            font-size: 1.0625rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background: white;
            color: var(--sms-primary);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.3);
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
        }
        /* Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        /* Demo Access Section */
        .demo-section {
            padding: 6rem 0;
            background: white;
        }
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--sms-gray-900);
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }
        .section-subtitle {
            font-size: 1.25rem;
            color: var(--sms-gray-600);
            max-width: 700px;
            margin: 0 auto;
        }
        .roles-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 3rem;
        }
        .role-card {
            background: white;
            border: 2px solid var(--sms-gray-200);
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .role-card:hover {
            transform: translateY(-4px);
            border-color: var(--sms-primary);
            box-shadow: 0 12px 24px -8px rgba(99, 102, 241, 0.2);
        }
        .role-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: white;
            margin-bottom: 1.25rem;
        }
        .role-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--sms-gray-900);
            margin-bottom: 0.5rem;
        }
        .role-description {
            font-size: 0.9375rem;
            color: var(--sms-gray-600);
            line-height: 1.6;
            min-height: 42px;
            margin-bottom: 1.5rem;
        }
        .credentials-box {
            background: var(--sms-gray-50);
            border: 1px solid var(--sms-gray-200);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .credential-row {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
        .credential-row:last-child {
            margin-bottom: 0;
        }
        .credential-label {
            font-weight: 600;
            min-width: 80px;
            color: var(--sms-gray-600);
        }
        .credential-value {
            font-family: 'Courier New', Consolas, monospace;
            background: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            flex: 1;
            color: var(--sms-gray-900);
            font-weight: 500;
        }
        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
            color: white;
            border: none;
            padding: 0.875rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
            margin-top: auto;
        }
        .login-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 16px rgba(99, 102, 241, 0.4);
        }
        /* Features Section */
        .features-section {
            padding: 6rem 0;
            background: var(--sms-gray-50);
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            margin-top: 3rem;
        }
        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            border: 1px solid var(--sms-gray-200);
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15);
        }
        .feature-icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }
        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--sms-gray-900);
        }
        .feature-card p {
            color: var(--sms-gray-600);
            font-size: 1rem;
            line-height: 1.6;
        }
        /* CTA Section */
        .cta-section {
            padding: 6rem 0;
            background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent));
            color: white;
            text-align: center;
        }
        .cta-content {
            max-width: 700px;
            margin: 0 auto;
        }
        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }
        .cta-section p {
            font-size: 1.25rem;
            opacity: 0.95;
            margin-bottom: 2.5rem;
        }
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-white {
            background: white;
            color: var(--sms-primary);
        }
        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2);
        }
        .btn-outline-white {
            background: transparent;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }
        .btn-outline-white:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
        }
        /* Footer */
        .footer {
            background: var(--sms-gray-900);
            color: var(--sms-gray-300);
            padding: 3rem 0 2rem;
        }
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 2rem;
        }
        .footer-section h4 {
            color: white;
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.125rem;
        }
        .footer-section p,
        .footer-section a {
            color: var(--sms-gray-400);
            text-decoration: none;
            font-size: 0.9375rem;
            line-height: 1.8;
        }
        .footer-section a:hover {
            color: white;
        }
        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid var(--sms-gray-800);
            color: var(--sms-gray-500);
            font-size: 0.875rem;
        }
        /* Responsive */
        @media (max-width: 1024px) {
            .roles-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.25rem;
            }
            .hero p {
                font-size: 1.125rem;
            }
            .section-title {
                font-size: 2rem;
            }
            .nav-container {
                padding: 0 1rem;
            }
            .nav-actions {
                gap: 0.5rem;
            }
            .nav-btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
            .hero {
                padding: 6rem 1rem 4rem;
            }
            .roles-grid,
            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('school-management.index') }}" class="nav-logo">
                <div class="nav-logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <span>School Management System</span>
            </a>
            <div class="nav-actions">
                <a href="{{ route('school-management.authorized-login') }}" class="nav-btn nav-btn-primary">
                    <i class="fas fa-rocket"></i> View Demo
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Explore Our School Management System Demo</h1>
            <p>Experience the complete solution for modern school administration</p>
            <div class="trust-badge">
                <i class="fas fa-check-circle"></i>
                <span>Fully Functional Demo | All Features Unlocked</span>
            </div>
            <div class="hero-cta">
                <a href="#demo-access" class="btn btn-primary">
                    <i class="fas fa-rocket"></i>
                    Get Started
                </a>
                <a href="#request-demo" class="btn btn-secondary">
                    <i class="fas fa-calendar-check"></i>
                    Request School Software
                </a>
            </div>
        </div>
    </section>

    <!-- Demo Access Section -->
    <section class="demo-section" id="demo-access">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Choose Your Role</h2>
                <p class="section-subtitle">Login with any of the roles below to explore role-specific features. All demo accounts use the same password for easy access.</p>
            </div>
            <div class="roles-grid">
                <!-- School Admin -->
                <div class="role-card">
                    <div class="role-icon" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <h3 class="role-name">School Admin</h3>
                    <p class="role-description">Manage students, teachers, fees, and daily operations</p>
                    <div class="credentials-box">
                        <div class="credential-row">
                            <span class="credential-label">Email:</span>
                            <span class="credential-value">admin@demo.com</span>
                        </div>
                        <div class="credential-row">
                            <span class="credential-label">Password:</span>
                            <span class="credential-value">demo123</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('school-management.demo-login.submit') }}" style="display: contents;">
                        @csrf
                        <input type="hidden" name="role" value="admin">
                        <button type="submit" class="login-btn">
                            <span>Login as School Admin</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>

                <!-- Teacher -->
                <div class="role-card">
                    <div class="role-icon" style="background: linear-gradient(135deg, #059669, #047857);">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3 class="role-name">Teacher</h3>
                    <p class="role-description">Mark attendance, manage exams, and track student progress</p>
                    <div class="credentials-box">
                        <div class="credential-row">
                            <span class="credential-label">Email:</span>
                            <span class="credential-value">teacher@demo.com</span>
                        </div>
                        <div class="credential-row">
                            <span class="credential-label">Password:</span>
                            <span class="credential-value">demo123</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('school-management.demo-login.submit') }}" style="display: contents;">
                        @csrf
                        <input type="hidden" name="role" value="teacher">
                        <button type="submit" class="login-btn">
                            <span>Login as Teacher</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>

                <!-- Student -->
                <div class="role-card">
                    <div class="role-icon" style="background: linear-gradient(135deg, #dc2626, #b91c1c);">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3 class="role-name">Student</h3>
                    <p class="role-description">View attendance, exam schedules, results, and notices</p>
                    <div class="credentials-box">
                        <div class="credential-row">
                            <span class="credential-label">Email:</span>
                            <span class="credential-value">student@demo.com</span>
                        </div>
                        <div class="credential-row">
                            <span class="credential-label">Password:</span>
                            <span class="credential-value">demo123</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('school-management.demo-login.submit') }}" style="display: contents;">
                        @csrf
                        <input type="hidden" name="role" value="student">
                        <button type="submit" class="login-btn">
                            <span>Login as Student</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>

                <!-- Parent -->
                <div class="role-card">
                    <div class="role-icon" style="background: linear-gradient(135deg, #ea580c, #c2410c);">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="role-name">Parent</h3>
                    <p class="role-description">Monitor child's attendance, academic performance, and fees</p>
                    <div class="credentials-box">
                        <div class="credential-row">
                            <span class="credential-label">Email:</span>
                            <span class="credential-value">parent@demo.com</span>
                        </div>
                        <div class="credential-row">
                            <span class="credential-label">Password:</span>
                            <span class="credential-value">demo123</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('school-management.demo-login.submit') }}" style="display: contents;">
                        @csrf
                        <input type="hidden" name="role" value="parent">
                        <button type="submit" class="login-btn">
                            <span>Login as Parent</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>

                <!-- Accountant -->
                <div class="role-card">
                    <div class="role-icon" style="background: linear-gradient(135deg, #0891b2, #0e7490);">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3 class="role-name">Accountant</h3>
                    <p class="role-description">Manage fee collection, payments, and financial reports</p>
                    <div class="credentials-box">
                        <div class="credential-row">
                            <span class="credential-label">Email:</span>
                            <span class="credential-value">accountant@demo.com</span>
                        </div>
                        <div class="credential-row">
                            <span class="credential-label">Password:</span>
                            <span class="credential-value">demo123</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('school-management.demo-login.submit') }}" style="display: contents;">
                        @csrf
                        <input type="hidden" name="role" value="accountant">
                        <button type="submit" class="login-btn">
                            <span>Login as Accountant</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Powerful Features for Modern Schools</h2>
                <p class="section-subtitle">Everything you need to manage your school efficiently and effectively</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>Smart Attendance</h3>
                    <p>Automated daily attendance tracking with instant parent notifications</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3>Exam Management</h3>
                    <p>Schedule exams, record marks, and generate detailed report cards</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3>Fee Collection</h3>
                    <p>Streamlined fee management with payment tracking and reminders</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>Comprehensive Reports</h3>
                    <p>Generate attendance, academic, and financial reports instantly</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3>Instant Notices</h3>
                    <p>Send announcements to students, teachers, and parents in seconds</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Mobile Friendly</h3>
                    <p>Access the system anywhere, anytime on any device</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="request-demo">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Transform Your School?</h2>
                <p>Experience the power of modern school management. Try our live demo or request a personalized demonstration for your institution.</p>
                <div class="cta-buttons">
                    <a href="#demo-access" class="btn btn-white">
                        <i class="fas fa-rocket"></i>
                        View Live Demo
                    </a>
                    <a href="mailto:support@schoolmanagement.com?subject=School Management System Demo Request" class="btn btn-outline-white">
                        <i class="fas fa-envelope"></i>
                        Request Demo
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>School Management System</h4>
                    <p>Complete, modern school administration platform designed to streamline operations and improve communication.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <p><a href="{{ route('school-management.index') }}">Home</a></p>
                    <p><a href="{{ route('school-management.demo-login') }}">Demo Login</a></p>
                    <p><a href="#request-demo">Request Demo</a></p>
                </div>
                <div class="footer-section">
                    <h4>Features</h4>
                    <p><a href="#features">Student Management</a></p>
                    <p><a href="#features">Teacher Portal</a></p>
                    <p><a href="#features">Parent Portal</a></p>
                    <p><a href="#features">Reports & Analytics</a></p>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <p>Email: support@schoolmanagement.com</p>
                    <p>Phone: +234 XXX XXX XXXX</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} School Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
