<x-app-layout current="osis-dashboard" role="osis" pageTitle="Dashboard Pengurus OSIS">
    <!-- OSIS Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-200 dark:border-[#222222]">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white">
                    Dashboard OSIS & Event Sekolah
                </h1>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-neutral-900 text-white dark:bg-white dark:text-black">
                    Koordinator Kolaborasi
                </span>
            </div>
            <p class="text-xs md:text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                Selamat bertugas, <strong class="text-neutral-800 dark:text-neutral-200">Muhammad Zidan</strong> (Ketua OSIS). Pantau event dan kurasi proyek siswa untuk pameran festival.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <x-button :href="route('osis.events')" variant="primary" size="md" icon="calendar">
                Agenda Event Festival
            </x-button>
        </div>
    </div>

    <!-- OSIS Metrik Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 my-6">
        <div class="bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] rounded-xl p-4 md:p-5 shadow-xs">
            <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Total Proyek Sekolah</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">{{ $totalProjects }}</span>
                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 flex items-center gap-0.5">
                    <x-icon name="activity" class="w-3.5 h-3.5 stroke-[2.5]" /> Aktif
                </span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] rounded-xl p-4 md:p-5 shadow-xs">
            <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Siswa Berkolaborasi</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">{{ $totalStudents }}</span>
                <span class="text-xs font-medium text-neutral-500">Lintas 5 Jurusan</span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] rounded-xl p-4 md:p-5 shadow-xs">
            <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Antrean Showcase</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">{{ $pendingShowcaseProjects->count() }}</span>
                <span class="text-xs font-medium text-amber-600 dark:text-amber-400 flex items-center gap-0.5">
                    <x-icon name="clock" class="w-3.5 h-3.5" /> Butuh Review
                </span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] rounded-xl p-4 md:p-5 shadow-xs">
            <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Festival Sekolah</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">H-42</span>
                <span class="text-xs font-semibold px-1.5 py-0.5 rounded bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300">
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
