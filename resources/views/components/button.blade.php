@props([
    'variant' => 'primary', // 'primary' | 'secondary' | 'outline' | 'ghost' | 'danger' | 'inverted'
    'size' => 'md',        // 'sm' | 'md' | 'lg'
    'type' => 'button',
    'href' => null,
    'icon' => null,
    'iconRight' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-150 rounded-lg select-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none active:scale-[0.98]';

    $sizeClasses = [
        'sm' => 'text-xs px-3 py-1.5 gap-1.5',
        'md' => 'text-sm px-4 py-2 gap-2',
        'lg' => 'text-base px-5 py-2.5 gap-2.5',
    ][$size] ?? 'text-sm px-4 py-2 gap-2';

    $variantClasses = [
        // Primary: Modern vibrant Blue-Indigo gradient with hover depth
        'primary' => 'bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white border border-transparent shadow-md hover:shadow-blue-500/25 focus:ring-blue-500 dark:from-blue-500 dark:to-indigo-600 dark:hover:from-blue-600 dark:hover:to-indigo-700',
        
        // Brand: 3-stop gradient for high-priority CTAs
        'brand' => 'bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:opacity-95 text-white border border-transparent shadow-md hover:shadow-indigo-500/25 focus:ring-indigo-500',

        // Inverted: Explicitly white on dark or colored sections
        'inverted' => 'bg-white hover:bg-neutral-100 text-neutral-900 border border-transparent shadow-md focus:ring-white font-bold',
        
        // Secondary: Bordered, subtle neutral bg
        'secondary' => 'bg-white hover:bg-neutral-50 text-neutral-800 border border-neutral-300/80 shadow-xs focus:ring-neutral-400 dark:bg-[#1A1A1A] dark:text-neutral-100 dark:border-[#2C2C2C] dark:hover:bg-[#222222]',
        
        // Outline: Transparent with clean border
        'outline' => 'bg-transparent hover:bg-neutral-100/80 text-neutral-800 border border-neutral-300 dark:text-neutral-200 dark:border-[#2E2E2E] dark:hover:bg-[#1C1C1C]',
        
        // Ghost: No border
        'ghost' => 'bg-transparent hover:bg-neutral-100/80 text-neutral-700 hover:text-black dark:text-neutral-400 dark:hover:text-white dark:hover:bg-[#1A1A1A]',
        
        // Danger: Semantic red
        'danger' => 'bg-rose-600 hover:bg-rose-700 text-white border border-transparent shadow-sm focus:ring-rose-500',

        // Success: Emerald
        'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white border border-transparent shadow-sm focus:ring-emerald-500',
    ][$variant] ?? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$baseClasses $sizeClasses $variantClasses"]) }}>
        @if($icon) <x-icon :name="$icon" class="{{ $size === 'sm' ? 'w-3.5 h-3.5' : 'w-4 h-4' }}" /> @endif
        <span>{{ $slot }}</span>
        @if($iconRight) <x-icon :name="$iconRight" class="{{ $size === 'sm' ? 'w-3.5 h-3.5' : 'w-4 h-4' }}" /> @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "$baseClasses $sizeClasses $variantClasses"]) }}>
        @if($icon) <x-icon :name="$icon" class="{{ $size === 'sm' ? 'w-3.5 h-3.5' : 'w-4 h-4' }}" /> @endif
        <span>{{ $slot }}</span>
        @if($iconRight) <x-icon :name="$iconRight" class="{{ $size === 'sm' ? 'w-3.5 h-3.5' : 'w-4 h-4' }}" /> @endif
    </button>
@endif
