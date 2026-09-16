@extends('layouts.admin')

@section('title', 'Parent Messages - School Management System')
@section('page-title', 'Parent Messages')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
        padding: 2rem;
    }
    
    /* Modern Header */
    .page-header {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
        border-radius: 24px;
        padding: 3rem 2.5rem;
        margin-bottom: 2.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    
    .page-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }
    
    .page-header-content {
        position: relative;
        z-index: 1;
    }
    
    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .page-title-icon {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    
    .page-subtitle {
        font-size: 1.125rem;
        opacity: 0.95;
        font-weight: 400;
    }
    
    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.8);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, var(--sms-primary), var(--sms-accent));
    }
    
    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .stat-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }
    
    .stat-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .stat-icon.total {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
    }
    
    .stat-icon.unread {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }
    
    .stat-icon.recent {
        background: linear-gradient(135deg, #10b981, #059669);
    }
    
    .stat-label {
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--sms-gray-500);
        font-weight: 600;
        margin-bottom: 0.75rem;
    }
    
    .stat-value {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        line-height: 1.2;
    }
    
    /* Messages Card */
    .messages-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--sms-gray-200);
        overflow: hidden;
    }
    
    .messages-card-header {
        padding: 1.75rem 2rem;
        border-bottom: 1px solid var(--sms-gray-200);
        background: linear-gradient(to right, rgba(99, 102, 241, 0.05), transparent);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .messages-card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .messages-card-title-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-primary-dark));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.125rem;
    }
    
    .messages-card-body {
        padding: 0;
    }
    
    /* Thread Items */
    .thread-item {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--sms-gray-100);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        position: relative;
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }
    
    .thread-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--sms-primary), var(--sms-accent));
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .thread-item:hover {
        background: linear-gradient(to right, rgba(99, 102, 241, 0.03), white);
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .thread-item:hover::before {
        opacity: 1;
    }
    
    .thread-item:last-child {
        border-bottom: none;
    }
    
    .thread-item.unread {
        background: linear-gradient(to right, rgba(99, 102, 241, 0.05), white);
    }
    
    .thread-item.unread::before {
        opacity: 1;
    }
    
    .thread-avatar {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.25rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }
    
    .thread-content {
        flex: 1;
        min-width: 0;
    }
    
    .thread-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.5rem;
        gap: 1rem;
    }
    
    .thread-parent-info {
        flex: 1;
        min-width: 0;
    }
    
    .thread-parent-name {
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--sms-gray-900);
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .thread-parent-email {
        font-size: 0.875rem;
        color: var(--sms-gray-500);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .thread-time {
        font-size: 0.8125rem;
        color: var(--sms-gray-500);
        white-space: nowrap;
        font-weight: 500;
    }
    
    .thread-last-message {
        color: var(--sms-gray-600);
        font-size: 0.9375rem;
        margin-top: 0.5rem;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .unread-badge {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border-radius: 9999px;
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.8;
        }
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--sms-gray-500);
    }
    
    .empty-state-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: var(--sms-primary);
    }
    
    .empty-state-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--sms-gray-700);
        margin-bottom: 0.5rem;
    }
    
    .empty-state-text {
        font-size: 1rem;
        color: var(--sms-gray-500);
        margin-bottom: 2rem;
    }
    
    .btn-create-message {
        background: linear-gradient(135deg, var(--sms-primary), var(--sms-accent));
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }
    
    .btn-create-message:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
    }
    
    @media (max-width: 768px) {
        .sms-page {
            padding: 1rem;
        }
        
        .page-header {
            padding: 2rem 1.5rem;
            border-radius: 16px;
        }
        
        .page-title {
            font-size: 1.75rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .thread-item {
            padding: 1.25rem 1.5rem;
        }
        
        .thread-avatar {
            width: 48px;
            height: 48px;
            font-size: 1rem;
        }
    }
</style>

<div class="sms-page">
    <!-- Modern Header -->
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">
                <div class="page-title-icon">
                    <i class="fas fa-comments"></i>
                </div>
                Parent Messages
            </h1>
            <p class="page-subtitle">Manage conversations with parents and respond to their inquiries</p>
        </div>
    </div>

    <!-- Stats Cards -->
    @php
        $totalThreads = $threads->count();
        $unreadCount = $threads->sum('unread_count');
        $recentThreads = $threads->filter(function($thread) {
            return $thread->last_message_at && $thread->last_message_at->isToday();
        })->count();
    @endphp
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div>
                    <div class="stat-label">Total Conversations</div>
                    <div class="stat-value">{{ $totalThreads }}</div>
                </div>
                <div class="stat-icon total">
                    <i class="fas fa-comments"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-header">
                <div>
                    <div class="stat-label">Unread Messages</div>
                    <div class="stat-value" style="color: #ef4444;">{{ $unreadCount }}</div>
                </div>
                <div class="stat-icon unread">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-header">
                <div>
                    <div class="stat-label">Today's Conversations</div>
                    <div class="stat-value" style="color: #059669;">{{ $recentThreads }}</div>
                </div>
                <div class="stat-icon recent">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages List -->
    <div class="messages-card">
        <div class="messages-card-header">
            <h2 class="messages-card-title">
                <div class="messages-card-title-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                All Conversations
            </h2>
            <a href="{{ route('school.messages.create') }}" class="btn-create-message">
                <i class="fas fa-plus"></i>
                New Message
            </a>
        </div>
        
        <div class="messages-card-body">
            @forelse($threads as $thread)
                <a href="{{ route('school.messages.show', $thread->id) }}" style="text-decoration: none; color: inherit; display: block;">
                    <div class="thread-item {{ $thread->unread_count > 0 ? 'unread' : '' }}">
                        <!-- Avatar -->
                        <div class="thread-avatar">
                            {{ strtoupper(substr($thread->parent->user->name, 0, 1)) }}
                        </div>
                        
                        <!-- Content -->
                        <div class="thread-content">
                            <div class="thread-header">
                                <div class="thread-parent-info">
                                    <div class="thread-parent-name">
                                        {{ $thread->parent->user->name }}
                                        @if($thread->unread_count > 0)
                                            <span class="unread-badge">{{ $thread->unread_count }}</span>
                                        @endif
                                    </div>
                                    <div class="thread-parent-email">
                                        <i class="fas fa-envelope" style="font-size: 0.75rem;"></i>
                                        {{ $thread->parent->user->email }}
                                    </div>
                                </div>
                                <div class="thread-time">
                                    @if($thread->last_message_at)
                                        @php
                                            $lastMessage = is_string($thread->last_message_at) ? \Carbon\Carbon::parse($thread->last_message_at) : $thread->last_message_at;
                                        @endphp
                                        @if($lastMessage->isToday())
                                            <i class="fas fa-clock" style="margin-right: 0.25rem;"></i>
                                            {{ $lastMessage->format('h:i A') }}
                                        @elseif($lastMessage->isYesterday())
                                            Yesterday
                                        @else
                                            {{ $lastMessage->format('M d, Y') }}
                                        @endif
                                    @else
                                        No messages
                                    @endif
                                </div>
                            </div>
                            
                            @if($thread->messages->count() > 0)
                                <div class="thread-last-message">
                                    <i class="fas fa-quote-left" style="font-size: 0.75rem; color: var(--sms-gray-400); margin-right: 0.5rem;"></i>
                                    {{ Str::limit($thread->messages->first()->message, 120) }}
                                </div>
                            @else
                                <div class="thread-last-message" style="color: var(--sms-gray-400); font-style: italic;">
                                    No messages yet
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="empty-state-title">No Conversations Yet</div>
                    <div class="empty-state-text">Start a conversation with a parent to begin messaging</div>
                    <a href="{{ route('school.messages.create') }}" class="btn-create-message">
                        <i class="fas fa-plus"></i>
                        Create New Message
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
