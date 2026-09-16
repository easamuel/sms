<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\MessageThread;
use App\Models\Message;
use Illuminate\Http\Request;

class ParentMessageController extends Controller
{
    public function index()
    {
        $smsUser = session('sms_user');
        $smsRole = session('sms_role');

        if ($smsRole !== 'parent') {
            return redirect()->route('sms.parent.dashboard')
                ->with('error', 'Access denied.');
        }

        $parent = \App\Models\Sms\SmsParent::where('user_id', $smsUser->id)->first();
        
        if (!$parent) {
            return redirect()->route('sms.parent.dashboard')
                ->with('error', 'Parent profile not found.');
        }

        $thread = MessageThread::where('parent_id', $parent->id)
            ->with(['admin', 'messages' => function($q) {
                $q->orderBy('created_at', 'desc')->limit(50);
            }])
            ->first();

        // Mark messages as read
        if ($thread) {
            Message::where('thread_id', $thread->id)
                ->where('sender_type', 'admin')
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);
        }

        return view('sms.parent.messages', compact('thread', 'parent'));
    }

    public function send(Request $request)
    {
        $smsUser = session('sms_user');
        $smsRole = session('sms_role');

        if ($smsRole !== 'parent') {
            return back()->with('error', 'Access denied.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $parent = \App\Models\Sms\SmsParent::where('user_id', $smsUser->id)->first();
        
        if (!$parent) {
            return back()->with('error', 'Parent profile not found.');
        }

        // Get or create thread (find admin for this school)
        // CRITICAL: Every school MUST have at least one admin
        $admin = \App\Models\Sms\SmsUser::where('school_id', $parent->school_id)
            ->where('role', 'admin')
            ->where('is_active', true)
            ->orderBy('created_at', 'asc') // Get the first/primary admin
            ->first();

        // If no admin exists, create one automatically (system requirement)
        if (!$admin) {
            \Log::warning('No admin found for school', ['school_id' => $parent->school_id]);
            
            // Create a system admin for this school
            $school = \App\Models\Sms\SmsSchool::find($parent->school_id);
            if ($school) {
                $admin = \App\Models\Sms\SmsUser::create([
                    'school_id' => $parent->school_id,
                    'name' => $school->name . ' Administrator',
                    'email' => 'admin@' . strtolower(str_replace(' ', '', $school->name)) . '.com',
                    'password' => bcrypt('admin123'), // Default password - should be changed
                    'role' => 'admin',
                    'is_active' => true,
                ]);
                
                \Log::info('Auto-created admin for school', ['school_id' => $parent->school_id, 'admin_id' => $admin->id]);
            } else {
                // This should never happen, but log it
                \Log::error('Parent school not found', ['parent_id' => $parent->id, 'school_id' => $parent->school_id]);
                return back()->with('error', 'School configuration error. Please contact support.');
            }
        }

        $thread = MessageThread::firstOrCreate(
            [
                'school_id' => $parent->school_id,
                'admin_id' => $admin->id,
                'parent_id' => $parent->id,
            ],
            ['last_message_at' => now()]
        );

        Message::create([
            'thread_id' => $thread->id,
            'sender_id' => $smsUser->id,
            'sender_type' => 'parent',
            'message' => $validated['message'],
        ]);

        $thread->update(['last_message_at' => now()]);

        return back()->with('success', 'Message sent.');
    }
}
