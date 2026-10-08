@props([
    'title' => 'Belum ada data',
    'description' => 'Mulai kolaborasi dengan membuat project pertama kamu.',
    'actionText' => null,
    'actionHref' => null,
    'icon' => 'folder-kanban',
])

<div class="border border-dashed border-neutral-300 dark:border-neutral-800 rounded-xl p-8 md:p-12 text-center flex flex-col items-center justify-center bg-white/50 dark:bg-[#151515]/50 my-4">
    <div class="w-12 h-12 rounded-xl bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 flex items-center justify-center text-neutral-600 dark:text-neutral-300 mb-4">
        <x-icon :name="$icon" class="w-6 h-6 stroke-[1.8]" />
    </div>

    <h3 class="text-base font-bold text-neutral-900 dark:text-white tracking-tight">
        {{ $title }}
    </h3>

    <p class="text-sm text-neutral-500 dark:text-neutral-400 max-w-sm mt-1 mb-5 leading-relaxed">
        {{ $description }}
    </p>

    @if($actionText && $actionHref)
        <x-button :href="$actionHref" variant="primary" size="sm" icon="plus">
            {{ $actionText }}
        </x-button>
    @endif
</div>
