<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Terminal Report Card Sample - ES-SCHOOLS Sales Kit</title>
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
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #ffffff;
        }

        .proof-badge {
            background: #059669;
            color: #a7f3d0;
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
            padding: 26px 30px;
            border-radius: 4px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            border: 2px solid #0f172a;
            position: relative;
            overflow: hidden;
        }

        .security-border {
            border: 1px solid #94a3b8;
            padding: 16px;
            position: relative;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 5rem;
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

        /* Header */
        .report-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 12px;
        }

        .crest-box {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e3a8a, #059669);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(30, 58, 138, 0.25);
        }

        .header-center {
            text-align: center;
            flex: 1;
            padding: 0 15px;
        }

        .school-h1 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            line-height: 1.2;
        }

        .school-motto {
            font-size: 0.72rem;
            font-style: italic;
            color: #059669;
            font-weight: 700;
            margin: 2px 0;
        }

        .school-address {
            font-size: 0.72rem;
            color: #475569;
        }

        .report-title-badge {
            background: #1e3a8a;
            color: #ffffff;
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 3px 16px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 6px;
        }

        .student-photo-box {
            width: 75px;
            height: 85px;
            border: 2px solid #cbd5e1;
            border-radius: 6px;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 0.65rem;
            text-align: center;
            padding: 4px;
            flex-shrink: 0;
        }

        .student-photo-box i {
            font-size: 1.8rem;
            color: #64748b;
            margin-bottom: 2px;
        }

        /* Student Profile Grid */
        .student-bio-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 12px;
            font-size: 0.78rem;
        }

        .bio-field strong {
            color: #0f172a;
        }
        .bio-field span {
            color: #334155;
        }

        /* Academic Subject Table */
        .academic-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.74rem;
            margin-bottom: 12px;
        }

        .academic-table th {
            background: #0f172a;
            color: #ffffff;
            padding: 5px 6px;
            text-align: center;
            font-weight: 700;
            border: 1px solid #334155;
            white-space: nowrap;
        }

        .academic-table th.subject-col {
            text-align: left;
            padding-left: 8px;
        }

        .academic-table td {
            padding: 4px 6px;
            border: 1px solid #cbd5e1;
            text-align: center;
        }

        .academic-table td.subject-col {
            text-align: left;
            padding-left: 8px;
            font-weight: 600;
        }

        .academic-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .grade-pill {
            font-weight: 800;
            padding: 1px 5px;
            border-radius: 3px;
            font-size: 0.7rem;
        }
        .grade-a1 { background: #dcfce7; color: #166534; }
        .grade-b2, .grade-b3 { background: #dbeafe; color: #1e40af; }
        .grade-c4 { background: #fef9c3; color: #854d0e; }

        /* Performance Appraisal / Domains Grid */
        .dual-domains-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }

        .domains-card {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 8px 12px;
            background: #ffffff;
        }

        .domains-title {
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #1e3a8a;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
            margin-bottom: 6px;
            display: flex;
            justify-content: space-between;
        }

        .domains-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.7rem;
        }

        .domains-table td {
            padding: 2px 4px;
            border-bottom: 1px solid #f1f5f9;
        }

        .domains-table td.rating-val {
            text-align: right;
            font-weight: 700;
            color: #059669;
        }

        /* Result Overview Strip */
        .result-summary-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 12px;
            text-align: center;
        }

        .summary-val {
            font-size: 1.15rem;
            font-weight: 800;
            color: #065f46;
        }

        .summary-lbl {
            font-size: 0.68rem;
            font-weight: 700;
            color: #047857;
            text-transform: uppercase;
        }

        /* Remarks & Signatures */
        .remarks-section {
            border: 1px solid #cbd5e1;
            padding: 8px 12px;
            border-radius: 6px;
            margin-bottom: 12px;
            background: #ffffff;
            font-size: 0.74rem;
        }

        .remark-row {
            display: flex;
            align-items: flex-start;
            margin-bottom: 6px;
        }

        .remark-lbl {
            width: 130px;
            font-weight: 700;
            color: #0f172a;
            flex-shrink: 0;
        }

        .remark-text {
            color: #334155;
            flex: 1;
            font-style: italic;
        }

        /* Signatures Grid */
        .signatures-grid {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            padding-top: 8px;
        }

        .sig-col {
            flex: 1;
            text-align: center;
        }

        .sig-drawn {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 1.05rem;
            color: #1e3a8a;
            border-bottom: 1px dashed #64748b;
            padding-bottom: 2px;
            margin-bottom: 4px;
        }

        .sig-title-lbl {
            font-size: 0.68rem;
            color: #475569;
            font-weight: 700;
            text-transform: uppercase;
        }

        .official-seal-box {
            width: 80px;
            height: 80px;
            border: 2px solid #b91c1c;
            color: #b91c1c;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 0.55rem;
            font-weight: 800;
            text-transform: uppercase;
            transform: rotate(-8deg);
            padding: 4px;
            line-height: 1.1;
        }

        .bursar-clearance-stamp {
            background: #ecfdf5;
            border: 1px solid #10b981;
            color: #047857;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.68rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
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
                border: 1px solid #0f172a !important;
                max-width: 100% !important;
                padding: 15px !important;
            }
            .academic-table th {
                background: #0f172a !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
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
            <span class="proof-badge">Proof 2 of 5: Terminal Report Card</span>
        </div>
        <div class="action-bar-right">
            <button onclick="window.print()" class="btn-action btn-print">
                <i class="fas fa-print"></i> Print A4 Portrait
            </button>
            <a href="https://wa.me/2349052585622?text=Hello%20ExtremeSolutions,%20I%20am%20reviewing%20the%20Official%20Terminal%20Report%20Card%20sample%20and%20want%20to%20schedule%20a%20demo." target="_blank" class="btn-action btn-whatsapp">
                <i class="fab fa-whatsapp"></i> Share on WhatsApp
            </a>
        </div>
    </div>

    <!-- PRINTABLE A4 PORTRAIT SHEET -->
    <div class="sheet">
        <div class="watermark">ACADEMIC EXCELLENCE</div>
        <div class="security-border">
            <div class="sheet-inner">
                
                <!-- Report Header -->
                <div class="report-header">
                    <div class="crest-box">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="header-center">
                        <h1 class="school-h1">Premier Leadership Academy</h1>
                        <p class="school-motto">&ldquo;Discipline, Knowledge and Character&rdquo;</p>
                        <p class="school-address">Plot 14, Commercial Avenue, Ikeja, Lagos State &bull; Tel: 09052585622</p>
                        <div class="report-title-badge">
                            Continuous Assessment &amp; Terminal Report Card
                        </div>
                    </div>
                    <div class="student-photo-box">
                        <i class="fas fa-user-circle"></i>
                        <span>STUDENT PASSPORT</span>
                    </div>
                </div>

                <!-- Student Bio Grid -->
                <div class="student-bio-grid">
                    <div class="bio-field"><strong>Student Name:</strong> <span>OKAFOR, Chinedu E.</span></div>
                    <div class="bio-field"><strong>Admission No:</strong> <span>PLA/2023/0482</span></div>
                    <div class="bio-field"><strong>Class:</strong> <span>JSS 3 Gold (Junior Sec.)</span></div>
                    <div class="bio-field"><strong>Gender / Age:</strong> <span>Male &bull; 14 Yrs</span></div>
                    <div class="bio-field"><strong>Term / Session:</strong> <span>3rd Term &bull; 2025/2026</span></div>
                    <div class="bio-field"><strong>Times School Opened:</strong> <span>120 Days</span></div>
                    <div class="bio-field"><strong>Times Present:</strong> <span>118 Days (98.3%)</span></div>
                    <div class="bio-field"><strong>House:</strong> <span>Nelson Mandela (Red)</span></div>
                </div>

                <!-- Academic Performance Table -->
                <table class="academic-table">
                    <thead>
                        <tr>
                            <th class="subject-col">Subject</th>
                            <th style="width: 55px;">CA1 (20)</th>
                            <th style="width: 55px;">CA2 (20)</th>
                            <th style="width: 55px;">Exam (60)</th>
                            <th style="width: 65px;">Total (100)</th>
                            <th style="width: 55px;">Class Min</th>
                            <th style="width: 55px;">Class Max</th>
                            <th style="width: 55px;">Class Avg</th>
                            <th style="width: 55px;">Grade</th>
                            <th style="width: 55px;">Pos.</th>
                            <th style="width: 140px;">Subject Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="subject-col">English Language</td>
                            <td>18</td>
                            <td>17</td>
                            <td>53</td>
                            <td><strong>88</strong></td>
                            <td>42</td>
                            <td>91</td>
                            <td>68.4</td>
                            <td><span class="grade-pill grade-a1">A1</span></td>
                            <td>2nd</td>
                            <td>Eloquent written expression</td>
                        </tr>
                        <tr>
                            <td class="subject-col">General Mathematics</td>
                            <td>19</td>
                            <td>18</td>
                            <td>55</td>
                            <td><strong>92</strong></td>
                            <td>38</td>
                            <td>96</td>
                            <td>65.2</td>
                            <td><span class="grade-pill grade-a1">A1</span></td>
                            <td>1st</td>
                            <td>Superb logical calculations</td>
                        </tr>
                        <tr>
                            <td class="subject-col">Basic Science</td>
                            <td>17</td>
                            <td>16</td>
                            <td>51</td>
                            <td><strong>84</strong></td>
                            <td>40</td>
                            <td>89</td>
                            <td>64.8</td>
                            <td><span class="grade-pill grade-a1">A1</span></td>
                            <td>3rd</td>
                            <td>Deep conceptual grasp</td>
                        </tr>
                        <tr>
                            <td class="subject-col">Basic Technology</td>
                            <td>16</td>
                            <td>17</td>
                            <td>48</td>
                            <td><strong>81</strong></td>
                            <td>35</td>
                            <td>85</td>
                            <td>61.5</td>
                            <td><span class="grade-pill grade-b2">B2</span></td>
                            <td>4th</td>
                            <td>Practical technical dexterity</td>
                        </tr>
                        <tr>
                            <td class="subject-col">Business Studies</td>
                            <td>18</td>
                            <td>18</td>
                            <td>54</td>
                            <td><strong>90</strong></td>
                            <td>45</td>
                            <td>94</td>
                            <td>71.0</td>
                            <td><span class="grade-pill grade-a1">A1</span></td>
                            <td>2nd</td>
                            <td>Excellent bookkeeping skill</td>
                        </tr>
                        <tr>
                            <td class="subject-col">Civic Education</td>
                            <td>17</td>
                            <td>18</td>
                            <td>52</td>
                            <td><strong>87</strong></td>
                            <td>50</td>
                            <td>92</td>
                            <td>72.5</td>
                            <td><span class="grade-pill grade-a1">A1</span></td>
                            <td>3rd</td>
                            <td>Commendable civic awareness</td>
                        </tr>
                        <tr>
                            <td class="subject-col">Computer Studies (ICT)</td>
                            <td>19</td>
                            <td>19</td>
                            <td>56</td>
                            <td><strong>94</strong></td>
                            <td>48</td>
                            <td>98</td>
                            <td>74.2</td>
                            <td><span class="grade-pill grade-a1">A1</span></td>
                            <td>2nd</td>
                            <td>Exceptional digital skills</td>
                        </tr>
                        <tr>
                            <td class="subject-col">Agricultural Science</td>
                            <td>15</td>
                            <td>16</td>
                            <td>46</td>
                            <td><strong>77</strong></td>
                            <td>41</td>
                            <td>83</td>
                            <td>63.1</td>
                            <td><span class="grade-pill grade-b3">B3</span></td>
                            <td>6th</td>
                            <td>Good practical fieldwork</td>
                        </tr>
                        <tr>
                            <td class="subject-col">Social Studies</td>
                            <td>16</td>
                            <td>16</td>
                            <td>50</td>
                            <td><strong>82</strong></td>
                            <td>44</td>
                            <td>88</td>
                            <td>66.9</td>
                            <td><span class="grade-pill grade-b2">B2</span></td>
                            <td>4th</td>
                            <td>Solid critical reasoning</td>
                        </tr>
                        <tr>
                            <td class="subject-col">French Language</td>
                            <td>15</td>
                            <td>14</td>
                            <td>44</td>
                            <td><strong>73</strong></td>
                            <td>30</td>
                            <td>86</td>
                            <td>58.4</td>
                            <td><span class="grade-pill grade-b3">B3</span></td>
                            <td>5th</td>
                            <td>Very good vocabulary growth</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Summary Strip -->
                <div class="result-summary-strip">
                    <div>
                        <div class="summary-val">848 / 1000</div>
                        <div class="summary-lbl">Cumulative Total</div>
                    </div>
                    <div>
                        <div class="summary-val">84.8%</div>
                        <div class="summary-lbl">Term Average</div>
                    </div>
                    <div>
                        <div class="summary-val">2nd / 45</div>
                        <div class="summary-lbl">Class Position</div>
                    </div>
                    <div>
                        <div class="summary-val" style="color: #15803d;">PASSED</div>
                        <div class="summary-lbl">Promoted to SSS 1</div>
                    </div>
                </div>

                <!-- Domains & Behavioral Traits -->
                <div class="dual-domains-grid">
                    <div class="domains-card">
                        <div class="domains-title">
                            <span>Affective Domain (Character Traits)</span>
                            <span style="font-weight: 500; font-size: 0.65rem;">Scale: 1 (Poor) to 5 (Exemplary)</span>
                        </div>
                        <table class="domains-table">
                            <tr><td>Punctuality &amp; Attendance</td><td class="rating-val">5 / 5</td><td>Politeness &amp; Respect</td><td class="rating-val">5 / 5</td></tr>
                            <tr><td>Neatness &amp; Uniform</td><td class="rating-val">5 / 5</td><td>Honesty &amp; Integrity</td><td class="rating-val">5 / 5</td></tr>
                            <tr><td>Leadership &amp; Responsibility</td><td class="rating-val">4 / 5</td><td>Relationship with Peers</td><td class="rating-val">4 / 5</td></tr>
                        </table>
                    </div>

                    <div class="domains-card">
                        <div class="domains-title">
                            <span>Psychomotor Domain (Skills)</span>
                            <span style="font-weight: 500; font-size: 0.65rem;">Scale: 1 to 5</span>
                        </div>
                        <table class="domains-table">
                            <tr><td>Handwriting &amp; Legibility</td><td class="rating-val">4 / 5</td><td>CBT Computer Literacy</td><td class="rating-val">5 / 5</td></tr>
                            <tr><td>Sports &amp; Athleticism</td><td class="rating-val">4 / 5</td><td>Musical &amp; Creative Skills</td><td class="rating-val">4 / 5</td></tr>
                        </table>
                        <div style="margin-top: 6px;">
                            <span class="bursar-clearance-stamp">
                                <i class="fas fa-check-circle"></i> Fees Cleared: &#8358;0.00 Balance (#PSK-89218)
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Remarks & Signatures -->
                <div class="remarks-section">
                    <div class="remark-row">
                        <span class="remark-lbl">Class Teacher Remark:</span>
                        <span class="remark-text">&ldquo;An outstanding academic performance. Chinedu is hardworking, respectful, and demonstrates genuine leadership qualities.&rdquo;</span>
                    </div>
                    <div class="remark-row" style="margin-bottom: 0;">
                        <span class="remark-lbl">Principal Remark:</span>
                        <span class="remark-text">&ldquo;Promoted to SSS 1 (Science Stream) with High Honours. Keep up this laudable standard.&rdquo;</span>
                    </div>
                </div>

                <!-- Signatures Grid -->
                <div class="signatures-grid">
                    <div class="sig-col">
                        <div class="sig-drawn">Mr. O. Babatunde</div>
                        <div class="sig-title-lbl">Class Teacher Signature</div>
                    </div>
                    <div class="official-seal-box">
                        <span>Premier Leadership Academy</span>
                        <span style="font-size: 0.68rem; color: #15803d;">OFFICIAL</span>
                        <span>Lagos State</span>
                    </div>
                    <div class="sig-col">
                        <div class="sig-drawn">Dr. Mrs. K. Balogun, Ph.D.</div>
                        <div class="sig-title-lbl">Principal &bull; Official Seal</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
