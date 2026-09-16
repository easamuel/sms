<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.6;
            color: #1e293b;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #1e3a8a, #1e40af);
            color: white;
            padding: 30px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .content {
            background: #f8fafc;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 5px;
            display: block;
        }
        .field-value {
            color: #1e293b;
            padding: 10px;
            background: white;
            border-radius: 4px;
            border-left: 3px solid #10b981;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0; font-size: 24px;">New Contact Form Submission</h1>
        <p style="margin: 10px 0 0 0; opacity: 0.9;">ES-SCHOOLS Platform</p>
    </div>
    
    <div class="content">
        <div class="field">
            <span class="field-label">From:</span>
            <div class="field-value">{{ $name }} ({{ $email }})</div>
        </div>
        
        <div class="field">
            <span class="field-label">Subject:</span>
            <div class="field-value">{{ $subject }}</div>
        </div>
        
        <div class="field">
            <span class="field-label">Message:</span>
            <div class="field-value" style="white-space: pre-wrap;">{{ $message }}</div>
        </div>
        
        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">
        
        <p style="color: #64748b; font-size: 14px; margin: 0;">
            This message was sent from the contact form on ES-SCHOOLS website.
        </p>
    </div>
</body>
</html>
