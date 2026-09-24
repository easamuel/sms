<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Graduation Certificate Sample - ES-SCHOOLS Sales Kit</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Great+Vibes&family=Playfair+Display:ital,wght@0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @page {
            size: A4 landscape;
            margin: 6mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Playfair Display', Georgia, serif;
            background: #0b1329;
            color: #1a202c;
            padding: 20px;
            min-height: 100vh;
        }

        /* Top Action Bar */
        .action-bar {
            max-width: 1050px;
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
            font-family: 'Plus Jakarta Sans', sans-serif;
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
            background: #b45309;
            color: #fef3c7;
            border: 1px solid #f59e0b;
            font-family: 'Plus Jakarta Sans', sans-serif;
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
            font-family: 'Plus Jakarta Sans', sans-serif;
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
            background: #d97706;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
        }

        .btn-print:hover {
            background: #b45309;
            transform: translateY(-1px);
        }

        .btn-whatsapp {
            background: #25d366;
            color: #ffffff;
        }

        /* Certificate Outer Frame */
        .cert-container {
            max-width: 1050px;
            margin: 0 auto;
            background: #fdfbf7;
            padding: 24px;
            border-radius: 4px;
            box-shadow: 0 20px 45px rgba(0,0,0,0.4);
            position: relative;
        }

        /* Gold Foil Filigree Outer Border */
        .gold-outer-border {
            border: 8px double #c59b27;
            padding: 14px;
            background: #fcf9f2;
            position: relative;
        }

        .gold-inner-border {
            border: 1.5px solid #d4af37;
            padding: 20px 30px;
            position: relative;
            background: radial-gradient(circle at center, #ffffff 0%, #faf6eb 100%);
        }

        /* Corner Ornaments */
        .corner-ornament {
            position: absolute;
            width: 32px;
            height: 32px;
            color: #c59b27;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .corner-tl { top: -2px; left: -2px; }
        .corner-tr { top: -2px; right: -2px; }
        .corner-bl { bottom: -2px; left: -2px; }
        .corner-br { bottom: -2px; right: -2px; }

        /* Watermark */
        .cert-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 14rem;
            color: rgba(212, 175, 55, 0.04);
            pointer-events: none;
            user-select: none;
            z-index: 0;
        }

        .cert-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        /* Certificate Header */
        .cert-crest {
            width: 75px;
            height: 75px;
            margin: 0 auto 8px auto;
            border-radius: 50%;
            border: 2px solid #c59b27;
            background: #172554;
            color: #d4af37;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            box-shadow: 0 4px 12px rgba(197, 155, 39, 0.25);
        }

        .cert-school-name {
            font-family: 'Cinzel', serif;
            font-size: 1.7rem;
            font-weight: 700;
            color: #172554;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .cert-school-tag {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            color: #78350f;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .cert-title-script {
            font-family: 'Cinzel', serif;
            font-size: 1.35rem;
            font-weight: 600;
            color: #92400e;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            border-bottom: 2px solid #d4af37;
            display: inline-block;
            padding-bottom: 4px;
            margin-bottom: 14px;
        }

        .cert-presentation-text {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 0.95rem;
            color: #475569;
            margin-bottom: 10px;
        }

        .recipient-name {
            font-family: 'Playfair Display', serif;
            font-size: 2.3rem;
            font-weight: 700;
            color: #172554;
            letter-spacing: 0.02em;
            margin-bottom: 10px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.05);
            border-bottom: 1px solid #cbd5e1;
            display: inline-block;
            padding: 0 35px 4px 35px;
        }

        .cert-body-text {
            max-width: 780px;
            margin: 0 auto 20px auto;
            font-family: 'Playfair Display', serif;
            font-size: 0.95rem;
            line-height: 1.6;
            color: #334155;
        }

        .cert-class-tag {
            font-family: 'Cinzel', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: #b45309;
            letter-spacing: 0.08em;
            margin-bottom: 22px;
        }

        /* Certificate Footer: Seal & Signatures */
        .cert-footer {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 25px;
            padding: 0 20px;
        }

        .sig-block {
            flex: 1;
            text-align: center;
        }

        .sig-handwritten {
            font-family: 'Great Vibes', cursive;
            font-size: 2.1rem;
            color: #172554;
            line-height: 1;
            margin-bottom: 2px;
        }

        .sig-divider {
            border-bottom: 1.5px solid #475569;
            width: 100%;
            margin-bottom: 4px;
        }

        .sig-name {
            font-family: 'Cinzel', serif;
            font-size: 0.8rem;
            font-weight: 700;
            color: #0f172a;
        }

        .sig-role {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.65rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        /* Gold Foil Embossed Seal */
        .embossed-gold-seal {
            width: 95px;
            height: 95px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, #fef08a 0%, #eab308 40%, #ca8a04 80%, #a16207 100%);
            border: 3px solid #fef08a;
            box-shadow: 0 8px 18px rgba(161, 98, 7, 0.4), inset 0 2px 4px rgba(255,255,255,0.6);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #713f12;
            padding: 6px;
            position: relative;
            transform: rotate(-5deg);
            flex-shrink: 0;
        }

        .seal-stars {
            font-size: 0.55rem;
            color: #713f12;
        }

        .seal-text-top {
            font-family: 'Cinzel', serif;
            font-size: 0.52rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .seal-center-icon {
            font-size: 1.25rem;
            color: #713f12;
            margin: 1px 0;
        }

        .seal-text-bot {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.48rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        /* Security Barcode & QR Code Strip */
        .cert-security-strip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 18px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.68rem;
            color: #64748b;
        }

        .cert-serial {
            font-family: monospace;
            font-weight: 700;
            color: #172554;
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
            .cert-container {
                box-shadow: none !important;
                max-width: 100% !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body>

    <!-- TOP ACTION BAR -->
    <div class="action-bar">
        <div class="action-bar-left">
            <a href="{{ route('materials.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> All Sales Materials
            </a>
            <span class="proof-badge">Proof 3 of 5: Graduation Certificate</span>
        </div>
        <div class="action-bar-right">
            <button onclick="window.print()" class="btn-action btn-print">
                <i class="fas fa-print"></i> Print A4 Landscape
            </button>
            <a href="https://wa.me/2349052585622?text=Hello%20ExtremeSolutions,%20I%20am%20reviewing%20the%20Official%20School%20Certificate%20sample%20and%20want%20to%20schedule%20a%20demo." target="_blank" class="btn-action btn-whatsapp">
                <i class="fab fa-whatsapp"></i> Share on WhatsApp
            </a>
        </div>
    </div>

    <!-- PRINTABLE A4 LANDSCAPE CERTIFICATE -->
    <div class="cert-container">
        <div class="gold-outer-border">
            <div class="gold-inner-border">
                
                <!-- Corner Ornaments -->
                <div class="corner-ornament corner-tl">&#10045;</div>
                <div class="corner-ornament corner-tr">&#10045;</div>
                <div class="corner-ornament corner-bl">&#10045;</div>
                <div class="corner-ornament corner-br">&#10045;</div>

                <div class="cert-watermark">&#9878;</div>

                <div class="cert-content">
                    
                    <!-- Header Crest -->
                    <div class="cert-crest">
                        <i class="fas fa-award"></i>
                    </div>

                    <h1 class="cert-school-name">Leadgate International Academy</h1>
                    <p class="cert-school-tag">Federal Republic of Nigeria &bull; Founded 1998 &bull; Govt. Reg. No: MOE/ED/4820</p>

                    <div class="cert-title-script">
                        Certificate of Academic Excellence &amp; Moral Testimonial
                    </div>

                    <p class="cert-presentation-text">This is to certify that</p>

                    <h2 class="recipient-name">Chinedu Emmanuel Okafor</h2>

                    <p class="cert-body-text">
                        having fulfilled with distinction all prescribed academic curricula, practical assessments, and character examinations under the statutory regulations of the Federal Ministry of Education and West African Examinations Council (WAEC), is hereby conferred this award as an exemplary graduate of the
                    </p>

                    <div class="cert-class-tag">
                        &mdash; Class of 2026 &mdash;
                    </div>

                    <!-- Footer: Signatures and Gold Seal -->
                    <div class="cert-footer">
                        
                        <!-- Left Signature: Board Chair -->
                        <div class="sig-block">
                            <div class="sig-handwritten">Chief J. K. Adeleke</div>
                            <div class="sig-divider"></div>
                            <div class="sig-name">Chief J. K. Adeleke, F.C.A.</div>
                            <div class="sig-role">Chairman, Board of Governors</div>
                        </div>

                        <!-- Center: Gold Foil Embossed Seal -->
                        <div class="embossed-gold-seal">
                            <div class="seal-stars">&#9733; &#9733; &#9733;</div>
                            <div class="seal-text-top">Leadgate Academy</div>
                            <div class="seal-center-icon"><i class="fas fa-shield-alt"></i></div>
                            <div class="seal-text-bot">Official Seal</div>
                            <div class="seal-stars">&#9733; &#9733; &#9733;</div>
                        </div>

                        <!-- Right Signature: Principal -->
                        <div class="sig-block">
                            <div class="sig-handwritten">Mrs. Adewale Adebayo</div>
                            <div class="sig-divider"></div>
                            <div class="sig-name">Mrs. Adewale Adebayo, M.Ed.</div>
                            <div class="sig-role">Principal &bull; Head of Academics</div>
                        </div>

                    </div>

                    <!-- Security Verification Strip -->
                    <div class="cert-security-strip">
                        <div>
                            <span>Certificate Serial: </span>
                            <span class="cert-serial">LIA-CERT-NG-2026-08492</span>
                        </div>
                        <div>
                            <span>Date of Award: <strong>18th Day of July, 2026</strong></span>
                        </div>
                        <div>
                            <span><i class="fas fa-lock" style="color: #059669;"></i> Tamper-Proof Cryptographic ID: <strong>9F8A-382C-4E12</strong></span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</body>
</html>
