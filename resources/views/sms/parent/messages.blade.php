@extends('layouts.app')

@section('title', 'Messages - School Management System')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-dashboard {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
    }
    .sms-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }
    .message-item {
        margin-bottom: 1.5rem;
        padding: 1rem;
        border-radius: 8px;
    }
    .message-item.admin {
        background: var(--sms-blue-50);
        margin-right: 2rem;
    }
    .message-item.parent {
        background: var(--sms-gray-100);
        margin-left: 2rem;
    }
    .message-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }
    .message-sender {
        font-weight: 700;
        font-size: 0.875rem;
    }
    .message-time {
        font-size: 0.8125rem;
        color: var(--sms-gray-500);
    }
    .message-content {
        color: var(--sms-gray-900);
        line-height: 1.6;
    }
    .message-form {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--sms-gray-200);
    }
    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--sms-gray-300);
        border-radius: 6px;
        font-size: 0.875rem;
        min-height: 100px;
        resize: vertical;
    }
    .btn-primary {
        background: var(--sms-blue-600);
        color: white;
        padding: 0.625rem 1.5rem;
        border-radius: 6px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        margin-top: 0.75rem;
    }
</style>

<div class="sms-dashboard">
    <div class="container-fluid py-4">
        <div class="sms-card">
            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">Messages with School Admin</h2>

            @if($thread)
                <div style="max-height: 500px; overflow-y: auto; margin-bottom: 1.5rem;">
                    @forelse($thread->messages as $message)
                        <div class="message-item {{ $message->sender_type }}">
                            <div class="message-header">
                                <div class="message-sender">
                                    {{ $message->sender_type === 'admin' ? 'School Admin' : 'You' }}
                                </div>
                                <div class="message-time">
                                    {{ $message->created_at->format('M d, Y h:i A') }}
                                </div>
                            </div>
                            <div class="message-content">
                                {{ $message->message }}
                            </div>
                        </div>
                    @empty
                        <p style="text-align: center; color: var(--sms-gray-500); padding: 2rem;">No messages yet. Start the conversation!</p>
                    @endforelse
                </div>

                <form method="POST" action="{{ route('sms.parent.messages.send') }}" class="message-form">
                    @csrf
                    <textarea name="message" class="form-control" placeholder="Type your message to the school admin..." required></textarea>
                    <button type="submit" class="btn-primary">Send Message</button>
                </form>
            @else
                <p style="text-align: center; color: var(--sms-gray-500); padding: 2rem; margin-bottom: 1.5rem;">
                    No conversation started yet. Send a message to start.
                </p>
                <form method="POST" action="{{ route('sms.parent.messages.send') }}" class="message-form">
                    @csrf
                    <textarea name="message" class="form-control" placeholder="Type your message to the school admin..." required></textarea>
                    <button type="submit" class="btn-primary">Send Message</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
