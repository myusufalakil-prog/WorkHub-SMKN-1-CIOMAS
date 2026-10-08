<x-app-layout current="osis-dashboard" role="osis" pageTitle="Dashboard Pengurus OSIS">
    <!-- Vibrant OSIS Welcome Hero Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-700 via-fuchsia-600 to-indigo-700 p-6 md:p-8 text-white shadow-xl shadow-purple-500/10 mb-6 border border-white/10">
        <div class="absolute -right-8 -top-8 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/4 -bottom-10 w-48 h-48 bg-pink-400/20 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md text-xs font-bold text-white mb-3 border border-white/20 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span>Pengurus OSIS &bull; SMKN 1 Ciomas</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight flex items-center gap-2">
                    <x-icon name="landmark" class="w-7 h-7 text-white shrink-0" />
                    <span>Dashboard OSIS & Event Sekolah</span>
                </h1>
                <p class="text-xs md:text-sm text-purple-100 mt-2 max-w-xl leading-relaxed">
                    Selamat bertugas, <strong class="text-white">{{ auth()->user()->name ?? 'Pengurus OSIS' }}</strong>. Kelola agenda festival tahunan dan kurasi karya siswa lintas 5 kejuruan untuk pameran publik.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <a 
                    href="{{ route('osis.events') }}" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-purple-900 font-extrabold text-xs shadow-lg hover:bg-purple-50 transition-all hover:scale-105 active:scale-95 cursor-pointer"
                >
                    <x-icon name="calendar" class="w-4 h-4 text-purple-600" />
                    <span>Agenda Event Festival</span>
                </a>
            </div>
        </div>
    </div>

    <!-- OSIS Metrik Grid with Themed Color Accents -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 my-6">
        <div class="bg-white dark:bg-[#161616] border border-neutral-200/80 dark:border-[#262626] rounded-2xl p-4 md:p-5 shadow-xs hover:border-purple-500/50 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Total Proyek Sekolah</span>
                <div class="w-7 h-7 rounded-lg bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                    <x-icon name="folder-kanban" class="w-4 h-4" />
                </div>
            </div>
            <div class="flex items-baseline justify-between mt-3">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">{{ $totalProjects }}</span>
                <span class="text-xs font-semibold text-purple-600 dark:text-purple-400 flex items-center gap-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse"></span> Aktif
                </span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#161616] border border-neutral-200/80 dark:border-[#262626] rounded-2xl p-4 md:p-5 shadow-xs hover:border-blue-500/50 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Siswa Berkolaborasi</span>
                <div class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                    <x-icon name="users" class="w-4 h-4" />
                </div>
            </div>
            <div class="flex items-baseline justify-between mt-3">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">{{ $totalStudents }}</span>
                <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">Lintas 5 Jurusan</span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#161616] border border-neutral-200/80 dark:border-[#262626] rounded-2xl p-4 md:p-5 shadow-xs hover:border-amber-500/50 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Antrean Showcase</span>
                <div class="w-7 h-7 rounded-lg bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    <x-icon name="clock" class="w-4 h-4" />
                </div>
            </div>
            <div class="flex items-baseline justify-between mt-3">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">{{ $pendingShowcaseProjects->count() }}</span>
                <span class="text-xs font-semibold text-amber-600 dark:text-amber-400 flex items-center gap-0.5">
                    Butuh Review
                </span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#161616] border border-neutral-200/80 dark:border-[#262626] rounded-2xl p-4 md:p-5 shadow-xs hover:border-rose-500/50 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Festival Sekolah</span>
                <div class="w-7 h-7 rounded-lg bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center">
                    <x-icon name="sparkles" class="w-4 h-4" />
                </div>
            </div>
            <div class="flex items-baseline justify-between mt-3">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">H-42</span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 dark:bg-rose-950/80 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                    Nov 2026
                </span>
            </div>
        </div>
    </div>

    <!-- Section 1: Antrean Kurasi Showcase Publik -->
    <section class="my-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white tracking-tight flex items-center gap-2">
                    <x-icon name="award" class="w-5 h-5 text-neutral-700 dark:text-neutral-300" />
                    Kurasi Proyek untuk Showcase Festival
                </h2>
                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                    Proyek siswa yang diajukan masuk ke galeri resmi festival sekolah dan disetujui untuk dipamerkan.
                </p>
            </div>
            <x-button :href="route('osis.kurasi')" variant="secondary" size="sm">
                Buka Meja Kurasi
            </x-button>
        </div>

        <x-card padding="p-0 overflow-hidden">
            <div class="divide-y divide-neutral-200 dark:divide-[#262626]">
                @forelse($pendingShowcaseProjects as $p)
                    <div class="p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 border border-neutral-200 dark:border-neutral-700">
                                    {{ $p->jurusan_label }}
                                </span>
                                <span class="text-xs text-neutral-400">Lead: <strong>{{ $p->lead->name ?? 'Siswa' }}</strong> ({{ $p->lead->kelas ?? 'Lintas Jurusan' }})</span>
                            </div>
                            <h3 class="text-base font-bold text-neutral-900 dark:text-white">
                                {{ $p->title }}
                            </h3>
                            <p class="text-xs text-neutral-600 dark:text-neutral-400 max-w-2xl line-clamp-1">
                                {{ $p->description }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <x-button :href="route('siswa.workspace', $p->id)" variant="secondary" size="sm">
                                Review Hasil Karya
                            </x-button>
                            <form action="{{ route('osis.kurasi.approve', $p->id) }}" method="POST" class="inline">
                                @csrf
                                <x-button type="submit" variant="primary" size="sm" icon="check">
                                    Setujui Showcase
                                </x-button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-sm text-neutral-500">
                        Tidak ada antrean kurasi proyek saat ini.
                    </div>
                @endforelse
            </div>
        </x-card>
    </section>

    <!-- Section 2: Monitoring Aktivitas Kolaborasi per Jurusan -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 my-8">
        <!-- 2 cols: Monitoring Semua Proyek Aktif -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-white tracking-tight">
                        Daftar Proyek Kolaborasi Siswa
                    </h2>
                    <p class="text-xs text-neutral-500">
                        Pantau progres pengerjaan setiap tim lintas jurusan.
                    </p>
                </div>
                <x-button :href="route('osis.projects')" variant="outline" size="sm">
                    Lihat Semua
                </x-button>
            </div>

            <div class="space-y-3">
                @foreach($projects as $p)
                    <div class="p-4 rounded-xl border border-neutral-200 dark:border-[#2A2A2A] bg-white dark:bg-[#181818] shadow-xs flex items-center justify-between gap-4">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[11px] font-semibold text-neutral-800 dark:text-neutral-200">
                                    {{ $p->jurusan_label }}
                                </span>
                                <span class="text-[10px] text-neutral-400">&bull; {{ $p->members->count() }} Anggota</span>
                            </div>
                            <h4 class="text-sm font-bold text-neutral-900 dark:text-white truncate">
                                {{ $p->title }}
                            </h4>
                            <div class="w-full bg-neutral-100 dark:bg-neutral-800 h-1.5 rounded-full mt-2 overflow-hidden max-w-md">
                                <div class="bg-neutral-900 dark:bg-white h-full" style="width: {{ $p->progress }}%"></div>
                            </div>
                        </div>

                        <div class="text-right shrink-0">
                            <span class="text-xs font-bold text-neutral-900 dark:text-white block">{{ $p->progress }}%</span>
                            <span class="text-[10px] text-neutral-400">{{ $p->status }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 1 col: Keaktifan Jurusan SMK -->
        <div>
            <x-card padding="p-5">
                <h3 class="text-sm font-bold text-neutral-900 dark:text-white mb-3 flex items-center gap-2">
                    <x-icon name="layers" class="w-4 h-4 text-neutral-500" />
                    Keaktifan Jurusan SMK
                </h3>

                <div class="space-y-3 text-xs">
                    @foreach($jurusans as $j)
                        <div class="p-3 rounded-lg border border-neutral-100 dark:border-[#262626] bg-neutral-50/50 dark:bg-[#151515] flex items-center justify-between">
                            <div>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ $j->kode }}</span>
                                <span class="text-neutral-400 text-[11px] block truncate max-w-[150px]">{{ $j->nama_lengkap }}</span>
                            </div>
                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-neutral-200 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200">
                                {{ $j->projects->count() }} Proyek
                            </span>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
