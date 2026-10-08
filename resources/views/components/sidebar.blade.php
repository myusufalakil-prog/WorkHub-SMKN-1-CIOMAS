@props([
    'current' => 'beranda',
    'role' => 'siswa', // 'siswa' | 'osis' | 'guru'
])

@php
    $studentNav = [
        ['id' => 'beranda', 'label' => 'Beranda Siswa', 'icon' => 'home', 'href' => route('siswa.dashboard')],
        ['id' => 'proyek', 'label' => 'Proyek Kolaborasi', 'icon' => 'folder-kanban', 'href' => route('siswa.proyek.index')],
        ['id' => 'match', 'label' => 'WORKHUB MATCH', 'icon' => 'cpu', 'href' => route('siswa.match')],
        ['id' => 'workspace', 'label' => 'Workspace Proyek', 'icon' => 'briefcase', 'href' => route('siswa.workspace')],
        ['id' => 'showcase', 'label' => 'Showcase Karya', 'icon' => 'sparkles', 'href' => route('siswa.showcase')],
    ];

    $osisNav = [
        ['id' => 'osis-dashboard', 'label' => 'Dashboard OSIS', 'icon' => 'home', 'href' => route('osis.dashboard')],
        ['id' => 'osis-events', 'label' => 'Event & Festival', 'icon' => 'sparkles', 'href' => route('osis.events')],
        ['id' => 'osis-proyek', 'label' => 'Monitoring Proyek', 'icon' => 'folder-kanban', 'href' => route('osis.proyek')],
        ['id' => 'osis-kurasi', 'label' => 'Kurasi Showcase', 'icon' => 'award', 'href' => route('osis.kurasi')],
        ['id' => 'osis-jurusan', 'label' => 'Aktivitas Jurusan', 'icon' => 'layers', 'href' => route('osis.jurusan')],
        ['id' => 'osis-broadcast', 'label' => 'Broadcast Info', 'icon' => 'bell', 'href' => route('osis.broadcast')],
    ];

    $navItems = match($role) {
        'osis' => $osisNav,
        default => $studentNav,
    };

    $roleBadgeText = match($role) {
        'osis' => 'PORTAL OSIS',
        default => 'PORTAL SISWA',
    };

    $auth = auth()->user();
    $currentUser = [
        'name' => $auth?->name ?? match($role) {
            'osis' => 'Pengurus OSIS',
            default => 'Siswa Kolaborator',
        },
        'sub' => $auth ? ($auth->kelas ?? ($auth->jabatan ?? ucfirst($auth->role))) : match($role) {
            'osis' => 'Divisi IT OSIS',
            default => 'Belum Login',
        },
        'initials' => strtoupper(substr($auth?->name ?? ($role === 'osis' ? 'OS' : 'SK'), 0, 2)),
    ];

    $profileId = $auth?->id ?? 1;
    $secondaryNav = match($role) {
        'osis' => [
            ['id' => 'notifikasi', 'label' => 'Notifikasi', 'icon' => 'bell', 'href' => route('siswa.notifikasi')],
            ['id' => 'profil', 'label' => 'Profil Pengurus', 'icon' => 'user', 'href' => route('siswa.profil', $profileId)],
        ],
        default => [
            ['id' => 'notifikasi', 'label' => 'Notifikasi', 'icon' => 'bell', 'href' => route('siswa.notifikasi')],
            ['id' => 'profil', 'label' => 'Profil Saya', 'icon' => 'user', 'href' => route('siswa.profil', $profileId)],
        ],
    };

    $roleBadgeClasses = match($role) {
        'osis' => 'bg-purple-100 text-purple-700 border-purple-200 dark:bg-purple-950/80 dark:text-purple-300 dark:border-purple-800/80',
        default => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-950/80 dark:text-blue-300 dark:border-blue-800/80',
    };
    $roleActiveNavClass = match($role) {
        'osis' => 'bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold shadow-md shadow-purple-600/25',
        default => 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold shadow-md shadow-blue-600/25',
    };
    $roleAvatarClass = match($role) {
        'osis' => 'bg-gradient-to-tr from-purple-600 to-pink-600 text-white shadow-md shadow-purple-600/20',
        default => 'bg-gradient-to-tr from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-600/20',
    };
@endphp

<!-- Modern Non-Black Sidebar (Soft Slate-50 in Light Mode, Midnight Slate in Dark Mode) -->
<aside class="hidden lg:flex flex-col w-64 bg-slate-50/90 dark:bg-[#0f172a] text-slate-700 dark:text-slate-300 border-r border-slate-200/90 dark:border-slate-800/80 select-none h-screen sticky top-0 shrink-0 z-30 justify-between backdrop-blur-md">
    <!-- Top: Logo & Main Navigation -->
    <div>
        <!-- Logo Header -->
        <div class="h-16 px-6 flex items-center justify-between border-b border-slate-200/80 dark:border-slate-800/80 bg-white/60 dark:bg-slate-900/40">
            <x-logo variant="full" theme="auto" size="md" :href="route('portal')" />
            
            <a 
                href="{{ route('portal') }}" 
                title="Keluar ke Portal Peran"
                class="text-[9px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded-full border transition-colors shadow-xs {{ $roleBadgeClasses }}"
            >
                {{ $roleBadgeText }}
            </a>
        </div>

        <!-- Role Portal Active Status Strip -->
        <div class="px-4 pt-3.5 pb-1">
            @if($auth?->role === 'admin')
                <div class="p-3 rounded-2xl bg-indigo-50/80 dark:bg-indigo-950/40 border border-indigo-200 dark:border-indigo-800/80 space-y-2.5 shadow-xs">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                            <span class="text-[10px] font-black text-indigo-900 dark:text-indigo-200 tracking-wider uppercase">SUPER ADMIN</span>
                        </div>
                        <a 
                            href="{{ route('portal') }}" 
                            title="Portal Switcher"
                            class="text-[9px] font-bold text-indigo-700 dark:text-indigo-300 hover:text-indigo-900 px-2 py-0.5 rounded-md bg-white dark:bg-indigo-900/60 hover:bg-indigo-100 transition-colors border border-indigo-200 dark:border-indigo-700"
                        >
                            Portal &rarr;
                        </a>
                    </div>
                    <!-- Quick Portal Switcher Buttons -->
                    <div class="grid grid-cols-2 gap-1.5 pt-1 border-t border-indigo-200/60 dark:border-indigo-800/50 text-[10px] text-center font-bold">
                        <a 
                            href="{{ route('siswa.dashboard') }}" 
                            title="Buka Portal Siswa"
                            class="py-1.5 rounded-lg transition-all {{ $role === 'siswa' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-extrabold shadow-sm' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-700 border border-slate-200/70 dark:border-slate-700' }}"
                        >
                            Siswa
                        </a>
                        <a 
                            href="{{ route('osis.dashboard') }}" 
                            title="Buka Portal OSIS"
                            class="py-1.5 rounded-lg transition-all {{ $role === 'osis' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white font-extrabold shadow-sm' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-purple-50 dark:hover:bg-slate-700 border border-slate-200/70 dark:border-slate-700' }}"
                        >
                            OSIS
                        </a>
                    </div>
                </div>
            @else
                <div class="flex items-center justify-between px-3 py-2 rounded-xl bg-white dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800 shadow-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[11px] font-bold text-slate-900 dark:text-white tracking-wide uppercase">{{ $roleBadgeText }}</span>
                    </div>
                    <a 
                        href="{{ route('portal') }}" 
                        title="Pilih / Ganti Portal Peran"
                        class="text-[10px] font-semibold text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 transition-colors border border-slate-200 dark:border-slate-700"
                    >
                        Ganti &rarr;
                    </a>
                </div>
            @endif
        </div>

        <!-- Navigation list -->
        <div class="px-3 py-4">
            <div class="px-3 mb-2 text-[10px] uppercase font-bold tracking-wider text-slate-400 dark:text-slate-500">
                Menu Khusus {{ ucfirst($role) }}
            </div>
            
            <nav class="space-y-1">
                @foreach($navItems as $item)
                    @php $isActive = $current === $item['id']; @endphp
                    <a 
                        href="{{ $item['href'] }}" 
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-200 {{ $isActive ? $roleActiveNavClass : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200/60 dark:hover:bg-slate-800/60' }}"
                    >
                        <x-icon :name="$item['icon']" class="w-4 h-4 {{ $isActive ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}" />
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="px-3 mt-6 mb-2 text-[10px] uppercase font-bold tracking-wider text-slate-400 dark:text-slate-500">
                Lainnya
            </div>

            <nav class="space-y-1">
                @foreach($secondaryNav as $item)
                    @php $isActive = $current === $item['id']; @endphp
                    <a 
                        href="{{ $item['href'] }}" 
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-200 {{ $isActive ? $roleActiveNavClass : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200/60 dark:hover:bg-slate-800/60' }}"
                    >
                        <x-icon :name="$item['icon']" class="w-4 h-4 {{ $isActive ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}" />
                        <span>{{ $item['label'] }}</span>

                        @if(isset($item['badge']))
                            <span class="ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                                {{ $item['badge'] }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </nav>
        </div>
    </div>

    <!-- Bottom: User Card & Logout -->
    <div class="p-3 border-t border-slate-200/80 dark:border-slate-800/80 space-y-2 bg-white/60 dark:bg-slate-900/40">

        <!-- Role User Profile Row -->
        <div class="flex items-center gap-3 p-2.5 rounded-xl bg-white dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/60 shadow-xs">
            <div class="w-9 h-9 rounded-xl {{ $roleAvatarClass }} flex items-center justify-center font-black text-xs shrink-0">
                {{ $currentUser['initials'] }}
            </div>
            <div class="flex flex-col min-w-0 flex-1">
                <span class="text-xs font-bold text-slate-900 dark:text-white truncate">
                    {{ $currentUser['name'] }}
                </span>
                <span class="text-[10px] text-slate-500 dark:text-slate-400 truncate">
                    {{ $currentUser['sub'] }}
                </span>
            </div>
        </div>

        @auth
            <!-- Tombol Keluar Akun -->
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button 
                    type="submit" 
                    class="w-full flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl text-xs font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors border border-rose-200/70 dark:border-rose-900/40 cursor-pointer"
                >
                    <x-icon name="arrow-right" class="w-3.5 h-3.5 rotate-180" />
                    <span>Keluar Akun (Logout)</span>
                </button>
            </form>
        @else
            <!-- Tombol Masuk / Login -->
            <a 
                href="{{ route('login') }}" 
                class="w-full flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-xs"
            >
                <span>Masuk ke Akun</span>
            </a>
        @endauth
    </div>
</aside>
