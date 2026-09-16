{{-- ES-SCHOOLS Logo Component --}}
@php
    $variant = $variant ?? 'full'; // 'icon', 'wordmark', 'full'
    $size = $size ?? 'default'; // 'sm', 'default', 'lg'
    $color = $color ?? 'default'; // 'default', 'light', 'dark'
    
    $sizes = [
        'sm' => ['icon' => 'w-8 h-8', 'text' => 'text-xl'],
        'default' => ['icon' => 'w-10 h-10', 'text' => 'text-2xl'],
        'lg' => ['icon' => 'w-16 h-16', 'text' => 'text-4xl']
    ];
    
    $currentSize = $sizes[$size] ?? $sizes['default'];
@endphp

<div class="logo-container inline-flex items-center gap-3" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    @if(in_array($variant, ['icon', 'full']))
    <div class="logo-icon {{ $currentSize['icon'] }}" style="flex-shrink: 0;">
        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
            <!-- Background Circle -->
            <circle cx="32" cy="32" r="30" fill="url(#logoGradient)"/>
            <!-- Graduation Cap -->
            <path d="M32 18L20 24L32 30L44 24L32 18Z" fill="white" opacity="0.95"/>
            <path d="M20 24V36C20 36 24 40 32 40C40 40 44 36 44 36V24" stroke="white" stroke-width="2" fill="none"/>
            <!-- Book -->
            <rect x="24" y="38" width="16" height="12" rx="2" fill="white" opacity="0.9"/>
            <line x1="28" y1="42" x2="36" y2="42" stroke="#10b981" stroke-width="1.5"/>
            <line x1="28" y1="45" x2="36" y2="45" stroke="#10b981" stroke-width="1.5"/>
            <!-- Gradient Definition -->
            <defs>
                <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:#1e3a8a;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#10b981;stop-opacity:1" />
                </linearGradient>
            </defs>
        </svg>
    </div>
    @endif
    
    @if(in_array($variant, ['wordmark', 'full']))
    <span class="logo-text {{ $currentSize['text'] }} font-bold" style="color: #1e3a8a; letter-spacing: -0.02em;">
        ES-SCHOOLS
    </span>
    @endif
</div>
