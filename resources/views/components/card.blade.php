@props([
    'padding' => 'p-5 md:p-6',
    'hover' => false,
])

<div {{ $attributes->merge([
    'class' => 'bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] rounded-xl shadow-xs transition-all duration-200 ' 
    . ($hover ? 'hover:border-neutral-400 dark:hover:border-neutral-600 hover:shadow-sm ' : '') 
    . $padding
]) }}>
    {{ $slot }}
</div>
