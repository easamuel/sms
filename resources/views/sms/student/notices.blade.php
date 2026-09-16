@extends('layouts.app')

@section('title', 'Notices - School Management System')

@section('content')
@include('sms.partials.design-system')
<style>
    .sms-page {
        background: var(--sms-gray-50);
        min-height: calc(100vh - 80px);
    }
    .sms-page-header {
        background: white;
        padding: 2rem;
        border-bottom: 1px solid var(--sms-gray-200);
        margin-bottom: 2rem;
    }
    .sms-page-title {
        font-size: 1.875rem;
        font-weight: 800;
        color: var(--sms-gray-900);
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }
    .sms-page-subtitle {
        color: var(--sms-gray-600);
        font-size: 1rem;
    }
    .sms-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--sms-gray-200);
        overflow: hidden;
    }
    .sms-card-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--sms-gray-200);
        background: var(--sms-gray-50);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .sms-card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
    }
    .sms-card-body {
        padding: 1.5rem;
    }
    .sms-notice-card {
        padding: 1.5rem;
        background: var(--sms-gray-50);
        border-radius: 12px;
        border-left: 4px solid var(--sms-primary);
        margin-bottom: 1rem;
        transition: all 0.2s;
    }
    .sms-notice-card:hover {
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    .sms-notice-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
        flex-wrap: wrap;
    }
    .sms-notice-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--sms-gray-900);
        margin: 0;
    }
    .sms-notice-date {
        font-size: 0.875rem;
        color: var(--sms-gray-500);
        white-space: nowrap;
    }
    .sms-notice-content {
        font-size: 0.9375rem;
        color: var(--sms-gray-600);
        margin-bottom: 0.75rem;
        line-height: 1.6;
    }
    .sms-notice-expiry {
        font-size: 0.8125rem;
        color: #f97316;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .sms-empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--sms-gray-500);
    }
    .sms-empty-state-icon {
        font-size: 3rem;
        color: var(--sms-gray-300);
        margin-bottom: 1rem;
    }
    .sms-empty-state-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--sms-gray-700);
        margin-bottom: 0.5rem;
    }
    .sms-empty-state-text {
        font-size: 0.9375rem;
        color: var(--sms-gray-500);
    }
    @media (max-width: 768px) {
        .sms-page-header {
            padding: 1.5rem;
        }
        .sms-page-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="sms-page">
    <div class="sms-page-header">
        <h1 class="sms-page-title">School Notices</h1>
        <p class="sms-page-subtitle">Announcements and important information from your school.</p>
    </div>

    <div style="max-width: 1400px; margin: 0 auto; padding: 0 2rem 2rem;">
        <div class="sms-card">
            <div class="sms-card-header">
                <h2 class="sms-card-title">Latest Notices</h2>
                <div style="font-size: 0.875rem; color: var(--sms-gray-600);">
                    {{ $notices->total() }} notice{{ $notices->total() === 1 ? '' : 's' }} found
                </div>
            </div>
            <div class="sms-card-body">
                @if($notices->count())
                    <div>
                        @foreach($notices as $notice)
                        <article class="sms-notice-card">
                            <header class="sms-notice-header">
                                <h3 class="sms-notice-title">{{ $notice->title }}</h3>
                                <time class="sms-notice-date" datetime="{{ $notice->published_at }}">
                                    @php
                                        $publishedAt = is_string($notice->published_at) ? \Carbon\Carbon::parse($notice->published_at) : ($notice->published_at ?? null);
                                    @endphp
                                    {{ $publishedAt ? $publishedAt->format('M d, Y') : 'Not published' }}
                                </time>
                            </header>
                            <p class="sms-notice-content">
                                {{ \Illuminate\Support\Str::limit($notice->content, 220) }}
                            </p>
                            @if($notice->expires_at)
                                @php
                                    $expiresAt = is_string($notice->expires_at) ? \Carbon\Carbon::parse($notice->expires_at) : $notice->expires_at;
                                @endphp
                                <div class="sms-notice-expiry">
                                    <i class="fas fa-clock"></i>
                                    <span>Expires {{ $expiresAt->format('M d, Y') }}</span>
                                </div>
                            @endif
                        </article>
                        @endforeach
                    </div>

                    <div style="margin-top: 1.5rem;">
                        {{ $notices->links() }}
                    </div>
                @else
                    <div class="sms-empty-state">
                        <div class="sms-empty-state-icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div class="sms-empty-state-title">No Notices Available</div>
                        <div class="sms-empty-state-text">There are no notices for you at the moment.</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
