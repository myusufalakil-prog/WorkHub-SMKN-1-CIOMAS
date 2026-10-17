<x-app-layout current="showcase" role="siswa" pageTitle="Galeri Karya Inovasi">
    <div class="pb-6 border-b border-neutral-200 dark:border-[#222222]">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold uppercase tracking-wider mb-2 shadow-xs">
            <x-icon name="sparkles" class="w-3.5 h-3.5" />
            Galeri Inovasi Multidisiplin
        </div>
        <h1 class="text-3xl font-extrabold tracking-tight text-neutral-950 dark:text-white">
            Galeri Karya Inovasi
        </h1>
        <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1 max-w-2xl">
            Kumpulan proyek terbaik yang telah berhasil diselesaikan oleh kolaborasi lintas domain dan terverifikasi untuk dipamerkan secara publik.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
        @forelse($projects as $p)
            <x-project-card 
                :title="$p->title"
                :jurusan="$p->jurusan_label"
                :description="$p->description"
                :tags="['PBL', $p->category]"
                :members="$p->members->count() . ' / ' . $p->target_members"
                :deadline="$p->deadline ? $p->deadline->format('d M Y') : '12 Nov 2026'"
                :progress="$p->progress"
                :status="$p->status"
                :href="route('siswa.workspace', $p->id)"
            />
        @empty
            <div class="col-span-1 md:col-span-2 p-8 text-center rounded-xl border border-dashed border-neutral-300 dark:border-neutral-700 bg-white dark:bg-[#181818]">
                <p class="text-sm font-semibold text-neutral-800 dark:text-neutral-200">
                    Belum ada karya yang masuk ke galeri pameran
                </p>
                <p class="text-xs text-neutral-500 mt-1">
                    Selesaikan kemajuan proyek hingga 70%+ atau ajukan kurasi melalui Tim Penyelenggara untuk ditampilkan di sini.
                </p>
                <div class="mt-4">
                    <x-button :href="route('siswa.proyek.index')" variant="secondary" size="sm">
                        Jelajahi Proyek Aktif
                    </x-button>
                </div>
            </div>
        @endforelse
    </div>
</x-app-layout>
