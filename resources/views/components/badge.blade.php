@props([
    'variant' => 'neutral', // 'neutral' | 'dark' | 'outline' | 'jurusan' | 'success' | 'warning' | 'error' | 'match'
    'size' => 'sm',        // 'xs' | 'sm' | 'md'
    'dot' => false,
])

@php
    $baseClasses = 'inline-flex items-center font-medium rounded-full tracking-normal border';

    $sizeClasses = [
        'xs' => 'text-[11px] px-2 py-0.5 gap-1',
        'sm' => 'text-xs px-2.5 py-1 gap-1.5',
        'md' => 'text-sm px-3 py-1.5 gap-2',
    ][$size] ?? 'text-xs px-2.5 py-1 gap-1.5';

    $variantClasses = [
        'neutral' => 'bg-neutral-100 text-neutral-700 border-neutral-200 dark:bg-[#1f1f1f] dark:text-neutral-300 dark:border-[#2f2f2f]',
        'dark' => 'bg-neutral-900 text-white border-neutral-800 dark:bg-white dark:text-neutral-900 dark:border-white',
        'outline' => 'bg-transparent text-neutral-700 border-neutral-300 dark:text-neutral-300 dark:border-[#333333]',
        'jurusan' => 'bg-blue-50 text-blue-700 font-bold border-blue-200 dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800/80',
        'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800/60',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/40 dark:text-amber-400 dark:border-amber-800/60',
        'error' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/40 dark:text-rose-400 dark:border-rose-800/60',
        'match' => 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold border-transparent shadow-xs',
    ][$variant] ?? 'bg-neutral-100 text-neutral-700 border-neutral-200';

    $dotColors = [
        'success' => 'bg-[#16A34A]',
        'warning' => 'bg-[#F59E0B]',
        'error' => 'bg-[#DC2626]',
        'neutral' => 'bg-neutral-400',
        'match' => 'bg-white dark:bg-black',
    ][$variant] ?? 'bg-neutral-400';
@endphp

<span {{ $attributes->merge(['class' => "$baseClasses $sizeClasses $variantClasses"]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColors }} shrink-0"></span>
    @endif
    {{ $slot }}
</span>
