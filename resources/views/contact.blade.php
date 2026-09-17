<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - ES-SCHOOLS | School Consultation & Support</title>
    <meta name="description" content="Get in touch with ES-SCHOOLS. Speak with our Nigerian school technology specialists, request a free digitization audit, or get instant support via WhatsApp or email.">
    <meta name="keywords" content="ES-SCHOOLS contact, Nigerian school management support, school portal consultation, Lagos school software, ExtremeSolutions Nigeria">
    
    <!-- Favicon & Icons -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary: #1e3a8a;
            --primary-dark: #172554;
            --primary-light: #2563eb;
            --accent-green: #10b981;
            --accent-green-dark: #059669;
            --bg-body: #f8fafc;
            --border-color: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #475569;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 16px -2px rgba(15, 23, 42, 0.08);
            --shadow-lg: 0 12px 32px -4px rgba(15, 23, 42, 0.12);
        }
        
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-main);
            background-color: var(--bg-body);
            line-height: 1.65;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        h1, h2, h3, h4 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text-main);
        }

        /* Top Announcement Bar */
        .top-bar {
            background: linear-gradient(90deg, #172554, #1e3a8a, #059669);
            color: #ffffff;
            padding: 0.45rem 1rem;
            font-size: 0.82rem;
            text-align: center;
            font-weight: 600;
        }

        .top-bar a {
            color: #34d399;
            text-decoration: underline;
            margin-left: 0.35rem;
        }
        
        /* Unified Navbar */
        .navbar {
            position: sticky;
            top: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            z-index: 1000;
            padding: 0.85rem 0;
        }
        
        .nav-container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-link {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
            transition: transform 0.2s;
        }
        
        .logo-link:hover {
            transform: scale(1.02);
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
        }
        
        .logo-text {
            font-family: 'Poppins', sans-serif;
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.02em;
        }

        .logo-badge {
            background: #dbeafe;
            color: #1e40af;
            font-size: 0.65rem;
            padding: 0.15rem 0.45rem;
            border-radius: 6px;
            font-weight: 700;
            text-transform: uppercase;
        }
        
        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.75rem;
        }
        
        .nav-links a {
            color: var(--text-main);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.92rem;
            transition: color 0.2s;
        }
        
        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-btn-audit {
            background: var(--accent-green);
            color: #ffffff !important;
            padding: 0.55rem 1.25rem;
            border-radius: 8px;
            font-weight: 700 !important;
            font-size: 0.88rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            transition: all 0.2s;
        }

        .nav-btn-audit:hover {
            background: var(--accent-green-dark);
            transform: translateY(-2px);
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.35rem;
            color: var(--text-main);
            cursor: pointer;
        }

        .mobile-menu {
            display: none;
            flex-direction: column;
            gap: 1rem;
            background: #ffffff;
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .mobile-menu.active {
            display: flex;
        }
        
        /* Hero */
        .contact-hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 4rem 1.5rem 5rem;
            text-align: center;
            position: relative;
        }
        
        .contact-hero h1 {
            font-size: 2.75rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 0.75rem;
        }
        
        .contact-hero p {
            font-size: 1.15rem;
            opacity: 0.92;
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        /* Contact Section */
        .contact-section {
            max-width: 1100px;
            margin: -3.5rem auto 4rem;
            padding: 0 1.5rem;
            position: relative;
            z-index: 10;
            width: 100%;
        }

        .contact-layout {
            display: grid;
            grid-template-columns: 1fr 1.3fr;
            gap: 2rem;
        }
        
        /* Contact Sidebar */
        .contact-sidebar {
            background: #ffffff;
            border-radius: 20px;
            padding: 2.5rem 2rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .contact-sidebar h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #0f172a;
        }

        .contact-sidebar p.desc {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .channel-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .channel-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .channel-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
            flex-shrink: 0;
        }

        .channel-icon.phone {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
        }

        .channel-icon.whatsapp {
            background: #25d366;
        }

        .channel-icon.email {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .channel-icon.web {
            background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        }

        .channel-info h4 {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.2rem;
        }

        .channel-info a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .channel-info a:hover {
            text-decoration: underline;
        }

        .channel-info p {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .whatsapp-cta-card {
            margin-top: 2rem;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 14px;
            padding: 1.25rem;
            text-align: center;
        }

        .whatsapp-cta-card a {
            background: #25d366;
            color: white;
            padding: 0.75rem 1.25rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.75rem;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
            transition: all 0.2s;
        }

        .whatsapp-cta-card a:hover {
            background: #1eb855;
            transform: translateY(-2px);
        }
        
        /* Contact Form Card */
        .contact-card {
            background: white;
            border-radius: 20px;
            padding: 3rem 2.5rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
        }

        .contact-card h2 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
            color: #0f172a;
        }

        .contact-card p.form-sub {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.35rem;
        }
        
        .form-group label {
            display: block;
            font-weight: 700;
            margin-bottom: 0.45rem;
            color: #1e293b;
            font-size: 0.9rem;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.2s;
            background: #ffffff;
            color: var(--text-main);
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.12);
        }
        
        .form-group textarea {
            min-height: 130px;
            resize: vertical;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .btn-submit {
            background: var(--accent-green);
            color: white;
            padding: 0.95rem 2rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
            transition: all 0.2s;
            flex: 1;
        }

        .btn-submit:hover {
            background: var(--accent-green-dark);
            transform: translateY(-2px);
        }
        
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        
        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Footer */
        .footer {
            background: #0b1329;
            color: #94a3b8;
            padding: 3rem 0 2rem;
            border-top: 1px solid #1e293b;
            margin-top: auto;
        }

        .footer-inner {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 0.875rem;
        }

        .footer-inner a {
            color: #cbd5e1;
            text-decoration: none;
        }

        .footer-inner a:hover {
            color: #ffffff;
        }

        @media (max-width: 968px) {
            .contact-layout {
                grid-template-columns: 1fr;
            }
            .nav-links {
                display: none;
            }
            .mobile-toggle {
                display: block;
            }
            .contact-hero {
                padding: 3rem 1.25rem 4.5rem;
            }
            .contact-hero h1 {
                font-size: 2.15rem;
            }
            .contact-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="top-bar">
        <span><i class="fab fa-whatsapp"></i> Instant WhatsApp Consultation: <a href="https://wa.me/2349052585622?text=Hello%20ES-SCHOOLS%2C%20I%20want%20to%20inquire%20about%20your%20School%20Management%20Platform." target="_blank" rel="noopener noreferrer"><strong>09052585622</strong></a> (WhatsApp Only, No Calls) | Email: <strong>sms@extremesolutions.com.ng</strong></span>
    </div>

    <!-- Navigation (Unified, Straight, No Login Button) -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="/" class="logo-link">
                <svg class="logo-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="32" cy="32" r="30" fill="url(#navGrad)"/>
                    <path d="M32 18L20 24L32 30L44 24L32 18Z" fill="white" opacity="0.95"/>
                    <path d="M20 24V36C20 36 24 40 32 40C40 40 44 36 44 36V24" stroke="white" stroke-width="2" fill="none"/>
                    <rect x="24" y="38" width="16" height="12" rx="2" fill="white" opacity="0.9"/>
                    <line x1="28" y1="42" x2="36" y2="42" stroke="#10b981" stroke-width="1.5"/>
                    <line x1="28" y1="45" x2="36" y2="45" stroke="#10b981" stroke-width="1.5"/>
                    <defs>
                        <linearGradient id="navGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#1e3a8a"/>
                            <stop offset="100%" style="stop-color:#10b981"/>
                        </linearGradient>
                    </defs>
                </svg>
                <span class="logo-text">ES-SCHOOLS</span>
                <span class="logo-badge">SMS</span>
            </a>

            <div class="nav-links">
                <a href="/">Home</a>
                <a href="/#demos">Live Demos</a>
                <a href="/#plan">How It Works</a>
                <a href="/#why">Why ES-SCHOOLS</a>
                <a href="{{ route('admission.create') }}" style="color: #059669; font-weight: 700; display: inline-flex; align-items: center; gap: 0.4rem; background: #ecfdf5; padding: 0.35rem 0.85rem; border-radius: 20px; border: 1px solid #a7f3d0;">
                    <i class="fas fa-user-plus"></i> Online Admission <span style="background: #10b981; color: white; font-size: 0.65rem; padding: 0.1rem 0.4rem; border-radius: 8px;">OPEN</span>
                </a>
                <a href="/#audit" class="nav-btn-audit">
                    <i class="fas fa-calendar-check"></i> Free School Audit
                </a>
            </div>

            <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="mobile-menu" id="mobileMenu">
            <a href="/">Home</a>
            <a href="/#demos"><i class="fas fa-play-circle" style="color: #3b82f6;"></i> Interactive Live Demos</a>
            <a href="/#plan"><i class="fas fa-tasks" style="color: #8b5cf6;"></i> 3-Step Plan</a>
            <a href="/#why"><i class="fas fa-shield-alt" style="color: #10b981;"></i> Why ES-SCHOOLS</a>
            <a href="{{ route('admission.create') }}" style="color: #059669; font-weight: 700;">
                <i class="fas fa-user-plus"></i> Online Admission [OPEN]
            </a>
            <a href="/#audit" class="nav-btn-audit" style="justify-content: center;">
                <i class="fas fa-calendar-check"></i> Request Free School Audit
            </a>
        </div>
    </nav>
    
    <div class="contact-hero">
        <h1>Connect with ES-SCHOOLS</h1>
        <p>Ready to automate tuition fee recovery, eliminate paper records, and modernize your school? We are here to help you get started.</p>
    </div>
    
    <div class="contact-section">
        <div class="contact-layout">
            <!-- Sidebar with Official Channels -->
            <div class="contact-sidebar">
                <div>
                    <h3>Official Channels</h3>
                    <p class="desc">Reach out directly to our Lagos and national deployment desks for consultations, audits, or technical support.</p>
                    
                    <div class="channel-list">
                        <div class="channel-item">
                            <div class="channel-icon whatsapp">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div class="channel-info">
                                <h4>Official WhatsApp Desk</h4>
                                <a href="https://wa.me/2349052585622?text=Hello%20ES-SCHOOLS%20Team%2C%20I%20would%20like%20to%20inquire%20about%20the%20School%20Management%20Platform%20and%20Demo." target="_blank" rel="noopener noreferrer">09052585622</a>
                                <p>Strictly WhatsApp (No Phone Calls) &bull; Mon - Fri</p>
                            </div>
                        </div>

                        <div class="channel-item">
                            <div class="channel-icon whatsapp">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="channel-info">
                                <h4>Instant Digitization Inquiries</h4>
                                <a href="https://wa.me/2349052585622?text=Hello%20ES-SCHOOLS%20Team%2C%20I%20would%20like%20to%20request%20a%20Free%20School%20Digitization%20Audit%20and%20Demo." target="_blank" rel="noopener noreferrer">09052585622</a>
                                <p>Fastest response (Usually under 10 mins)</p>
                            </div>
                        </div>

                        <div class="channel-item">
                            <div class="channel-icon email">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="channel-info">
                                <h4>Official Support Email</h4>
                                <a href="mailto:sms@extremesolutions.com.ng">sms@extremesolutions.com.ng</a>
                                <p>Inquiries, proposals &amp; data rosters</p>
                            </div>
                        </div>

                        <div class="channel-item">
                            <div class="channel-icon web">
                                <i class="fas fa-globe"></i>
                            </div>
                            <div class="channel-info">
                                <h4>Parent Corporation</h4>
                                <a href="https://extremesolutions.com.ng" target="_blank" rel="noopener noreferrer">ExtremeSolutions Nigeria</a>
                                <p>Enterprise Software &amp; Digital Solutions</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="whatsapp-cta-card">
                    <p style="font-weight: 700; color: #166534; font-size: 0.95rem;">Prefer chatting on WhatsApp?</p>
                    <p style="font-size: 0.85rem; color: #15803d; margin-top: 0.25rem;">Chat directly with an educational specialist right now.</p>
                    <a href="https://wa.me/2349052585622?text=Hello%20ES-SCHOOLS%20Team%2C%20I%20am%20a%20school%20proprietor%20and%20I%20would%20like%20to%20request%20a%20Free%20School%20Digitization%20Audit%20and%20Demo." target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-whatsapp"></i> WhatsApp: 09052585622
                    </a>
                </div>
            </div>

            <!-- Contact Form Card -->
            <div class="contact-card">
                <h2>Send an Official Message</h2>
                <p class="form-sub">Fill out the brief form below and our team will get back to you within 24 hours.</p>

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle" style="font-size: 1.25rem;"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle" style="font-size: 1.25rem;"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle" style="font-size: 1.25rem;"></i>
                        <span>Please correct the errors in the form and try again.</span>
                    </div>
                @endif
                
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="name">Your Name &amp; Title *</label>
                        <input type="text" id="name" name="name" placeholder="e.g. Mrs. Funke Adeleke (Proprietress)" value="{{ old('name') }}" required>
                        @error('name')
                            <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Your Email Address *</label>
                        <input type="email" id="email" name="email" placeholder="e.g. principal@yourschool.com" value="{{ old('email') }}" required>
                        @error('email')
                            <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject / Inquiry Type *</label>
                        <input type="text" id="subject" name="subject" placeholder="e.g. Request for Free 15-Minute School Audit &amp; Setup" value="{{ old('subject') }}" required>
                        @error('subject')
                            <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Your Message / School Details *</label>
                        <textarea id="message" name="message" placeholder="Tell us about your school (Name, Location, Approximate Student Population, and current challenges)..." required>{{ old('message') }}</textarea>
                        @error('message')
                            <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i>
                            <span>Send Message</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <p>&copy; {{ date('Y') }} ES-SCHOOLS by <a href="https://extremesolutions.com.ng" target="_blank" style="color: #34d399; font-weight: 600;">ExtremeSolutions Nigeria</a>. All rights reserved.</p>
            <div style="display: flex; gap: 1.25rem;">
                <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
                <a href="{{ route('terms-of-service') }}">Terms of Service</a>
                <a href="{{ route('cookie-policy') }}">Cookie Policy</a>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileToggle = document.getElementById('mobileToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileToggle && mobileMenu) {
                mobileToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>
