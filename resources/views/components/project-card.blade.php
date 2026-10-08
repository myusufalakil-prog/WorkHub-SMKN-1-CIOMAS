@props([
    'title',
    'jurusan' => '',       // e.g. 'PPLG × Animasi × BCF'
    'description',
    'tags' => [],          // e.g. ['Web', 'UI/UX', 'Video']
    'members' => '6 / 8',
    'deadline' => '12 Nov 2026',
    'progress' => 80,
    'href' => '#',
    'status' => 'Sedang Berjalan', // 'Open Recruitment' | 'Sedang Berjalan' | 'Selesai'
])

@php
    $progressColor = match(true) {
        $progress >= 100 => 'from-emerald-500 to-teal-500',
        $progress >= 60 => 'from-blue-600 via-indigo-500 to-purple-600',
        $progress >= 30 => 'from-amber-500 to-orange-500',
        default => 'from-neutral-500 to-neutral-400',
    };
@endphp

<div class="bg-white dark:bg-[#161616] border border-neutral-200/80 dark:border-[#262626] rounded-2xl p-5 md:p-6 shadow-xs flex flex-col justify-between hover:border-neutral-400 dark:hover:border-neutral-600 hover:shadow-lg transition-all duration-300 group relative overflow-hidden">
    <!-- Top section: Jurusan & Status -->
    <div>
        <div class="flex items-center justify-between gap-2 mb-3">
            @if($jurusan)
                <span class="text-[11px] font-bold tracking-wide text-neutral-800 dark:text-neutral-200 bg-neutral-100 dark:bg-[#202020] px-2.5 py-1 rounded-lg border border-neutral-200 dark:border-neutral-700/80 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                    {{ $jurusan }}
                </span>
            @endif

            @if($status === 'Open Recruitment')
                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Recruiting
                </span>
            @elseif($status === 'Selesai')
                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-full bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-700">
                    <x-icon name="check" class="w-3 h-3 text-emerald-500 stroke-[3]" />
                    Selesai
                </span>
            @else
                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                    Aktif
                </span>
            @endif
        </div>

        <!-- Project Title -->
        <h3 class="text-base sm:text-lg font-bold text-neutral-950 dark:text-white tracking-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
            <a href="{{ $href }}" class="focus:outline-none">
                {{ $title }}
            </a>
        </h3>

        <!-- Description -->
        <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400 mt-2 line-clamp-2 leading-relaxed">
            {{ $description }}
        </p>

        <!-- Category / Skill Tags -->
        @if(!empty($tags))
            <div class="flex flex-wrap gap-1.5 mt-3.5">
                @foreach($tags as $tag)
                    <span class="text-[10px] font-semibold text-neutral-600 dark:text-neutral-400 bg-neutral-100/80 dark:bg-[#1E1E1E] border border-neutral-200/80 dark:border-neutral-800 px-2 py-0.5 rounded-md">
                        {{ $tag }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Bottom section: Meta & Progress -->
    <div class="mt-5 pt-4 border-t border-neutral-100 dark:border-[#222222]">
        <div class="grid grid-cols-2 gap-2 text-xs text-neutral-500 dark:text-neutral-400 mb-3">
            <div>
                <span class="block text-[10px] uppercase font-bold text-neutral-400 dark:text-neutral-500 tracking-wider">Anggota Tim</span>
                <span class="font-semibold text-neutral-800 dark:text-neutral-200 mt-0.5 flex items-center gap-1">
                    <x-icon name="users" class="w-3.5 h-3.5 text-neutral-400" />
                    {{ $members }} Anggota
                </span>
            </div>
            <div>
                <span class="block text-[10px] uppercase font-bold text-neutral-400 dark:text-neutral-500 tracking-wider">Tenggat Waktu</span>
                <span class="font-semibold text-neutral-800 dark:text-neutral-200 mt-0.5 flex items-center gap-1">
                    <x-icon name="calendar" class="w-3.5 h-3.5 text-neutral-400" />
                    {{ $deadline }}
                </span>
            </div>
        </div>

        <!-- Progress bar -->
        <div class="space-y-1.5 mb-4">
            <div class="flex justify-between text-xs font-semibold">
                <span class="text-neutral-500 dark:text-neutral-400">Penyelesaian PBL</span>
                <span class="text-neutral-900 dark:text-white">{{ $progress }}%</span>
            </div>
            <div class="w-full h-2 bg-neutral-100 dark:bg-[#202020] rounded-full overflow-hidden p-0.5 border border-neutral-200/60 dark:border-neutral-800">
                <div 
                    class="h-full bg-gradient-to-r {{ $progressColor }} rounded-full transition-all duration-500" 
                    style="width: {{ $progress }}%"
                ></div>
            </div>
        </div>

        <!-- Action Button -->
        <a 
            href="{{ $href }}" 
            class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl text-xs font-bold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-sm hover:shadow-md cursor-pointer"
        >
            <span>Lihat Workspace Proyek</span>
            <x-icon name="arrow-right" class="w-3.5 h-3.5" />
        </a>
    </div>
</div>
