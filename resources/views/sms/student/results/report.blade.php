<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Performance Report - {{ $student->user->name ?? 'Student' }}</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background: white;
            padding: 15px;
            position: relative;
        }
        .report-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            position: relative;
            padding: 20px;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.08;
            z-index: 0;
            font-size: 120px;
            font-weight: bold;
            color: #000;
            white-space: nowrap;
        }
        .watermark-logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.05;
            z-index: 0;
            max-width: 500px;
            max-height: 500px;
        }
        .watermark-confidential {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0.1;
            z-index: 0;
            font-size: 80px;
            font-weight: bold;
            color: #000;
        }
        .report-content {
            position: relative;
            z-index: 1;
        }
        .school-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
        }
        .school-logo {
            max-width: 80px;
            max-height: 80px;
            margin: 0 auto 10px;
        }
        .school-name {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .school-contact {
            font-size: 10px;
            line-height: 1.4;
            color: #333;
        }
        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 15px 0;
            letter-spacing: 1px;
        }
        .student-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            border: 1px solid #000;
            padding: 12px;
        }
        .student-info-left {
            flex: 1;
            font-size: 11px;
            line-height: 1.6;
        }
        .info-row {
            display: flex;
            margin-bottom: 4px;
        }
        .info-label {
            font-weight: bold;
            min-width: 140px;
        }
        .info-value {
            flex: 1;
        }
        .student-photo {
            width: 100px;
            height: 120px;
            border: 2px solid #000;
            object-fit: cover;
            background: #f0f0f0;
            margin-left: 15px;
        }
        .cognitive-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 9px;
        }
        .cognitive-table th,
        .cognitive-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
        .cognitive-table th {
            background: #f0f0f0;
            font-weight: bold;
        }
        .cognitive-table td {
            font-size: 8px;
        }
        .two-column-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        .attendance-box {
            border: 1px solid #000;
            padding: 10px;
        }
        .attendance-box h4 {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 8px;
            text-align: center;
            background: #f0f0f0;
            padding: 4px;
        }
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        .attendance-table td {
            border: 1px solid #000;
            padding: 4px;
        }
        .domain-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
            margin-bottom: 10px;
        }
        .domain-table th,
        .domain-table td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }
        .domain-table th {
            background: #f0f0f0;
            font-weight: bold;
            font-size: 9px;
        }
        .checkbox-cell {
            width: 30px;
        }
        .grade-scale {
            border: 1px solid #000;
            padding: 8px;
            margin-bottom: 15px;
            font-size: 8px;
        }
        .grade-scale h4 {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: center;
        }
        .grade-scale-row {
            display: flex;
            margin-bottom: 2px;
        }
        .grade-scale-label {
            font-weight: bold;
            min-width: 80px;
        }
        .grade-analysis {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 15px;
        }
        .grade-analysis h4 {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 8px;
            text-align: center;
            background: #f0f0f0;
            padding: 4px;
        }
        .grade-analysis-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        .grade-analysis-table td {
            border: 1px solid #000;
            padding: 4px;
        }
        .performance-summary {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 15px;
        }
        .performance-summary h4 {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 8px;
            text-align: center;
            background: #f0f0f0;
            padding: 4px;
        }
        .performance-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        .performance-table td {
            border: 1px solid #000;
            padding: 4px;
        }
        .remarks-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        .remark-box {
            border: 1px solid #000;
            padding: 10px;
            min-height: 80px;
        }
        .remark-box h4 {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .remark-text {
            font-size: 9px;
            line-height: 1.4;
            min-height: 50px;
        }
        .footer-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 9px;
            border-top: 1px solid #000;
            padding-top: 10px;
        }
        .footer-item {
            text-align: center;
        }
        .footer-label {
            font-weight: bold;
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <div class="report-container">
        <!-- Watermarks -->
        @if($student->school && $student->school->logo)
        @php
            $isPdfFlag = isset($isPdf) && $isPdf;
            if ($isPdfFlag) {
                $logoPath = storage_path('app/public/' . $student->school->logo);
                if (!file_exists($logoPath)) {
                    $logoPath = public_path('storage/' . $student->school->logo);
                }
            } else {
                $logoPath = asset('storage/' . $student->school->logo);
            }
        @endphp
        <img src="{{ $logoPath }}" alt="School Logo" class="watermark-logo">
        @endif
        <div class="watermark">FORMAT 1</div>
        <div class="watermark-confidential">CONFIDENTIAL</div>

        <div class="report-content">
            <!-- School Header -->
            <div class="school-header">
                @if($student->school && $student->school->logo)
                <img src="{{ $logoPath }}" alt="School Logo" class="school-logo">
                @endif
                <div class="school-name">{{ strtoupper($student->school->name ?? 'SCHOOL NAME') }}</div>
                <div class="school-contact">
                    @if($student->school)
                        {{ $student->school->address ?? '' }}
                        @if($student->school->city), {{ $student->school->city }}@endif
                        @if($student->school->state), {{ $student->school->state }}@endif
                        <br>
                        @if($student->school->phone)Phone: {{ $student->school->phone }} | @endif
                        @if($student->school->email)Email: {{ $student->school->email }} | @endif
                        @if($student->school->website)Website: {{ $student->school->website }}@endif
                    @endif
                </div>
            </div>

            <!-- Report Title -->
            <div class="report-title">
                STUDENT'S PERFORMANCE REPORT<br>
                {{ strtoupper($term) }}
            </div>

            <!-- Student Information -->
            <div class="student-section">
                <div class="student-info-left">
                    <div class="info-row">
                        <span class="info-label">Name:</span>
                        <span class="info-value"><strong>{{ strtoupper($student->user->name ?? 'N/A') }}</strong></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Class:</span>
                        <span class="info-value">{{ strtoupper($student->class->name ?? 'N/A') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Gender:</span>
                        <span class="info-value">{{ strtoupper($student->gender ?? 'N/A') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Session:</span>
                        <span class="info-value">{{ $academicYear }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Admission No:</span>
                        <span class="info-value">{{ $student->student_id_number }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">D.O.B.:</span>
                        <span class="info-value">
                            @if($student->date_of_birth)
                                {{ is_string($student->date_of_birth) ? \Carbon\Carbon::parse($student->date_of_birth)->format('d-m-Y') : $student->date_of_birth->format('d-m-Y') }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Age:</span>
                        <span class="info-value">
                            @if($student->date_of_birth)
                                @php
                                    $dob = is_string($student->date_of_birth) ? \Carbon\Carbon::parse($student->date_of_birth) : $student->date_of_birth;
                                    $age = $dob->age;
                                    $months = $dob->diffInMonths(now()) % 12;
                                @endphp
                                {{ $age }}yrs {{ $months }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    @if($student->club)
                    <div class="info-row">
                        <span class="info-label">House/Club:</span>
                        <span class="info-value">{{ strtoupper($student->club->name) }}</span>
                    </div>
                    @endif
                </div>
                <div>
                    @if($student->photo)
                        @php
                            $isPdfFlag = isset($isPdf) && $isPdf;
                            if ($isPdfFlag) {
                                $photoPath = storage_path('app/public/' . $student->photo);
                                if (!file_exists($photoPath)) {
                                    $photoPath = public_path('storage/' . $student->photo);
                                }
                            } else {
                                $photoPath = asset('storage/' . $student->photo);
                            }
                        @endphp
                        <img src="{{ $photoPath }}" alt="Student Photo" class="student-photo">
                    @else
                        <div class="student-photo" style="display: flex; align-items: center; justify-content: center; color: #999; font-size: 10px; text-align: center;">
                            No Photo
                        </div>
                    @endif
                </div>
            </div>

            <!-- Cognitive Domain Table -->
            <table class="cognitive-table">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>SUBJECT</th>
                        <th>C.A.</th>
                        <th>EXAM</th>
                        <th>TOTAL</th>
                        <th>GRADE</th>
                        <th>REMARK</th>
                        <th>CLASS AVERAGE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resultsWithClassAvg as $index => $result)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td style="text-align: left; padding-left: 8px;">{{ strtoupper($result->subject->name ?? 'N/A') }}</td>
                        <td>{{ number_format($result->ca_score ?? 0, 1) }}</td>
                        <td>{{ number_format($result->exam_score ?? 0, 1) }}</td>
                        <td><strong>{{ number_format($result->total_score ?? 0, 1) }}</strong></td>
                        <td><strong>{{ $result->grade ?? 'N/A' }}</strong></td>
                        <td>{{ strtoupper($result->remark ?? 'N/A') }}</td>
                        <td>{{ number_format($result->class_average ?? 0, 1) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Attendance and Domains Section -->
            <div class="two-column-section">
                <!-- Attendance Summary -->
                <div class="attendance-box">
                    <h4>ATTENDANCE SUMMARY</h4>
                    <table class="attendance-table">
                        <tr>
                            <td><strong>No. of Times School Opened</strong></td>
                            <td>{{ $totalDays }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. of Times Present</strong></td>
                            <td>{{ $presentDays }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. of Times Absent</strong></td>
                            <td>{{ $absentDays }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Grade Analysis -->
                <div class="grade-analysis">
                    <h4>GRADE ANALYSIS</h4>
                    <table class="grade-analysis-table">
                        <tr>
                            <td><strong>Total Subjects Offered</strong></td>
                            <td>{{ $totalSubjects }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Subjects Passed</strong></td>
                            <td>{{ $passedSubjects }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Subjects Failed</strong></td>
                            <td>{{ $failedSubjects }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Affective Domain -->
            <div style="margin-bottom: 15px;">
                <h4 style="font-size: 11px; font-weight: bold; margin-bottom: 8px; text-align: center; background: #f0f0f0; padding: 4px; border: 1px solid #000;">AFFECTIVE DOMAIN</h4>
                <table class="domain-table">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>TRAIT</th>
                            <th class="checkbox-cell">1</th>
                            <th class="checkbox-cell">2</th>
                            <th class="checkbox-cell">3</th>
                            <th class="checkbox-cell">4</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $affectiveTraits = ['Punctuality', 'Honesty', 'Neatness', 'Politeness', 'Obedience', 'Self-Control', 'Relationship with Others'];
                            $affectiveRating = 4; // Default rating (can be stored in database later)
                        @endphp
                        @foreach($affectiveTraits as $idx => $trait)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td style="text-align: left; padding-left: 8px;">{{ $trait }}</td>
                            <td>{{ $affectiveRating == 1 ? '✓' : '' }}</td>
                            <td>{{ $affectiveRating == 2 ? '✓' : '' }}</td>
                            <td>{{ $affectiveRating == 3 ? '✓' : '' }}</td>
                            <td>{{ $affectiveRating == 4 ? '✓' : '' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Psychomotor Skills -->
            <div style="margin-bottom: 15px;">
                <h4 style="font-size: 11px; font-weight: bold; margin-bottom: 8px; text-align: center; background: #f0f0f0; padding: 4px; border: 1px solid #000;">PSYCHOMOTOR SKILL</h4>
                <table class="domain-table">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>SKILL</th>
                            <th class="checkbox-cell">1</th>
                            <th class="checkbox-cell">2</th>
                            <th class="checkbox-cell">3</th>
                            <th class="checkbox-cell">4</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $psychomotorSkills = ['Handling of Tools', 'Drawing/Painting', 'Handwriting', 'Musical Skill', 'Public Speaking', 'Sports/Gaming'];
                            $psychomotorRating = 4; // Default rating
                        @endphp
                        @foreach($psychomotorSkills as $idx => $skill)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td style="text-align: left; padding-left: 8px;">{{ $skill }}</td>
                            <td>{{ $psychomotorRating == 1 ? '✓' : '' }}</td>
                            <td>{{ $psychomotorRating == 2 ? '✓' : '' }}</td>
                            <td>{{ $psychomotorRating == 3 ? '✓' : '' }}</td>
                            <td>{{ $psychomotorRating == 4 ? '✓' : '' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Grade Scale -->
            <div class="grade-scale">
                <h4>GRADE SCALE</h4>
                <div class="grade-scale-row">
                    <span class="grade-scale-label">A1-A6:</span>
                    <span>80-100% EXCELLENT</span>
                </div>
                <div class="grade-scale-row">
                    <span class="grade-scale-label">B1-B6:</span>
                    <span>70-79% VERY GOOD</span>
                </div>
                <div class="grade-scale-row">
                    <span class="grade-scale-label">C1-C6:</span>
                    <span>60-69% GOOD</span>
                </div>
                <div class="grade-scale-row">
                    <span class="grade-scale-label">D1-D6:</span>
                    <span>50-59% PASS</span>
                </div>
                <div class="grade-scale-row">
                    <span class="grade-scale-label">E1-E6:</span>
                    <span>40-49% POOR</span>
                </div>
                <div class="grade-scale-row">
                    <span class="grade-scale-label">F1-F6:</span>
                    <span>0-39% FAIL</span>
                </div>
            </div>

            <!-- Performance Summary -->
            <div class="performance-summary">
                <h4>PERFORMANCE SUMMARY</h4>
                <table class="performance-table">
                    <tr>
                        <td><strong>Total Score</strong></td>
                        <td>{{ number_format($totalScore, 1) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Obtainable</strong></td>
                        <td>{{ number_format($totalObtainable, 1) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Percentage</strong></td>
                        <td>{{ number_format($percentage, 2) }}%</td>
                    </tr>
                    <tr>
                        <td><strong>Grade</strong></td>
                        <td><strong>{{ $overallGrade }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Remark</strong></td>
                        <td><strong>{{ $overallRemark }}</strong></td>
                    </tr>
                </table>
            </div>

            <!-- Remarks Section -->
            <div class="remarks-section">
                <div class="remark-box">
                    <h4>CLASS TEACHER'S REMARK</h4>
                    <div class="remark-text">
                        @php
                            $teacherComment = $results->first()->teacher_comment ?? '';
                        @endphp
                        {{ $teacherComment ?: 'Good performance. Keep it up!' }}
                    </div>
                </div>
                <div class="remark-box">
                    <h4>PRINCIPAL'S REMARK</h4>
                    <div class="remark-text">
                        @if($percentage >= 80)
                            Excellent performance! Continue to maintain this standard.
                        @elseif($percentage >= 70)
                            Very good result. You can do even better. Keep working hard.
                        @elseif($percentage >= 60)
                            Good performance. There's room for improvement. Study harder.
                        @elseif($percentage >= 50)
                            Average result. You need to put in more effort to improve.
                        @else
                            Poor performance. You need to study harder and seek help when needed.
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer-section">
                <div class="footer-item">
                    <div class="footer-label">Date of Report</div>
                    <div>{{ date('D, d F Y') }}</div>
                </div>
                <div class="footer-item">
                    <div class="footer-label">Next Session Begins</div>
                    <div>
                        @php
                            $nextYear = (int)explode('/', $academicYear)[1];
                            $nextSessionStart = \Carbon\Carbon::create($nextYear, 9, 1)->format('D, d F Y');
                        @endphp
                        {{ $nextSessionStart }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
