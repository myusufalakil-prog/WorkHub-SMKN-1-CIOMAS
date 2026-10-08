@props([
    'title' => null,
])

<header class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-4 md:px-8 flex items-center justify-between sticky top-0 z-20 transition-colors">
    <!-- Left: Mobile logo or Page Title -->
    <div class="flex items-center gap-4">
        <!-- Logo visible on mobile & tablet -->
        <div class="lg:hidden flex items-center gap-2">
            <x-logo variant="full" size="sm" :href="route('home')" />
        </div>

        @if($title)
            <div class="hidden lg:block">
                <h1 class="text-base font-bold text-slate-900 dark:text-white tracking-tight">
                    {{ $title }}
                </h1>
            </div>
        @endif
    </div>

    <!-- Center: Search input -->
    <div class="flex-1 max-w-md mx-4">
        <form action="{{ route('projects.index') }}" method="GET" class="relative">
            <x-icon name="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" />
            <input 
                type="text" 
                name="q"
                placeholder="Cari proyek, jurusan (PPLG, Animasi...), atau skill..." 
                class="w-full pl-9 pr-4 py-1.5 text-xs md:text-sm bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 border border-transparent focus:border-blue-500 rounded-xl focus:outline-none focus:bg-white dark:focus:bg-slate-900 transition-all"
            />
        </form>
    </div>

    <!-- Right: Notifications, Quick Actions, Profile -->
    <div class="flex items-center gap-2 md:gap-3">
        <!-- Quick Create Action (Desktop) -->
        @auth
            @if(auth()->user()->role === 'osis')
                <x-button :href="route('osis.events')" variant="primary" size="sm" icon="plus" class="hidden sm:inline-flex">
                    Event
                </x-button>
            @else
                <x-button :href="route('projects.create')" variant="primary" size="sm" icon="plus" class="hidden sm:inline-flex">
                    Proyek
                </x-button>
            @endif
        @endauth


        <!-- Notification Icon with Badge -->
        <a 
            href="{{ route('siswa.notifikasi') }}" 
            class="relative p-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
            title="Notifikasi"
        >
            <x-icon name="bell" class="w-4 h-4" />
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white dark:ring-slate-900 animate-pulse"></span>
        </a>

        <!-- Profile Avatar Link -->
        @auth
            <a 
                href="{{ route('siswa.profil', auth()->id()) }}" 
                class="flex items-center gap-2 pl-2 border-l border-neutral-200 dark:border-[#222222] group"
            >
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/20 group-hover:scale-105 transition-transform">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                </div>
                <div class="hidden xl:flex flex-col text-left leading-none">
                    <span class="text-xs font-bold text-neutral-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        {{ auth()->user()->name }}
                    </span>
                    <span class="text-[10px] text-neutral-400 mt-0.5">
                        {{ auth()->user()->kelas ?? ucfirst(auth()->user()->role) }}
                    </span>
                </div>
            </a>
        @else
            <div class="flex items-center gap-2 pl-2 border-l border-neutral-200 dark:border-[#222222]">
                <a href="{{ route('login') }}" class="text-xs font-semibold text-neutral-700 dark:text-neutral-200 hover:text-black dark:hover:text-white px-2.5 py-1.5 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-xl transition-all shadow-xs">
                    Daftar
                </a>
            </div>
        @endauth
    </div>
</header>
