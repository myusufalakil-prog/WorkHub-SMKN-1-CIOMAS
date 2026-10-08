@props([
    'title' => 'Terjadi masalah',
    'description' => 'Data belum dapat dimuat. Silakan coba lagi.',
    'retryHref' => 'javascript:window.location.reload()',
])

<div class="border border-neutral-200 dark:border-[#2A2A2A] rounded-xl p-8 md:p-12 text-center flex flex-col items-center justify-center bg-white dark:bg-[#181818] my-4 shadow-xs">
    <div class="w-12 h-12 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900/60 flex items-center justify-center text-rose-600 dark:text-rose-400 mb-4">
        <x-icon name="x" class="w-6 h-6 stroke-[2.2]" />
    </div>

    <h3 class="text-base font-bold text-neutral-900 dark:text-white tracking-tight">
        {{ $title }}
    </h3>

    <p class="text-sm text-neutral-500 dark:text-neutral-400 max-w-sm mt-1 mb-5 leading-relaxed">
        {{ $description }}
    </p>

    <x-button :href="$retryHref" variant="secondary" size="sm">
        Coba Lagi
    </x-button>
</div>
