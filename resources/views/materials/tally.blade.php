<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Broadsheet Tally Sheet Sample - ES-SCHOOLS Sales Kit</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @page {
            size: A4 landscape;
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
            color: #1e293b;
            padding: 20px;
            min-height: 100vh;
        }

        /* Top Action Bar (Hidden when printing) */
        .action-bar {
            max-width: 1100px;
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
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #ffffff;
        }

        .proof-badge {
            background: #1e3a8a;
            color: #60a5fa;
            border: 1px solid #3b82f6;
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

        .btn-whatsapp:hover {
            background: #1eb855;
            transform: translateY(-1px);
        }

        /* Printable Document Sheet */
        .sheet {
            max-width: 1100px;
            margin: 0 auto;
            background: #ffffff;
            padding: 24px 28px;
            border-radius: 4px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            border: 1px solid #cbd5e1;
            position: relative;
            overflow: hidden;
        }

        /* Subtle Security Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-25deg);
            font-size: 5.5rem;
            font-weight: 800;
            color: rgba(15, 23, 42, 0.03);
            white-space: nowrap;
            pointer-events: none;
            user-select: none;
            z-index: 0;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .sheet-inner {
            position: relative;
            z-index: 1;
        }

        /* Header Layout */
        .sheet-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 12px;
        }

        .header-logo-side {
            width: 75px;
            height: 75px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f1f5f9;
            border: 2px solid #1e3a8a;
            color: #1e3a8a;
            font-size: 2rem;
            flex-shrink: 0;
        }

        .header-title-center {
            text-align: center;
            flex-grow: 1;
            padding: 0 15px;
        }

        .republic-tag {
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #059669;
            margin-bottom: 2px;
        }

        .school-name {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .school-sub {
            font-size: 0.75rem;
            color: #475569;
            font-weight: 600;
            margin-top: 2px;
        }

        .document-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 4px;
            background: #eff6ff;
            display: inline-block;
            padding: 2px 14px;
            border-radius: 4px;
            border: 1px solid #bfdbfe;
        }

        .header-qr-side {
            text-align: right;
            flex-shrink: 0;
            width: 90px;
        }

        .qr-placeholder {
            width: 65px;
            height: 65px;
            margin-left: auto;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            padding: 3px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .qr-placeholder svg {
            width: 100%;
            height: 100%;
        }

        .qr-label {
            font-size: 0.6rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 3px;
            text-align: center;
        }

        /* Metadata Bar */
        .meta-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 8px 14px;
            border-radius: 6px;
            margin-bottom: 12px;
            font-size: 0.78rem;
        }

        .meta-item strong {
            color: #0f172a;
        }

        .meta-item span {
            color: #475569;
        }

        /* Broadsheet Tally Table */
        .tally-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.76rem;
            margin-bottom: 12px;
        }

        .tally-table th {
            background: #0f172a;
            color: #ffffff;
            padding: 6px 8px;
            text-align: center;
            font-weight: 700;
            border: 1px solid #334155;
            white-space: nowrap;
        }

        .tally-table th.name-col {
            text-align: left;
        }

        .tally-table td {
            padding: 5px 8px;
            border: 1px solid #cbd5e1;
            text-align: center;
            color: #1e293b;
        }

        .tally-table td.name-col {
            text-align: left;
            font-weight: 600;
        }

        .tally-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .tally-table tbody tr:hover {
            background-color: #f1f5f9;
        }

        .grade-badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 4px;
            font-weight: 800;
            font-size: 0.7rem;
        }

        .grade-a1 { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .grade-b2, .grade-b3 { background: #eff6ff; color: #1d4ed8; border: 1px solid #93c5fd; }
        .grade-c4, .grade-c5, .grade-c6 { background: #fef9c3; color: #a16207; border: 1px solid #fde047; }
        .grade-pass { background: #ffedd5; color: #c2410c; border: 1px solid #fed7aa; }

        .pos-badge {
            font-weight: 800;
            color: #1e3a8a;
        }
        .pos-1 { color: #d97706; font-weight: 900; }
        .pos-2 { color: #475569; font-weight: 900; }
        .pos-3 { color: #b45309; font-weight: 900; }

        /* Stats & Value Proposition Box */
        .bottom-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 15px;
            align-items: center;
            border-top: 1px solid #cbd5e1;
            padding-top: 10px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        .stat-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 6px 10px;
            border-radius: 6px;
            text-align: center;
        }

        .stat-num {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
        }

        .stat-lbl {
            font-size: 0.65rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Signatures & Seal */
        .auth-signatures {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .sig-block {
            text-align: center;
            flex: 1;
        }

        .sig-line {
            width: 100%;
            border-bottom: 1px dashed #64748b;
            margin-bottom: 4px;
            height: 24px;
            position: relative;
        }

        .sig-image-text {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 0.95rem;
            color: #1e3a8a;
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
        }

        .sig-title {
            font-size: 0.68rem;
            color: #475569;
            font-weight: 700;
            text-transform: uppercase;
        }

        .stamp-badge {
            width: 72px;
            height: 72px;
            border: 2px solid #2563eb;
            color: #2563eb;
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
            line-height: 1.1;
            box-shadow: inset 0 0 0 2px #dbeafe;
        }

        /* Pitch Highlight Banner at Bottom */
        .pitch-highlight-bar {
            margin-top: 12px;
            background: linear-gradient(90deg, #172554, #1e3a8a);
            color: #ffffff;
            padding: 8px 14px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.75rem;
        }

        .pitch-highlight-bar strong {
            color: #34d399;
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
            .tally-table th {
                background: #0f172a !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .pitch-highlight-bar {
                background: #1e3a8a !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <!-- TOP ACTION / NAVIGATION BAR (Hidden during print) -->
    <div class="action-bar">
        <div class="action-bar-left">
            <a href="{{ route('materials.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> All Sales Materials
            </a>
            <span class="proof-badge">Proof 1 of 5: The Master Tally</span>
        </div>
        <div class="action-bar-right">
            <button onclick="window.print()" class="btn-action btn-print">
                <i class="fas fa-print"></i> Print A4 Landscape
            </button>
            <a href="https://wa.me/2349052585622?text=Hello%20ExtremeSolutions,%20I%20am%20reviewing%20the%20Master%20Broadsheet%20Tally%20Sheet%20sample%20and%20want%20to%20schedule%20a%20demo." target="_blank" class="btn-action btn-whatsapp">
                <i class="fab fa-whatsapp"></i> Share on WhatsApp
            </a>
        </div>
    </div>

    <!-- PRINTABLE A4 LANDSCAPE BROADSHEET SHEET -->
    <div class="sheet">
        <div class="watermark">OFFICIAL ACADEMIC RECORD</div>
        <div class="sheet-inner">
            
            <!-- Sheet Header -->
            <div class="sheet-header">
                <div class="header-logo-side">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="header-title-center">
                    <div class="republic-tag">Federal Republic of Nigeria &bull; State Ministry of Education</div>
                    <h1 class="school-name">Premier Leadership Academy, Lagos</h1>
                    <p class="school-sub">Plot 14, Commercial Avenue, Ikeja &bull; Approved WAEC &amp; NECO Examination Centre No: 048219</p>
                    <div class="document-title">
                        Continuous Assessment &amp; Terminal Examination Master Broadsheet (Tally Sheet)
                    </div>
                </div>
                <div class="header-qr-side">
                    <div class="qr-placeholder">
                        <!-- Vector QR Code representation -->
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
                    </div>
                    <div class="qr-label">Scan to Verify</div>
                </div>
            </div>

            <!-- Meta Strip -->
            <div class="meta-strip">
                <div class="meta-item"><strong>Academic Session:</strong> <span>2025/2026 Academic Year</span></div>
                <div class="meta-item"><strong>Term:</strong> <span>Third Term (Promotional)</span></div>
                <div class="meta-item"><strong>Class:</strong> <span>SS 2 Science (Senior Secondary)</span></div>
                <div class="meta-item"><strong>Subject:</strong> <span>General Mathematics (WAEC Core)</span></div>
            </div>

            <!-- Broadsheet Tally Table -->
            <table class="tally-table">
                <thead>
                    <tr>
                        <th style="width: 35px;">S/N</th>
                        <th style="width: 110px;">Adm. No</th>
                        <th class="name-col">Student Full Name</th>
                        <th style="width: 45px;">Sex</th>
                        <th style="width: 65px;">CA 1 (20)</th>
                        <th style="width: 65px;">CA 2 (20)</th>
                        <th style="width: 65px;">Exam (60)</th>
                        <th style="width: 75px;">Total (100)</th>
                        <th style="width: 65px;">Grade</th>
                        <th style="width: 65px;">Position</th>
                        <th style="width: 170px;">Teacher Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>PLA/23/0101</td>
                        <td class="name-col">ADEBAYO Oluwaseun T.</td>
                        <td>M</td>
                        <td>18</td>
                        <td>19</td>
                        <td>56</td>
                        <td><strong>93</strong></td>
                        <td><span class="grade-badge grade-a1">A1</span></td>
                        <td><span class="pos-badge pos-1">1st</span></td>
                        <td>Exceptional analytical depth</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>PLA/23/0108</td>
                        <td class="name-col">CHUKWU Chinaza Emeka</td>
                        <td>M</td>
                        <td>17</td>
                        <td>18</td>
                        <td>54</td>
                        <td><strong>89</strong></td>
                        <td><span class="grade-badge grade-a1">A1</span></td>
                        <td><span class="pos-badge pos-2">2nd</span></td>
                        <td>Brilliant problem solver</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>PLA/23/0114</td>
                        <td class="name-col">MUSA Fatima Ibrahim</td>
                        <td>F</td>
                        <td>18</td>
                        <td>16</td>
                        <td>52</td>
                        <td><strong>86</strong></td>
                        <td><span class="grade-badge grade-a1">A1</span></td>
                        <td><span class="pos-badge pos-3">3rd</span></td>
                        <td>Consistent high-level focus</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>PLA/23/0122</td>
                        <td class="name-col">OKON Jane Bassey</td>
                        <td>F</td>
                        <td>16</td>
                        <td>17</td>
                        <td>49</td>
                        <td><strong>82</strong></td>
                        <td><span class="grade-badge grade-b2">B2</span></td>
                        <td><span class="pos-badge">4th</span></td>
                        <td>Very good mathematical mastery</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>PLA/23/0130</td>
                        <td class="name-col">BALOGUN David Ayomide</td>
                        <td>M</td>
                        <td>15</td>
                        <td>16</td>
                        <td>48</td>
                        <td><strong>79</strong></td>
                        <td><span class="grade-badge grade-b2">B2</span></td>
                        <td><span class="pos-badge">5th</span></td>
                        <td>Good grasp of algebraic concepts</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>PLA/23/0135</td>
                        <td class="name-col">OKAFOR Chinedu Emmanuel</td>
                        <td>M</td>
                        <td>16</td>
                        <td>15</td>
                        <td>46</td>
                        <td><strong>77</strong></td>
                        <td><span class="grade-badge grade-b3">B3</span></td>
                        <td><span class="pos-badge">6th</span></td>
                        <td>Commendable performance</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>PLA/23/0142</td>
                        <td class="name-col">IBRAHIM Yahaya Aliyu</td>
                        <td>M</td>
                        <td>14</td>
                        <td>15</td>
                        <td>44</td>
                        <td><strong>73</strong></td>
                        <td><span class="grade-badge grade-b3">B3</span></td>
                        <td><span class="pos-badge">7th</span></td>
                        <td>Steady academic progress</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>PLA/23/0149</td>
                        <td class="name-col">DANJUMA Zainab Bello</td>
                        <td>F</td>
                        <td>13</td>
                        <td>14</td>
                        <td>42</td>
                        <td><strong>69</strong></td>
                        <td><span class="grade-badge grade-c4">C4</span></td>
                        <td><span class="pos-badge">8th</span></td>
                        <td>Satisfactory result; practice more</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>PLA/23/0155</td>
                        <td class="name-col">EZEOBI Somtochukwu K.</td>
                        <td>M</td>
                        <td>14</td>
                        <td>13</td>
                        <td>40</td>
                        <td><strong>67</strong></td>
                        <td><span class="grade-badge grade-c4">C4</span></td>
                        <td><span class="pos-badge">9th</span></td>
                        <td>Capable of higher achievement</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>PLA/23/0161</td>
                        <td class="name-col">AFOLABI Toluwanimi Grace</td>
                        <td>F</td>
                        <td>12</td>
                        <td>13</td>
                        <td>38</td>
                        <td><strong>63</strong></td>
                        <td><span class="grade-badge grade-c5">C5</span></td>
                        <td><span class="pos-badge">10th</span></td>
                        <td>Needs more focus on geometry</td>
                    </tr>
                </tbody>
            </table>

            <!-- Bottom Section: Summary Stats and Official Sign-offs -->
            <div class="bottom-section">
                <div>
                    <div class="stats-grid">
                        <div class="stat-box">
                            <div class="stat-num">45</div>
                            <div class="stat-lbl">Class Roll</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-num">93%</div>
                            <div class="stat-lbl">Highest Mark</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-num">77.4%</div>
                            <div class="stat-lbl">Class Average</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-num">100%</div>
                            <div class="stat-lbl">Pass Rate</div>
                        </div>
                    </div>
                </div>

                <div class="auth-signatures">
                    <div class="sig-block">
                        <div class="sig-line">
                            <span class="sig-image-text">Mr. A. Fashola</span>
                        </div>
                        <div class="sig-title">Subject Teacher</div>
                    </div>
                    <div class="stamp-badge">
                        <span>Central Academic Board</span>
                        <span style="font-size: 0.7rem; color: #10b981;">* APPROVED *</span>
                        <span>Lagos State</span>
                    </div>
                    <div class="sig-block">
                        <div class="sig-line">
                            <span class="sig-image-text">Dr. Mrs. K. Balogun</span>
                        </div>
                        <div class="sig-title">Principal's Seal</div>
                    </div>
                </div>
            </div>

            <!-- Pitch Highlight Bar -->
            <div class="pitch-highlight-bar">
                <span><i class="fas fa-bolt" style="color: #34d399;"></i> <strong>Instant Computation:</strong> Generated automatically in <strong>0.8 seconds</strong> by the ES-SCHOOLS Academic Engine.</span>
                <span><strong>Zero Math Errors</strong> &bull; Automated WAEC/NECO Grade &amp; Rank Conversion</span>
            </div>

        </div>
    </div>

</body>
</html>
