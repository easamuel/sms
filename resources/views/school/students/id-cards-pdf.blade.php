<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>All Student ID Cards - {{ $school->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        
        .page {
            page-break-after: always;
        }
        
        .page:last-child {
            page-break-after: auto;
        }
        
        .id-cards-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .id-card-container {
            width: 100%;
            height: 150px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }
        
        .id-card-container::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            pointer-events: none;
        }
        
        .id-card-content {
            display: flex;
            height: 100%;
            position: relative;
            z-index: 1;
        }
        
        .id-card-left {
            flex: 0 0 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }
        
        .id-card-photo {
            width: 70px;
            height: 85px;
            border-radius: 8px;
            border: 3px solid white;
            object-fit: cover;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        .id-card-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
        }
        
        .id-card-header {
            margin-bottom: 8px;
        }
        
        .id-card-school {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            opacity: 0.95;
        }
        
        .id-card-title {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.85;
        }
        
        .id-card-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .id-card-name {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 6px;
            line-height: 1.2;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .id-card-detail {
            font-size: 9px;
            margin-bottom: 4px;
            line-height: 1.3;
        }
        
        .id-card-detail-label {
            font-weight: 600;
            opacity: 0.9;
            display: inline-block;
            width: 50px;
        }
        
        .id-card-detail-value {
            font-weight: 500;
        }
        
        .id-card-footer {
            margin-top: 8px;
            padding-top: 6px;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            font-size: 8px;
            text-align: center;
            opacity: 0.85;
        }
        
        .id-card-id {
            font-weight: 700;
            font-size: 10px;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>
    @foreach($students->chunk(4) as $chunk)
        <div class="page">
            <div class="id-cards-grid">
                @foreach($chunk as $student)
                    <div class="id-card-container">
                        <div class="id-card-content">
                            <div class="id-card-left">
                                @php
                                    $photoPath = file_exists(public_path('storage/' . $student->photo)) 
                                        ? public_path('storage/' . $student->photo) 
                                        : (file_exists(storage_path('app/public/' . $student->photo))
                                            ? storage_path('app/public/' . $student->photo)
                                            : null);
                                @endphp
                                @if($student->photo && $photoPath)
                                    <img src="{{ $photoPath }}" alt="Student Photo" class="id-card-photo">
                                @else
                                    <div class="id-card-photo" style="display: flex; align-items: center; justify-content: center; color: #999; font-size: 8px; text-align: center; padding: 4px;">
                                        No Photo
                                    </div>
                                @endif
                            </div>
                            
                            <div class="id-card-right">
                                <div class="id-card-header">
                                    <div class="id-card-school">{{ $school->name ?? 'SCHOOL NAME' }}</div>
                                    <div class="id-card-title">Student Identity Card</div>
                                </div>
                                
                                <div class="id-card-info">
                                    <div class="id-card-name">{{ $student->user->name ?? 'N/A' }}</div>
                                    
                                    <div class="id-card-detail">
                                        <span class="id-card-detail-label">Class:</span>
                                        <span class="id-card-detail-value">{{ $student->class->name ?? 'N/A' }}</span>
                                    </div>
                                    
                                    @if($student->club)
                                    <div class="id-card-detail">
                                        <span class="id-card-detail-label">Club:</span>
                                        <span class="id-card-detail-value">{{ $student->club->name }}</span>
                                    </div>
                                    @if($student->club_position)
                                    <div class="id-card-detail">
                                        <span class="id-card-detail-label">Position:</span>
                                        <span class="id-card-detail-value">{{ $student->club_position }}</span>
                                    </div>
                                    @endif
                                    @endif
                                </div>
                                
                                <div class="id-card-footer">
                                    <div class="id-card-id">ID: {{ $student->student_id_number }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</body>
</html>
