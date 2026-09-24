<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bursar Tuition Recovery & Fee Clearance Audit - ES-SCHOOLS Sales Kit</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
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
            background: #047857;
            color: #d1fae5;
            border: 1px solid #10b981;
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
            padding: 28px 32px;
            border-radius: 4px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            border: 1px solid #cbd5e1;
            position: relative;
        }

        /* Header */
        .header-strip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .school-info h1 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
        }

        .school-info p {
            font-size: 0.75rem;
            color: #475569;
            font-weight: 600;
        }

        .doc-title-badge {
            background: #172554;
            color: #ffffff;
            padding: 4px 14px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-align: right;
        }

        /* SECTION A: THE PROPRIETOR'S TUITION RECOVERY AUDIT */
        .audit-card {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 18px;
        }

        .audit-heading {
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #1e3a8a;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 6px;
        }

        .audit-comparison-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .comparison-col {
            padding: 10px 14px;
            border-radius: 6px;
        }

        .col-old-way {
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .col-new-way {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
        }

        .col-title {
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 6px;
        }

        .col-old-way .col-title { color: #b91c1c; }
        .col-new-way .col-title { color: #047857; }

        .stat-line {
            display: flex;
            justify-content: space-between;
            font-size: 0.78rem;
            margin-bottom: 4px;
        }

        .stat-line strong {
            color: #0f172a;
        }

        .stat-highlight-old {
            font-size: 1.15rem;
            font-weight: 800;
            color: #dc2626;
            margin-top: 4px;
        }

        .stat-highlight-new {
            font-size: 1.15rem;
            font-weight: 800;
            color: #059669;
            margin-top: 4px;
        }

        /* SECTION B: STUDENT FEE RECEIPT & CLEARANCE */
        .receipt-card {
            border: 2px solid #0f172a;
            border-radius: 8px;
            padding: 16px 20px;
            background: #ffffff;
            position: relative;
        }

        .receipt-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px dashed #94a3b8;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }

        .receipt-brand h3 {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f172a;
        }

        .receipt-brand span {
            font-size: 0.72rem;
            color: #64748b;
        }

        .receipt-ref-box {
            text-align: right;
            font-size: 0.72rem;
        }

        .receipt-ref-box strong {
            color: #1e3a8a;
            font-size: 0.82rem;
            font-family: monospace;
        }

        /* Student Mini Bio */
        .student-receipt-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            border-radius: 6px;
            margin-bottom: 12px;
            font-size: 0.76rem;
        }

        /* Itemized Fee Table */
        .fee-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.76rem;
            margin-bottom: 12px;
        }

        .fee-table th {
            background: #0f172a;
            color: #ffffff;
            padding: 6px 10px;
            text-align: left;
            font-weight: 700;
        }

        .fee-table th.amount-col {
            text-align: right;
        }

        .fee-table td {
            padding: 5px 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .fee-table td.amount-col {
            text-align: right;
            font-weight: 600;
        }

        .fee-table tr.total-row td {
            border-top: 2px solid #0f172a;
            border-bottom: 2px solid #0f172a;
            font-size: 0.85rem;
            font-weight: 800;
            background: #f1f5f9;
        }

        /* Payment Clearance Banner */
        .clearance-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ecfdf5;
            border: 2px solid #10b981;
            padding: 10px 16px;
            border-radius: 6px;
            margin-bottom: 14px;
        }

        .clearance-status {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .clearance-status i {
            font-size: 1.8rem;
            color: #059669;
        }

        .clearance-status h4 {
            font-size: 0.95rem;
            font-weight: 800;
            color: #065f46;
        }

        .clearance-status p {
            font-size: 0.72rem;
            color: #047857;
        }

        .outstanding-balance {
            text-align: right;
        }

        .outstanding-balance span {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #047857;
        }

        .outstanding-balance h3 {
            font-size: 1.4rem;
            font-weight: 900;
            color: #059669;
        }

        /* Signatures and Stamps */
        .footer-signs {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-top: 8px;
        }

        .bursar-stamp {
            width: 75px;
            height: 75px;
            border: 2px solid #059669;
            color: #059669;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 0.52rem;
            font-weight: 800;
            text-transform: uppercase;
            transform: rotate(-10deg);
            padding: 4px;
        }

        .barcode-box {
            font-family: monospace;
            font-size: 0.72rem;
            color: #64748b;
            text-align: center;
            letter-spacing: 0.15em;
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
                max-width: 100% !important;
                padding: 0 !important;
            }
            .fee-table th {
                background: #0f172a !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .clearance-banner {
                background: #ecfdf5 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
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
            <span class="proof-badge">Proof 4 of 5: Bursary Recovery &amp; Clearance</span>
        </div>
        <div class="action-bar-right">
            <button onclick="window.print()" class="btn-action btn-print">
                <i class="fas fa-print"></i> Print A4 Portrait
            </button>
            <a href="https://wa.me/2349052585622?text=Hello%20ExtremeSolutions,%20I%20am%20reviewing%20the%20Bursar%20Tuition%20Recovery%20Clearance%20sample%20and%20want%20to%20schedule%20a%20demo." target="_blank" class="btn-action btn-whatsapp">
                <i class="fab fa-whatsapp"></i> Share on WhatsApp
            </a>
        </div>
    </div>

    <!-- SHEET -->
    <div class="sheet">
        
        <!-- Header -->
        <div class="header-strip">
            <div class="school-info">
                <h1>Premier Leadership Academy</h1>
                <p>Bursary &amp; Financial Accounting Department &bull; Lagos, Nigeria</p>
            </div>
            <div class="doc-title-badge">
                Tuition Recovery &amp; Clearance Audit
            </div>
        </div>

        <!-- SECTION A: THE PROPRIETOR'S TUITION RECOVERY AUDIT -->
        <div class="audit-card">
            <div class="audit-heading">
                <span>Executive Tuition Recovery Audit &bull; Termly Revenue Impact</span>
                <span style="color: #059669;"><i class="fas fa-chart-line"></i> Direct-to-Bank Reconciliation</span>
            </div>

            <div class="audit-comparison-grid">
                <!-- Old Way -->
                <div class="comparison-col col-old-way">
                    <div class="col-title"><i class="fas fa-times-circle"></i> The Old Way (Manual Paper Tellers)</div>
                    <div class="stat-line"><span>Total Term Fees Billed:</span> <strong>&#8358;24,560,000</strong></div>
                    <div class="stat-line"><span>Collected Before Exams:</span> <strong>&#8358;16,700,000 (68%)</strong></div>
                    <div class="stat-line"><span>Misplaced / Fake Transfer Alerts:</span> <strong>&#8358;1,850,000</strong></div>
                    <div class="stat-highlight-old">&#8358;7,860,000 Uncollected Debt</div>
                </div>

                <!-- ES-SCHOOLS Way -->
                <div class="comparison-col col-new-way">
                    <div class="col-title"><i class="fas fa-check-circle"></i> The ES-SCHOOLS Way (Automated Gateway)</div>
                    <div class="stat-line"><span>Total Term Fees Billed:</span> <strong>&#8358;24,560,000</strong></div>
                    <div class="stat-line"><span>Automated Recovery Rate:</span> <strong>98.2% On-Time</strong></div>
                    <div class="stat-line"><span>Fake Receipts / Discrepancies:</span> <strong>&#8358;0.00 (Zero Leakage)</strong></div>
                    <div class="stat-highlight-new">&#8358;7,420,000 Net Capital Recovered</div>
                </div>
            </div>
        </div>

        <!-- SECTION B: OFFICIAL STUDENT FEE CLEARANCE SLIP -->
        <div class="receipt-card">
            <div class="receipt-header-row">
                <div class="receipt-brand">
                    <h3>Official Electronic Fee Receipt &amp; Exam Clearance Slip</h3>
                    <span>Verified Instant Paystack / Flutterwave Gateway Settlement</span>
                </div>
                <div class="receipt-ref-box">
                    <div>Receipt No: <strong>#ES-REC-2026-90412</strong></div>
                    <div>Transaction Ref: <strong>PSK-TRX-2026-89218-NG</strong></div>
                    <div>Date: <strong>14-May-2026 09:14 AM</strong></div>
                </div>
            </div>

            <div class="student-receipt-grid">
                <div><strong>Student Name:</strong> OKAFOR, Chinedu E.</div>
                <div><strong>Admission No:</strong> PLA/2023/0482</div>
                <div><strong>Class:</strong> JSS 3 Gold</div>
                <div><strong>Parent/Payer:</strong> Mr. Emeka Okafor</div>
                <div><strong>Payment Method:</strong> Online Card / Bank Transfer</div>
                <div><strong>Bank Channel:</strong> Zenith Bank Instant Settlement</div>
            </div>

            <table class="fee-table">
                <thead>
                    <tr>
                        <th style="width: 30px;">#</th>
                        <th>Fee Item &amp; Description</th>
                        <th class="amount-col">Billed Amount (&#8358;)</th>
                        <th class="amount-col">Paid Amount (&#8358;)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Tuition Fee &amp; Academic Instruction (3rd Term)</td>
                        <td class="amount-col">120,000.00</td>
                        <td class="amount-col">120,000.00</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>ICT &amp; Online CBT Examination Infrastructure Levy</td>
                        <td class="amount-col">15,000.00</td>
                        <td class="amount-col">15,000.00</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Science Laboratory &amp; STEM Workshop Materials</td>
                        <td class="amount-col">10,000.00</td>
                        <td class="amount-col">10,000.00</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Extracurricular Activities, Sports &amp; Clubs</td>
                        <td class="amount-col">5,000.00</td>
                        <td class="amount-col">5,000.00</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Parent Teacher Association (PTA) Termly Levy</td>
                        <td class="amount-col">5,000.00</td>
                        <td class="amount-col">5,000.00</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="2" style="text-align: right;"><strong>TOTAL TERM FEES CLEARED:</strong></td>
                        <td class="amount-col">&#8358;155,000.00</td>
                        <td class="amount-col" style="color: #059669;">&#8358;155,000.00</td>
                    </tr>
                </tbody>
            </table>

            <!-- Clearance Banner -->
            <div class="clearance-banner">
                <div class="clearance-status">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <h4>EXAMINATION ADMISSION CLEARED</h4>
                        <p>Student is 100% authorized to sit for 3rd Term Promotional Examinations &amp; access CBT portal.</p>
                    </div>
                </div>
                <div class="outstanding-balance">
                    <span>Outstanding Balance</span>
                    <h3>&#8358;0.00</h3>
                </div>
            </div>

            <!-- Footer Signs -->
            <div class="footer-signs">
                <div style="font-size: 0.72rem; color: #475569; max-width: 380px;">
                    <p><strong>Bursary Verification Notice:</strong> This digital receipt is cryptographically generated upon bank confirmation. No manual teller paper is required. Instant receipts are automatically dispatched to parent WhatsApp.</p>
                </div>

                <div class="barcode-box">
                    <div>||| | ||||| || |||||| | |||| |||</div>
                    <div>PLA-FEE-89218-NG</div>
                </div>

                <div class="bursar-stamp">
                    <span>Bursary Dept</span>
                    <span style="font-size: 0.65rem; color: #10b981;">* CLEARED *</span>
                    <span>Fully Paid</span>
                </div>
            </div>

        </div>

    </div>

</body>
</html>
