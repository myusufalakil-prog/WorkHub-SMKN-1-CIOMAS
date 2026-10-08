<x-app-layout current="proyek" pageTitle="Daftar Proyek Kolaborasi">
    <!-- Header with Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-200 dark:border-[#222222]">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white">
                Proyek Kolaborasi
            </h1>
            <p class="text-xs md:text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                Eksplorasi proyek lintas jurusan, temukan rekan satu tim, atau buat ide kolaborasi barumu.
            </p>
        </div>

        <x-button :href="route('projects.create')" variant="primary" size="md" icon="plus">
            Buat Proyek
        </x-button>
    </div>

    <!-- Filter Bar (Clean pill buttons for Jurusan) -->
    <div class="my-6 space-y-4">
        <!-- Jurusan Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs">
            <span class="text-neutral-400 font-semibold mr-1 shrink-0">Jurusan:</span>
            <a 
                href="{{ route('projects.index', ['jurusan' => 'Semua', 'status' => $currentStatus, 'q' => $search]) }}"
                class="px-3 py-1.5 rounded-full font-medium transition-all shrink-0 {{ $currentJurusan === 'Semua' ? 'bg-neutral-900 text-white dark:bg-white dark:text-neutral-950 font-bold shadow-xs' : 'bg-white dark:bg-[#181818] text-neutral-700 dark:text-neutral-300 border border-neutral-200 dark:border-[#2A2A2A] hover:border-neutral-400' }}"
            >
                Semua
            </a>
            @foreach($jurusans as $j)
                <a 
                    href="{{ route('projects.index', ['jurusan' => $j->kode, 'status' => $currentStatus, 'q' => $search]) }}"
                    class="px-3 py-1.5 rounded-full font-medium transition-all shrink-0 {{ $currentJurusan === $j->kode ? 'bg-neutral-900 text-white dark:bg-white dark:text-neutral-950 font-bold shadow-xs' : 'bg-white dark:bg-[#181818] text-neutral-700 dark:text-neutral-300 border border-neutral-200 dark:border-[#2A2A2A] hover:border-neutral-400' }}"
                >
                    {{ $j->kode }}
                </a>
            @endforeach
        </div>

        <!-- Secondary Filters & Search -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
            <!-- Status Filter -->
            <div class="flex items-center gap-1.5 text-xs w-full sm:w-auto overflow-x-auto">
                <span class="text-neutral-400 font-semibold mr-1 shrink-0">Status:</span>
                @foreach(['Semua', 'Open Recruitment', 'Sedang Berjalan', 'Selesai'] as $st)
                    <a 
                        href="{{ route('projects.index', ['status' => $st, 'jurusan' => $currentJurusan, 'q' => $search]) }}"
                        class="px-2.5 py-1 rounded-md text-xs font-medium transition-colors shrink-0 {{ $currentStatus === $st ? 'bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-white font-bold' : 'text-neutral-500 hover:text-neutral-900 dark:hover:text-white' }}"
                    >
                        {{ $st }}
                    </a>
                @endforeach
            </div>

            <!-- Total count label -->
            <span class="text-xs text-neutral-400 font-medium self-end sm:self-center">
                Menampilkan {{ $projects->count() }} proyek riil
            </span>
        </div>
    </div>

    <!-- Project Cards Grid -->
    @if($projects->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($projects as $p)
                <x-project-card 
                    :title="$p->title"
                    :jurusan="$p->jurusan_label"
                    :description="$p->description"
                    :tags="['PBL', $p->category]"
                    :members="$p->members->count() . ' / ' . $p->target_members"
                    :deadline="$p->deadline ? $p->deadline->format('d M Y') : '12 Nov 2026'"
                    :progress="$p->progress"
                    :status="$p->status"
                    :href="route('workspace.show', $p->id)"
                />
            @endforeach
        </div>
    @else
        <!-- Standardized Empty State -->
        <x-empty-state 
            title="Belum ada proyek yang cocok"
            description="Tidak ada proyek dengan filter yang dipilih. Coba ganti kata kunci atau buat proyek baru."
            actionText="Buat Proyek Baru"
            :actionHref="route('projects.create')"
        />
    @endif
</x-app-layout>
