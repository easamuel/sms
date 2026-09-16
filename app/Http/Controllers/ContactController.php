<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
        
        try {
            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
            ];
            
            // Send email
            Mail::send('emails.contact', $data, function($mail) use ($data) {
                $mail->to('help@extremesolutions.com.ng')
                     ->subject('Contact Form: ' . $data['subject'])
                     ->replyTo($data['email'], $data['name']);
            });
            
            return redirect()->route('contact')
                ->with('success', 'Thank you for your message! We\'ll get back to you as soon as possible.');
                
        } catch (\Exception $e) {
            \Log::error('Contact form error: ' . $e->getMessage());
            
            return redirect()->route('contact')
                ->with('error', 'Sorry, there was an error sending your message. Please try again later or email us directly at help@extremesolutions.com.ng')
                ->withInput();
        }
    }
}
