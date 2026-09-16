<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - ES-SCHOOLS | Premium School Management Platform</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --navy: #1e3a8a;
            --navy-dark: #1e40af;
            --navy-light: #3b82f6;
            --green: #10b981;
            --green-dark: #059669;
            --green-light: #34d399;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #0f172a;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--gray-50);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Background Pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(30, 58, 138, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(16, 185, 129, 0.05) 0%, transparent 50%);
            z-index: 0;
            pointer-events: none;
        }
        
        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1200px;
        }
        
        .login-container {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.08);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 600px;
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Left Side - Illustration */
        .login-left {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-dark) 100%);
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }
        
        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 8s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.1); opacity: 0.5; }
        }
        
        .login-left-content {
            position: relative;
            z-index: 1;
            text-align: center;
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.8s ease-out 0.2s both;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-logo-wrapper {
            margin-bottom: 2rem;
        }
        
        .login-logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 2rem;
            color: var(--white);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            animation: logoFloat 3s ease-in-out infinite;
        }
        
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .login-left h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
            color: var(--white);
        }
        
        .login-left p {
            font-size: 1rem;
            opacity: 0.95;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        
        .login-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .login-feature {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            transition: transform 0.2s, background 0.2s;
        }
        
        .login-feature:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .login-feature-icon {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        
        .login-feature-text {
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        /* Right Side - Form */
        .login-right {
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: fadeIn 0.8s ease-out 0.4s both;
        }
        
        .login-header {
            margin-bottom: 2rem;
        }
        
        .login-header h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }
        
        .login-header p {
            color: var(--gray-600);
            font-size: 0.9375rem;
        }
        
        .login-form {
            width: 100%;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }
        
        .form-label span.required {
            color: #dc2626;
        }
        
        .role-selection {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
        }
        
        .role-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.875rem 0.75rem;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            background: var(--gray-50);
            font-weight: 500;
            color: var(--gray-700);
            font-size: 0.875rem;
            min-height: 44px;
        }
        
        .role-label:hover {
            border-color: var(--navy-light);
            background: rgba(30, 58, 138, 0.05);
        }
        
        .role-label input[type="radio"] {
            margin: 0;
            cursor: pointer;
            width: 18px;
            height: 18px;
            accent-color: var(--navy);
        }
        
        .role-label:has(input[type="radio"]:checked) {
            border-color: var(--navy);
            background: rgba(30, 58, 138, 0.1);
            color: var(--navy);
        }
        
        .form-input-group {
            position: relative;
        }
        
        .form-input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
            z-index: 1;
        }
        
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.2s;
            background: var(--white);
            color: var(--gray-900);
            min-height: 44px;
            font-family: 'Inter', sans-serif;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--navy);
            box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.1);
        }
        
        .form-input::placeholder {
            color: var(--gray-400);
        }
        
        .form-error {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        .login-btn {
            width: 100%;
            padding: 0.875rem 1.5rem;
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-dark) 100%);
            color: var(--white);
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            min-height: 48px;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
            position: relative;
            overflow: hidden;
        }
        
        .login-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 58, 138, 0.35);
        }
        
        .login-btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        .login-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .login-btn i {
            position: relative;
            z-index: 1;
        }
        
        .login-btn span {
            position: relative;
            z-index: 1;
        }
        
        .login-help {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-200);
        }
        
        .login-help p {
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        
        .login-help a {
            color: var(--navy);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        
        .login-help a:hover {
            color: var(--navy-dark);
            text-decoration: underline;
        }
        
        /* Mobile Responsive */
        @media (max-width: 968px) {
            body {
                padding: 0.5rem;
                align-items: flex-start;
                padding-top: 1rem;
            }
            
            .login-container {
                grid-template-columns: 1fr;
                border-radius: 12px;
                min-height: auto;
            }
            
            .login-left {
                padding: 2rem 1.5rem;
                min-height: 280px;
            }
            
            .login-logo {
                width: 64px;
                height: 64px;
                font-size: 1.5rem;
            }
            
            .login-left h1 {
                font-size: 1.5rem;
                margin-bottom: 0.75rem;
            }
            
            .login-left p {
                font-size: 0.9375rem;
                margin-bottom: 1.5rem;
            }
            
            .login-features {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
                margin-top: 1.5rem;
            }
            
            .login-feature {
                padding: 0.625rem;
            }
            
            .login-feature-icon {
                width: 32px;
                height: 32px;
                font-size: 0.875rem;
            }
            
            .login-feature-text {
                font-size: 0.8125rem;
            }
            
            .login-right {
                padding: 2rem 1.5rem;
            }
            
            .login-header h2 {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 640px) {
            body {
                padding: 0;
            }
            
            .login-wrapper {
                width: 100%;
            }
            
            .login-container {
                border-radius: 0;
                min-height: 100vh;
            }
            
            .login-left {
                padding: 2rem 1.25rem;
                min-height: 240px;
            }
            
            .login-logo {
                width: 56px;
                height: 56px;
                font-size: 1.25rem;
            }
            
            .login-left h1 {
                font-size: 1.375rem;
            }
            
            .login-left p {
                font-size: 0.875rem;
            }
            
            .login-features {
                grid-template-columns: 1fr;
                gap: 0.625rem;
            }
            
            .login-right {
                padding: 1.5rem 1.25rem;
            }
            
            .login-header {
                margin-bottom: 1.5rem;
            }
            
            .login-header h2 {
                font-size: 1.375rem;
            }
            
            .login-header p {
                font-size: 0.875rem;
            }
            
            .role-selection {
                grid-template-columns: 1fr;
                gap: 0.625rem;
            }
            
            .role-label {
                padding: 0.875rem 1rem;
                justify-content: flex-start;
            }
            
            .form-group {
                margin-bottom: 1.25rem;
            }
            
            .form-label {
                font-size: 0.8125rem;
            }
            
            .login-help {
                margin-top: 1.5rem;
                padding-top: 1.25rem;
            }
        }
        
        @media (max-width: 390px) {
            .login-left {
                padding: 1.5rem 1rem;
                min-height: 200px;
            }
            
            .login-right {
                padding: 1.25rem 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <!-- Left Side - Branding -->
            <div class="login-left">
                <div class="login-left-content">
                    <div class="login-logo-wrapper">
                        <div class="login-logo">
                            <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: 100%;">
                                <circle cx="32" cy="32" r="30" fill="rgba(255,255,255,0.2)"/>
                                <path d="M32 18L20 24L32 30L44 24L32 18Z" fill="white" opacity="0.95"/>
                                <path d="M20 24V36C20 36 24 40 32 40C40 40 44 36 44 36V24" stroke="white" stroke-width="2" fill="none"/>
                                <rect x="24" y="38" width="16" height="12" rx="2" fill="white" opacity="0.9"/>
                                <line x1="28" y1="42" x2="36" y2="42" stroke="#10b981" stroke-width="1.5"/>
                                <line x1="28" y1="45" x2="36" y2="45" stroke="#10b981" stroke-width="1.5"/>
                            </svg>
                        </div>
                    </div>
                    <h1>ES-SCHOOLS</h1>
                    <p>Access your dashboard, manage records, and stay connected with your school community.</p>
                    
                    <div class="login-features">
                        <div class="login-feature">
                            <div class="login-feature-icon">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div class="login-feature-text">Track Attendance</div>
                        </div>
                        <div class="login-feature">
                            <div class="login-feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="login-feature-text">View Results</div>
                        </div>
                        <div class="login-feature">
                            <div class="login-feature-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="login-feature-text">Assignments</div>
                        </div>
                        <div class="login-feature">
                            <div class="login-feature-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="login-feature-text">Timetable</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Login Form -->
            <div class="login-right">
                <div class="login-header">
                    <h2>Welcome Back</h2>
                    <p>Sign in to access your dashboard</p>
                </div>
                
                <?php if(session('error')): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div><?php echo e(session('error')); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <div><?php echo e(session('success')); ?></div>
                </div>
                <?php endif; ?>
                
                <form method="POST" action="<?php echo e(route('login.submit')); ?>" class="login-form" id="loginForm">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Hidden field to ensure role is always submitted -->
                    <input type="hidden" name="role_fallback" id="role-fallback" value="<?php echo e(old('role', 'admin')); ?>">
                    
                    <!-- Role Selection -->
                    <div class="form-group">
                        <label class="form-label">I am a <span class="required">*</span></label>
                        <div class="role-selection">
                            <label for="role-admin" class="role-label">
                                <input type="radio" name="role" value="admin" <?php echo e(old('role', 'admin') === 'admin' ? 'checked' : ''); ?> required id="role-admin">
                                <span>Admin</span>
                            </label>
                            <label for="role-teacher" class="role-label">
                                <input type="radio" name="role" value="teacher" <?php echo e(old('role') === 'teacher' ? 'checked' : ''); ?> required id="role-teacher">
                                <span>Teacher</span>
                            </label>
                            <label for="role-student" class="role-label">
                                <input type="radio" name="role" value="student" <?php echo e(old('role') === 'student' ? 'checked' : ''); ?> required id="role-student">
                                <span>Student</span>
                            </label>
                            <label for="role-parent" class="role-label">
                                <input type="radio" name="role" value="parent" <?php echo e(old('role') === 'parent' ? 'checked' : ''); ?> required id="role-parent">
                                <span>Parent</span>
                            </label>
                        </div>
                        <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span><?php echo e($message); ?></span>
                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" id="identifier-label">Admin Email</label>
                        <div class="form-input-group">
                            <i class="fas fa-shield-alt form-input-icon" id="identifier-icon"></i>
                            <input 
                                type="text" 
                                name="identifier" 
                                id="identifier-input"
                                class="form-input" 
                                placeholder="Enter Admin Email (e.g. admin@demo.com)"
                                value="<?php echo e(old('identifier')); ?>"
                                required
                                autofocus
                            >
                        </div>
                        <?php $__errorArgs = ['identifier'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span><?php echo e($message); ?></span>
                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="form-input-group">
                            <i class="fas fa-lock form-input-icon"></i>
                            <input 
                                type="password" 
                                name="password" 
                                class="form-input" 
                                placeholder="Enter your password"
                                required
                            >
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span><?php echo e($message); ?></span>
                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <button type="submit" class="login-btn" id="loginBtn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Sign In</span>
                    </button>
                </form>
                
                <!-- 1-Click Role Demo Access (Pitch Mode) -->
                <div class="demo-quick-access" style="margin-top: 1.75rem; padding: 1.25rem; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <div style="text-align: center; margin-bottom: 0.875rem;">
                        <span style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; color: #64748b;">Instant Pitch Mode</span>
                        <h3 style="font-size: 1rem; font-weight: 700; color: #1e293b; margin-top: 0.15rem;">1-Click Role Demo Access</h3>
                        <p style="font-size: 0.775rem; color: #64748b;">Instant login for school pitch demonstrations</p>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.625rem;">
                        <form method="POST" action="<?php echo e(route('school-management.demo-login.submit')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="role" value="admin">
                            <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.625rem 0.5rem; background: #1e3a8a; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 0.8rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                <i class="fas fa-shield-alt"></i>
                                <span>Admin Demo</span>
                            </button>
                        </form>
                        <form method="POST" action="<?php echo e(route('school-management.demo-login.submit')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="role" value="teacher">
                            <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.625rem 0.5rem; background: #059669; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 0.8rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <span>Teacher Demo</span>
                            </button>
                        </form>
                        <form method="POST" action="<?php echo e(route('school-management.demo-login.submit')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="role" value="student">
                            <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.625rem 0.5rem; background: #7c3aed; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 0.8rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                <i class="fas fa-user-graduate"></i>
                                <span>Student Demo</span>
                            </button>
                        </form>
                        <form method="POST" action="<?php echo e(route('school-management.demo-login.submit')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="role" value="parent">
                            <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.625rem 0.5rem; background: #d97706; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 0.8rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                <i class="fas fa-user-friends"></i>
                                <span>Parent Demo</span>
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="login-help">
                    <p>
                        Need help? <a href="<?php echo e(route('contact')); ?>">Contact Support</a>
                    </p>
                    <p>
                        <a href="<?php echo e(route('home')); ?>">← Back to Home</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleInputs = document.querySelectorAll('input[name="role"]');
            const identifierLabel = document.getElementById('identifier-label');
            const identifierInput = document.getElementById('identifier-input');
            const identifierIcon = document.getElementById('identifier-icon');
            const loginBtn = document.getElementById('loginBtn');
            const loginForm = document.getElementById('loginForm');
            
            function updateFormForRole(role) {
                if (role === 'admin') {
                    identifierLabel.textContent = 'Admin Email';
                    identifierInput.placeholder = 'Enter Admin Email (e.g. admin@demo.com)';
                    identifierIcon.className = 'fas fa-shield-alt form-input-icon';
                } else if (role === 'student') {
                    identifierLabel.textContent = 'Student ID';
                    identifierInput.placeholder = 'Enter your Student ID (e.g. STU-00001)';
                    identifierIcon.className = 'fas fa-id-card form-input-icon';
                } else if (role === 'teacher') {
                    identifierLabel.textContent = 'Employee ID or Email';
                    identifierInput.placeholder = 'Enter your Employee ID or Email';
                    identifierIcon.className = 'fas fa-user-tie form-input-icon';
                } else if (role === 'parent') {
                    identifierLabel.textContent = 'Email or Phone';
                    identifierInput.placeholder = 'Enter your Email or Phone Number';
                    identifierIcon.className = 'fas fa-user form-input-icon';
                }
            }
            
            roleInputs.forEach(input => {
                input.addEventListener('change', function() {
                    updateFormForRole(this.value);
                    const fallbackField = document.getElementById('role-fallback');
                    if (fallbackField) {
                        fallbackField.value = this.value;
                    }
                });
            });
            
            // Initialize with selected role
            const selectedRole = document.querySelector('input[name="role"]:checked');
            if (selectedRole) {
                updateFormForRole(selectedRole.value);
                const fallbackField = document.getElementById('role-fallback');
                if (fallbackField) {
                    fallbackField.value = selectedRole.value;
                }
            }
            
            // Form submission with loading state
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    const checkedRole = document.querySelector('input[name="role"]:checked');
                    if (checkedRole) {
                        const fallbackField = document.getElementById('role-fallback');
                        if (fallbackField) {
                            fallbackField.value = checkedRole.value;
                        }
                    }
                    
                    // Show loading state
                    if (loginBtn) {
                        loginBtn.disabled = true;
                        loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Signing In...</span>';
                    }
                });
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\User\Documents\SMS_EXTRACTED\resources\views/school-management/authorized-login.blade.php ENDPATH**/ ?>