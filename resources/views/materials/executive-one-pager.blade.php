<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazon-Style Executive 1-Pager & PR/FAQ - ES-SCHOOLS Sales Kit</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            background: #0b1329;
            color: #0f172a;
            padding: 20px;
            min-height: 100vh;
        }

        /* Top Action Bar */
        .action-bar {
            max-width: 860px;
            margin: 0 auto 20px auto;
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid #334155;
            padding: 12px 24px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        .action-bar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .back-link {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .back-link:hover {
            color: #ffffff;
        }

        .proof-badge {
            background: #4338ca;
            color: #e0e7ff;
            border: 1px solid #6366f1;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 4px 10px;
            border-radius: 9999px;
        }

        .action-bar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-action {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-print {
            background: #10b981;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-print:hover {
            background: #059669;
            transform: translateY(-1px);
        }

        .btn-whatsapp {
            background: #25d366;
            color: #ffffff;
        }

        /* Printable Sheet */
        .sheet {
            max-width: 860px;
            margin: 0 auto;
            background: #ffffff;
            padding: 28px 34px;
            border-radius: 4px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            border: 1px solid #cbd5e1;
            position: relative;
        }

        /* Top Press Release Bar */
        .pr-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .pr-logo-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 800;
            font-size: 1.15rem;
            color: #172554;
        }

        .pr-tag {
            font-size: 0.72rem;
            font-weight: 800;
            color: #b91c1c;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        /* Main Headline */
        .pr-headline {
            font-size: 1.32rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.3;
            letter-spacing: -0.01em;
            margin-bottom: 6px;
        }

        .pr-dateline {
            font-size: 0.75rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .pr-lead {
            font-size: 0.88rem;
            line-height: 1.55;
            color: #334155;
            margin-bottom: 12px;
            font-weight: 500;
        }

        /* Executive Metrics Strip */
        .metrics-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 14px;
            text-align: center;
        }

        .metric-item .val {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1e3a8a;
        }

        .metric-item .lbl {
            font-size: 0.68rem;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
        }

        /* Customer Spotlight Quote Box */
        .quote-box {
            background: #eff6ff;
            border-left: 4px solid #1e3a8a;
            padding: 12px 16px;
            border-radius: 0 6px 6px 0;
            margin-bottom: 14px;
        }

        .quote-text {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 0.92rem;
            line-height: 1.5;
            color: #1e293b;
            margin-bottom: 6px;
        }

        .quote-author {
            font-size: 0.75rem;
            font-weight: 700;
            color: #1e3a8a;
        }

        /* Two Column Body Section */
        .two-col-layout {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 18px;
            margin-bottom: 14px;
        }

        .col-card {
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            border-radius: 6px;
            background: #ffffff;
        }

        .col-card h4 {
            font-size: 0.82rem;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 4px;
        }

        .feature-bullets {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 6px;
            font-size: 0.78rem;
        }

        .feature-bullets li {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            color: #334155;
            line-height: 1.4;
        }

        .feature-bullets li i {
            color: #10b981;
            margin-top: 3px;
            font-size: 0.8rem;
        }

        /* The 3-Step Simple Transition */
        .steps-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 14px;
        }

        .step-mini-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
            border-radius: 6px;
        }

        .step-num {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #1e3a8a;
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 4px;
        }

        .step-title {
            font-size: 0.78rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .step-desc {
            font-size: 0.7rem;
            color: #64748b;
            line-height: 1.35;
        }

        /* Executive Tear-off / Call-to-Action Slip */
        .executive-action-slip {
            border: 2px dashed #1e3a8a;
            background: #f0fdf4;
            padding: 12px 18px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .action-details h4 {
            font-size: 0.95rem;
            font-weight: 800;
            color: #065f46;
            margin-bottom: 2px;
        }

        .action-details p {
            font-size: 0.75rem;
            color: #047857;
        }

        .contact-pill-box {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .contact-chip {
            background: #ffffff;
            border: 1px solid #10b981;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #065f46;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .qr-action-box {
            text-align: center;
            flex-shrink: 0;
        }

        .qr-action-box svg {
            width: 55px;
            height: 55px;
            border: 1px solid #cbd5e1;
            padding: 2px;
            background: #ffffff;
            border-radius: 4px;
        }

        .qr-action-lbl {
            font-size: 0.58rem;
            font-weight: 700;
            color: #047857;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }
            .action-bar {
                display: none !important;
            }
            .sheet {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body>

    <!-- ACTION BAR -->
    <div class="action-bar">
        <div class="action-bar-left">
            <a href="{{ route('materials.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> All Sales Materials
            </a>
            <span class="proof-badge">Proof 5 of 5: Executive Leave-Behind PR/FAQ</span>
        </div>
        <div class="action-bar-right">
            <button onclick="window.print()" class="btn-action btn-print">
                <i class="fas fa-print"></i> Print A4 Portrait
            </button>
            <a href="https://wa.me/2349052585622?text=Hello%20ExtremeSolutions,%20I%20am%20reviewing%20the%20Executive%201-Pager%20PR/FAQ%20and%20want%20to%20schedule%20a%20demo." target="_blank" class="btn-action btn-whatsapp">
                <i class="fab fa-whatsapp"></i> Share on WhatsApp
            </a>
        </div>
    </div>

    <!-- SHEET -->
    <div class="sheet">
        
        <!-- Press Release Bar -->
        <div class="pr-header">
            <div class="pr-logo-brand">
                <i class="fas fa-graduation-cap" style="color: #10b981;"></i>
                <span>ES-SCHOOLS</span>
            </div>
            <div class="pr-tag">
                FOR IMMEDIATE RELEASE &bull; EXECUTIVE BRIEF
            </div>
        </div>

        <h1 class="pr-headline">
            Leading Nigerian Private Schools Eliminate Fee Defaults and Cut Administrative Paperwork by 85% with ES-SCHOOLS
        </h1>

        <div class="pr-dateline">
            LAGOS &amp; ABUJA, NIGERIA &bull; ACADEMIC DIGITIZATION INITIATIVE
        </div>

        <p class="pr-lead">
            <strong>ES-SCHOOLS</strong> today announced the widespread deployment of its unified school management and automated tuition fee recovery platform across private primary, junior, and senior secondary schools in Nigeria. The cloud-native system solves the three most painful operational crises facing school proprietors: <strong>unpaid tuition fees, late-night report card arithmetic, and paper register chaos</strong>.
        </p>

        <!-- Executive Metrics Strip -->
        <div class="metrics-strip">
            <div class="metric-item">
                <div class="val">&#8358;150M+</div>
                <div class="lbl">Tuition Tracked</div>
            </div>
            <div class="metric-item">
                <div class="val">98.4%</div>
                <div class="lbl">Fee Recovery Rate</div>
            </div>
            <div class="metric-item">
                <div class="val">0.8 Sec</div>
                <div class="lbl">Broadsheet Math</div>
            </div>
            <div class="metric-item">
                <div class="val">24 Hours</div>
                <div class="lbl">Zero-Risk Setup</div>
            </div>
        </div>

        <!-- Customer Spotlight Quote -->
        <div class="quote-box">
            <p class="quote-text">
                &ldquo;Before ES-SCHOOLS, compiling terminal report cards took our 28 teachers two agonizing weeks every December and July. With ES-SCHOOLS, teachers enter continuous assessment marks on their phones, and our complete broadsheet and report cards are generated in less than two hours. More importantly, we recovered over &#8358;6.4 million in overdue fees in our very first term.&rdquo;
            </p>
            <div class="quote-author">
                &mdash; Mrs. F. A. Adenuga, M.Ed., Principal &amp; Proprietress, Kingsway Model College, Ikeja, Lagos
            </div>
        </div>

        <!-- Two Column Breakdown -->
        <div class="two-col-layout">
            <div class="col-card">
                <h4>What School Owners Gain Immediately</h4>
                <ul class="feature-bullets">
                    <li><i class="fas fa-check-circle"></i> <strong>Automated Paystack Gateway:</strong> Parents pay fees directly into your school bank account with instant receipts sent via WhatsApp.</li>
                    <li><i class="fas fa-check-circle"></i> <strong>Zero Calculator Errors:</strong> CA1, CA2, Exam, and WAEC grades computed with 100% precision.</li>
                    <li><i class="fas fa-check-circle"></i> <strong>Mobile Attendance Register:</strong> Mark whole classes in 30 seconds on any Android phone.</li>
                    <li><i class="fas fa-check-circle"></i> <strong>CBT Exam Engine:</strong> Built-in WAEC/JAMB standard online testing.</li>
                </ul>
            </div>

            <div class="col-card">
                <h4>Common Proprietor Questions (FAQ)</h4>
                <ul class="feature-bullets">
                    <li><i class="fas fa-question-circle" style="color: #6366f1;"></i> <strong>Do staff need computers?</strong> No. Works smoothly on teachers' smartphones.</li>
                    <li><i class="fas fa-question-circle" style="color: #6366f1;"></i> <strong>What if internet is slow?</strong> Built with ultra-low data footprint (works on 3G).</li>
                    <li><i class="fas fa-question-circle" style="color: #6366f1;"></i> <strong>Are student records safe?</strong> 256-bit encrypted daily automated cloud backups.</li>
                </ul>
            </div>
        </div>

        <!-- The 3-Step Simple Transition -->
        <div class="steps-container">
            <div class="step-mini-card">
                <div class="step-num">1</div>
                <div class="step-title">Send Student List</div>
                <div class="step-desc">Hand over your current register in Excel, paper, or WhatsApp.</div>
            </div>
            <div class="step-mini-card">
                <div class="step-num">2</div>
                <div class="step-title">24-Hr Free Setup</div>
                <div class="step-desc">Our team uploads your curriculum and trains staff in 45 minutes.</div>
            </div>
            <div class="step-mini-card">
                <div class="step-num">3</div>
                <div class="step-title">Run on Autopilot</div>
                <div class="step-desc">Track tuition fees, publish results, and eliminate paper stress.</div>
            </div>
        </div>

        <!-- Executive Action Slip -->
        <div class="executive-action-slip">
            <div class="action-details">
                <h4>Schedule Your Free 45-Minute School Audit</h4>
                <p>We will walk you through your personalized school portal with zero setup fee.</p>
            </div>
            <div class="contact-pill-box">
                <div class="contact-chip">
                    <i class="fab fa-whatsapp" style="color: #25d366; font-size: 1.1rem;"></i>
                    <span>09052585622</span>
                </div>
            </div>
            <div class="qr-action-box">
                <svg viewBox="0 0 100 100" fill="#0f172a">
                    <rect x="0" y="0" width="30" height="30" rx="3"/>
                    <rect x="5" y="5" width="20" height="20" fill="#fff"/>
                    <rect x="10" y="10" width="10" height="10"/>
                    <rect x="70" y="0" width="30" height="30" rx="3"/>
                    <rect x="75" y="5" width="20" height="20" fill="#fff"/>
                    <rect x="80" y="10" width="10" height="10"/>
                    <rect x="0" y="70" width="30" height="30" rx="3"/>
                    <rect x="5" y="75" width="20" height="20" fill="#fff"/>
                    <rect x="10" y="80" width="10" height="10"/>
                    <rect x="35" y="10" width="8" height="8"/>
                    <rect x="50" y="15" width="12" height="6"/>
                    <rect x="35" y="35" width="30" height="30"/>
                    <rect x="75" y="45" width="15" height="10"/>
                    <rect x="40" y="75" width="15" height="15"/>
                    <rect x="65" y="75" width="25" height="15"/>
                </svg>
                <div class="qr-action-lbl">Scan for Demo</div>
            </div>
        </div>

    </div>

</body>
</html>

