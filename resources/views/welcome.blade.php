<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Primary Meta Tags -->
        <title>ES-SCHOOLS | Stop Chasing Fees &amp; Run on Autopilot</title>
        <meta name="title" content="ES-SCHOOLS | Stop Chasing Fees &amp; Run on Autopilot">
        <meta name="description" content="Automate tuition fee recovery, 1-click terminal report cards, and parent billing for Nigerian schools. Test-drive live interactive demos today.">
        <meta name="keywords" content="school management system, school administration, student management, teacher portal, attendance tracking, result management, fee management, online school system, education software, school ERP">
        <meta name="author" content="ExtremeSolutions Nigeria">
        <meta name="robots" content="index, follow">
        <meta name="language" content="English">
        <meta name="revisit-after" content="7 days">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:title" content="ES-SCHOOLS: Automate Tuition &amp; School Operations">
        <meta property="og:description" content="Automate tuition recovery, 1-click report cards &amp; parent billing for Nigerian schools. Try live interactive demos now!">
        <meta property="og:image" content="{{ asset('og-preview.png') }}">
        <meta property="og:site_name" content="ES-SCHOOLS">
        <meta property="og:locale" content="en_NG">
        
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ url('/') }}">
        <meta name="twitter:title" content="ES-SCHOOLS: Automate Tuition &amp; School Operations">
        <meta name="twitter:description" content="Automate tuition recovery, 1-click report cards &amp; parent billing for Nigerian schools. Try live interactive demos now!">
        <meta name="twitter:image" content="{{ asset('og-preview.png') }}">
        
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ url('/') }}">
        @if(env('GOOGLE_SITE_VERIFICATION'))
        <meta name="google-site-verification" content="{{ env('GOOGLE_SITE_VERIFICATION') }}">
        @endif
        
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
                "Mobile-Friendly Interface",
                "Real-time Notifications",
                "Report Generation"
            ],
            "screenshot": "{{ asset('images/screenshot.jpg') }}",
            "softwareVersion": "1.0",
            "releaseNotes": "Modern, mobile-friendly school management platform"
        }
        </script>
        
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "School Management System",
            "url": "{{ url('/') }}",
            "logo": "{{ asset('images/logo.png') }}",
            "description": "Comprehensive school management system for modern education",
            "contactPoint": {
                "@type": "ContactPoint",
                "contactType": "Customer Service",
                "availableLanguage": "English"
            }
        }
        </script>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: #333;
            }
            .container {
                text-align: center;
                background: white;
                padding: 3rem;
                border-radius: 10px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.1);
                max-width: 600px;
            }
            h1 {
                font-size: 2.5rem;
                margin-bottom: 1rem;
                color: #667eea;
            }
            p {
                font-size: 1.1rem;
                margin-bottom: 2rem;
                color: #666;
            }
            .links {
                display: flex;
                gap: 1rem;
                justify-content: center;
                flex-wrap: wrap;
            }
            a {
                display: inline-block;
                padding: 0.75rem 1.5rem;
                background: #667eea;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                transition: background 0.3s;
            }
            a:hover {
                background: #5568d3;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>School Management System</h1>
            <p>Welcome to the comprehensive School Management System. Streamline your school administration with our modern, mobile-friendly platform designed for administrators, teachers, and students.</p>
            <div class="links">
                <a href="{{ route('school-management.index') }}">School Management Portal</a>
            </div>
            <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee; text-align: left;">
                <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: #667eea;">Key Features</h2>
                <ul style="list-style: none; padding: 0; color: #666;">
                    <li style="margin-bottom: 0.5rem;">✓ Student & Staff Management</li>
                    <li style="margin-bottom: 0.5rem;">✓ Attendance Tracking</li>
                    <li style="margin-bottom: 0.5rem;">✓ Result Management & Reports</li>
                    <li style="margin-bottom: 0.5rem;">✓ Fee Management</li>
                    <li style="margin-bottom: 0.5rem;">✓ Assignment & Exam Management</li>
                    <li style="margin-bottom: 0.5rem;">✓ Mobile-Friendly Interface</li>
                </ul>
            </div>
        </div>
    </body>
</html>
