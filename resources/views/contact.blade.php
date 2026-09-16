<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - ES-SCHOOLS</title>
    <meta name="description" content="Get in touch with ES-SCHOOLS. We're here to help you transform your school administration with our premium management platform.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
            --off-white: #f8fafc;
            --light-grey: #e2e8f0;
            --charcoal: #1e293b;
            --grey: #64748b;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--charcoal);
            line-height: 1.7;
            background: var(--off-white);
            -webkit-font-smoothing: antialiased;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }
        
        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--light-grey);
            z-index: 1000;
            padding: 1rem 0;
            box-shadow: 0 4px 20px rgba(30, 58, 138, 0.1);
        }
        
        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            transition: transform 0.2s;
        }
        
        .logo-link:hover {
            transform: scale(1.02);
        }
        
        .logo-icon {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
        }
        
        .logo-text {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: -0.02em;
        }
        
        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        
        .nav-links a {
            color: var(--charcoal);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9375rem;
            transition: color 0.2s;
        }
        
        .nav-links a:hover {
            color: var(--navy);
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.9375rem;
            font-family: 'Inter', sans-serif;
            min-height: 44px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--navy), var(--navy-dark));
            color: white;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
        }
        
        .btn-secondary {
            background: var(--green);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .btn-secondary:hover {
            background: var(--green-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        
        /* Contact Section */
        .contact-hero {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-dark) 100%);
            padding: 8rem 1.5rem 4rem;
            text-align: center;
            color: white;
        }
        
        .contact-hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: white;
        }
        
        .contact-hero p {
            font-size: 1.25rem;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .contact-section {
            max-width: 900px;
            margin: -3rem auto 4rem;
            padding: 0 1.5rem;
        }
        
        .contact-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--charcoal);
            font-size: 0.9375rem;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--light-grey);
            border-radius: 0.5rem;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            background: var(--off-white);
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--navy);
            background: white;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }
        
        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }
        
        .contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
            padding-top: 3rem;
            border-top: 1px solid var(--light-grey);
        }
        
        .contact-info-item {
            text-align: center;
        }
        
        .contact-info-item i {
            font-size: 2rem;
            color: var(--navy);
            margin-bottom: 1rem;
        }
        
        .contact-info-item h3 {
            font-size: 1.125rem;
            margin-bottom: 0.5rem;
            color: var(--charcoal);
        }
        
        .contact-info-item p {
            color: var(--grey);
            font-size: 0.9375rem;
        }
        
        @media (max-width: 768px) {
            .contact-hero h1 {
                font-size: 2rem;
            }
            
            .contact-card {
                padding: 2rem 1.5rem;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo-link">
                <svg class="logo-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                <span class="logo-text">ES-SCHOOLS</span>
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}#features">Features</a>
                <a href="{{ route('home') }}#who">Who It's For</a>
                <a href="{{ route('home') }}#why">Why Choose Us</a>
                <a href="{{ route('school-management.index') }}" class="btn btn-primary" style="background: linear-gradient(135deg, var(--navy), var(--navy-dark)); padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </a>
            </div>
        </div>
    </nav>
    
    <div class="contact-hero">
        <h1>Get In Touch</h1>
        <p>We're here to help you transform your school administration. Send us a message and we'll get back to you as soon as possible.</p>
    </div>
    
    <div class="contact-section">
        <div class="contact-card">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> Please correct the errors below and try again.
                </div>
            @endif
            
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name">Your Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email">Your Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject *</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required>
                    @error('subject')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="message">Your Message *</label>
                    <textarea id="message" name="message" required>{{ old('message') }}</textarea>
                    @error('message')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">
                        <i class="fas fa-paper-plane"></i>
                        Send Message
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary" style="background: var(--light-grey); color: var(--charcoal);">
                        <i class="fas fa-arrow-left"></i>
                        Back to Home
                    </a>
                </div>
            </form>
            
            <div class="contact-info">
                <div class="contact-info-item">
                    <i class="fas fa-envelope"></i>
                    <h3>Email Us</h3>
                    <p>help@extremesolutions.com.ng</p>
                </div>
                <div class="contact-info-item">
                    <i class="fas fa-clock"></i>
                    <h3>Response Time</h3>
                    <p>Within 24 hours</p>
                </div>
                <div class="contact-info-item">
                    <i class="fas fa-headset"></i>
                    <h3>Support</h3>
                    <p>We're here to help</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
