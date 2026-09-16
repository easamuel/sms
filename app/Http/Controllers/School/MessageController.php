<?php

namespace App\Http\Controllers\School;

use App\Models\MessageThread;
use App\Models\Message;
use App\Models\Sms\SmsParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends BaseSchoolController
{
    public function index()
    {
        $school = $this->getSchool();
        $smsUser = session('sms_user');
        
        if (!$school || !$smsUser) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $threads = MessageThread::where('school_id', $school->id)
            ->where('admin_id', $smsUser->id)
            ->with(['parent.user', 'messages' => function($q) {
                $q->latest()->limit(1);
            }])
            ->orderBy('last_message_at', 'desc')
            ->get();

        // Get unread counts
        foreach ($threads as $thread) {
            $thread->unread_count = $thread->unreadCount($smsUser->id, 'admin');
        }

        return view('school.messages.index', compact('threads', 'school'));
    }

    public function show($threadId)
    {
        $school = $this->getSchool();
        $smsUser = session('sms_user');
        
        if (!$school || !$smsUser) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $thread = MessageThread::where('school_id', $school->id)
            ->where('admin_id', $smsUser->id)
            ->where('id', $threadId)
            ->with(['parent.user', 'messages.sender'])
            ->firstOrFail();

        // Mark messages as read
        Message::where('thread_id', $threadId)
            ->where('sender_type', 'parent')
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('school.messages.show', compact('thread', 'school'));
    }

    public function send(Request $request, $threadId)
    {
        $school = $this->getSchool();
        $smsUser = session('sms_user');
        
        if (!$school || !$smsUser) {
            return back()->with('error', 'Unauthorized.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $thread = MessageThread::where('school_id', $school->id)
            ->where('admin_id', $smsUser->id)
            ->where('id', $threadId)
            ->firstOrFail();

        Message::create([
            'thread_id' => $threadId,
            'sender_id' => $smsUser->id,
            'sender_type' => 'admin',
            'message' => $validated['message'],
        ]);

        $thread->update(['last_message_at' => now()]);

        return back()->with('success', 'Message sent.');
    }

    public function create()
    {
        $school = $this->getSchool();
        $smsUser = session('sms_user');
        
        if (!$school || !$smsUser) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        // Get all parents for the school
        $parents = SmsParent::where('school_id', $school->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('school.messages.create', compact('parents', 'school'));
    }

    public function store(Request $request)
    {
        $school = $this->getSchool();
        $smsUser = session('sms_user');
        
        if (!$school || !$smsUser) {
            return back()->with('error', 'Unauthorized.');
        }

        $validated = $request->validate([
            'parent_id' => 'required|exists:sms_parents,id',
            'message' => 'required|string|max:5000',
        ]);

        // Verify parent belongs to school
        $parent = SmsParent::where('school_id', $school->id)
            ->where('id', $validated['parent_id'])
            ->firstOrFail();

        // Get or create thread
        $thread = MessageThread::firstOrCreate(
            [
                'school_id' => $school->id,
                'admin_id' => $smsUser->id,
                'parent_id' => $validated['parent_id'],
            ],
            ['last_message_at' => now()]
        );

        Message::create([
            'thread_id' => $thread->id,
            'sender_id' => $smsUser->id,
            'sender_type' => 'admin',
            'message' => $validated['message'],
        ]);

        $thread->update(['last_message_at' => now()]);

        return redirect()->route('school.messages.show', $thread->id)
            ->with('success', 'Message sent.');
    }
}
