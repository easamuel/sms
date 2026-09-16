<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo Access - ES-SCHOOLS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --navy: #1e3a8a;
            --navy-dark: #1e40af;
            --green: #10b981;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-900: #0f172a;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .container {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            max-width: 900px;
            width: 100%;
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-dark) 100%);
            color: var(--white);
            padding: 2.5rem 2rem;
            text-align: center;
        }
        
        .header .logo {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }
        
        .header h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            font-size: 0.9375rem;
            opacity: 0.95;
        }
        
        .badge {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.375rem 0.875rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 600;
        }
        
        .content {
            padding: 2.5rem 2rem;
        }
        
        .content h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }
        
        .content p {
            color: var(--gray-600);
            font-size: 0.9375rem;
            margin-bottom: 2rem;
        }
        
        .role-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .role-btn {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem 1.5rem;
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            color: var(--gray-900);
            width: 100%;
            text-align: left;
        }
        
        .role-btn:hover {
            border-color: var(--navy);
            background: rgba(30, 58, 138, 0.05);
            transform: translateX(4px);
        }
        
        .role-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
            color: var(--white);
        }
        
        .role-btn[data-role="admin"] .role-icon {
            background: linear-gradient(135deg, var(--navy), var(--navy-dark));
        }
        
        .role-btn[data-role="teacher"] .role-icon {
            background: linear-gradient(135deg, var(--green), #059669);
        }
        
        .role-btn[data-role="student"] .role-icon {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }
        
        .role-btn[data-role="parent"] .role-icon {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }
        
        .role-btn[data-role="accountant"] .role-icon {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
        
        .role-info {
            flex: 1;
            min-width: 0;
        }
        
        .role-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--gray-900);
        }
        
        .role-desc {
            font-size: 0.875rem;
            color: var(--gray-600);
        }
        
        .role-arrow {
            color: var(--gray-600);
            transition: transform 0.2s;
        }
        
        .role-btn:hover .role-arrow {
            transform: translateX(4px);
            color: var(--navy);
        }
        
        .footer-links {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-200);
            text-align: center;
        }
        
        .footer-links a {
            color: var(--navy);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            margin: 0 0.75rem;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
        
        /* Mobile */
        @media (max-width: 640px) {
            body {
                padding: 0;
                align-items: flex-start;
            }
            
            .container {
                border-radius: 0;
                min-height: 100vh;
                max-width: 100%;
            }
            
            .header {
                padding: 2rem 1.5rem;
            }
            
            .header h1 {
                font-size: 1.5rem;
            }
            
            .header p {
                font-size: 0.875rem;
            }
            
            .content {
                padding: 2rem 1.5rem;
            }
            
            .content h2 {
                font-size: 1.25rem;
            }
            
            .role-buttons {
                gap: 0.875rem;
            }
            
            .role-btn {
                padding: 1rem 1.25rem;
                width: 100%;
                flex-wrap: nowrap;
            }
            
            .role-icon {
                width: 44px;
                height: 44px;
                font-size: 1.125rem;
                flex-shrink: 0;
            }
            
            .role-info {
                flex: 1;
                min-width: 0;
            }
            
            .role-title {
                font-size: 1rem;
            }
            
            .role-desc {
                font-size: 0.8125rem;
            }
            
            .role-arrow {
                flex-shrink: 0;
            }
            
            .footer-links {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .footer-links a {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: 100%;">
                    <circle cx="32" cy="32" r="30" fill="rgba(255,255,255,0.2)"/>
                    <path d="M32 18L20 24L32 30L44 24L32 18Z" fill="white" opacity="0.95"/>
                    <path d="M20 24V36C20 36 24 40 32 40C40 40 44 36 44 36V24" stroke="white" stroke-width="2" fill="none"/>
                    <rect x="24" y="38" width="16" height="12" rx="2" fill="white" opacity="0.9"/>
                    <line x1="28" y1="42" x2="36" y2="42" stroke="#10b981" stroke-width="1.5"/>
                    <line x1="28" y1="45" x2="36" y2="45" stroke="#10b981" stroke-width="1.5"/>
                </svg>
            </div>
            <h1>Try ES-SCHOOLS</h1>
            <p>Experience our platform with demo accounts</p>
            <div class="badge">
                <i class="fas fa-flask"></i> Demo Mode
            </div>
        </div>
        
        <div class="content">
            <h2>Choose Your Role</h2>
            <p>Select a role to explore the platform</p>
            
            <div class="role-buttons">
                <form method="POST" action="{{ route('school-management.demo-login.submit') }}" style="display: contents;">
                    @csrf
                    <input type="hidden" name="role" value="admin">
                    <button type="submit" class="role-btn" data-role="admin">
                        <div class="role-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="role-info">
                            <div class="role-title">School Administrator</div>
                            <div class="role-desc">Full system access and management</div>
                        </div>
                        <div class="role-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </button>
                </form>
                
                <form method="POST" action="{{ route('school-management.demo-login.submit') }}" style="display: contents;">
                    @csrf
                    <input type="hidden" name="role" value="teacher">
                    <button type="submit" class="role-btn" data-role="teacher">
                        <div class="role-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="role-info">
                            <div class="role-title">Teacher</div>
                            <div class="role-desc">Manage classes, exams, and results</div>
                        </div>
                        <div class="role-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </button>
                </form>
                
                <form method="POST" action="{{ route('school-management.demo-login.submit') }}" style="display: contents;">
                    @csrf
                    <input type="hidden" name="role" value="student">
                    <button type="submit" class="role-btn" data-role="student">
                        <div class="role-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="role-info">
                            <div class="role-title">Student</div>
                            <div class="role-desc">View results, attendance, and assignments</div>
                        </div>
                        <div class="role-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </button>
                </form>
                
                <form method="POST" action="{{ route('school-management.demo-login.submit') }}" style="display: contents;">
                    @csrf
                    <input type="hidden" name="role" value="parent">
                    <button type="submit" class="role-btn" data-role="parent">
                        <div class="role-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="role-info">
                            <div class="role-title">Parent</div>
                            <div class="role-desc">Monitor your child's progress</div>
                        </div>
                        <div class="role-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </button>
                </form>
                
                <form method="POST" action="{{ route('school-management.demo-login.submit') }}" style="display: contents;">
                    @csrf
                    <input type="hidden" name="role" value="accountant">
                    <button type="submit" class="role-btn" data-role="accountant">
                        <div class="role-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div class="role-info">
                            <div class="role-title">Accountant</div>
                            <div class="role-desc">Manage fees and financial records</div>
                        </div>
                        <div class="role-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </button>
                </form>
            </div>
            
            <div class="footer-links">
                <a href="{{ route('login') }}">Go to Login</a>
                <a href="{{ route('home') }}">Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>
