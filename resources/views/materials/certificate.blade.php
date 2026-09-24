<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExtremeSolutions - Official Academic Performance Certificate & Report</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Playfair+Display:wght@700;900&family=Cinzel:wght@600;700;800&family=Great+Vibes&family=Alex+Brush&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @page {
            size: A4 portrait;
            margin: 6mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #0b1329;
            color: #000000;
            padding: 20px 10px;
            font-size: 11px;
            line-height: 1.25;
        }

        /* Top Action Bar */
        .action-bar {
            max-width: 820px;
            margin: 0 auto 16px auto;
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid #334155;
            padding: 12px 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        .action-bar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .back-link {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.85rem;
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
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 3px 8px;
            border-radius: 9999px;
        }

        .view-toggle-btns {
            display: inline-flex;
            background: #1e293b;
            border-radius: 8px;
            padding: 3px;
            border: 1px solid #475569;
        }

        .toggle-btn {
            background: transparent;
            color: #cbd5e1;
            border: none;
            padding: 5px 12px;
            font-size: 0.78rem;
            font-weight: 700;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .toggle-btn.active {
            background: #3b82f6;
            color: #ffffff;
        }

        .action-bar-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-action {
            padding: 7px 14px;
            border-radius: 7px;
            font-size: 0.82rem;
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
        }

        .btn-print:hover {
            background: #059669;
        }

        .btn-download {
            background: #2563eb;
            color: #ffffff;
        }

        .btn-download:hover {
            background: #1d4ed8;
        }

        /* Printable Sheet Canvas */
        .sheet {
            width: 210mm;
            min-height: 297mm;
            max-width: 820px;
            margin: 0 auto;
            background: #ffffff;
            padding: 10px 14px 14px 14px;
            border: 1px solid #1e293b;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            position: relative;
            box-sizing: border-box;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.2px;
        }

        th, td {
            border: 1px solid #222222;
            padding: 2.2px 3px;
            text-align: center;
            vertical-align: middle;
        }

        .th-olive {
            background-color: #6c8437 !important;
            color: #ffffff !important;
            font-weight: 700;
            font-size: 9px;
            text-transform: uppercase;
        }

        /* Header Layout */
        .report-header {
            display: grid;
            grid-template-columns: 85px 1fr 90px;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
            padding-bottom: 4px;
        }

        .school-crest {
            text-align: center;
        }

        .school-crest svg {
            width: 80px;
            height: 80px;
        }

        .school-info {
            text-align: center;
        }

        .school-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 19px;
            font-weight: 900;
            color: #0f2757;
            letter-spacing: 0.5px;
            line-height: 1.15;
            margin-bottom: 2px;
        }

        .school-motto {
            font-weight: 800;
            font-size: 10.5px;
            color: #1a1a1a;
            margin-bottom: 2px;
            letter-spacing: 0.3px;
        }

        .school-address {
            font-size: 9.5px;
            color: #333333;
            margin-bottom: 2px;
        }

        .school-contact {
            font-size: 8.5px;
            color: #444444;
            margin-bottom: 1px;
        }

        .school-links {
            font-size: 8px;
            color: #444444;
            margin-bottom: 3px;
        }

        .report-title-banner {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 12.5px;
            font-weight: 900;
            letter-spacing: 0.8px;
            color: #000000;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .passport-photo-box {
            width: 85px;
            height: 98px;
            border: 1px solid #111111;
            padding: 2px;
            background: #ffffff;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .passport-photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Bio Data Box */
        .biodata-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
            border: 1.5px solid #111111;
            font-size: 9px;
        }

        .biodata-table td {
            border: 1px solid #222222;
            padding: 3px 5px;
            text-align: left;
        }

        .biodata-lbl {
            font-weight: 800;
            color: #000000;
        }

        .biodata-val {
            font-weight: 700;
            color: #000000;
        }

        /* Main 2-column layout */
        .main-columns {
            display: grid;
            grid-template-columns: 58% 42%;
            gap: 6px;
            margin-bottom: 6px;
            align-items: start;
        }

        .table-subjects {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.4px;
        }

        .table-subjects th {
            padding: 3px 2px;
            line-height: 1.1;
        }

        .table-subjects td {
            padding: 2px 2px;
            height: 15.5px;
        }

        .table-subjects td.subject-name {
            text-align: left;
            padding-left: 4px;
            font-weight: 700;
            font-size: 8.5px;
            letter-spacing: -0.1px;
        }

        .table-subjects td.remark-cell {
            font-size: 7.8px;
            font-weight: 700;
        }

        /* Right column stacked tables */
        .right-column {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .table-side {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.2px;
        }

        .table-side th, .table-side td {
            padding: 1.8px 2px;
            height: 14.5px;
        }

        .table-side td.item-name {
            text-align: left;
            padding-left: 4px;
            font-weight: 600;
        }

        .tick-mark {
            font-weight: 900;
            color: #000000;
            font-size: 10px;
        }

        /* Bottom Section */
        .bottom-section {
            display: grid;
            grid-template-columns: 24% 28% 48%;
            gap: 5px;
            margin-bottom: 5px;
            align-items: stretch;
        }

        .perf-summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.2px;
        }

        .perf-summary-table td {
            padding: 2px 3px;
            text-align: left;
            height: 15px;
        }

        .perf-summary-table td.val {
            text-align: right;
            font-weight: 800;
        }

        .grade-analysis-box {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .table-grade-analysis {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.8px;
            margin-bottom: 3px;
        }

        .table-grade-analysis th, .table-grade-analysis td {
            padding: 2px 1px;
            height: 13px;
        }

        .indices-box {
            border: 1px solid #222222;
            padding: 2px 4px;
            font-size: 7.4px;
            line-height: 1.25;
            background: #fafafa;
        }

        .indices-title {
            font-weight: 800;
            text-align: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 1px;
            margin-bottom: 1px;
        }

        /* Remarks & Signatures Box */
        .remarks-container {
            border: 1.5px solid #111111;
            margin-bottom: 4px;
        }

        .remark-row {
            display: grid;
            grid-template-columns: 110px 1fr 140px;
            border-bottom: 1px solid #222222;
            min-height: 28px;
            align-items: center;
        }

        .remark-row:last-child {
            border-bottom: none;
            min-height: 38px;
        }

        .remark-label {
            font-weight: 800;
            font-size: 8.8px;
            padding: 3px 5px;
            border-right: 1px solid #222222;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .remark-content {
            font-size: 8.8px;
            padding: 3px 6px;
            font-style: italic;
            border-right: 1px solid #222222;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .remark-sign-box {
            padding: 2px 4px;
            font-size: 8px;
            text-align: center;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .sign-line {
            font-family: 'Alex Brush', cursive, serif;
            font-size: 16px;
            color: #0f2757;
            line-height: 1;
            margin-bottom: -2px;
        }

        .sign-name {
            font-weight: 800;
            font-size: 7.8px;
            text-transform: uppercase;
        }

        .official-seal {
            position: absolute;
            right: 10px;
            top: -10px;
            width: 55px;
            height: 55px;
            opacity: 0.85;
            pointer-events: none;
        }

        /* Resumption Line */
        .resumption-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            font-size: 9.5px;
            font-weight: 800;
            padding: 3px 0;
            border-top: 1px solid #222;
            border-bottom: 1px solid #222;
            margin-bottom: 4px;
        }

        /* Footer Branding */
        .footer-branding {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 7.5px;
            font-weight: 800;
            color: #333333;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            padding-top: 2px;
        }

        .footer-logo {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #0f2757;
        }

        /* Graduation Certificate Alternative View (Hidden by default, can toggle) */
        #gradCertSheet {
            display: none;
            width: 297mm;
            min-height: 210mm;
            max-width: 1020px;
            margin: 0 auto;
            background: #ffffff;
            padding: 24px;
            border: 2px solid #b45309;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            text-align: center;
            position: relative;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .action-bar {
                display: none !important;
            }

            .sheet {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                padding: 4mm 6mm !important;
            }
        }
    </style>
</head>
<body>

    <!-- Top Action Bar (Hidden during Print) -->
    <div class="action-bar">
        <div class="action-bar-left">
            <a href="{{ route('materials.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Sales Kit Hub
            </a>
            <span class="proof-badge">
                <i class="fas fa-award"></i> ExtremeSolutions Official Certificate &amp; Report Proof
            </span>
        </div>
        <div class="action-bar-right">
            <a href="{{ route('materials.download-zip') }}" class="btn-action btn-download">
                <i class="fas fa-download"></i> Download Package (.ZIP)
            </a>
            <button onclick="window.print()" class="btn-action btn-print">
                <i class="fas fa-print"></i> Print Document (A4)
            </button>
        </div>
    </div>

    <!-- Active View: ExtremeSolutions Performance Report & Certificate -->
    <div class="sheet" id="reportSheet">

        <!-- Header Section -->
        <div class="report-header">
            <!-- Left Crest -->
            <div class="school-crest">
                <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="46" fill="#f8fafc" stroke="#6c8437" stroke-width="4"/>
                    <circle cx="50" cy="50" r="40" stroke="#0f2757" stroke-width="1.5" stroke-dasharray="3 2"/>
                    <!-- Shield Body -->
                    <path d="M50 16 L26 26 V48 C26 64 36 78 50 82 C64 78 74 64 74 48 V26 Z" fill="#0f2757"/>
                    <!-- Shield Inner -->
                    <path d="M50 20 L30 28 V46 C30 60 38 73 50 77 C62 73 70 60 70 46 V28 Z" fill="#ffffff"/>
                    <!-- Cross & Book -->
                    <path d="M50 24 V66 M34 44 H66" stroke="#6c8437" stroke-width="3"/>
                    <path d="M38 52 C44 50 48 53 50 55 C52 53 56 50 62 52 V64 C56 62 52 64 50 62 C48 64 44 62 38 64 Z" fill="#0f2757"/>
                    <!-- Banner -->
                    <path d="M20 78 C35 73 65 73 80 78 L76 86 C62 82 38 82 24 86 Z" fill="#6c8437"/>
                    <text x="50" y="83" font-size="5" font-weight="900" fill="#ffffff" text-anchor="middle" font-family="Arial">EXTREMESOLUTIONS</text>
                </svg>
            </div>

            <!-- Center Info -->
            <div class="school-info">
                <h1 class="school-title">EXTREMESOLUTIONS MODEL GROUP OF SCHOOLS</h1>
                <div class="school-motto">MOTTO: KNOWLEDGE IS FREEDOM &amp; POWER</div>
                <div class="school-address">Victoria Island Campus, Lagos &bull; Idumegan Quarters, Ekpoma, Edo State</div>
                <div class="school-contact">Tel: 08158339342, 08150772800, 09052585622</div>
                <div class="school-links">Website: sms.extremesolutions.com.ng &bull; Email: sms@extremesolutions.com.ng</div>
                <div class="report-title-banner">SECOND TERM STUDENT'S PERFORMANCE REPORT</div>
            </div>

            <!-- Right Passport Photo Box -->
            <div class="passport-photo-box">
                <svg viewBox="0 0 100 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="100" height="120" fill="#e2e8f0"/>
                    <circle cx="50" cy="42" r="22" fill="#fed7aa"/>
                    <path d="M28 40 C28 20 72 20 72 40 C68 28 32 28 28 40 Z" fill="#78350f"/>
                    <circle cx="43" cy="40" r="2" fill="#1e293b"/>
                    <circle cx="57" cy="40" r="2" fill="#1e293b"/>
                    <path d="M48 44 L50 48 L52 44" stroke="#9a3412" stroke-width="1.2" fill="none"/>
                    <path d="M45 52 Q50 56 55 52" stroke="#9a3412" stroke-width="1.2" fill="none"/>
                    <path d="M15 120 L28 72 C35 70 45 74 50 78 C55 74 65 70 72 72 L85 120 Z" fill="#0f2757"/>
                    <path d="M42 74 L50 90 L58 74 L50 76 Z" fill="#ffffff"/>
                    <path d="M48 80 L50 120 L52 120 L52 80 Z" fill="#dc2626"/>
                    <text x="50" y="114" font-size="7" font-weight="700" fill="#ffffff" text-anchor="middle">PASSPORT</text>
                </svg>
            </div>
        </div>

        <!-- Student Biodata Box -->
        <table class="biodata-table">
            <tr>
                <td style="width: 48%;"><span class="biodata-lbl">NAME:</span> <span class="biodata-val">EZE, Chikaodili Nkechi</span></td>
                <td style="width: 26%;"><span class="biodata-lbl">CLASS:</span> <span class="biodata-val">JSS 2A</span></td>
                <td style="width: 26%;"><span class="biodata-lbl">SESSION:</span> <span class="biodata-val">2024_2025</span></td>
            </tr>
            <tr>
                <td><span class="biodata-lbl">ADMISSION NO:</span> <span class="biodata-val">04/1643</span></td>
                <td><span class="biodata-lbl">D.O.B.:</span> <span class="biodata-val">Mon, 02-Feb-2006</span></td>
                <td><span class="biodata-lbl">AGE:</span> <span class="biodata-val">17yrs</span></td>
            </tr>
            <tr>
                <td><span class="biodata-lbl">GENDER:</span> <span class="biodata-val">FEMALE</span></td>
                <td><span class="biodata-lbl">HOUSE:</span> <span class="biodata-val">FEMI AWONIYI</span></td>
                <td><span class="biodata-lbl">CLUB/SOCIETY:</span> <span class="biodata-val">SCRABBLE, JETS, DEBATE</span></td>
            </tr>
        </table>

        <!-- Main Content 2 Columns -->
        <div class="main-columns">

            <!-- Left: Cognitive Domain Table (Exact 17 subjects from image) -->
            <div>
                <table class="table-subjects">
                    <thead>
                        <tr>
                            <th class="th-olive" style="width: 38%; text-align: left; padding-left: 4px;">COGNITIVE DOMAIN<br>SUBJECTS</th>
                            <th class="th-olive" style="width: 7%;">C.A.<br>40</th>
                            <th class="th-olive" style="width: 7%;">EXAM<br>60</th>
                            <th class="th-olive" style="width: 9%;">Term<br>TOTAL<br>100</th>
                            <th class="th-olive" style="width: 7%;">GRADE</th>
                            <th class="th-olive" style="width: 9%;">SUBJ.<br>POSN</th>
                            <th class="th-olive" style="width: 13%;">GRADE<br>REMARKS</th>
                            <th class="th-olive" style="width: 10%;">CLASS<br>AVG</th>
                            <th class="th-olive" style="width: 9%;">1st<br>Term<br>100</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="subject-name">AGRICULTURAL SCIENCE</td>
                            <td>37</td><td>47</td><td>84</td><td>B2</td><td>2nd</td><td class="remark-cell">VERY GOOD</td><td>67.7</td><td>84</td>
                        </tr>
                        <tr>
                            <td class="subject-name">BASIC SCIENCE</td>
                            <td>34</td><td>34</td><td>68</td><td>C4</td><td>17th</td><td class="remark-cell">CREDIT</td><td>68.9</td><td>83</td>
                        </tr>
                        <tr>
                            <td class="subject-name">BASIC TECHNOLOGY</td>
                            <td>32</td><td>39</td><td>71</td><td>B3</td><td>20th</td><td class="remark-cell">GOOD</td><td>70.8</td><td>78</td>
                        </tr>
                        <tr>
                            <td class="subject-name">CIVIC EDUCATION</td>
                            <td>35</td><td>42</td><td>77</td><td>B2</td><td>11th</td><td class="remark-cell">VERY GOOD</td><td>72.3</td><td>80</td>
                        </tr>
                        <tr>
                            <td class="subject-name">ENGLISH STUDIES</td>
                            <td>19</td><td>49</td><td>68</td><td>C4</td><td>14th</td><td class="remark-cell">CREDIT</td><td>66.6</td><td>76</td>
                        </tr>
                        <tr>
                            <td class="subject-name">FRENCH</td>
                            <td>28</td><td>43</td><td>71</td><td>B3</td><td>16th</td><td class="remark-cell">GOOD</td><td>68.3</td><td>86</td>
                        </tr>
                        <tr>
                            <td class="subject-name">HOME ECONOMICS</td>
                            <td>26</td><td>29</td><td>55</td><td>C6</td><td>30th</td><td class="remark-cell">CREDIT</td><td>68.4</td><td>52</td>
                        </tr>
                        <tr>
                            <td class="subject-name">INFO. &amp; COMM. TECHNOLOGY</td>
                            <td>27</td><td>53</td><td>80</td><td>B2</td><td>6th</td><td class="remark-cell">VERY GOOD</td><td>68.3</td><td>63</td>
                        </tr>
                        <tr>
                            <td class="subject-name">PHONICS</td>
                            <td>30</td><td>31</td><td>61</td><td>C5</td><td>29th</td><td class="remark-cell">CREDIT</td><td>72.9</td><td>67</td>
                        </tr>
                        <tr>
                            <td class="subject-name">PHYSICAL &amp; HEALTH EDUCATION</td>
                            <td>24</td><td>56</td><td>80</td><td>B2</td><td>5th</td><td class="remark-cell">VERY GOOD</td><td>68.9</td><td>88</td>
                        </tr>
                        <tr>
                            <td class="subject-name">RELIGIOUS STUDIES</td>
                            <td>27</td><td>35</td><td>62</td><td>C5</td><td>21st</td><td class="remark-cell">CREDIT</td><td>68.7</td><td>72</td>
                        </tr>
                        <tr>
                            <td class="subject-name">SECURITY EDUCATION</td>
                            <td>27</td><td>41</td><td>68</td><td>C4</td><td>22nd</td><td class="remark-cell">CREDIT</td><td>72.3</td><td>71</td>
                        </tr>
                        <tr>
                            <td class="subject-name">MATHEMATICS</td>
                            <td>31</td><td>40</td><td>71</td><td>B3</td><td>16th</td><td class="remark-cell">GOOD</td><td>71.0</td><td>64</td>
                        </tr>
                        <tr>
                            <td class="subject-name">CULTURAL &amp; CREATIVE ARTS</td>
                            <td>32</td><td>51</td><td>83</td><td>B2</td><td>2nd</td><td class="remark-cell">VERY GOOD</td><td>67.7</td><td>50</td>
                        </tr>
                        <tr>
                            <td class="subject-name">MUSIC</td>
                            <td>26</td><td>29</td><td>55</td><td>C6</td><td>26th</td><td class="remark-cell">CREDIT</td><td>66.5</td><td>78</td>
                        </tr>
                        <tr>
                            <td class="subject-name">SOCIAL STUDIES</td>
                            <td>30</td><td>30</td><td>60</td><td>C5</td><td>24th</td><td class="remark-cell">CREDIT</td><td>68.5</td><td>69</td>
                        </tr>
                        <tr>
                            <td class="subject-name">YORUBA LANGUAGE</td>
                            <td>27</td><td>47</td><td>74</td><td>B3</td><td>12th</td><td class="remark-cell">GOOD</td><td>70.8</td><td>83</td>
                        </tr>
                        <tr>
                            <td class="subject-name">&nbsp;</td>
                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td class="subject-name">&nbsp;</td>
                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Right Column: Attendance, Affective, Psychomotor, Grade Scale -->
            <div class="right-column">

                <!-- 1. Attendance Summary -->
                <table class="table-side">
                    <thead>
                        <tr>
                            <th colspan="2" class="th-olive">ATTENDANCE SUMMARY</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="item-name" style="width: 62%;">Times School Opened</td>
                            <td style="width: 38%; font-weight: 800;">140</td>
                        </tr>
                        <tr>
                            <td class="item-name">No of Times Present</td>
                            <td style="font-weight: 800;">126 <span style="font-size: 7.2px; font-weight: normal;">(90.0 %)</span></td>
                        </tr>
                        <tr>
                            <td class="item-name">No of Times Absent</td>
                            <td style="font-weight: 800;">14</td>
                        </tr>
                    </tbody>
                </table>

                <!-- 2. Affective Domain (Checked boxes) -->
                <table class="table-side">
                    <thead>
                        <tr>
                            <th class="th-olive" style="width: 58%; text-align: left; padding-left: 4px;">AFFECTIVE DOMAIN</th>
                            <th class="th-olive" style="width: 8.4%;">5</th>
                            <th class="th-olive" style="width: 8.4%;">4</th>
                            <th class="th-olive" style="width: 8.4%;">3</th>
                            <th class="th-olive" style="width: 8.4%;">2</th>
                            <th class="th-olive" style="width: 8.4%;">1</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="item-name">Attentiveness</td>
                            <td></td><td><span class="tick-mark">&#10003;</span></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td class="item-name">Honesty</td>
                            <td></td><td><span class="tick-mark">&#10003;</span></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td class="item-name">Neatness</td>
                            <td></td><td><span class="tick-mark">&#10003;</span></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td class="item-name">Politeness</td>
                            <td></td><td></td><td></td><td><span class="tick-mark">&#10003;</span></td><td></td>
                        </tr>
                        <tr>
                            <td class="item-name">Punctuality/ Assembly</td>
                            <td></td><td></td><td></td><td></td><td><span class="tick-mark">&#10003;</span></td>
                        </tr>
                        <tr>
                            <td class="item-name">Self Control/ Calmness</td>
                            <td></td><td></td><td><span class="tick-mark">&#10003;</span></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td class="item-name">Obedience</td>
                            <td></td><td><span class="tick-mark">&#10003;</span></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td class="item-name">Reliability</td>
                            <td></td><td></td><td><span class="tick-mark">&#10003;</span></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td class="item-name">Sense Of Responsibility</td>
                            <td><span class="tick-mark">&#10003;</span></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td class="item-name">Relationship With Others</td>
                            <td></td><td><span class="tick-mark">&#10003;</span></td><td></td><td></td><td></td>
                        </tr>
                    </tbody>
                </table>

                <!-- 3. Psychomotor Skills (Checked boxes) -->
                <table class="table-side">
                    <thead>
                        <tr>
                            <th class="th-olive" style="width: 58%; text-align: left; padding-left: 4px;">PSYCHOMOTOR -SKIL</th>
                            <th class="th-olive" style="width: 8.4%;">5</th>
                            <th class="th-olive" style="width: 8.4%;">4</th>
                            <th class="th-olive" style="width: 8.4%;">3</th>
                            <th class="th-olive" style="width: 8.4%;">2</th>
                            <th class="th-olive" style="width: 8.4%;">1</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="item-name">Handling Of Tools</td>
                            <td></td><td></td><td><span class="tick-mark">&#10003;</span></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td class="item-name">Drawing/ Painting</td>
                            <td></td><td><span class="tick-mark">&#10003;</span></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td class="item-name">Handwriting</td>
                            <td></td><td></td><td></td><td><span class="tick-mark">&#10003;</span></td><td></td>
                        </tr>
                        <tr>
                            <td class="item-name">Public Speaking</td>
                            <td></td><td><span class="tick-mark">&#10003;</span></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td class="item-name">Speech Fluency</td>
                            <td><span class="tick-mark">&#10003;</span></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td class="item-name">Sports &amp; Games</td>
                            <td></td><td></td><td></td><td><span class="tick-mark">&#10003;</span></td><td></td>
                        </tr>
                    </tbody>
                </table>

                <!-- 4. Grade Scale -->
                <table class="table-side">
                    <thead>
                        <tr>
                            <th colspan="3" class="th-olive">Grade Scale</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-weight: 800; width: 22%;">A1</td>
                            <td style="width: 38%;">85-100%</td>
                            <td style="width: 40%; font-weight: 700; text-align: left; padding-left: 4px;">EXCELLENT</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 800;">B2</td>
                            <td>75-84.9%</td>
                            <td style="font-weight: 700; text-align: left; padding-left: 4px;">VERY GOOD</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 800;">B3</td>
                            <td>70-74.9%</td>
                            <td style="font-weight: 700; text-align: left; padding-left: 4px;">GOOD</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 800;">C4</td>
                            <td>65-69.9%</td>
                            <td style="font-weight: 700; text-align: left; padding-left: 4px;">CREDIT</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 800;">C5</td>
                            <td>60-64.9%</td>
                            <td style="font-weight: 700; text-align: left; padding-left: 4px;">CREDIT</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 800;">C6</td>
                            <td>50-59.9%</td>
                            <td style="font-weight: 700; text-align: left; padding-left: 4px;">CREDIT</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 800;">D7</td>
                            <td>45-49.9%</td>
                            <td style="font-weight: 700; text-align: left; padding-left: 4px;">PASS</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 800;">E8</td>
                            <td>40-44.9%</td>
                            <td style="font-weight: 700; text-align: left; padding-left: 4px;">PASS</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 800;">F9</td>
                            <td>0-39.9%</td>
                            <td style="font-weight: 700; text-align: left; padding-left: 4px;">FAIL</td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>

        <!-- Bottom Performance Summary & Analysis -->
        <div class="bottom-section">

            <!-- Performance Summary -->
            <table class="perf-summary-table">
                <thead>
                    <tr>
                        <th colspan="2" class="th-olive">PERFORMANCE SUMMARY</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Obtained:</td>
                        <td class="val">1188.0</td>
                    </tr>
                    <tr>
                        <td>Total Obtainable:</td>
                        <td class="val">1700</td>
                    </tr>
                    <tr>
                        <td>Total Subjects:</td>
                        <td class="val">17</td>
                    </tr>
                    <tr>
                        <td>%TAGE</td>
                        <td class="val">69.88%</td>
                    </tr>
                    <tr>
                        <td>GRADE</td>
                        <td class="val">C4</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center; font-weight: 800; background: #f1f5f9;">
                            13th of 32 - CREDIT
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Grade Analysis Table -->
            <div class="grade-analysis-box">
                <table class="table-grade-analysis">
                    <thead>
                        <tr>
                            <th colspan="9" class="th-olive">Grade Analysis</th>
                        </tr>
                        <tr>
                            <th>A1</th><th>B2</th><th>B3</th><th>C4</th><th>C5</th><th>C6</th><th>D7</th><th>E8</th><th>F9</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>-</td><td>5</td><td>4</td><td>3</td><td>3</td><td>2</td><td>-</td><td>-</td><td>-</td>
                        </tr>
                    </tbody>
                </table>
                <div style="font-size: 6.8px; text-align: center; font-weight: 800; color: #555; padding: 2px 0;">
                    EXTREMESOLUTIONS ES-SCHOOLS &copy; 2026
                </div>
            </div>

            <!-- Rating Indices -->
            <div class="indices-box">
                <div class="indices-title">Rating Indices</div>
                <div><strong>5</strong> - Maintains an Excellent degree of Observable (Obv) traits</div>
                <div><strong>4</strong> - Maintains a High level of Obv traits</div>
                <div><strong>3</strong> - Acceptable level of Obv traits</div>
                <div><strong>2</strong> - Shows Minimal regard for Obv traits</div>
                <div><strong>1</strong> - Has No regard for Observable traits</div>
            </div>

        </div>

        <!-- Remarks & Signatures Box -->
        <div class="remarks-container">
            <div class="remark-row">
                <div class="remark-label">Class Teacher's Remark</div>
                <div class="remark-content">has shown excellent ability to set goals and be persistent in achieving them. Nice job!!</div>
                <div class="remark-sign-box">
                    <div style="font-size: 7px; color: #666; margin-bottom: 2px;">Sign:</div>
                    <div class="sign-line">A. Timileyin</div>
                    <div class="sign-name">MR ADIGUN TIMILEYIN</div>
                </div>
            </div>
            <div class="remark-row">
                <div class="remark-label">Principal's Remark</div>
                <div class="remark-content">A Bright and Commendable Performance.. An Average Result... You can Do much Better. Study Harder.</div>
                <div class="remark-sign-box">
                    <!-- Red Official Stamp Seal -->
                    <svg class="official-seal" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="46" stroke="#b91c1c" stroke-width="2.5" fill="none"/>
                        <circle cx="50" cy="50" r="38" stroke="#b91c1c" stroke-width="1.2" stroke-dasharray="3 2" fill="none"/>
                        <path d="M50 18 C68 18 82 32 82 50 C82 68 68 82 50 82" stroke="#b91c1c" stroke-width="0.8" fill="none"/>
                        <text x="50" y="32" font-size="6.5" font-weight="900" fill="#b91c1c" text-anchor="middle" font-family="Arial">EXTREMESOLUTIONS</text>
                        <text x="50" y="42" font-size="5.2" font-weight="800" fill="#b91c1c" text-anchor="middle" font-family="Arial">APPROVED &bull; VERIFIED</text>
                        <text x="50" y="60" font-size="7" font-weight="900" fill="#b91c1c" text-anchor="middle" font-family="Arial">24 APR 2026</text>
                        <text x="50" y="72" font-size="5.5" font-weight="800" fill="#b91c1c" text-anchor="middle" font-family="Arial">OFFICE OF PRINCIPAL</text>
                    </svg>

                    <div style="font-size: 7px; color: #666; margin-bottom: 2px;">Sign:</div>
                    <div class="sign-line">Owolabi Badmos</div>
                    <div class="sign-name">MR OWOLABI BADMOS</div>
                    <div style="font-size: 7.2px; font-weight: 700; color: #111; margin-top: 2px;">Date: 24-Apr-2026</div>
                </div>
            </div>
        </div>

        <!-- Resumption Bar -->
        <div class="resumption-bar">
            <span>Next Term Begins:</span>
            <span style="font-size: 10.5px; color: #0f2757;">Mon, 28-April-2026</span>
        </div>

        <!-- Footer Branding -->
        <div class="footer-branding">
            <div class="footer-logo">
                <svg width="14" height="14" viewBox="0 0 64 64" fill="none">
                    <circle cx="32" cy="32" r="30" fill="#0f2757"/>
                    <path d="M32 18L20 24L32 30L44 24L32 18Z" fill="white"/>
                    <rect x="24" y="38" width="16" height="10" fill="#10b981"/>
                </svg>
                <span>POWERED BY EXTREMESOLUTIONS SOFTWARE V2.4 &bull; ES-SCHOOLS</span>
            </div>
            <div>VERIFIED ACADEMIC DOSSIER &bull; OFFICIAL SCHOOL AUDIT COPY</div>
        </div>

    </div>

</body>
</html>
