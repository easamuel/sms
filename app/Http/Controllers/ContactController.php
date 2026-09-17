<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }
    
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);
        
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'submitted_at' => now()->toDateTimeString(),
            'ip' => $request->ip(),
        ];

        // 1. Always record in dedicated server log for fail-safe storage
        Log::info('CONTACT_FORM_SUBMISSION', $data);

        // 2. Append to persistent inquiries file backup
        try {
            $inquiriesFile = storage_path('logs/inquiries.log');
            file_put_contents(
                $inquiriesFile,
                "[" . now()->toDateTimeString() . "] From: {$data['name']} <{$data['email']}> | Subject: {$data['subject']} | Msg: " . str_replace(["\r", "\n"], " ", $data['message']) . "\n",
                FILE_APPEND
            );
        } catch (\Throwable $e) {
            Log::warning('Could not write to inquiries.log: ' . $e->getMessage());
        }

        // 3. Attempt delivery via Laravel Mailer to sms@extremesolutions.com.ng
        $mailSent = false;
        try {
            Mail::send('emails.contact', $data, function($mail) use ($data) {
                $mail->to('sms@extremesolutions.com.ng')
                     ->subject('New Inquiry: ' . $data['subject'])
                     ->replyTo($data['email'], $data['name']);
            });
            $mailSent = true;
        } catch (\Throwable $e) {
            Log::error('Laravel Mailer error in ContactController: ' . $e->getMessage());
        }

        // 4. Fallback to native PHP mail for cPanel Exim MTA if Mailer was on log driver
        if (!$mailSent) {
            try {
                $headers = "From: sms@extremesolutions.com.ng\r\n" .
                           "Reply-To: {$data['email']}\r\n" .
                           "X-Mailer: PHP/" . phpversion();
                $body = "New Contact Form Submission on ES-SCHOOLS:\n\n" .
                        "Name: {$data['name']}\n" .
                        "Email: {$data['email']}\n" .
                        "Subject: {$data['subject']}\n\n" .
                        "Message:\n{$data['message']}\n\n" .
                        "IP Address: {$data['ip']}\n" .
                        "Timestamp: {$data['submitted_at']}\n";
                @mail('sms@extremesolutions.com.ng', 'New Contact Inquiry: ' . $data['subject'], $body, $headers);
            } catch (\Throwable $e) {
                Log::warning('Native PHP mail fallback also failed: ' . $e->getMessage());
            }
        }
        
        return redirect()->route('contact')
            ->with('success', 'Thank you for reaching out! Your message has been sent to our admissions and support team (sms@extremesolutions.com.ng). We will respond promptly.');
    }
}
