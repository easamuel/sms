<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student ID Card - {{ $student->student_id_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: #f5f5f5;
        }
        
        .id-card-container {
            width: 340px;
            height: 215px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            margin: 10px auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: relative;
        }
        
        /* School Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60px;
            font-weight: 700;
            color: rgba(0, 0, 0, 0.05);
            text-transform: uppercase;
            letter-spacing: 5px;
            white-space: nowrap;
            z-index: 0;
            pointer-events: none;
        }
        
        /* Front Side */
        .id-card-front {
            width: 100%;
            height: 100%;
            position: relative;
            z-index: 1;
        }
        
        .orange-triangle {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background: #ff6600;
            clip-path: polygon(0 0, 100% 0, 100% 60%, 0 100%);
        }
        
        .school-info {
            position: absolute;
            top: 15px;
            left: 20px;
            color: white;
            z-index: 2;
        }
        
        .school-name {
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }
        
        .school-slogan {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.95;
        }
        
        .photo-container {
            position: absolute;
            top: 50px;
            right: 20px;
            z-index: 3;
        }
        
        .student-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 4px solid #ff6600;
            object-fit: cover;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        .student-details {
            position: absolute;
            top: 85px;
            left: 20px;
            right: 20px;
            font-size: 11px;
            line-height: 1.6;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 4px;
        }
        
        .detail-label {
            font-weight: 600;
            color: #333;
            width: 120px;
            flex-shrink: 0;
        }
        
        .detail-value {
            color: #555;
            flex: 1;
        }
        
        .orange-bar-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 30px;
            background: #ff6600;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }
        
        .school-address {
            color: white;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Back Side */
        .id-card-back {
            width: 100%;
            height: 100%;
            position: relative;
            background: white;
        }
        
        .orange-bar-top {
            width: 100%;
            height: 30px;
            background: #ff6600;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .back-content {
            padding: 15px 20px;
            font-size: 9px;
            line-height: 1.5;
        }
        
        .terms-title {
            font-weight: 700;
            margin-bottom: 8px;
            color: #333;
        }
        
        .terms-list {
            margin-bottom: 10px;
            color: #555;
        }
        
        .terms-list ul {
            list-style: none;
            padding-left: 0;
        }
        
        .terms-list li {
            margin-bottom: 5px;
            padding-left: 15px;
            position: relative;
        }
        
        .terms-list li:before {
            content: "•";
            position: absolute;
            left: 0;
            color: #ff6600;
            font-weight: bold;
        }
        
        .contact-info {
            margin-bottom: 10px;
            color: #555;
        }
        
        .contact-row {
            margin-bottom: 3px;
        }
        
        .qr-code-area {
            text-align: center;
            margin: 10px 0;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 4px;
        }
        
        .qr-placeholder {
            width: 60px;
            height: 60px;
            background: #ddd;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #999;
        }
        
        .dates-section {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        
        .date-row {
            margin-bottom: 3px;
            color: #555;
        }
        
        .signature-area {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 10px;
        }
        
        .logo-area {
            font-size: 8px;
            color: #999;
            text-align: center;
        }
        
        .signature-line {
            text-align: right;
            font-size: 9px;
            color: #555;
        }
        
        .signature-line div {
            border-top: 1px solid #333;
            width: 100px;
            margin-bottom: 3px;
        }
        
        .orange-bar-bottom-back {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 30px;
            background: #ff6600;
        }
        
        @media print {
            .id-card-container {
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <!-- Front Side -->
    <div class="id-card-container">
        <div class="watermark">{{ strtoupper($school->name ?? 'SCHOOL') }}</div>
        <div class="id-card-front">
            <div class="orange-triangle"></div>
            
            <div class="school-info">
                <div class="school-name">{{ strtoupper($school->name ?? 'SCHOOL NAME') }}</div>
                <div class="school-slogan">{{ strtoupper($school->motto ?? ($school->name ?? 'EXCELLENCE IN EDUCATION')) }}</div>
            </div>
            
            <div class="photo-container">
                @php
                    $photoPath = file_exists(public_path('storage/' . $student->photo)) 
                        ? public_path('storage/' . $student->photo) 
                        : (file_exists(storage_path('app/public/' . $student->photo))
                            ? storage_path('app/public/' . $student->photo)
                            : null);
                @endphp
                @if($student->photo && $photoPath)
                    <img src="{{ $photoPath }}" alt="Student Photo" class="student-photo">
                @else
                    <div class="student-photo" style="display: flex; align-items: center; justify-content: center; background: #f0f0f0; color: #999; font-size: 10px; text-align: center;">
                        No Photo
                    </div>
                @endif
            </div>
            
            <div class="student-details">
                <div class="detail-row">
                    <span class="detail-label">Reg No:</span>
                    <span class="detail-value">{{ $student->student_id_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Student Name:</span>
                    <span class="detail-value"><strong>{{ strtoupper($student->user->name ?? 'N/A') }}</strong></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Class:</span>
                    <span class="detail-value">{{ $student->class->name ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Group:</span>
                    <span class="detail-value">{{ $student->club ? ($student->club->name . ($student->club_position ? ' - ' . $student->club_position : '')) : 'N/A' }}</span>
                </div>
            </div>
            
            <div class="orange-bar-bottom">
                <div class="school-address">
                    {{ strtoupper($school->address ?? 'School Address') }}, {{ strtoupper($school->city ?? 'City') }}, {{ strtoupper($school->state ?? 'State') }}
                </div>
            </div>
            
            <!-- Bottom Section: QR Code and Signature -->
            <div style="position: absolute; bottom: 30px; left: 20px; right: 20px; display: flex; justify-content: space-between; align-items: flex-end;">
                <!-- Left: QR Code -->
                <div style="text-align: center;">
                    <div style="padding: 4px; background: #f9f9f9; border-radius: 4px; width: 50px;">
                        <div style="width: 40px; height: 40px; background: #ddd; margin: 0 auto; display: flex; align-items: center; justify-content: center; font-size: 7px; color: #999; border-radius: 2px; flex-direction: column;">
                            <div style="font-weight: bold; margin-bottom: 2px;">QR</div>
                            <div>{{ substr($student->student_id_number, -4) }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right: Signature -->
                <div style="text-align: right; font-size: 8px; color: #555;">
                    @if($school->logo)
                    <div style="margin-bottom: 3px;">
                        <img src="{{ file_exists(public_path('storage/' . $school->logo)) ? public_path('storage/' . $school->logo) : storage_path('app/public/' . $school->logo) }}" 
                             alt="Logo" style="max-width: 30px; max-height: 30px;">
                    </div>
                    @endif
                    <div style="border-top: 1px solid #333; width: 80px; margin: 0 auto 2px auto;"></div>
                    <div style="font-weight: 600;">Principal</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
