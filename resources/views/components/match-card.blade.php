@props([
    'name' => 'Raka',
    'classMajor' => 'XI PPLG',
    'score' => 94,
    'skills' => ['Frontend', 'UI/UX', 'Pengalaman project'],
    'avatar' => null,
    'href' => '#',
])

<div class="bg-white dark:bg-[#181818] border border-neutral-200/80 dark:border-[#2A2A2A] rounded-2xl p-5 shadow-xs flex flex-col justify-between hover:border-blue-400 dark:hover:border-blue-600 hover:shadow-lg transition-all duration-300 relative overflow-hidden group">
    <!-- Top accent indicator -->
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-indigo-600"></div>

    <div>
        <!-- Student header + match score badge -->
        <div class="flex items-start justify-between gap-3 mb-3.5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm shadow-blue-500/20 group-hover:scale-105 transition-transform">
                    @if($avatar)
                        <img src="{{ $avatar }}" alt="{{ $name }}" class="w-full h-full object-cover rounded-xl">
                    @else
                        {{ strtoupper(substr($name, 0, 2)) }}
                    @endif
                </div>
                <div>
                    <h4 class="font-bold text-base text-neutral-900 dark:text-white leading-snug group-hover:text-blue-600 transition-colors">
                        {{ $name }}
                    </h4>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400 font-medium">
                        {{ $classMajor }}
                    </span>
                </div>
            </div>

            <!-- Match Score Badge -->
            <div class="text-right">
                <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-xs">
                    <x-icon name="cpu" class="w-3 h-3 text-emerald-100" />
                    {{ $score }}% Cocok
                </span>
            </div>
        </div>

        <!-- Checklist of verified criteria -->
        <div class="space-y-1.5 py-3 border-y border-neutral-100 dark:border-[#262626] my-2">
            @foreach($skills as $skill)
                <div class="flex items-center gap-2 text-xs text-neutral-700 dark:text-neutral-300">
                    <x-icon name="check" class="w-3.5 h-3.5 text-emerald-500 shrink-0 stroke-[3]" />
                    <span>{{ $skill }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Action Button -->
    <div class="mt-4">
        <a 
            href="{{ $href }}" 
            class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl text-xs font-bold border border-blue-600/70 text-blue-700 bg-blue-50/50 hover:bg-blue-600 hover:text-white transition-all cursor-pointer"
        >
            Lihat Profil
            <x-icon name="arrow-right" class="w-3 h-3" />
        </a>
    </div>
</div>
