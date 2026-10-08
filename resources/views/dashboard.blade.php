<x-app-layout current="beranda" role="siswa" pageTitle="Beranda Siswa">
    <!-- Welcome Header with Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-200 dark:border-[#222222]">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white">
                    Halo, {{ auth()->user()->name ?? ($student->name ?? 'Siswa WORKHUB') }}
                </h1>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-700">
                    {{ auth()->user()->kelas ?? ($student->kelas ?? 'Kelas Siswa') }} &bull; {{ auth()->user()->jurusan->kode ?? ($student->jurusan->kode ?? 'SMK') }}
                </span>
            </div>
            <p class="text-xs md:text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                Ada <span class="font-semibold text-neutral-900 dark:text-white">{{ $projects->count() }} proyek aktif</span> di sekolah dan beberapa tugas menunggu penyelesaianmu.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <x-button :href="route('projects.create')" variant="primary" size="md" icon="plus">
                Buat Proyek
            </x-button>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 my-6">
        <div class="bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] rounded-xl p-4 md:p-5 shadow-xs">
            <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Proyek Berjalan</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">{{ $projects->count() }}</span>
                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 flex items-center gap-0.5">
                    <x-icon name="check" class="w-3.5 h-3.5 stroke-[2.5]" /> Aktif
                </span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] rounded-xl p-4 md:p-5 shadow-xs">
            <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Tugas Saya</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">{{ $urgentTasks->count() }}</span>
                <span class="text-xs font-medium text-amber-600 dark:text-amber-400 flex items-center gap-0.5">
                    <x-icon name="clock" class="w-3.5 h-3.5" /> Mendesak
                </span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] rounded-xl p-4 md:p-5 shadow-xs">
            <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Kandidat Kolaborator</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">{{ $candidates->count() + 1 }}</span>
                <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                    5 Jurusan
                </span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] rounded-xl p-4 md:p-5 shadow-xs">
            <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Kecocokan AI</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white">96%</span>
                <span class="text-xs font-semibold text-neutral-900 dark:text-white bg-neutral-100 dark:bg-neutral-800 px-1.5 py-0.5 rounded">
                    Tinggi
                </span>
            </div>
        </div>
    </div>

    <!-- Active Projects Section -->
    <section class="mt-8 mb-10">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white tracking-tight">
                    Proyek Kolaborasi Siswa
                </h2>
                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                    Sinergi karya teknologi, multimedia, dan desain antarjurusan SMK.
                </p>
            </div>
            <x-button :href="route('projects.index')" variant="ghost" size="sm" iconRight="arrow-right">
                Semua Proyek
            </x-button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($projects->take(3) as $p)
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
    </section>

    <!-- Two-column Section: WORKHUB MATCH & Quick Task Feed -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 my-10">
        <!-- WORKHUB MATCH (2 cols) -->
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
                <x-button :href="route('match.index')" variant="outline" size="sm">
                    Lihat Semua
                </x-button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($candidates->take(2) as $c)
                    <x-match-card 
                        :name="$c->name"
                        :classMajor="($c->kelas ?? 'Siswa') . ' ' . ($c->jurusan->kode ?? '')"
                        :score="rand(88, 96)"
                        :skills="$c->skills->pluck('name')->all()"
                        :href="route('profile.show', $c->id)"
                    />
                @endforeach
            </div>
        </div>

        <!-- Upcoming Tasks Sidebar Widget -->
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
                <x-button :href="route('workspace.show', 1)" variant="outline" size="sm" class="w-full justify-center text-xs">
                    Buka Workspace Proyek
                </x-button>
            </div>
        </div>
    </div>
</x-app-layout>
