@props([
    'type' => 'card', // 'card' | 'project' | 'list' | 'profile'
    'count' => 1,
])

<div class="space-y-4">
    @for($i = 0; $i < $count; $i++)
        @if($type === 'project')
            <div class="bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] rounded-xl p-5 md:p-6 animate-pulse space-y-4">
                <div class="flex justify-between items-center">
                    <div class="h-4 w-28 bg-neutral-200 dark:bg-neutral-800 rounded-full"></div>
                    <div class="h-4 w-16 bg-neutral-200 dark:bg-neutral-800 rounded-full"></div>
                </div>
                <div class="h-6 w-3/4 bg-neutral-200 dark:bg-neutral-800 rounded-md"></div>
                <div class="space-y-2">
                    <div class="h-3 w-full bg-neutral-100 dark:bg-neutral-800/60 rounded"></div>
                    <div class="h-3 w-4/5 bg-neutral-100 dark:bg-neutral-800/60 rounded"></div>
                </div>
                <div class="flex gap-2 pt-2">
                    <div class="h-5 w-12 bg-neutral-200 dark:bg-neutral-800 rounded"></div>
                    <div class="h-5 w-14 bg-neutral-200 dark:bg-neutral-800 rounded"></div>
                </div>
                <div class="pt-4 border-t border-neutral-100 dark:border-neutral-800/80 grid grid-cols-2 gap-2">
                    <div class="h-8 bg-neutral-100 dark:bg-neutral-800 rounded"></div>
                    <div class="h-8 bg-neutral-100 dark:bg-neutral-800 rounded"></div>
                </div>
                <div class="h-8 w-full bg-neutral-200 dark:bg-neutral-800 rounded-lg"></div>
            </div>
        @elseif($type === 'list')
            <div class="bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] rounded-xl p-4 animate-pulse flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-neutral-200 dark:bg-neutral-800"></div>
                    <div class="space-y-1.5">
                        <div class="h-4 w-32 bg-neutral-200 dark:bg-neutral-800 rounded"></div>
                        <div class="h-3 w-20 bg-neutral-100 dark:bg-neutral-800/60 rounded"></div>
                    </div>
                </div>
                <div class="h-7 w-20 bg-neutral-200 dark:bg-neutral-800 rounded-lg"></div>
            </div>
        @else
            <div class="bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] rounded-xl p-5 animate-pulse space-y-3">
                <div class="h-5 w-1/3 bg-neutral-200 dark:bg-neutral-800 rounded"></div>
                <div class="h-4 w-2/3 bg-neutral-100 dark:bg-neutral-800/60 rounded"></div>
                <div class="h-10 bg-neutral-100 dark:bg-neutral-800 rounded"></div>
            </div>
        @endif
    @endfor
</div>
