<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Slip - {{ $student->user->name ?? 'Student' }}</title>
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
            padding: 20px;
            position: relative;
        }
        .result-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            position: relative;
            padding: 30px;
        }
        .school-logo-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.05;
            z-index: 0;
            max-width: 600px;
            max-height: 600px;
        }
        .result-content {
            position: relative;
            z-index: 1;
        }
        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }
        .student-info {
            flex: 1;
        }
        .student-photo {
            width: 120px;
            height: 150px;
            border: 2px solid #000;
            border-radius: 4px;
            object-fit: cover;
            background: #f0f0f0;
        }
        .info-row {
            display: flex;
            margin-bottom: 8px;
            font-size: 13px;
        }
        .info-label {
            font-weight: bold;
            min-width: 120px;
        }
        .info-value {
            flex: 1;
        }
        .performance-summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #ddd;
        }
        .summary-item {
            text-align: center;
        }
        .summary-label {
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
        }
        .summary-value {
            font-size: 16px;
            font-weight: bold;
            color: #000;
        }
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }
        .results-table th,
        .results-table td {
            border: 1px solid #000;
            padding: 8px 5px;
            text-align: center;
        }
        .results-table th {
            background: #f0f0f0;
            font-weight: bold;
            font-size: 10px;
        }
        .results-table td {
            font-size: 11px;
        }
        .results-table .subject-col {
            text-align: left;
            padding-left: 8px;
            font-weight: 600;
        }
        .grade-A { background: #d4edda; }
        .grade-C { background: #fff3cd; }
        .grade-P { background: #d1ecf1; }
        .grade-F { background: #f8d7da; }
        .key-section {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #ddd;
        }
        .key-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 12px;
        }
        .key-items {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            font-size: 11px;
        }
        .key-item {
            display: flex;
            gap: 5px;
        }
        .key-label {
            font-weight: bold;
            min-width: 80px;
        }
        .comments-section {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }
        .comment-box {
            border: 1px solid #000;
            padding: 15px;
            min-height: 120px;
        }
        .comment-label {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 12px;
        }
        .comment-text {
            font-size: 11px;
            margin-bottom: 15px;
            min-height: 40px;
        }
        .comment-signature {
            border-top: 1px solid #000;
            padding-top: 10px;
            margin-top: 10px;
        }
        .signature-line {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            margin-top: 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        @media print {
            body {
                padding: 0;
            }
            .result-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="result-container">
        @if($school->logo)
        <img src="{{ asset('storage/' . $school->logo) }}" alt="School Logo" class="school-logo-bg">
        @endif
        
        <div class="result-content">
            <div class="result-header">
                <div class="student-info">
                    <div class="info-row">
                        <span class="info-label">Name:</span>
                        <span class="info-value"><strong>{{ $student->user->name ?? 'N/A' }}</strong></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Gender:</span>
                        <span class="info-value">{{ ucfirst($student->gender ?? 'N/A') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Regno:</span>
                        <span class="info-value">{{ $student->student_id_number }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Report:</span>
                        <span class="info-value">Annual Result</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Session:</span>
                        <span class="info-value">{{ $academicYear }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Year:</span>
                        <span class="info-value">{{ explode('/', $academicYear)[0] }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Next Term Begins:</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($academicYear)->addYear()->format('d M, Y') }}</span>
                    </div>
                </div>
                <div>
                    @if($student->photo)
                        <img src="{{ asset('storage/' . $student->photo) }}" alt="Student Photo" class="student-photo">
                    @else
                        <div class="student-photo" style="display: flex; align-items: center; justify-content: center; color: #999;">
                            No Photo
                        </div>
                    @endif
                </div>
            </div>

            <div class="performance-summary">
                <div class="summary-item">
                    <div class="summary-label">Position</div>
                    <div class="summary-value">{{ $position }}<sup>th</sup></div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Average</div>
                    <div class="summary-value">{{ number_format($average, 2) }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Total Score</div>
                    <div class="summary-value">{{ number_format($totalScore, 1) }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Result Analysis</div>
                    <div class="summary-value">{{ $average >= 50 ? 'Passed' : 'Failed' }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Class</div>
                    <div class="summary-value">{{ $student->class->name ?? 'N/A' }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Number in Class</div>
                    <div class="summary-value">{{ $classSize }}</div>
                </div>
            </div>

            <table class="results-table">
                <thead>
                    <tr>
                        <th>Subject(s)</th>
                        <th>A(100%)</th>
                        <th>B(100%)</th>
                        <th>C(100%)</th>
                        <th>D(300%)</th>
                        <th>E(100%)</th>
                        <th>F({{ $classSize }})</th>
                        <th>G(100%)</th>
                        <th>H</th>
                        <th>I</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $subjects = \App\Models\Sms\SmsSubject::where('school_id', $school->id)->get();
                        $firstTermResults = $results->where('term', 'First Term')->keyBy('subject_id');
                        $secondTermResults = $results->where('term', 'Second Term')->keyBy('subject_id');
                        $thirdTermResults = $results->where('term', 'Third Term')->keyBy('subject_id');
                    @endphp
                    @foreach($subjects as $subject)
                    @php
                        $firstTerm = $firstTermResults->get($subject->id);
                        $secondTerm = $secondTermResults->get($subject->id);
                        $thirdTerm = $thirdTermResults->get($subject->id);
                        
                        $term1Score = $firstTerm ? ($firstTerm->ca_score + $firstTerm->exam_score) : null;
                        $term2Score = $secondTerm ? ($secondTerm->ca_score + $secondTerm->exam_score) : null;
                        $term3Score = $thirdTerm ? ($thirdTerm->ca_score + $thirdTerm->exam_score) : null;
                        
                        $total = ($term1Score ?? 0) + ($term2Score ?? 0) + ($term3Score ?? 0);
                        $average = $total > 0 ? $total / 3 : 0;
                        
                        $grade = '';
                        $remark = '';
                        if ($average >= 70) {
                            $grade = 'A';
                            $remark = 'Excellent';
                        } elseif ($average >= 55) {
                            $grade = 'C';
                            $remark = 'Credit';
                        } elseif ($average >= 40) {
                            $grade = 'P';
                            $remark = 'Pass';
                        } else {
                            $grade = 'F';
                            $remark = 'Fail';
                        }
                        
                        $position = $firstTerm ? $firstTerm->position : '-';
                    @endphp
                    <tr>
                        <td class="subject-col">{{ $subject->name }}</td>
                        <td>{{ $term1Score !== null ? number_format($term1Score, 0) : '-' }}</td>
                        <td>{{ $term2Score !== null ? number_format($term2Score, 0) : '-' }}</td>
                        <td>{{ $term3Score !== null ? number_format($term3Score, 0) : '-' }}</td>
                        <td>{{ $total > 0 ? number_format($total, 0) : '-' }}</td>
                        <td>{{ $average > 0 ? number_format($average, 2) : '-' }}</td>
                        <td>{{ $position }}{{ $position !== '-' ? 'th' : '' }}</td>
                        <td>{{ $average > 0 ? number_format($average, 2) : '-' }}</td>
                        <td class="grade-{{ $grade }}">{{ $grade }}</td>
                        <td>{{ $remark }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="key-section">
                <div class="key-title">Key to Columns:</div>
                <div class="key-items">
                    <div class="key-item"><span class="key-label">A =</span> First term (100%)</div>
                    <div class="key-item"><span class="key-label">B =</span> Second term (100%)</div>
                    <div class="key-item"><span class="key-label">C =</span> Third term (100%)</div>
                    <div class="key-item"><span class="key-label">D =</span> Total Score (300%)</div>
                    <div class="key-item"><span class="key-label">E =</span> Average (100%)</div>
                    <div class="key-item"><span class="key-label">F =</span> Position in Subject ({{ $classSize }})</div>
                    <div class="key-item"><span class="key-label">G =</span> Class Average (100%)</div>
                    <div class="key-item"><span class="key-label">H =</span> Grade</div>
                    <div class="key-item"><span class="key-label">I =</span> Remark</div>
                </div>
                <div style="margin-top: 15px;">
                    <div class="key-title">Key to Grade:</div>
                    <div class="key-items">
                        <div class="key-item"><span class="key-label">A (Excellent) =</span> 70-100%</div>
                        <div class="key-item"><span class="key-label">C (Credit) =</span> 55-69%</div>
                        <div class="key-item"><span class="key-label">P (Pass) =</span> 40-54%</div>
                        <div class="key-item"><span class="key-label">F (Fail) =</span> 0-39%</div>
                    </div>
                </div>
            </div>

            <div class="comments-section">
                <div class="comment-box">
                    <div class="comment-label">Class Teacher's Comment:</div>
                    <div class="comment-text"></div>
                    <div class="comment-signature">
                        <div class="signature-line">
                            <span>Name:</span>
                            <span>_________________________</span>
                        </div>
                        <div class="signature-line">
                            <span>Date:</span>
                            <span>_________________________</span>
                        </div>
                        <div class="signature-line">
                            <span>Signature:</span>
                            <span>_________________________</span>
                        </div>
                    </div>
                </div>
                <div class="comment-box">
                    <div class="comment-label">Principal's Comment:</div>
                    <div class="comment-text"></div>
                    <div class="comment-signature">
                        <div class="signature-line">
                            <span>Name:</span>
                            <span>_________________________</span>
                        </div>
                        <div class="signature-line">
                            <span>Date:</span>
                            <span>_________________________</span>
                        </div>
                        <div class="signature-line">
                            <span>Signature:</span>
                            <span>_________________________</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                This result was calculated by School Management System
            </div>
        </div>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
