<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Admission Application - ES-SCHOOLS</title>
    <meta name="description" content="Apply for online admission at ES-SCHOOLS. Fast, seamless online application for Nursery, Primary, Junior and Senior Secondary School.">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Favicon & Icons -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    
    <style>
        :root {
            --primary: #1e3a8a;
            --primary-dark: #172554;
            --primary-light: #3b82f6;
            --accent: #10b981;
            --accent-dark: #059669;
            --bg-page: #f4f6fb;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 20px -2px rgba(0,0,0,0.06);
            --shadow-lg: 0 10px 25px -5px rgba(30,58,138,0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Top Header */
        .admission-header {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03);
        }

        .header-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--primary);
            font-weight: 800;
            font-size: 1.25rem;
        }

        .brand-logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            box-shadow: 0 4px 10px rgba(30,58,138,0.2);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-header {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-home {
            color: var(--text-muted);
            background: #f1f5f9;
        }
        .btn-home:hover {
            color: var(--primary);
            background: #e2e8f0;
        }

        .btn-login {
            background: var(--primary);
            color: white;
        }
        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        /* Banner */
        .admission-hero {
            background: linear-gradient(135deg, var(--primary) 0%, #1e40af 50%, #172554 100%);
            color: white;
            padding: 3.5rem 1.5rem 4.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .admission-hero::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -5%;
            width: 110%;
            height: 60px;
            background: var(--bg-page);
            border-radius: 50% 50% 0 0;
        }

        .badge-session {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #6ee7b7;
            padding: 0.4rem 1.25rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            opacity: 0.9;
            max-width: 650px;
            margin: 0 auto;
            font-weight: 400;
        }

        /* Main Container */
        .form-container {
            max-width: 960px;
            margin: -2rem auto 4rem;
            padding: 0 1.5rem;
            position: relative;
            z-index: 10;
        }

        .form-card {
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        /* Success Slip Box */
        .slip-box {
            padding: 3rem 2.5rem;
            text-align: center;
        }

        .slip-badge {
            width: 76px;
            height: 76px;
            background: #dcfce7;
            color: #15803d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.25rem;
            margin: 0 auto 1.5rem;
        }

        .slip-title {
            font-size: 1.875rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .slip-subtitle {
            color: var(--text-muted);
            font-size: 1rem;
            max-width: 550px;
            margin: 0 auto 2rem;
        }

        .slip-ref-pill {
            display: inline-block;
            background: #eff6ff;
            border: 2px dashed var(--primary);
            padding: 1rem 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .slip-ref-pill span {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: block;
        }

        .slip-ref-pill strong {
            font-size: 1.625rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: 0.05em;
        }

        .slip-details-table {
            width: 100%;
            max-width: 700px;
            margin: 0 auto 2.5rem;
            text-align: left;
            border-collapse: collapse;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .slip-details-table th, .slip-details-table td {
            padding: 0.875rem 1.25rem;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9375rem;
        }

        .slip-details-table th {
            background: #f8fafc;
            color: var(--text-muted);
            width: 38%;
            font-weight: 600;
        }

        .slip-details-table td {
            color: var(--text-dark);
            font-weight: 700;
        }

        .slip-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.75rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }

        .btn-print {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 14px rgba(30,58,138,0.25);
        }
        .btn-print:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-new {
            background: #f1f5f9;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
        }
        .btn-new:hover {
            background: #e2e8f0;
        }

        /* Form Sections */
        .form-section {
            padding: 2.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .form-section:last-of-type {
            border-bottom: none;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.75rem;
        }

        .section-number {
            width: 32px;
            height: 32px;
            background: #eff6ff;
            color: var(--primary);
            border: 2px solid var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-dark);
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        .form-grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1.25rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 0.4rem;
        }

        .form-label .required {
            color: #ef4444;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
            font-family: inherit;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: #f8fafc;
            color: var(--text-dark);
            transition: all 0.2s ease;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(30,58,138,0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-help {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.35rem;
        }

        /* Submit Button */
        .form-footer {
            padding: 2rem 2.5rem;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-note {
            font-size: 0.8125rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: white;
            font-size: 1.0625rem;
            font-weight: 700;
            padding: 0.875rem 2.5rem;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(16,185,129,0.35);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16,185,129,0.45);
        }

        /* Print Media Styling */
        @media print {
            .admission-header, .admission-hero, .slip-actions, .btn-header {
                display: none !important;
            }
            body {
                background: white !important;
                color: black !important;
            }
            .form-container {
                margin: 0 !important;
                max-width: 100% !important;
                padding: 0 !important;
            }
            .form-card {
                box-shadow: none !important;
                border: none !important;
            }
            .slip-box {
                padding: 0 !important;
            }
            .slip-details-table {
                width: 100% !important;
                max-width: 100% !important;
            }
        }

        /* Responsive Breakpoints */
        @media (max-width: 768px) {
            .form-grid-2, .form-grid-3 {
                grid-template-columns: 1fr;
            }
            .hero-title {
                font-size: 1.875rem;
            }
            .form-section {
                padding: 1.5rem;
            }
            .form-footer {
                padding: 1.5rem;
            }
            .btn-submit {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header class="admission-header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="brand-link">
                <div class="brand-logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <span>ES-SCHOOLS</span>
            </a>

            <div class="header-actions">
                <a href="{{ route('home') }}" class="btn-header btn-home">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="{{ route('school-management.demo-login') }}" class="btn-header btn-home" style="color: #059669; font-weight: 700;">
                    <i class="fas fa-play-circle"></i> Live Demo
                </a>
                <a href="{{ route('login') }}" class="btn-header btn-login">
                    <i class="fas fa-sign-in-alt"></i> Portal Login
                </a>
            </div>
        </div>
    </header>

    <!-- Admission Hero Banner -->
    <section class="admission-hero">
        <div class="badge-session">
            <i class="fas fa-calendar-alt"></i> Academic Session {{ $sessionYear ?? '2026/2027' }}
        </div>
        <h1 class="hero-title">Online Student Admission Portal</h1>
        <p class="hero-subtitle">
            Welcome to ES-SCHOOLS online application. Submit your child's registration in 5 easy steps and receive an instant admission acknowledgment slip.
        </p>
    </section>

    <!-- Application Form Container -->
    <main class="form-container">
        <div class="form-card">

            @if(session('admission_success'))
                @php $appData = session('admission_data'); @endphp
                <!-- Success Acknowledgment Slip -->
                <div class="slip-box">
                    <div class="slip-badge">
                        <i class="fas fa-check"></i>
                    </div>
                    <h2 class="slip-title">Application Submitted Successfully!</h2>
                    <p class="slip-subtitle">
                        Your admission application for <strong>{{ $appData['first_name'] }} {{ $appData['last_name'] }}</strong> has been officially received and logged into our school registry.
                    </p>

                    <div class="slip-ref-pill">
                        <span>Official Application Number</span>
                        <strong>{{ $appData['application_number'] }}</strong>
                    </div>

                    <table class="slip-details-table">
                        <tr>
                            <th>Student Full Name</th>
                            <td>{{ $appData['first_name'] }} {{ $appData['middle_name'] ?? '' }} {{ $appData['last_name'] }}</td>
                        </tr>
                        <tr>
                            <th>Gender & Date of Birth</th>
                            <td>{{ $appData['gender'] }} (DOB: {{ $appData['date_of_birth'] }})</td>
                        </tr>
                        <tr>
                            <th>Class Applied For</th>
                            <td><span style="color: var(--primary); font-weight: 800;">{{ $appData['class_applied'] }}</span></td>
                        </tr>
                        <tr>
                            <th>Academic Session</th>
                            <td>{{ $appData['academic_session'] ?? '2026/2027' }}</td>
                        </tr>
                        <tr>
                            <th>Parent / Guardian</th>
                            <td>{{ $appData['parent_name'] }} ({{ $appData['parent_relationship'] }})</td>
                        </tr>
                        <tr>
                            <th>Contact Phone</th>
                            <td>{{ $appData['parent_phone'] }}</td>
                        </tr>
                        <tr>
                            <th>Contact Email</th>
                            <td>{{ $appData['parent_email'] }}</td>
                        </tr>
                        <tr>
                            <th>Residential Address</th>
                            <td>{{ $appData['residential_address'] }}</td>
                        </tr>
                        <tr>
                            <th>Application Status</th>
                            <td><span style="background: #fef3c7; color: #b45309; padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.8125rem;">Under Review</span></td>
                        </tr>
                        <tr>
                            <th>Date & Time Logged</th>
                            <td>{{ $appData['submitted_at'] }}</td>
                        </tr>
                    </table>

                    <div class="slip-actions">
                        <button onclick="window.print()" class="btn-action btn-print">
                            <i class="fas fa-print"></i> Print Acknowledgment Slip
                        </button>
                        <a href="{{ route('admission.create') }}" class="btn-action btn-new">
                            <i class="fas fa-plus"></i> Submit Another Application
                        </a>
                        <a href="{{ route('home') }}" class="btn-action btn-new">
                            <i class="fas fa-arrow-left"></i> Return to Homepage
                        </a>
                    </div>
                </div>

            @else

                <!-- Application Form -->
                <form action="{{ route('admission.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if ($errors->any())
                        <div style="margin: 1.5rem 2.5rem 0; padding: 1rem 1.25rem; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; color: #b91c1c; font-size: 0.875rem;">
                            <strong>Please fix the errors below:</strong>
                            <ul style="margin-left: 1.25rem; margin-top: 0.25rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Section 1: Academic Information -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-number">1</div>
                            <h2 class="section-title">Academic Information</h2>
                        </div>

                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label" for="class_applied">
                                    Class Applying For <span class="required">*</span>
                                </label>
                                <select name="class_applied" id="class_applied" class="form-select" required>
                                    <option value="">-- Select Class to Enter --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->name }}" {{ old('class_applied') == $class->name ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="academic_session">
                                    Academic Session
                                </label>
                                <input type="text" name="academic_session" id="academic_session" class="form-input" value="{{ $sessionYear ?? '2026/2027' }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Student Personal Information -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-number">2</div>
                            <h2 class="section-title">Student Personal Details</h2>
                        </div>

                        <div class="form-grid-3">
                            <div class="form-group">
                                <label class="form-label" for="first_name">
                                    First Name <span class="required">*</span>
                                </label>
                                <input type="text" name="first_name" id="first_name" class="form-input" placeholder="e.g. Samuel" value="{{ old('first_name') }}" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="middle_name">
                                    Middle Name
                                </label>
                                <input type="text" name="middle_name" id="middle_name" class="form-input" placeholder="e.g. Chukwudi" value="{{ old('middle_name') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="last_name">
                                    Surname / Last Name <span class="required">*</span>
                                </label>
                                <input type="text" name="last_name" id="last_name" class="form-input" placeholder="e.g. Adebayo" value="{{ old('last_name') }}" required>
                            </div>
                        </div>

                        <div class="form-grid-3">
                            <div class="form-group">
                                <label class="form-label" for="gender">
                                    Gender <span class="required">*</span>
                                </label>
                                <select name="gender" id="gender" class="form-select" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="date_of_birth">
                                    Date of Birth <span class="required">*</span>
                                </label>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="form-input" value="{{ old('date_of_birth') }}" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="state_of_origin">
                                    State of Origin
                                </label>
                                <input type="text" name="state_of_origin" id="state_of_origin" class="form-input" placeholder="e.g. Lagos, Rivers, Oyo" value="{{ old('state_of_origin') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Parent / Guardian Information -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-number">3</div>
                            <h2 class="section-title">Parent / Guardian Information</h2>
                        </div>

                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label" for="parent_name">
                                    Parent / Guardian Full Name <span class="required">*</span>
                                </label>
                                <input type="text" name="parent_name" id="parent_name" class="form-input" placeholder="e.g. Dr. & Mrs. Adebayo" value="{{ old('parent_name') }}" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="parent_relationship">
                                    Relationship to Student <span class="required">*</span>
                                </label>
                                <select name="parent_relationship" id="parent_relationship" class="form-select" required>
                                    <option value="Father" {{ old('parent_relationship') == 'Father' ? 'selected' : '' }}>Father</option>
                                    <option value="Mother" {{ old('parent_relationship') == 'Mother' ? 'selected' : '' }}>Mother</option>
                                    <option value="Guardian" {{ old('parent_relationship') == 'Guardian' ? 'selected' : '' }}>Legal Guardian</option>
                                    <option value="Other" {{ old('parent_relationship') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-grid-3">
                            <div class="form-group">
                                <label class="form-label" for="parent_phone">
                                    Mobile Phone Number <span class="required">*</span>
                                </label>
                                <input type="tel" name="parent_phone" id="parent_phone" class="form-input" placeholder="e.g. 08012345678" value="{{ old('parent_phone') }}" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="parent_email">
                                    Email Address <span class="required">*</span>
                                </label>
                                <input type="email" name="parent_email" id="parent_email" class="form-input" placeholder="e.g. parent@example.com" value="{{ old('parent_email') }}" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="parent_occupation">
                                    Occupation / Workplace
                                </label>
                                <input type="text" name="parent_occupation" id="parent_occupation" class="form-input" placeholder="e.g. Civil Engineer" value="{{ old('parent_occupation') }}">
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label" for="residential_address">
                                Residential Home Address <span class="required">*</span>
                            </label>
                            <input type="text" name="residential_address" id="residential_address" class="form-input" placeholder="House number, Street, Area, City" value="{{ old('residential_address') }}" required>
                        </div>
                    </div>

                    <!-- Section 4: Previous Academic Background -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-number">4</div>
                            <h2 class="section-title">Previous Academic History</h2>
                        </div>

                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label" for="previous_school">
                                    Previous School Attended (if any)
                                </label>
                                <input type="text" name="previous_school" id="previous_school" class="form-input" placeholder="e.g. St. Michael International Academy" value="{{ old('previous_school') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="last_class_passed">
                                    Last Class Passed
                                </label>
                                <input type="text" name="last_class_passed" id="last_class_passed" class="form-input" placeholder="e.g. Primary 4 / JSS 1" value="{{ old('last_class_passed') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Section 5: Medical & Emergency Contact -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-number">5</div>
                            <h2 class="section-title">Medical & Emergency Information</h2>
                        </div>

                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label" for="emergency_contact">
                                    Emergency Contact Phone
                                </label>
                                <input type="tel" name="emergency_contact" id="emergency_contact" class="form-input" placeholder="e.g. 08087654321" value="{{ old('emergency_contact') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="medical_conditions">
                                    Known Allergies or Medical Conditions (Optional)
                                </label>
                                <input type="text" name="medical_conditions" id="medical_conditions" class="form-input" placeholder="e.g. Asthmatic, Penicillin allergy, or None" value="{{ old('medical_conditions') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Form Footer with Submit Button -->
                    <div class="form-footer">
                        <div class="footer-note">
                            <i class="fas fa-shield-alt" style="color: var(--accent);"></i>
                            Your personal information is confidential and protected by ES-SCHOOLS security policies.
                        </div>

                        <button type="submit" class="btn-submit">
                            <span>Submit Online Application</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>

                </form>

            @endif

        </div>
    </main>

    <!-- Footer -->
    <footer style="background: #ffffff; border-top: 1px solid var(--border-color); padding: 2rem 0; text-align: center; color: var(--text-muted); font-size: 0.875rem;">
        <div style="max-width: 1100px; margin: 0 auto; padding: 0 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <p>&copy; {{ date('Y') }} ES-SCHOOLS by <a href="https://extremesolutions.com.ng" target="_blank" rel="noopener noreferrer" style="color: #10b981; font-weight: 600; text-decoration: none;">ExtremeSolutions Nigeria</a>. All rights reserved.</p>
            <div style="display: flex; gap: 1.25rem; font-size: 0.85rem;">
                <span><i class="fas fa-phone-alt" style="color: #1e3a8a;"></i> 09052585622</span>
                <span><i class="fas fa-envelope" style="color: #10b981;"></i> sms@extremesolutions.com.ng</span>
                <a href="{{ route('contact') }}" style="color: #1e3a8a; font-weight: 600; text-decoration: none;">Contact Support</a>
            </div>
        </div>
    </footer>

</body>
</html>

