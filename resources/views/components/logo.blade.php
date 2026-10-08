@props([
    'variant' => 'full', // 'full' | 'compact'
    'theme' => 'auto',   // 'light' | 'dark' | 'auto'
    'size' => 'md',      // 'sm' | 'md' | 'lg'
    'href' => null,
])

@php
    $sizeClasses = [
        'sm' => ['icon' => 'w-6 h-6', 'text' => 'text-base', 'sub' => 'text-[9px]'],
        'md' => ['icon' => 'w-8 h-8', 'text' => 'text-lg', 'sub' => 'text-[10px]'],
        'lg' => ['icon' => 'w-10 h-10', 'text' => 'text-2xl', 'sub' => 'text-xs'],
    ][$size] ?? ['icon' => 'w-8 h-8', 'text' => 'text-lg', 'sub' => 'text-[10px]'];

    // Theme color logic: Signature vibrant Blue-Indigo gradient icon
    $iconBg = 'bg-gradient-to-tr from-blue-600 to-indigo-600 text-white shadow-sm shadow-blue-500/20';
    $iconStroke = '#FFFFFF';

    $textColor = match($theme) {
        'dark' => 'text-white',
        'light' => 'text-neutral-900',
        default => 'text-neutral-900 dark:text-white'
    };
@endphp

<{{ $href ? 'a' : 'div' }} 
    @if($href) href="{{ $href }}" @endif
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5 font-bold tracking-tight select-none group']) }}
>
    <!-- Abstract WORKHUB Isometric Collaboration Hub Symbol -->
    <div class="{{ $sizeClasses['icon'] }} {{ $iconBg }} rounded-lg p-1.5 flex items-center justify-center transition-transform group-hover:scale-105 duration-200 shrink-0 shadow-sm">
        <svg viewBox="0 0 32 32" fill="none" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 5L25 10.2V20.8L16 26L7 20.8V10.2L16 5Z" stroke="{{ $iconStroke }}" stroke-width="2.5" stroke-linejoin="round"/>
            <path d="M16 5V15.5M25 20.8L16 15.5M7 20.8L16 15.5" stroke="{{ $iconStroke }}" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round"/>
            <circle cx="16" cy="15.5" r="2.8" fill="{{ $iconStroke }}"/>
        </svg>
    </div>

    @if($variant === 'full')
        <div class="flex flex-col leading-none">
            <span class="font-extrabold {{ $sizeClasses['text'] }} tracking-tight {{ $textColor }} font-sans">
                WORK<span class="font-semibold opacity-90">HUB</span>
            </span>
            <span class="text-[9px] tracking-widest uppercase font-bold text-neutral-500 dark:text-neutral-400 mt-0.5">
                SMKN 1 CIOMAS
            </span>
        </div>
    @endif
</{{ $href ? 'a' : 'div' }}>
