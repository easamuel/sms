@extends('layouts.admin')

@section('title', 'Message Thread - School Management System')
@section('page-title', 'Message with ' . ($thread->parent?->user?->name ?? 'Parent'))

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
        padding: 2rem 0;
    }
    
    .message-container {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .sms-card {
        background: white;
        border-radius: var(--sms-radius-lg);
        box-shadow: var(--sms-shadow-lg);
        border: 1px solid var(--sms-gray-200);
        overflow: hidden;
    }
    
    .message-header-section {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--sms-gray-200);
    }
    
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1rem;
        transition: color 0.2s;
    }
    
    .back-link:hover {
        color: white;
    }
    
    .conversation-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .parent-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.85);
    }
    
    .parent-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1rem;
    }
    
    .messages-container {
        padding: 2rem;
        max-height: 600px;
        overflow-y: auto;
        background: var(--sms-gray-50);
    }
    
    .messages-container::-webkit-scrollbar {
        width: 8px;
    }
    
    .messages-container::-webkit-scrollbar-track {
        background: var(--sms-gray-100);
    }
    
    .messages-container::-webkit-scrollbar-thumb {
        background: var(--sms-gray-300);
        border-radius: 4px;
    }
    
    .messages-container::-webkit-scrollbar-thumb:hover {
        background: var(--sms-gray-400);
    }
    
    .message-item {
        margin-bottom: 1.5rem;
        display: flex;
        animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .message-item.admin {
        justify-content: flex-end;
    }
    
    .message-item.parent {
        justify-content: flex-start;
    }
    
    .message-bubble {
        max-width: 70%;
        padding: 1rem 1.25rem;
        border-radius: var(--sms-radius-lg);
        position: relative;
        box-shadow: var(--sms-shadow-sm);
    }
    
    .message-item.admin .message-bubble {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        border-bottom-right-radius: 4px;
    }
    
    .message-item.parent .message-bubble {
        background: white;
        color: var(--sms-gray-900);
        border: 1px solid var(--sms-gray-200);
        border-bottom-left-radius: 4px;
    }
    
    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
        gap: 1rem;
    }
    
    .message-sender {
        font-weight: 700;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .message-time {
        font-size: 0.75rem;
        opacity: 0.7;
        white-space: nowrap;
    }
    
    .message-content {
        line-height: 1.6;
        word-wrap: break-word;
        font-size: 0.9375rem;
    }
    
    .message-form-section {
        padding: 1.5rem 2rem;
        background: white;
        border-top: 1px solid var(--sms-gray-200);
    }
    
    .message-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .form-control {
        width: 100%;
        padding: 1rem;
        border: 2px solid var(--sms-gray-200);
        border-radius: var(--sms-radius);
        font-size: 0.9375rem;
        min-height: 120px;
        resize: vertical;
        font-family: inherit;
        transition: all 0.2s;
        background: var(--sms-gray-50);
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--sms-primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        color: white;
        padding: 0.875rem 2rem;
        border-radius: var(--sms-radius);
        border: none;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.2s;
        align-self: flex-end;
        box-shadow: var(--sms-shadow-sm);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--sms-shadow-md);
    }
    
    .btn-primary:active {
        transform: translateY(0);
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--sms-gray-500);
    }
    
    .empty-state-icon {
        font-size: 3rem;
        color: var(--sms-gray-300);
        margin-bottom: 1rem;
    }
    
    .empty-state-text {
        font-size: 1rem;
        color: var(--sms-gray-600);
    }
    
    @media (max-width: 768px) {
        .sms-page {
            padding: 1rem 0;
        }
        
        .message-header-section {
            padding: 1.25rem 1.5rem;
        }
        
        .conversation-title {
            font-size: 1.25rem;
        }
        
        .messages-container {
            padding: 1.5rem;
            max-height: 500px;
        }
        
        .message-bubble {
            max-width: 85%;
        }
        
        .message-form-section {
            padding: 1.25rem 1.5rem;
        }
    }
</style>

<div class="sms-page">
    <div class="container-fluid">
        <div class="message-container">
            <div class="sms-card">
                <div class="message-header-section">
                    <a href="{{ route('school.messages.index') }}" class="back-link">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Messages
                    </a>
                    <h3 class="conversation-title">
                        <div class="parent-avatar">
                            {{ strtoupper(substr($thread->parent?->user?->name ?? 'P', 0, 1)) }}
                        </div>
                        <div>
                            <div>Conversation with {{ $thread->parent?->user?->name ?? 'Parent' }}</div>
                            @if($thread->parent?->user?->email)
                                <div class="parent-info">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $thread->parent?->user?->email }}
                                </div>
                            @endif
                        </div>
                    </h3>
                </div>

                <div class="messages-container">
                    @forelse($thread->messages as $message)
                        <div class="message-item {{ $message->sender_type }}">
                            <div class="message-bubble">
                                <div class="message-header">
                                    <div class="message-sender">
                                        {{ $message->sender_type === 'admin' ? 'You' : ($thread->parent?->user?->name ?? 'Parent') }}
                                    </div>
                                    <div class="message-time">
                                        {{ $message->created_at->format('M d, Y h:i A') }}
                                    </div>
                                </div>
                                <div class="message-content">
                                    {{ $message->message }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-icon">💬</div>
                            <div class="empty-state-text">No messages yet. Start the conversation!</div>
                        </div>
                    @endforelse
                </div>

                <div class="message-form-section">
                    <form method="POST" action="{{ route('school.messages.send', $thread->id) }}" class="message-form">
                        @csrf
                        <textarea 
                            name="message" 
                            class="form-control" 
                            placeholder="Type your message here..." 
                            required
                            rows="4"
                        ></textarea>
                        <button type="submit" class="btn-primary">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
