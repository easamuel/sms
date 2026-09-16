<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ES-SCHOOLS - Premium School Management Platform for Nigerian Schools</title>
    <meta name="description" content="Transform your school administration with ES-SCHOOLS. The comprehensive, modern platform trusted by schools across Nigeria and Africa. Streamline operations, engage parents, and empower your entire school community.">
    
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
            /* Brand Colors - Deep Navy + Fresh Green */
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
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            font-size: 16px;
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
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
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
        
        /* Hide logo text on tablet and mobile for better nav menu spacing */
        @media (max-width: 968px) {
            .logo-text {
                display: none;
            }
        }
        
        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        
        @media (max-width: 1024px) {
            .nav-links {
                gap: 1.25rem;
            }
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
            box-shadow: 0 4px 16px rgba(30, 58, 138, 0.35);
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(30, 58, 138, 0.45);
        }
        
        .btn-secondary {
            background: var(--green);
            color: white;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.35);
            border: none;
        }
        
        .btn-secondary:hover {
            background: var(--green-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(16, 185, 129, 0.45);
        }
        
        .btn-outline {
            background: transparent;
            color: var(--navy);
            border: 2px solid var(--navy);
        }
        
        .btn-outline:hover {
            background: var(--navy);
            color: white;
        }
        
        .nav-btn-login {
            background: white;
            color: var(--navy);
            padding: 0.625rem 1.5rem;
            font-size: 0.9375rem;
            font-weight: 600;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .nav-btn-login:hover {
            background: var(--off-white);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            color: var(--navy-dark);
        }
        
        .nav-btn-contact {
            background: white;
            color: var(--green-dark);
            padding: 0.625rem 1.5rem;
            font-size: 0.9375rem;
            font-weight: 600;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .nav-btn-contact:hover {
            background: var(--off-white);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            color: var(--green);
        }
        
        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding-top: 160px;
        }
        
        @media (max-width: 768px) {
            /* MOBILE: Hero as ONE unified container */
            .hero {
                padding-top: 0 !important;
                margin-top: 0 !important;
                min-height: auto !important;
                display: block !important;
                position: relative !important;
                overflow: hidden !important;
                background: #1e3a8a;
            }
            
            /* Hide slideshow on mobile - show only first slide as static */
            .hero-slideshow {
                position: relative !important;
                height: auto !important;
                min-height: auto !important;
                display: block !important;
            }
            
            /* Hide all slides except first */
            .hero-slide {
                position: relative !important;
                opacity: 1 !important;
                display: none !important;
                min-height: auto !important;
                background: none !important;
            }
            
            .hero-slide:first-child {
                display: block !important;
                background: #1e3a8a !important;
            }
            
            /* Remove all absolute positioning on mobile */
            .hero-slide::after {
                display: none !important;
            }
            
            /* Unified hero content container */
            .hero-content {
                position: relative !important;
                margin: 0 !important;
                padding: 6rem 1.25rem 3rem !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                justify-content: flex-start !important;
                text-align: center !important;
                width: 100% !important;
                max-width: 100% !important;
                min-height: auto !important;
            }
            
            .hero-slide-content {
                position: relative !important;
                opacity: 1 !important;
                visibility: visible !important;
                transform: none !important;
                pointer-events: auto !important;
                width: 100% !important;
                padding: 0 !important;
            }
            
            .hero-text {
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            
            .hero-text h1 {
                font-size: 1.75rem !important;
                line-height: 1.3 !important;
                margin-bottom: 1rem !important;
                color: #ffffff !important;
                font-weight: 700 !important;
            }
            
            .hero-text .subtitle {
                font-size: 1rem !important;
                line-height: 1.6 !important;
                margin-bottom: 1.75rem !important;
                color: #ffffff !important;
                font-weight: 400 !important;
            }
            
            .hero-buttons {
                margin-top: 0 !important;
                width: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                gap: 1rem !important;
            }
            
            .hero-cta {
                width: 100% !important;
                max-width: 320px !important;
                justify-content: center !important;
                margin: 0 !important;
            }
            
            .hero-indicators {
                display: none !important;
            }
        }
        
        @media (max-width: 480px) {
            .hero {
                padding-top: 0 !important;
            }
            
            .hero-content {
                padding: 4rem 1.25rem 3rem !important;
            }
            
            .hero-text h1 {
                font-size: 1.625rem !important;
            }
            
            .hero-text .subtitle {
                font-size: 0.9375rem !important;
            }
        }
        
        @media (max-width: 390px) {
            .hero-content {
                padding: 5rem 1rem 2.5rem !important;
            }
            
            .hero-text h1 {
                font-size: 1.5rem !important;
            }
        }
        
        @media (max-width: 480px) {
            .video-wrapper {
                min-height: 600px;
            }
            
            .animated-demo {
                min-height: 600px;
            }
            
            .demo-slide {
                min-height: 600px;
                padding: 2.5rem 1rem;
            }
        }
        
        .hero-slideshow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        
        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 2s ease-in-out;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }
        
        .hero-slide.active {
            opacity: 1;
            z-index: 2;
        }
        
        .hero-slide.active .hero-slide-content {
            opacity: 1 !important;
            transform: translateY(0) !important;
            visibility: visible !important;
            pointer-events: auto !important;
        }
        
        .hero-slide::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.85) 0%, rgba(30, 64, 175, 0.75) 100%);
            z-index: 1;
        }
        
        @media (max-width: 768px) {
            .hero-slide::after {
                display: none !important;
            }
            
            .hero-slide:first-child {
                background: #1e3a8a !important;
            }
        }
        
        .hero-slide:nth-child(1) {
            background-image: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&q=80');
        }
        
        .hero-slide:nth-child(2) {
            background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1920&q=80');
        }
        
        .hero-slide:nth-child(3) {
            background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920&q=80');
        }
        
        .hero-slide:nth-child(4) {
            background-image: url('https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=1920&q=80');
        }
        
        .hero-content {
            max-width: 900px;
            margin: 0 auto;
            padding: 8rem 1.5rem 4rem;
            text-align: center;
            position: relative;
            z-index: 10;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .hero-text {
            color: white;
        }
        
        .hero-slide-content {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
            visibility: hidden;
            pointer-events: none;
        }
        
        .hero-slide.active .hero-slide-content {
            opacity: 1 !important;
            transform: translateY(0) !important;
            visibility: visible !important;
            pointer-events: auto !important;
        }
        
        .hero-slide-content.active {
            opacity: 1 !important;
            transform: translateY(0) !important;
            visibility: visible !important;
            pointer-events: auto !important;
        }
        
        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: white;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
        }
        
        .hero-text .subtitle {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            opacity: 0.95;
            line-height: 1.7;
            font-weight: 400;
            text-shadow: 0 1px 10px rgba(0, 0, 0, 0.2);
        }
        
        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }
        
        .hero-cta {
            padding: 1rem 2.5rem;
            font-size: 1.125rem;
            font-weight: 600;
            background: var(--green);
            color: white;
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.4);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .hero-cta:hover {
            background: var(--green-dark);
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(16, 185, 129, 0.5);
        }
        
        .hero-indicators {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 0.75rem;
            z-index: 3;
        }
        
        .hero-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.6);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .hero-indicator.active {
            background: white;
            border-color: white;
            transform: scale(1.2);
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
        
        /* Features Section */
        .features {
            padding: 6rem 1.5rem;
            background: var(--white);
        }
        
        .container {
            max-width: 1280px;
            margin: 0 auto;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-header h2 {
            font-size: 2.75rem;
            margin-bottom: 1rem;
            color: var(--charcoal);
        }
        
        .section-header p {
            font-size: 1.125rem;
            color: var(--grey);
            max-width: 700px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
        }
        
        .feature-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 1rem;
            border: 1px solid var(--light-grey);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--navy), var(--green));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(30, 58, 138, 0.15);
            border-color: var(--navy);
        }
        
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        
        .feature-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--navy), var(--green));
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
            color: var(--charcoal);
        }
        
        .feature-card p {
            color: var(--grey);
            line-height: 1.7;
        }
        
        /* Who It's For Section */
        .who-section {
            padding: 6rem 1.5rem;
            background: var(--off-white);
        }
        
        .who-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .who-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 1rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        
        .who-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(30, 58, 138, 0.15);
        }
        
        .who-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--navy), var(--green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
            box-shadow: 0 8px 20px rgba(30, 58, 138, 0.3);
        }
        
        .who-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--charcoal);
        }
        
        .who-card p {
            color: var(--grey);
            line-height: 1.7;
        }
        
        /* Why Choose Section */
        .why-section {
            padding: 6rem 1.5rem;
            background: var(--white);
        }
        
        .why-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .why-item {
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
        }
        
        .why-icon {
            width: 48px;
            height: 48px;
            background: var(--green);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        
        .why-content h4 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            color: var(--charcoal);
        }
        
        .why-content p {
            color: var(--grey);
            line-height: 1.7;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 6rem 1.5rem;
            background: linear-gradient(135deg, var(--navy), var(--navy-dark));
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&q=80') center/cover;
            opacity: 0.1;
        }
        
        .cta-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .cta-section h2 {
            font-size: 2.75rem;
            margin-bottom: 1rem;
            color: white;
        }
        
        .cta-section p {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            opacity: 0.95;
        }
        
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        /* Video Section */
        .video-section {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-dark) 100%);
            padding: 6rem 1.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .video-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1920&q=80') center/cover;
            opacity: 0.1;
            z-index: 0;
        }
        
        .video-container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        .video-header {
            text-align: center;
            margin-bottom: 3rem;
            color: white;
        }
        
        .video-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: white;
        }
        
        .video-header p {
            font-size: 1.25rem;
            opacity: 0.95;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .video-wrapper {
            position: relative;
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            aspect-ratio: 16 / 9;
            min-height: 500px;
        }
        
        /* Animated Demo Styles */
        .animated-demo {
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .demo-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transform: translateX(50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            z-index: 1;
        }
        
        .demo-slide.active {
            opacity: 1;
            transform: translateX(0);
            z-index: 2;
        }
        
        .demo-content {
            text-align: center;
            color: white;
            max-width: 700px;
            animation: fadeInUp 0.6s ease-out;
        }
        
        .demo-character {
            margin-bottom: 2rem;
        }
        
        .character-avatar {
            width: 120px;
            height: 120px;
            margin: 0 auto;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            color: white;
            border: 4px solid rgba(255, 255, 255, 0.3);
            animation: pulse 2s ease-in-out infinite;
            position: relative;
        }
        
        .character-avatar.student {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.3), rgba(5, 150, 105, 0.3));
        }
        
        .character-avatar.teacher {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(37, 99, 235, 0.3));
        }
        
        .character-avatar.admin {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.3), rgba(124, 58, 237, 0.3));
        }
        
        .character-avatar.parent {
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.3), rgba(219, 39, 119, 0.3));
        }
        
        .character-avatar.success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.4), rgba(5, 150, 105, 0.4));
            animation: bounce 2s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.05); }
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
        
        .demo-text {
            margin-top: 1.5rem;
        }
        
        .demo-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: white;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .demo-description {
            font-size: 1.125rem;
            line-height: 1.7;
            opacity: 0.95;
            margin-bottom: 1.5rem;
        }
        
        .demo-features {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: center;
            margin-top: 1.5rem;
        }
        
        .feature-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideIn 0.5s ease-out;
        }
        
        .feature-badge i {
            color: var(--green);
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .demo-cta {
            margin-top: 2rem;
        }
        
        .demo-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2.5rem;
            background: var(--green);
            color: white;
            text-decoration: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1.125rem;
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.4);
            transition: all 0.3s ease;
            animation: pulse 2s ease-in-out infinite;
        }
        
        .demo-btn:hover {
            background: var(--green-dark);
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(16, 185, 129, 0.5);
        }
        
        .demo-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            z-index: 10;
        }
        
        .progress-bar {
            width: 100%;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 1rem;
        }
        
        .progress-fill {
            height: 100%;
            background: var(--green);
            border-radius: 2px;
            transition: width 0.3s ease;
            width: 14.28%;
        }
        
        .demo-dots {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
        }
        
        .demo-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .demo-dot.active {
            background: white;
            transform: scale(1.3);
            border-color: var(--green);
        }
        
        .demo-dot:hover {
            background: rgba(255, 255, 255, 0.7);
        }
        
        .video-wrapper video,
        .video-wrapper iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
            position: absolute;
            top: 0;
            left: 0;
        }
        
        .video-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--navy-dark), var(--navy));
            color: white;
            padding: 3rem;
            text-align: center;
        }
        
        .video-placeholder-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            opacity: 0.8;
        }
        
        .video-placeholder h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .video-placeholder p {
            opacity: 0.9;
            line-height: 1.7;
        }
        
        /* Footer */
        .footer {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            color: white;
            padding: 5rem 1.5rem 2rem;
            position: relative;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--green), transparent);
        }
        
        .footer-content {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 4rem;
            margin-bottom: 3rem;
        }
        
        .footer-brand {
            max-width: 350px;
        }
        
        .footer-brand-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .footer-brand-logo svg {
            width: 44px;
            height: 44px;
        }
        
        .footer-brand h4 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: white;
            font-weight: 800;
        }
        
        .footer-brand p {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }
        
        .footer-social {
            display: flex;
            gap: 1rem;
        }
        
        .footer-social a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-social a:hover {
            background: var(--green);
            transform: translateY(-3px);
        }
        
        .footer-section h5 {
            font-size: 1.125rem;
            margin-bottom: 1.5rem;
            color: white;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        .footer-section a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: block;
            margin-bottom: 0.875rem;
            transition: all 0.2s ease;
            font-size: 0.9375rem;
        }
        
        .footer-section a:hover {
            color: var(--green);
            padding-left: 0.5rem;
        }
        
        .footer-bottom {
            max-width: 1280px;
            margin: 0 auto;
            padding-top: 2.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .footer-bottom p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9375rem;
            margin: 0;
        }
        
        .footer-bottom-links {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }
        
        .footer-bottom-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9375rem;
            transition: color 0.2s;
        }
        
        .footer-bottom-links a:hover {
            color: var(--green);
        }
        
        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: transparent;
            border: none;
            color: var(--charcoal);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
        }
        
        .mobile-menu {
            display: none;
            position: fixed;
            top: 70px;
            left: 0;
            right: 0;
            background: white;
            border-bottom: 1px solid var(--light-grey);
            padding: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            z-index: 999;
        }
        
        .mobile-menu.active {
            display: block;
        }
        
        .mobile-menu a {
            display: block;
            padding: 0.75rem 1rem;
            color: var(--charcoal);
            text-decoration: none;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            transition: background 0.2s;
        }
        
        .mobile-menu a:hover {
            background: var(--off-white);
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .video-section {
                padding: 4rem 1rem;
            }
            
            .video-header h2 {
                font-size: 2rem;
            }
            
            .video-header p {
                font-size: 1.125rem;
            }
            
            .video-wrapper {
                border-radius: 1rem;
                max-width: 100%;
                aspect-ratio: auto;
                min-height: 650px;
                height: auto;
            }
            
            .animated-demo {
                border-radius: 1rem;
                min-height: 650px;
                height: auto;
            }
            
            .demo-slide {
                padding: 3rem 1.5rem;
                min-height: 650px;
                align-items: flex-start;
                padding-top: 2.5rem;
            }
            
            .demo-content {
                max-width: 100%;
                width: 100%;
            }
            
            .demo-title {
                font-size: 1.5rem;
                margin-bottom: 1rem;
                line-height: 1.3;
            }
            
            .demo-description {
                font-size: 1rem;
                line-height: 1.7;
            }
            
            .character-avatar {
                width: 90px;
                height: 90px;
                font-size: 3rem;
                margin-bottom: 1.5rem;
            }
            
            .feature-badge {
                font-size: 0.75rem;
                padding: 0.4rem 0.75rem;
            }
            
            .demo-btn {
                padding: 0.875rem 2rem;
                font-size: 1rem;
            }
            
            .demo-progress {
                padding: 1rem;
            }
            
            .footer {
                padding: 4rem 1.5rem 2rem;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 3rem;
            }
            
            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
            
            .footer-bottom-links {
                justify-content: center;
            }
            .nav-links {
                display: none;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .logo-text {
                display: none;
            }
            
            .logo-icon {
                width: 36px;
                height: 36px;
            }
            
            /* Hero section already handled in earlier mobile query */
            
            .section-header h2 {
                font-size: 2rem;
            }
            
            .features-grid,
            .who-grid,
            .why-grid {
                grid-template-columns: 1fr;
            }
            
            .cta-section h2 {
                font-size: 2rem;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
            }
            
            .features,
            .who-section,
            .why-section,
            .cta-section {
                padding: 4rem 1rem;
            }
        }
        
        @media (max-width: 480px) {
            /* Hero styles already defined in @media (max-width: 768px) above */
            .hero-content {
                padding: 5.5rem 1.25rem 2.5rem !important;
            }
            
            .hero-text h1 {
                font-size: 1.625rem !important;
                line-height: 1.3 !important;
                margin-bottom: 1rem !important;
            }
            
            .hero-text .subtitle {
                font-size: 0.9375rem !important;
                line-height: 1.6 !important;
                margin-bottom: 1.75rem !important;
            }
            
            .nav-container {
                padding: 0 1rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                width: 100%;
            }
            
            .hero-buttons .btn {
                width: 100%;
            }
            
            .cta-buttons {
                flex-direction: column;
            }
            
            .cta-buttons .btn {
                width: 100%;
            }
        }
        
        /* Animations */
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
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        .hero-slide-content {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .hero-slide.active .hero-slide-content {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .hero-text h1 {
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }
        
        .hero-text .subtitle {
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }
        
        .hero-cta {
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .animate-delay-1 {
            animation-delay: 0.1s;
        }
        
        .animate-delay-2 {
            animation-delay: 0.2s;
        }
        
        /* Button hover micro-interactions */
        .hero-cta {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hero-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(30, 58, 138, 0.3);
        }
        
        .hero-cta:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="/" class="logo-link">
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
                <a href="#features">Features</a>
                <a href="#who">Who It's For</a>
                <a href="#why">Why Choose Us</a>
                <a href="<?php echo e(route('school-management.demo-login')); ?>" style="color: var(--green-dark); font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem;">
                    <i class="fas fa-play-circle" style="color: var(--green);"></i>
                    Live Demo
                </a>
                <a href="<?php echo e(route('login')); ?>" class="nav-btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </a>
                <a href="<?php echo e(route('contact')); ?>" class="nav-btn-contact">
                    <i class="fas fa-envelope"></i>
                    Contact
                </a>
            </div>
            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <a href="#features">Features</a>
            <a href="#who">Who It's For</a>
            <a href="#why">Why Choose Us</a>
            <a href="<?php echo e(route('school-management.demo-login')); ?>" style="color: var(--green-dark); font-weight: 700; display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1rem;">
                <i class="fas fa-play-circle" style="color: var(--green);"></i>
                Explore Live Demo
            </a>
            <a href="<?php echo e(route('login')); ?>" class="nav-btn-login" style="margin-top: 0.5rem; width: 100%; justify-content: center;">
                <i class="fas fa-sign-in-alt"></i>
                Login
            </a>
            <a href="<?php echo e(route('contact')); ?>" class="nav-btn-contact" style="margin-top: 0.5rem; width: 100%; justify-content: center;">
                <i class="fas fa-envelope"></i>
                Contact
            </a>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-slideshow">
            <div class="hero-slide active">
                <div class="hero-content">
                    <div class="hero-slide-content active">
                        <div class="hero-text">
                            <h1>Transform Your School Administration with Confidence</h1>
                            <p class="subtitle">ES-SCHOOLS is the comprehensive platform trusted by schools across Nigeria and Africa. Streamline operations, engage parents, and empower your entire school community with our modern, secure solution.</p>
                            <div class="hero-buttons">
                                <a href="<?php echo e(route('login')); ?>" class="hero-cta">
                                    <i class="fas fa-rocket"></i>
                                    Get Started Today
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-slide">
                <div class="hero-content">
                    <div class="hero-slide-content">
                        <div class="hero-text">
                            <h1>Empower Teachers, Engage Parents, Inspire Students</h1>
                            <p class="subtitle">Join hundreds of schools already using ES-SCHOOLS to manage attendance, track performance, handle fees, and communicate seamlessly with parents. Built specifically for Nigerian and African schools.</p>
                            <div class="hero-buttons">
                                <a href="<?php echo e(route('login')); ?>" class="hero-cta">
                                    <i class="fas fa-rocket"></i>
                                    Get Started Today
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-slide">
                <div class="hero-content">
                    <div class="hero-slide-content">
                        <div class="hero-text">
                            <h1>Modern Technology for Modern Schools</h1>
                            <p class="subtitle">From student enrollment to exam results, from fee management to parent communication - everything you need in one powerful, easy-to-use platform designed for educational excellence.</p>
                            <div class="hero-buttons">
                                <a href="<?php echo e(route('login')); ?>" class="hero-cta">
                                    <i class="fas fa-rocket"></i>
                                    Get Started Today
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-slide">
                <div class="hero-content">
                    <div class="hero-slide-content">
                        <div class="hero-text">
                            <h1>Trusted by Schools Across Africa</h1>
                            <p class="subtitle">Experience the difference that professional school management software makes. Reduce administrative workload, improve parent engagement, and focus on what matters most - education.</p>
                            <div class="hero-buttons">
                                <a href="<?php echo e(route('login')); ?>" class="hero-cta">
                                    <i class="fas fa-rocket"></i>
                                    Get Started Today
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-indicators">
            <span class="hero-indicator active" data-slide="0"></span>
            <span class="hero-indicator" data-slide="1"></span>
            <span class="hero-indicator" data-slide="2"></span>
            <span class="hero-indicator" data-slide="3"></span>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-header">
                <h2>Everything You Need to Manage Your School</h2>
                <p>Powerful features designed to simplify administration and enhance the learning experience for everyone in your school community.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Complete Student & Staff Management</h3>
                    <p>Comprehensive database management for all students and staff members. Track enrollment, attendance, and performance with ease. Generate detailed reports instantly.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h3>Real-Time Attendance Tracking</h3>
                    <p>Monitor attendance in real-time with automated notifications to parents. Generate detailed reports and analytics to identify patterns and improve student engagement.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Advanced Result Management</h3>
                    <p>Streamlined result entry, grading, and report generation. Support for CA1, CA2, and Exam scores with automatic calculations, grade assignments, and position rankings.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h3>Comprehensive Fee Management</h3>
                    <p>Complete fee tracking and payment management system. Send automated reminders, track payments in real-time, and generate receipts instantly. Perfect for Nigerian schools.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h3>Assignment & Exam Management</h3>
                    <p>Create and manage assignments, practice sessions, and exams effortlessly. Support for both online and offline assessments with detailed analytics and performance tracking.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Mobile-First Design</h3>
                    <p>Access your school management system from any device. Beautiful, responsive interface optimized for smartphones and tablets. Perfect for schools where mobile access is essential.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Who It's For Section -->
    <section class="who-section" id="who">
        <div class="container">
            <div class="section-header">
                <h2>Built for Everyone in Your School</h2>
                <p>ES-SCHOOLS is designed to serve every member of your school community with purpose-built interfaces and workflows.</p>
            </div>
            <div class="who-grid">
                <div class="who-card">
                    <div class="who-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3>School Administrators</h3>
                    <p>Complete control over your school operations. Manage students, staff, fees, and reports from one centralized dashboard. Make data-driven decisions with comprehensive analytics.</p>
                </div>
                <div class="who-card">
                    <div class="who-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3>Teachers</h3>
                    <p>Streamlined workflows for attendance, grading, and assignments. Focus on teaching while the platform handles administrative tasks. Access everything you need from your mobile device.</p>
                </div>
                <div class="who-card">
                    <div class="who-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3>Students</h3>
                    <p>Easy access to results, assignments, timetable, and attendance records. Stay informed about your academic progress and never miss important updates from your school.</p>
                </div>
                <div class="who-card">
                    <div class="who-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3>Parents</h3>
                    <p>Stay connected with your child's education. Receive real-time notifications about attendance, results, fees, and school announcements. Track academic progress effortlessly.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Why Choose Section -->
    <section class="why-section" id="why">
        <div class="container">
            <div class="section-header">
                <h2>Why Schools Choose ES-SCHOOLS</h2>
                <p>Built specifically for Nigerian and African schools, with features and support tailored to your needs.</p>
            </div>
            <div class="why-grid">
                <div class="why-item">
                    <div class="why-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="why-content">
                        <h4>Bank-Level Security</h4>
                        <p>Your data is protected with enterprise-grade security. Regular backups and encrypted connections ensure your school's information is always safe.</p>
                    </div>
                </div>
                <div class="why-item">
                    <div class="why-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="why-content">
                        <h4>Automated Workflows</h4>
                        <p>Save hours every week with automated processes. From attendance tracking to fee reminders, let the system handle routine tasks so you can focus on education.</p>
                    </div>
                </div>
                <div class="why-item">
                    <div class="why-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="why-content">
                        <h4>Comprehensive Reports</h4>
                        <p>Generate detailed reports on attendance, academic performance, fees, and more. Export data for analysis and make informed decisions about your school.</p>
                    </div>
                </div>
                <div class="why-item">
                    <div class="why-icon">
                        <i class="fas fa-mouse-pointer"></i>
                    </div>
                    <div class="why-content">
                        <h4>Incredibly Easy to Use</h4>
                        <p>No technical expertise required. Our intuitive interface means your staff can start using the platform immediately. Training takes less than an hour.</p>
                    </div>
                </div>
                <div class="why-item">
                    <div class="why-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="why-content">
                        <h4>Built for Nigerian Schools</h4>
                        <p>Designed with Nigerian curriculum, fee structures, and academic terms in mind. Works seamlessly with your existing school processes and requirements.</p>
                    </div>
                </div>
                <div class="why-item">
                    <div class="why-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="why-content">
                        <h4>Dedicated Support</h4>
                        <p>Get help when you need it. Our support team understands Nigerian schools and is ready to assist you with setup, training, and ongoing support.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Video Section -->
    <section class="video-section" id="video">
        <div class="video-container">
            <div class="video-header">
                <h2>See Your School in Action</h2>
                <p>Watch how our platform transforms school administration with an intuitive interface designed for educators, students, and parents.</p>
            </div>
            <div class="video-wrapper" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);">
                <div class="animated-demo" id="animatedDemo">
                    <!-- Slide 1: Welcome -->
                    <div class="demo-slide active" data-slide="0">
                        <div class="demo-content">
                            <div class="demo-character">
                                <div class="character-avatar">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                            </div>
                            <div class="demo-text">
                                <h3 class="demo-title">Welcome to ES-SCHOOLS</h3>
                                <p class="demo-description">The complete school management platform designed for Nigerian and African schools. Let's explore how it works!</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 2: Student Management -->
                    <div class="demo-slide" data-slide="1">
                        <div class="demo-content">
                            <div class="demo-character">
                                <div class="character-avatar student">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                            </div>
                            <div class="demo-text">
                                <h3 class="demo-title">Complete Student Management</h3>
                                <p class="demo-description">Easily manage student records, enrollment, and academic information. Track everything from admission to graduation in one place.</p>
                                <div class="demo-features">
                                    <span class="feature-badge"><i class="fas fa-check"></i> Student Profiles</span>
                                    <span class="feature-badge"><i class="fas fa-check"></i> Enrollment Tracking</span>
                                    <span class="feature-badge"><i class="fas fa-check"></i> Academic Records</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 3: Attendance Tracking -->
                    <div class="demo-slide" data-slide="2">
                        <div class="demo-content">
                            <div class="demo-character">
                                <div class="character-avatar teacher">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                            </div>
                            <div class="demo-text">
                                <h3 class="demo-title">Real-Time Attendance Tracking</h3>
                                <p class="demo-description">Teachers can mark attendance instantly. Parents receive automatic notifications. Generate detailed reports with one click.</p>
                                <div class="demo-features">
                                    <span class="feature-badge"><i class="fas fa-check"></i> Quick Marking</span>
                                    <span class="feature-badge"><i class="fas fa-check"></i> Parent Alerts</span>
                                    <span class="feature-badge"><i class="fas fa-check"></i> Analytics</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 4: Results Management -->
                    <div class="demo-slide" data-slide="3">
                        <div class="demo-content">
                            <div class="demo-character">
                                <div class="character-avatar admin">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                            </div>
                            <div class="demo-text">
                                <h3 class="demo-title">Streamlined Results Management</h3>
                                <p class="demo-description">Enter CA1, CA2, and Exam scores. The system automatically calculates totals, grades, and positions. Generate report cards instantly.</p>
                                <div class="demo-features">
                                    <span class="feature-badge"><i class="fas fa-check"></i> Auto Grading</span>
                                    <span class="feature-badge"><i class="fas fa-check"></i> Report Cards</span>
                                    <span class="feature-badge"><i class="fas fa-check"></i> CSV Upload</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 5: Fee Management -->
                    <div class="demo-slide" data-slide="4">
                        <div class="demo-content">
                            <div class="demo-character">
                                <div class="character-avatar parent">
                                    <i class="fas fa-wallet"></i>
                                </div>
                            </div>
                            <div class="demo-text">
                                <h3 class="demo-title">Comprehensive Fee Management</h3>
                                <p class="demo-description">Track all school fees, send payment reminders, and generate receipts automatically. Perfect for Nigerian schools with flexible payment options.</p>
                                <div class="demo-features">
                                    <span class="feature-badge"><i class="fas fa-check"></i> Payment Tracking</span>
                                    <span class="feature-badge"><i class="fas fa-check"></i> Auto Receipts</span>
                                    <span class="feature-badge"><i class="fas fa-check"></i> Reminders</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 6: Parent Communication -->
                    <div class="demo-slide" data-slide="5">
                        <div class="demo-content">
                            <div class="demo-character">
                                <div class="character-avatar parent">
                                    <i class="fas fa-comments"></i>
                                </div>
                            </div>
                            <div class="demo-text">
                                <h3 class="demo-title">Seamless Parent Communication</h3>
                                <p class="demo-description">Parents can view their children's progress, attendance, and fees in real-time. Stay connected with your school community.</p>
                                <div class="demo-features">
                                    <span class="feature-badge"><i class="fas fa-check"></i> Real-Time Updates</span>
                                    <span class="feature-badge"><i class="fas fa-check"></i> Notifications</span>
                                    <span class="feature-badge"><i class="fas fa-check"></i> Dashboard Access</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 7: Call to Action -->
                    <div class="demo-slide" data-slide="6">
                        <div class="demo-content">
                            <div class="demo-character">
                                <div class="character-avatar success">
                                    <i class="fas fa-rocket"></i>
                                </div>
                            </div>
                            <div class="demo-text">
                                <h3 class="demo-title">Ready to Get Started?</h3>
                                <p class="demo-description">Join hundreds of schools already using ES-SCHOOLS to transform their administration. Start your free trial today!</p>
                                <div class="demo-cta">
                                    <a href="<?php echo e(route('login')); ?>" class="demo-btn">
                                        <i class="fas fa-arrow-right"></i>
                                        Get Started Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress Indicators -->
                    <div class="demo-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" id="progressFill"></div>
                        </div>
                        <div class="demo-dots">
                            <span class="demo-dot active" data-slide="0"></span>
                            <span class="demo-dot" data-slide="1"></span>
                            <span class="demo-dot" data-slide="2"></span>
                            <span class="demo-dot" data-slide="3"></span>
                            <span class="demo-dot" data-slide="4"></span>
                            <span class="demo-dot" data-slide="5"></span>
                            <span class="demo-dot" data-slide="6"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-brand">
                <div class="footer-brand-logo">
                    <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="32" cy="32" r="30" fill="url(#footerLogoGradient)"/>
                        <path d="M32 18L20 24L32 30L44 24L32 18Z" fill="white" opacity="0.95"/>
                        <path d="M20 24V36C20 36 24 40 32 40C40 40 44 36 44 36V24" stroke="white" stroke-width="2" fill="none"/>
                        <rect x="24" y="38" width="16" height="12" rx="2" fill="white" opacity="0.9"/>
                        <line x1="28" y1="42" x2="36" y2="42" stroke="#10b981" stroke-width="1.5"/>
                        <line x1="28" y1="45" x2="36" y2="45" stroke="#10b981" stroke-width="1.5"/>
                        <defs>
                            <linearGradient id="footerLogoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#1e3a8a;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#10b981;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                    </svg>
                    <h4>ES-SCHOOLS</h4>
                </div>
                <p>The modern school management platform designed specifically for Nigerian and African schools. Transform your administration with confidence and streamline your operations.</p>
                <div class="footer-social">
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" aria-label="Twitter" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="footer-section">
                <h5>Product</h5>
                <a href="#features">Features</a>
                <a href="#who">Who It's For</a>
                <a href="#why">Why Choose Us</a>
                <a href="#video">Watch Demo</a>
                <a href="<?php echo e(route('login')); ?>">Get Started</a>
            </div>
            <div class="footer-section">
                <h5>Access</h5>
                <a href="<?php echo e(route('login')); ?>">Login</a>
                <a href="<?php echo e(route('login')); ?>">Student/Teacher Login</a>
                <a href="<?php echo e(route('school-management.demo-login')); ?>">Try Demo</a>
                <a href="<?php echo e(route('contact')); ?>">Contact Us</a>
            </div>
            <div class="footer-section">
                <h5>Support</h5>
                <a href="<?php echo e(route('contact')); ?>">Get Help</a>
                <a href="mailto:help@extremesolutions.com.ng">Email Support</a>
                <a href="tel:+2348000000000">Phone Support</a>
                <a href="#features">Documentation</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo e(date('Y')); ?> ES-SCHOOLS by <a href="https://extremesolutions.com.ng" target="_blank" style="color: var(--green); text-decoration: none; font-weight: 600;">ExtremeSolutions</a>. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="<?php echo e(route('privacy-policy')); ?>">Privacy Policy</a>
                <a href="<?php echo e(route('terms-of-service')); ?>">Terms of Service</a>
                <a href="<?php echo e(route('cookie-policy')); ?>">Cookie Policy</a>
            </div>
        </div>
    </footer>
    
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('active');
                    const icon = this.querySelector('i');
                    if (mobileMenu.classList.contains('active')) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    } else {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });
                
                // Close menu when clicking a link
                mobileMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.remove('active');
                        const icon = mobileMenuToggle.querySelector('i');
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    });
                });
            }
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#') {
                    e.preventDefault();
                    return;
                }
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    const mobileMenu = document.getElementById('mobileMenu');
                    if (mobileMenu && mobileMenu.classList.contains('active')) {
                        mobileMenu.classList.remove('active');
                        const icon = document.getElementById('mobileMenuToggle')?.querySelector('i');
                        if (icon) {
                            icon.classList.remove('fa-times');
                            icon.classList.add('fa-bars');
                        }
                    }
                }
            });
        });
        
        // Hero Slideshow with Content
        (function() {
            // Check if we're on mobile
            const isMobile = window.innerWidth <= 768;
            
            let currentSlide = 0;
            const slides = document.querySelectorAll('.hero-slide');
            const slideContents = document.querySelectorAll('.hero-slide-content');
            const indicators = document.querySelectorAll('.hero-indicator');
            
            if (slides.length === 0) return;
            
            function showSlide(index) {
                // Remove active from all
                slides.forEach(slide => slide.classList.remove('active'));
                slideContents.forEach(content => content.classList.remove('active'));
                indicators.forEach(indicator => indicator.classList.remove('active'));
                
                // Add active to current
                if (slides[index]) {
                    slides[index].classList.add('active');
                }
                if (slideContents[index]) {
                    slideContents[index].classList.add('active');
                }
                if (indicators[index]) {
                    indicators[index].classList.add('active');
                }
                
                currentSlide = index;
            }
            
            function nextSlide() {
                const next = (currentSlide + 1) % slides.length;
                showSlide(next);
            }
            
            // Initialize first slide to ensure it's visible
            if (slides.length > 0) {
                showSlide(0);
            }
            
            // Only run slideshow on desktop/tablet (not mobile)
            if (!isMobile) {
                // Change slide every 6 seconds
                setInterval(nextSlide, 6000);
                
                // Indicator click handlers
                indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', () => {
                        showSlide(index);
                    });
                });
            }
        })();
        
        // Smooth scroll for anchor links
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    
                    // Skip if it's just "#"
                    if (href === '#' || href === '') {
                        return;
                    }
                    
                    e.preventDefault();
                    const target = document.querySelector(href);
                    
                    if (target) {
                        // Calculate offset for fixed navbar
                        const navbarHeight = document.getElementById('navbar').offsetHeight;
                        const targetPosition = target.offsetTop - navbarHeight;
                        
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                        
                        // Update URL without jumping
                        if (history.pushState) {
                            history.pushState(null, null, href);
                        }
                    }
                });
            });
        });
        
        // Handle page load with hash
        window.addEventListener('load', function() {
            if (window.location.hash) {
                const target = document.querySelector(window.location.hash);
                if (target) {
                    const navbarHeight = document.getElementById('navbar').offsetHeight;
                    const targetPosition = target.offsetTop - navbarHeight;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
        
        // Animated Demo Slideshow
        (function() {
            let currentDemoSlide = 0;
            const demoSlides = document.querySelectorAll('.demo-slide');
            const demoDots = document.querySelectorAll('.demo-dot');
            const progressFill = document.getElementById('progressFill');
            
            if (demoSlides.length === 0) return;
            
            const totalSlides = demoSlides.length;
            let autoPlayInterval;
            
            function showDemoSlide(index) {
                // Remove active from all
                demoSlides.forEach(slide => slide.classList.remove('active'));
                demoDots.forEach(dot => dot.classList.remove('active'));
                
                // Add active to current
                demoSlides[index].classList.add('active');
                demoDots[index].classList.add('active');
                
                // Update progress bar
                const progress = ((index + 1) / totalSlides) * 100;
                if (progressFill) {
                    progressFill.style.width = progress + '%';
                }
                
                currentDemoSlide = index;
            }
            
            function nextDemoSlide() {
                const next = (currentDemoSlide + 1) % totalSlides;
                showDemoSlide(next);
            }
            
            // Auto-play: Change slide every 5 seconds
            function startAutoPlay() {
                autoPlayInterval = setInterval(nextDemoSlide, 5000);
            }
            
            function stopAutoPlay() {
                if (autoPlayInterval) {
                    clearInterval(autoPlayInterval);
                }
            }
            
            // Dot click handlers
            demoDots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    stopAutoPlay();
                    showDemoSlide(index);
                    startAutoPlay();
                });
            });
            
            // Pause on hover
            const animatedDemo = document.getElementById('animatedDemo');
            if (animatedDemo) {
                animatedDemo.addEventListener('mouseenter', stopAutoPlay);
                animatedDemo.addEventListener('mouseleave', startAutoPlay);
            }
            
            // Initialize
            showDemoSlide(0);
            startAutoPlay();
        })();
    </script>
</body>
</html>
<?php /**PATH C:\Users\User\Documents\SMS_EXTRACTED\resources\views/landing.blade.php ENDPATH**/ ?>