<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Proofs &amp; Outreach Materials Kit - ES-SCHOOLS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0b1329;
            color: #f1f5f9;
            line-height: 1.6;
            padding-bottom: 60px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Top Bar */
        .top-nav {
            border-bottom: 1px solid #1e293b;
            padding: 16px 0;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #ffffff;
            font-weight: 800;
            font-size: 1.2rem;
        }

        .brand-badge {
            background: #10b981;
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 9999px;
            text-transform: uppercase;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-live-portal {
            background: #1e3a8a;
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-live-portal:hover {
            background: #2563eb;
        }

        .btn-whatsapp-hotline {
            background: #25d366;
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Hero Banner */
        .materials-hero {
            padding: 50px 0 35px 0;
            text-align: center;
            position: relative;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
            padding: 4px 14px;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 16px;
        }

        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            margin-bottom: 14px;
        }

        .hero-title span {
            background: linear-gradient(135deg, #34d399, #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-sub {
            font-size: 1.05rem;
            color: #94a3b8;
            max-width: 760px;
            margin: 0 auto 30px auto;
        }

        /* Physical Sales Kit Presentation Image Card */
        .flatlay-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
            margin-bottom: 50px;
        }

        .flatlay-img {
            width: 100%;
            height: auto;
            display: block;
        }

        .flatlay-caption {
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #0f172a;
            border-top: 1px solid #334155;
            font-size: 0.85rem;
            color: #94a3b8;
        }

        /* Proofs Grid */
        .proofs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }

        .proof-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 14px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s, border-color 0.25s, box-shadow 0.25s;
        }

        .proof-card:hover {
            transform: translateY(-4px);
            border-color: #3b82f6;
            box-shadow: 0 15px 30px rgba(30, 58, 138, 0.25);
        }

        .proof-card-header {
            padding: 18px 20px 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #334155;
        }

        .proof-tag {
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 3px 10px;
            border-radius: 9999px;
        }

        .tag-blue { background: #1e3a8a; color: #93c5fd; }
        .tag-green { background: #065f46; color: #a7f3d0; }
        .tag-amber { background: #78350f; color: #fde68a; }
        .tag-indigo { background: #3730a3; color: #c7d2fe; }

        .proof-thumb-box {
            background: #0f172a;
            height: 200px;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #334155;
        }

        .proof-thumb-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .proof-card:hover .proof-thumb-box img {
            transform: scale(1.03);
        }

        .proof-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .proof-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .proof-desc {
            font-size: 0.88rem;
            color: #94a3b8;
            line-height: 1.55;
            margin-bottom: 16px;
            flex-grow: 1;
        }

        .proof-target {
            font-size: 0.78rem;
            font-weight: 700;
            color: #38bdf8;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .proof-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .btn-view-proof {
            background: #2563eb;
            color: #ffffff;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-view-proof:hover {
            background: #1d4ed8;
        }

        .btn-print-direct {
            background: #0f172a;
            color: #34d399;
            border: 1px solid #059669;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-print-direct:hover {
            background: #059669;
            color: #ffffff;
        }

        /* Amazon & Meta Outreach Playbook Section */
        .playbook-card {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border: 1px solid #334155;
            border-radius: 16px;
            padding: 35px 40px;
            margin-bottom: 50px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }

        .playbook-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .playbook-sub {
            font-size: 0.95rem;
            color: #94a3b8;
            margin-bottom: 25px;
        }

        .playbook-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .playbook-box {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid #334155;
            border-radius: 10px;
            padding: 20px;
        }

        .playbook-box h4 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #38bdf8;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .playbook-steps {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
            font-size: 0.88rem;
        }

        .playbook-steps li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: #cbd5e1;
            line-height: 1.5;
        }

        .step-badge {
            background: #1e3a8a;
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 800;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 1.85rem; }
            .playbook-columns { grid-template-columns: 1fr; }
            .flatlay-caption { flex-direction: column; gap: 8px; text-align: center; }
            .nav-actions { display: none; }
        }
    </style>
</head>
<body>

    <!-- TOP NAVIGATION -->
    <header class="top-nav">
        <div class="container nav-inner">
            <a href="/" class="brand-link">
                <i class="fas fa-graduation-cap" style="color: #10b981;"></i>
                <span>ES-SCHOOLS</span>
                <span class="brand-badge">Sales Kit</span>
            </a>
            <div class="nav-actions">
                <a href="/#demos" class="btn-live-portal">
                    <i class="fas fa-play-circle"></i> Live Demos
                </a>
                <a href="https://wa.me/2349052585622?text=Hello%20ExtremeSolutions,%20I%20am%20reviewing%20the%20Sales%20Proofs%20and%20want%20to%20schedule%20a%20school%20presentation." target="_blank" class="btn-whatsapp-hotline">
                    <i class="fab fa-whatsapp"></i> WhatsApp: 09052585622
                </a>
            </div>
        </div>
    </header>

    <main class="container">
        
        <!-- HERO -->
        <section class="materials-hero">
            <div class="hero-eyebrow">
                <i class="fas fa-briefcase"></i> Amazon &amp; Meta Field Sales Suite
            </div>
            <h1 class="hero-title">
                5 Authoritative Proof Materials for <span>Proprietors &amp; Principals</span>
            </h1>
            <p class="hero-sub">
                Designed to eliminate buyer resistance in Nigerian private schools. Hand these physical samples to school owners to prove that your software actually works, calculates error-free tallies, and recovers tuition fees.
            </p>
        </section>

        <!-- PHYSICAL EXECUTIVE SALES KIT MOCKUP FLATLAY -->
        <div class="flatlay-card">
            <img src="{{ asset('images/executive-sales-kit.jpg') }}" alt="ES-SCHOOLS Executive Sales Kit Presentation Package" class="flatlay-img">
            <div class="flatlay-caption">
                <span><i class="fas fa-folder-open" style="color: #38bdf8;"></i> <strong>The Complete Field Presentation Folder:</strong> Luxury portfolio containing the Master Tally, Certificate, Report Card, Clearance Receipt, and 1-Pager.</span>
                <span>Ready for A4 Print &amp; PDF Export</span>
            </div>
        </div>

        <!-- THE 5 PROOFS GRID -->
        <section class="proofs-grid">
            
            <!-- PROOF 1: THE MASTER TALLY BROADSHEET -->
            <div class="proof-card">
                <div class="proof-card-header">
                    <span class="proof-tag tag-blue">Proof 1 &bull; Teacher &amp; Exam Officer</span>
                    <span style="font-size: 0.75rem; color: #94a3b8;"><i class="fas fa-print"></i> A4 Landscape</span>
                </div>
                <div class="proof-thumb-box">
                    <img src="{{ asset('images/proof-master-tally.jpg') }}" alt="Master Broadsheet Tally Sheet">
                </div>
                <div class="proof-body">
                    <h3 class="proof-title">Continuous Assessment Master Tally Broadsheet</h3>
                    <p class="proof-desc">
                        Shows teachers and exam officers how raw CA1 (20), CA2 (20), and Terminal Exam (60) marks are computed into cumulative scores, WAEC letter grades (A1 to F9), and class rankings in <strong>0.8 seconds</strong> without manual calculator errors.
                    </p>
                    <div class="proof-target">
                        <i class="fas fa-bullseye"></i> <strong>Show to:</strong> Head Teachers, Form Tutors, Exam Officers
                    </div>
                    <div class="proof-actions">
                        <a href="{{ route('materials.tally') }}" class="btn-view-proof">
                            <i class="fas fa-eye"></i> View Full Sheet
                        </a>
                        <a href="{{ route('materials.tally') }}#print" onclick="window.open('{{ route('materials.tally') }}', '_blank').focus();" class="btn-print-direct">
                            <i class="fas fa-print"></i> Print A4
                        </a>
                    </div>
                </div>
            </div>

            <!-- PROOF 2: THE OFFICIAL TERMINAL REPORT CARD -->
            <div class="proof-card">
                <div class="proof-card-header">
                    <span class="proof-tag tag-green">Proof 2 &bull; Parent &amp; PTA Experience</span>
                    <span style="font-size: 0.75rem; color: #94a3b8;"><i class="fas fa-print"></i> A4 Portrait</span>
                </div>
                <div class="proof-thumb-box">
                    <img src="{{ asset('images/mockup-parent-portal.png') }}" alt="Student Terminal Report Card">
                </div>
                <div class="proof-body">
                    <h3 class="proof-title">Official Student Terminal Report Card</h3>
                    <p class="proof-desc">
                        A pristine, tamper-proof academic report card featuring student passport, school crest, WAEC/NECO grade scale, psychomotor/affective domain appraisal, automated attendance tracker, and verifiable digital bursary clearance stamp.
                    </p>
                    <div class="proof-target">
                        <i class="fas fa-bullseye"></i> <strong>Show to:</strong> Principals, PTA Executives, Parents
                    </div>
                    <div class="proof-actions">
                        <a href="{{ route('materials.report-card') }}" class="btn-view-proof">
                            <i class="fas fa-eye"></i> View Full Sheet
                        </a>
                        <a href="{{ route('materials.report-card') }}#print" onclick="window.open('{{ route('materials.report-card') }}', '_blank').focus();" class="btn-print-direct">
                            <i class="fas fa-print"></i> Print A4
                        </a>
                    </div>
                </div>
            </div>

            <!-- PROOF 3: OFFICIAL SCHOOL GRADUATION CERTIFICATE -->
            <div class="proof-card">
                <div class="proof-card-header">
                    <span class="proof-tag tag-amber">Proof 3 &bull; Prestige &amp; Graduation</span>
                    <span style="font-size: 0.75rem; color: #94a3b8;"><i class="fas fa-print"></i> A4 Landscape</span>
                </div>
                <div class="proof-thumb-box">
                    <img src="{{ asset('images/proof-certificate-sample.jpg') }}" alt="School Graduation Certificate">
                </div>
                <div class="proof-body">
                    <h3 class="proof-title">Graduation &amp; Moral Testimonial Certificate</h3>
                    <p class="proof-desc">
                        Ivy League caliber parchment certificate with Victorian gold-foil filigree border, embossed seal stamp, Nigerian school crest, and cryptographic anti-forgery verification serial number. Proves the school’s high academic stature.
                    </p>
                    <div class="proof-target">
                        <i class="fas fa-bullseye"></i> <strong>Show to:</strong> School Proprietors, Board of Governors
                    </div>
                    <div class="proof-actions">
                        <a href="{{ route('materials.certificate') }}" class="btn-view-proof">
                            <i class="fas fa-eye"></i> View Certificate
                        </a>
                        <a href="{{ route('materials.certificate') }}#print" onclick="window.open('{{ route('materials.certificate') }}', '_blank').focus();" class="btn-print-direct">
                            <i class="fas fa-print"></i> Print A4
                        </a>
                    </div>
                </div>
            </div>

            <!-- PROOF 4: BURSAR TUITION RECOVERY AUDIT -->
            <div class="proof-card">
                <div class="proof-card-header">
                    <span class="proof-tag tag-green">Proof 4 &bull; Proprietor Financial Audit</span>
                    <span style="font-size: 0.75rem; color: #94a3b8;"><i class="fas fa-print"></i> A4 Portrait</span>
                </div>
                <div class="proof-thumb-box">
                    <img src="{{ asset('images/mockup-admin-portal.png') }}" alt="Bursary Tuition Recovery Audit">
                </div>
                <div class="proof-body">
                    <h3 class="proof-title">Bursary Recovery &amp; Paystack Clearance Slip</h3>
                    <p class="proof-desc">
                        Compares the old manual paper receipt bleed (32% fee defaults, fake transfer alerts) against the automated Paystack gateway with <strong>98.4% fee recovery</strong>. Includes itemized electronic student fee clearance slip.
                    </p>
                    <div class="proof-target">
                        <i class="fas fa-bullseye"></i> <strong>Show to:</strong> School Owners, Bursars, Accountants
                    </div>
                    <div class="proof-actions">
                        <a href="{{ route('materials.bursar-clearance') }}" class="btn-view-proof">
                            <i class="fas fa-eye"></i> View Audit Slip
                        </a>
                        <a href="{{ route('materials.bursar-clearance') }}#print" onclick="window.open('{{ route('materials.bursar-clearance') }}', '_blank').focus();" class="btn-print-direct">
                            <i class="fas fa-print"></i> Print A4
                        </a>
                    </div>
                </div>
            </div>

            <!-- PROOF 5: AMAZON WORKING BACKWARDS 1-PAGER -->
            <div class="proof-card">
                <div class="proof-card-header">
                    <span class="proof-tag tag-indigo">Proof 5 &bull; Executive Field Leave-Behind</span>
                    <span style="font-size: 0.75rem; color: #94a3b8;"><i class="fas fa-print"></i> A4 Portrait</span>
                </div>
                <div class="proof-thumb-box">
                    <img src="{{ asset('images/executive-sales-kit.jpg') }}" alt="Amazon Style Executive 1 Pager">
                </div>
                <div class="proof-body">
                    <h3 class="proof-title">Amazon-Style PR/FAQ Executive Brief</h3>
                    <p class="proof-desc">
                        A concise 1-page Customer Press Release and FAQ designed to leave on the proprietor’s desk. Features customer case study, 3-step zero-friction transition plan, and a physical tear-off consultation booking slip.
                    </p>
                    <div class="proof-target">
                        <i class="fas fa-bullseye"></i> <strong>Show to:</strong> Proprietors deciding between software vendors
                    </div>
                    <div class="proof-actions">
                        <a href="{{ route('materials.executive-one-pager') }}" class="btn-view-proof">
                            <i class="fas fa-eye"></i> View 1-Pager
                        </a>
                        <a href="{{ route('materials.executive-one-pager') }}#print" onclick="window.open('{{ route('materials.executive-one-pager') }}', '_blank').focus();" class="btn-print-direct">
                            <i class="fas fa-print"></i> Print A4
                        </a>
                    </div>
                </div>
            </div>

        </section>

        <!-- AMAZON & META SALES PLAYBOOK -->
        <section class="playbook-card">
            <h2 class="playbook-title">
                <i class="fas fa-lightbulb" style="color: #f59e0b;"></i> The In-Person Outreach Playbook (How to Pitch &amp; Close)
            </h2>
            <p class="playbook-sub">
                Follow these tested tactics during in-person school visits to turn hesitant proprietors into eager clients:
            </p>

            <div class="playbook-columns">
                <!-- Meta Physical Sales Method -->
                <div class="playbook-box">
                    <h4><i class="fas fa-hand-holding" style="color: #10b981;"></i> The Meta "Tangible First" Sales Method</h4>
                    <ul class="playbook-steps">
                        <li>
                            <span class="step-badge">1</span>
                            <div>
                                <strong>Place the physical certificate and tally sheet on their desk:</strong> Don't start by talking about software. Hand them the printed graduation certificate and the master tally sheet. Physical touch creates perceived value immediately.
                            </div>
                        </li>
                        <li>
                            <span class="step-badge">2</span>
                            <div>
                                <strong>Show the teacher arithmetic relief:</strong> Say: <em>&ldquo;Sir/Madam, your teachers spend two weeks manually adding up tally marks and report cards every December. ES-SCHOOLS does that in 0.8 seconds with 100% precision.&rdquo;</em>
                            </div>
                        </li>
                        <li>
                            <span class="step-badge">3</span>
                            <div>
                                <strong>Show the Tuition Bleed Slip:</strong> Hand over the Bursary Recovery slip. Ask: <em>&ldquo;How much unpaid school fees did your bursary lose to fake transfer alerts or uncollected debts last term?&rdquo;</em>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Amazon Working Backwards Method -->
                <div class="playbook-box">
                    <h4><i class="fas fa-award" style="color: #6366f1;"></i> The Amazon "Working Backwards" Method</h4>
                    <ul class="playbook-steps">
                        <li>
                            <span class="step-badge">1</span>
                            <div>
                                <strong>Lead with the customer result (PR/FAQ):</strong> Hand them the 1-Page Press Release. Let them read the headline: <em>&ldquo;Private Schools Cut 85% of Admin Overhead and Recover ₦14M with ES-SCHOOLS.&rdquo;</em>
                            </div>
                        </li>
                        <li>
                            <span class="step-badge">2</span>
                            <div>
                                <strong>Eliminate transition anxiety:</strong> Address the #1 hidden fear: <em>&ldquo;You don't need technical skills. We migrate your student records within 24 hours for free, and train your teachers in 45 minutes.&rdquo;</em>
                            </div>
                        </li>
                        <li>
                            <span class="step-badge">3</span>
                            <div>
                                <strong>Leave the physical folder behind:</strong> Leave the folder with the scannable QR code and WhatsApp number <strong>09052585622</strong> so other board members can review it.
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

    </main>

</body>
</html>

