<x-app-layout current="osis-kurasi" role="osis" pageTitle="Kurasi Showcase Festival">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-200 dark:border-[#222222]">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white">
                Kurasi Showcase Festival Sekolah
            </h1>
            <p class="text-xs md:text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                Pilih dan setujui karya kolaborasi siswa terbaik untuk ditampilkan di panggung pameran resmi.
            </p>
        </div>
    </div>

    <!-- Antrean Pengajuan yang Belum Masuk Showcase -->
    <div class="my-8 space-y-4">
        <h2 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-2">
            <x-icon name="clock" class="w-5 h-5 text-amber-500" />
            Antrean Pengajuan Proyek Masuk Showcase ({{ $pendingProjects->count() }})
        </h2>

        @forelse($pendingProjects as $p)
            <x-card padding="p-5">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded bg-neutral-100 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200">
                                {{ $p->jurusan_label }}
                            </span>
                            <span class="text-xs text-neutral-400">Lead: {{ $p->lead->name ?? 'Siswa' }}</span>
                        </div>
                        <h3 class="text-base font-bold text-neutral-900 dark:text-white">
                            {{ $p->title }}
                        </h3>
                        <p class="text-xs text-neutral-500 line-clamp-2 max-w-3xl">
                            {{ $p->description }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <x-button :href="route('siswa.workspace', $p->id)" variant="secondary" size="sm">
                            Tinjau Berkas
                        </x-button>

                        <form action="{{ route('osis.kurasi.approve', $p->id) }}" method="POST">
                            @csrf
                            <x-button type="submit" variant="primary" size="sm" icon="check">
                                Setujui Masuk Showcase
                            </x-button>
                        </form>
                    </div>
                </div>
            </x-card>
        @empty
            <div class="p-6 text-center text-xs text-neutral-400 border border-dashed rounded-xl">
                Semua proyek yang diajukan telah selesai dikurasi!
            </div>
        @endforelse
    </div>

    <!-- Proyek yang Sudah Tervalidasi di Showcase -->
    <div class="my-10 space-y-4">
        <h2 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-2">
            <x-icon name="sparkles" class="w-5 h-5 text-emerald-500" />
            Proyek Resmi Terpilih di Showcase ({{ $approvedProjects->count() }})
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($approvedProjects as $ap)
                <div class="p-5 rounded-xl border border-neutral-200 dark:border-[#2A2A2A] bg-white dark:bg-[#181818] shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded bg-neutral-900 text-white dark:bg-white dark:text-black">
                                {{ $ap->jurusan_label }}
                            </span>
                            <x-badge variant="success" size="xs">Showcase Live</x-badge>
                        </div>
                        <h4 class="text-base font-bold text-neutral-900 dark:text-white mt-2">
                            {{ $ap->title }}
                        </h4>
                        <p class="text-xs text-neutral-500 mt-1 line-clamp-2">
                            {{ $ap->description }}
                        </p>
                    </div>

                    <div class="mt-4 pt-3 border-t border-neutral-100 dark:border-[#242424] flex items-center justify-between text-xs text-neutral-500">
                        <span>Lead: {{ $ap->lead->name }}</span>
                        <x-button :href="route('siswa.workspace', $ap->id)" variant="outline" size="sm">
                            Buka Karya
                        </x-button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
