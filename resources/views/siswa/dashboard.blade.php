<x-app-layout current="beranda" role="siswa" pageTitle="Beranda Siswa">
    <!-- Vibrant Welcome Hero Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-700 p-6 md:p-8 text-white shadow-xl shadow-blue-500/10 mb-6 border border-white/10">
        <!-- Ambient decorative blurs -->
        <div class="absolute -right-8 -top-8 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/4 -bottom-10 w-48 h-48 bg-purple-400/20 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md text-xs font-bold text-white mb-3 border border-white/20 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>{{ auth()->user()->kelas ?? ($student->kelas ?? 'Siswa') }} &bull; {{ auth()->user()->jurusan->nama_lengkap ?? ($student->jurusan->nama_lengkap ?? 'SMKN 1 Ciomas') }}</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                    Halo, {{ auth()->user()->name ?? ($student->name ?? 'Siswa SMKN 1 Ciomas') }}
                </h1>
                <p class="text-xs md:text-sm text-blue-100 mt-2 max-w-xl leading-relaxed">
                    Siap berkolaborasi hari ini? Kamu memiliki <strong class="text-white underline decoration-white/40">{{ $projects->count() }} proyek aktif</strong> lintas 5 kejuruan SMKN 1 Ciomas.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <a 
                    href="{{ route('siswa.proyek.create') }}" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-blue-900 font-extrabold text-xs shadow-lg hover:bg-blue-50 transition-all hover:scale-105 active:scale-95 cursor-pointer"
                >
                    <x-icon name="plus" class="w-4 h-4 text-blue-600 stroke-[3]" />
                    <span>Buat Proyek Baru</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid with Themed Color Accents -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 my-6">
        <div class="bg-white dark:bg-[#161616] border border-neutral-200/80 dark:border-[#262626] rounded-2xl p-4 md:p-5 shadow-xs hover:border-blue-500/50 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Proyek Berjalan</span>
                <div class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                    <x-icon name="folder-kanban" class="w-4 h-4" />
                </div>
            </div>
            <div class="flex items-baseline justify-between mt-3">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">{{ $projects->count() }}</span>
                <span class="text-xs font-semibold text-blue-600 dark:text-blue-400 flex items-center gap-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span> Aktif
                </span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#161616] border border-neutral-200/80 dark:border-[#262626] rounded-2xl p-4 md:p-5 shadow-xs hover:border-amber-500/50 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Tugas Saya</span>
                <div class="w-7 h-7 rounded-lg bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    <x-icon name="clock" class="w-4 h-4" />
                </div>
            </div>
            <div class="flex items-baseline justify-between mt-3">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">{{ $urgentTasks->count() }}</span>
                <span class="text-xs font-semibold text-amber-600 dark:text-amber-400 flex items-center gap-0.5">
                    Mendesak
                </span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#161616] border border-neutral-200/80 dark:border-[#262626] rounded-2xl p-4 md:p-5 shadow-xs hover:border-purple-500/50 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Kandidat Rekan</span>
                <div class="w-7 h-7 rounded-lg bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                    <x-icon name="users" class="w-4 h-4" />
                </div>
            </div>
            <div class="flex items-baseline justify-between mt-3">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">{{ $candidates->count() + 1 }}</span>
                <span class="text-xs font-semibold text-purple-600 dark:text-purple-400">
                    5 Jurusan
                </span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#161616] border border-neutral-200/80 dark:border-[#262626] rounded-2xl p-4 md:p-5 shadow-xs hover:border-emerald-500/50 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Kecocokan AI</span>
                <div class="w-7 h-7 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                    <x-icon name="sparkles" class="w-4 h-4" />
                </div>
            </div>
            <div class="flex items-baseline justify-between mt-3">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">96%</span>
                <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/80 px-2 py-0.5 rounded-full border border-emerald-200 dark:border-emerald-800">
                    Optimal
                </span>
            </div>
        </div>
    </div>

    @if(isset($announcements) && $announcements->isNotEmpty())
        <div class="mb-8 p-4 md:p-5 rounded-2xl bg-gradient-to-r from-purple-50 via-pink-50 to-amber-50 dark:from-purple-950/30 dark:via-pink-950/20 dark:to-amber-950/20 border border-purple-200/80 dark:border-purple-900/50 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="p-1.5 rounded-lg bg-purple-600 text-white shadow-xs">
                        <x-icon name="bell" class="w-3.5 h-3.5" />
                    </span>
                    <h3 class="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-purple-900 dark:text-purple-300">
                        Papan Informasi & Broadcast OSIS
                    </h3>
                </div>
                <a href="{{ route('siswa.notifikasi') }}" class="text-[11px] font-bold text-purple-700 dark:text-purple-400 hover:underline">
                    Semua Pengumuman &rarr;
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($announcements as $ann)
                    <div class="p-3.5 rounded-xl bg-white/90 dark:bg-[#181818]/90 border border-purple-100 dark:border-neutral-800 text-xs">
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <span class="font-bold text-neutral-900 dark:text-white truncate">{{ $ann->title }}</span>
                            <span class="text-[10px] text-neutral-400 shrink-0">{{ $ann->created_at ? $ann->created_at->diffForHumans() : 'Baru saja' }}</span>
                        </div>
                        <p class="text-neutral-600 dark:text-neutral-400 text-[11px] line-clamp-2 leading-relaxed">{{ $ann->desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Active Projects Section -->
    <section class="mt-8 mb-10">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white tracking-tight">
                    Proyek Kolaborasi Saya
                </h2>
                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                    Proyek yang kamu pimpin atau kamu ikuti sebagai anggota aktif.
                </p>
            </div>
            <x-button :href="route('siswa.proyek.index')" variant="ghost" size="sm" iconRight="arrow-right">
                Semua Proyek
            </x-button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($projects->take(4) as $p)
                @php
                    $activeCount = $p->activeMembers ? $p->activeMembers->count() : $p->members->where('pivot.status', 'active')->count();
                @endphp
                <x-project-card 
                    :title="$p->title"
                    :jurusan="$p->jurusan_label ?: 'Umum'"
                    :description="$p->description"
                    :tags="['PBL', $p->category]"
                    :members="$activeCount . ' / ' . $p->target_members"
                    :deadline="$p->deadline ? $p->deadline->format('d M Y') : '-'"
                    :progress="$p->progress"
                    :status="$p->status"
                    :href="route('siswa.workspace', $p->id)"
                />
            @empty
                <div class="col-span-full bg-white dark:bg-[#181818] border border-dashed border-neutral-300 dark:border-neutral-700 rounded-2xl p-8 text-center">
                    <div class="w-10 h-10 rounded-full bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center mx-auto mb-3">
                        <x-icon name="folder-kanban" class="w-5 h-5 text-neutral-500" />
                    </div>
                    <h3 class="text-sm font-bold text-neutral-900 dark:text-white">Belum Ada Proyek Kolaborasi Aktif</h3>
                    <p class="text-xs text-neutral-500 mt-1 max-w-sm mx-auto">Kamu belum menjadi ketua atau anggota aktif dalam proyek apapun. Inisiasi proyek baru atau gabung ke proyek temanmu!</p>
                    <div class="mt-4 flex items-center justify-center gap-3">
                        <x-button :href="route('siswa.proyek.create')" variant="primary" size="sm" icon="plus">
                            Buat Proyek Baru
                        </x-button>
                        <x-button :href="route('siswa.proyek.index')" variant="secondary" size="sm" icon="folder-kanban">
                            Jelajahi Proyek Sekolah
                        </x-button>
                    </div>
                </div>
            @endforelse
        </div>

        @if(isset($exploreProjects) && $exploreProjects->count() > 0)
            <div class="mt-8 pt-6 border-t border-neutral-200 dark:border-[#222222]">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-neutral-900 dark:text-white tracking-tight flex items-center gap-1.5">
                            <x-icon name="sparkles" class="w-4 h-4 text-amber-500" />
                            Peluang Kolaborasi Lintas Jurusan di Sekolah
                        </h3>
                        <p class="text-[11px] text-neutral-500">
                            Proyek karya siswa lain yang sedang membuka perekrutan anggota baru.
                        </p>
                    </div>
                    <a href="{{ route('siswa.proyek.index') }}" class="text-xs font-semibold text-neutral-700 dark:text-neutral-300 hover:underline">
                        Lihat Semua &rarr;
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($exploreProjects->take(2) as $ep)
                        <div class="p-4 rounded-xl border border-neutral-200 dark:border-[#2A2A2A] bg-neutral-50/60 dark:bg-[#141414] flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-2">
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-neutral-200 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300">
                                        {{ $ep->jurusan_label }}
                                    </span>
                                    <span class="text-[10px] text-neutral-500">
                                        Lead: {{ $ep->lead->name ?? 'Siswa' }}
                                    </span>
                                </div>
                                <h4 class="text-sm font-bold text-neutral-900 dark:text-white line-clamp-1">{{ $ep->title }}</h4>
                                <p class="text-xs text-neutral-500 line-clamp-2 mt-1">{{ $ep->description }}</p>
                            </div>
                            <div class="mt-3 pt-2 border-t border-neutral-200 dark:border-[#262626] flex items-center justify-between">
                                <span class="text-xs text-neutral-500">Progress: {{ $ep->progress }}%</span>
                                <a href="{{ route('siswa.proyek.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-neutral-900 dark:text-white hover:underline">
                                    Ajukan Gabung &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>

    <!-- Two-column Section: WORKHUB MATCH & Quick Task Feed -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 my-10">
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-1.5">
                        <x-icon name="cpu" class="w-4 h-4 text-neutral-800 dark:text-neutral-200" />
                        <h2 class="text-lg font-bold text-neutral-900 dark:text-white tracking-tight">
                            WORKHUB MATCH
                        </h2>
                    </div>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                        Temukan orang yang paling cocok untuk project kamu.
                    </p>
                </div>
                <x-button :href="route('siswa.match')" variant="outline" size="sm">
                    Lihat Semua
                </x-button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($candidates->take(2) as $c)
                    <x-match-card 
                        :name="$c->name"
                        :classMajor="($c->kelas ?? 'Siswa') . ' ' . ($c->jurusan->kode ?? '')"
                        :score="95"
                        :skills="$c->skills->pluck('name')->all()"
                        :href="route('siswa.profil', $c->id)"
                    />
                @empty
                    <div class="col-span-full bg-white dark:bg-[#181818] border border-dashed border-neutral-300 dark:border-neutral-700 rounded-xl p-6 text-center text-xs text-neutral-400">
                        Belum ada siswa lain yang terdaftar. Ajak teman sekelasmu bergabung di WORKHUB!
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] rounded-xl p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-neutral-100 dark:border-[#262626]">
                    <h3 class="text-sm font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                        <x-icon name="briefcase" class="w-4 h-4 text-neutral-500" />
                        Tugas Mendesak Saya
                    </h3>
                    <span class="text-[11px] font-semibold text-neutral-400">{{ $urgentTasks->count() }} Tugas</span>
                </div>

                <div class="divide-y divide-neutral-100 dark:divide-[#242424] mt-1 text-xs">
                    @forelse($urgentTasks as $task)
                        <div class="py-3 flex items-start gap-2.5">
                            <form action="{{ route('siswa.workspace.task.status', [$task->project_id, $task->id]) }}" method="POST" class="inline shrink-0">
                                @csrf
                                <input 
                                    type="checkbox" 
                                    onchange="this.form.submit()" 
                                    title="Centang untuk menandai selesai" 
                                    class="mt-0.5 rounded border-neutral-300 dark:border-neutral-700 text-black focus:ring-black cursor-pointer"
                                />
                            </form>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('siswa.workspace', ['id' => $task->project_id, 'tab' => 'tugas']) }}" class="font-medium text-neutral-800 dark:text-neutral-200 block truncate hover:underline">
                                    {{ $task->title }}
                                </a>
                                <span class="text-[10px] text-amber-600 dark:text-amber-400 font-semibold mt-0.5 block">
                                    {{ $task->due_text ?? 'Segera' }} &bull; {{ $task->project->title ?? 'Proyek' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="py-4 text-center text-xs text-neutral-400">
                            Semua tugas telah diselesaikan!
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-neutral-100 dark:border-[#262626]">
                <x-button :href="route('siswa.workspace')" variant="outline" size="sm" class="w-full justify-center text-xs">
                    Buka Workspace Proyek
                </x-button>
            </div>
        </div>
    </div>
</x-app-layout>
