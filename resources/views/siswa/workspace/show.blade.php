<x-app-layout current="workspace" role="siswa" pageTitle="Workspace Proyek">
    @if(!$project)
        <div class="max-w-xl mx-auto py-16 px-4 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center text-neutral-400">
                <x-icon name="briefcase" class="w-8 h-8" />
            </div>
            <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                Belum Ada Proyek Aktif di Workspace
            </h2>
            <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 max-w-md mx-auto mb-6">
                Workspace ini adalah ruang kolaborasi untuk pengerjaan tugas tim, file aset, dan chat realtime. Silakan inisiasi proyek baru atau gabung ke proyek yang tersedia.
            </p>
            <div class="flex items-center justify-center gap-3">
                <x-button :href="route('siswa.proyek.create')" variant="primary" size="md" icon="plus">
                    Buat Proyek Baru
                </x-button>
                <x-button :href="route('siswa.proyek.index')" variant="secondary" size="md" icon="folder-kanban">
                    Jelajahi Proyek
                </x-button>
            </div>
        </div>
    @else
        @php
            $activeMembers = $project->activeMembers ?? collect();
            $pendingMembers = $project->pendingMembers ?? collect();
            $tasks = $project->tasks ?? collect();
            $files = $project->files ?? collect();
            $activities = $project->activities ?? collect();
            $messages = $project->messages ?? collect();
            $currentUserId = auth()->id();
            $isLead = ($currentUserId === $project->lead_id) || (auth()->user()?->role === 'admin');
            $isPendingUser = $pendingMembers->contains('id', $currentUserId);
            $isActiveUser = $activeMembers->contains('id', $currentUserId) || $isLead;
        @endphp

        @if(!$isActiveUser)
            <!-- Banner Mode Pratinjau untuk Non-Anggota -->
            <div class="mb-6 p-4 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-neutral-100/90 dark:bg-[#161616] flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-neutral-200 dark:bg-neutral-800 flex items-center justify-center text-neutral-600 dark:text-neutral-300 shrink-0">
                        <x-icon name="eye" class="w-4 h-4" />
                    </div>
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-900 dark:text-white">
                            Mode Pratinjau Proyek
                        </h4>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                            @if($isPendingUser)
                                Pengajuan Anda untuk bergabung sedang <strong>Menunggu Persetujuan</strong> dari Ketua Tim.
                            @else
                                Anda belum bergabung ke dalam tim kolaborasi proyek ini. Silakan ajukan diri untuk berkolaborasi penuh.
                            @endif
                        </p>
                    </div>
                </div>

                @if(!$isPendingUser)
                    <button 
                        type="button"
                        onclick="document.getElementById('modalJoinWorkspace').showModal()"
                        class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 text-xs font-bold rounded-lg bg-neutral-900 text-white hover:bg-neutral-800 dark:bg-white dark:text-neutral-900 dark:hover:bg-neutral-100 transition-colors shadow-xs shrink-0 cursor-pointer"
                    >
                        <x-icon name="user-plus" class="w-3.5 h-3.5" />
                        Ajukan Gabung Tim
                    </button>
                @else
                    <span class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200 dark:border-amber-800 shrink-0 flex items-center gap-1">
                        <x-icon name="clock" class="w-3.5 h-3.5" />
                        Menunggu Konfirmasi Ketua
                    </span>
                @endif
            </div>
        @endif

        <!-- 1. Workspace Switcher Bar: Quick Switcher for Multiple Workspaces -->
        @php
            $userProjectList = $myProjects ?? collect([$project]);
        @endphp
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3 p-3 sm:p-3.5 rounded-2xl bg-white dark:bg-[#161616] border border-neutral-200/90 dark:border-[#282828] shadow-xs">
            <!-- Left: Dropdown Workspace Switcher -->
            <div class="relative" id="workspaceSwitcherDropdown">
                <details class="group relative">
                    <summary class="list-none flex items-center gap-2.5 px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200/80 dark:bg-neutral-800/80 dark:hover:bg-neutral-700/80 text-slate-800 dark:text-neutral-100 text-xs font-bold cursor-pointer transition-all border border-slate-200/80 dark:border-neutral-700 select-none">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center shrink-0 text-[10px] font-black shadow-xs">
                            {{ strtoupper(substr($project->title, 0, 2)) }}
                        </div>
                        <span class="max-w-[180px] sm:max-w-xs truncate font-extrabold text-neutral-900 dark:text-white">{{ $project->title }}</span>
                        <span class="text-[10px] px-1.5 py-0.5 rounded-md font-semibold {{ ($currentUserId === $project->lead_id) ? 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300' }}">
                            {{ ($currentUserId === $project->lead_id) ? 'Ketua Tim' : 'Anggota' }}
                        </span>
                        <x-icon name="chevron-down" class="w-3.5 h-3.5 text-neutral-400 group-open:rotate-180 transition-transform shrink-0" />
                    </summary>

                    <!-- Dropdown Menu List -->
                    <div class="absolute left-0 top-full mt-2 w-80 sm:w-96 rounded-2xl bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2C2C2C] shadow-2xl p-2 z-50 animate-in fade-in zoom-in-95 duration-100">
                        <div class="px-3 py-2 border-b border-neutral-100 dark:border-[#242424] flex items-center justify-between">
                            <span class="text-[11px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">
                                Workspace Saya ({{ $userProjectList->count() }})
                            </span>
                            <a href="{{ route('siswa.proyek.create') }}" class="text-[11px] font-bold text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                                <x-icon name="plus" class="w-3 h-3 stroke-[3]" /> Buat Baru
                            </a>
                        </div>

                        <div class="max-h-64 overflow-y-auto divide-y divide-neutral-100 dark:divide-[#242424] my-1">
                            @forelse($userProjectList as $mp)
                                <a 
                                    href="{{ route('siswa.workspace', $mp->id) }}"
                                    class="p-2.5 rounded-xl flex items-center justify-between gap-3 hover:bg-neutral-50 dark:hover:bg-[#222222] transition-colors {{ $mp->id === $project->id ? 'bg-blue-50/80 dark:bg-blue-950/40 border border-blue-200/80 dark:border-blue-900/60' : '' }}"
                                >
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <div class="w-8 h-8 rounded-lg {{ $mp->id === $project->id ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/25' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300' }} flex items-center justify-center shrink-0 text-xs font-bold">
                                            {{ strtoupper(substr($mp->title, 0, 2)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-1.5">
                                                <h5 class="text-xs font-bold text-neutral-900 dark:text-white truncate">
                                                    {{ $mp->title }}
                                                </h5>
                                                @if($mp->id === $project->id)
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>
                                                @endif
                                            </div>
                                            <span class="text-[10px] text-neutral-500 dark:text-neutral-400 block truncate">
                                                {{ ($currentUserId === $mp->lead_id) ? 'Ketua Tim' : 'Anggota' }} &bull; {{ $mp->jurusan_label ?: 'Kolaborasi' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-right shrink-0">
                                        <span class="text-[11px] font-bold text-neutral-700 dark:text-neutral-300 block">
                                            {{ $mp->progress }}%
                                        </span>
                                        <span class="text-[9px] text-neutral-400 font-medium">
                                            Progress
                                        </span>
                                    </div>
                                </a>
                            @empty
                                <div class="p-4 text-center text-xs text-neutral-400">
                                    Belum ada proyek lain.
                                </div>
                            @endforelse
                        </div>

                        <div class="pt-2 border-t border-neutral-100 dark:border-[#242424] px-1">
                            <a 
                                href="{{ route('siswa.proyek.index') }}" 
                                class="w-full inline-flex items-center justify-center gap-1.5 py-1.5 text-[11px] font-bold text-neutral-600 dark:text-neutral-300 hover:text-neutral-900 dark:hover:text-white rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
                            >
                                <x-icon name="folder-kanban" class="w-3.5 h-3.5" />
                                <span>Jelajahi Semua Proyek Sekolah</span>
                                <x-icon name="arrow-right" class="w-3 h-3" />
                            </a>
                        </div>
                    </div>
                </details>
            </div>

            <!-- Right: Quick Counter / Helper -->
            <div class="flex items-center gap-3 text-xs text-neutral-500 dark:text-neutral-400">
                <span class="hidden sm:inline">
                    Kamu memiliki <strong class="text-neutral-900 dark:text-white font-bold">{{ $userProjectList->count() }} proyek</strong> aktif
                </span>
                <a 
                    href="{{ route('siswa.proyek.create') }}" 
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 hover:opacity-90 transition-opacity shadow-xs"
                >
                    <x-icon name="plus" class="w-3.5 h-3.5 stroke-[3]" />
                    <span>+ Proyek Baru</span>
                </a>
            </div>
        </div>

        <!-- Project Header Bar -->
        <div class="pb-6 border-b border-neutral-200 dark:border-[#222222]">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-50 text-blue-700 dark:bg-blue-950/80 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                            {{ $project->jurusan_label }}
                        </span>
                        <x-badge variant="success" size="xs" :dot="true">{{ $project->status }}</x-badge>
                        @if($project->is_showcase)
                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 dark:bg-amber-950/70 dark:text-amber-300 border border-amber-200 dark:border-amber-800 flex items-center gap-1">
                                <x-icon name="award" class="w-3.5 h-3.5" /> Showcase Resmi
                            </span>
                        @endif
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-neutral-950 dark:text-white">
                        {{ $project->title }}
                    </h1>
                    <p class="text-xs md:text-sm text-neutral-600 dark:text-neutral-400 mt-1 max-w-3xl leading-relaxed">
                        {{ $project->description }}
                    </p>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <x-button :href="route('siswa.match')" variant="secondary" size="sm" icon="cpu">
                        AI Match
                    </x-button>

                    @if($isActiveUser)
                        <button 
                            onclick="document.getElementById('modalTambahTugas').showModal()"
                            class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-md hover:shadow-blue-500/25 cursor-pointer"
                        >
                            <x-icon name="plus" class="w-3.5 h-3.5 stroke-[3]" />
                            Tambah Tugas
                        </button>
                    @elseif(!$isPendingUser)
                        <button 
                            onclick="document.getElementById('modalJoinWorkspace').showModal()"
                            class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-md hover:shadow-blue-500/25 cursor-pointer"
                        >
                            <x-icon name="user-plus" class="w-3.5 h-3.5" />
                            Ajukan Gabung
                        </button>
                    @endif
                </div>
            </div>

        <!-- 4 Key Indicators with Themed Colors -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 mt-6">
            <div class="bg-white dark:bg-[#161616] border border-neutral-200/80 dark:border-[#262626] rounded-2xl p-4 shadow-xs hover:border-blue-500/50 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Progress PBL</span>
                    <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">On Track</span>
                </div>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-2xl font-extrabold text-neutral-900 dark:text-white">{{ $project->progress }}%</span>
                </div>
                <div class="w-full h-1.5 bg-neutral-100 dark:bg-neutral-800 rounded-full mt-2.5 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-600 rounded-full transition-all duration-500" style="width: {{ $project->progress }}%"></div>
                </div>
            </div>

            <div class="bg-white dark:bg-[#161616] border border-neutral-200/80 dark:border-[#262626] rounded-2xl p-4 shadow-xs hover:border-amber-500/50 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Deadline</span>
                    <div class="w-6 h-6 rounded-lg bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                        <x-icon name="calendar" class="w-3.5 h-3.5" />
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-base sm:text-lg font-bold text-neutral-900 dark:text-white block">{{ $project->deadline ? $project->deadline->format('d M Y') : '12 Nov 2026' }}</span>
                    <span class="text-[10px] text-amber-600 dark:text-amber-400 font-semibold mt-1 block">Tenggat Tim</span>
                </div>
            </div>

            <div class="bg-white dark:bg-[#161616] border border-neutral-200/80 dark:border-[#262626] rounded-2xl p-4 shadow-xs hover:border-purple-500/50 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Kolaborator</span>
                    <div class="w-6 h-6 rounded-lg bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                        <x-icon name="users" class="w-3.5 h-3.5" />
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-base sm:text-lg font-bold text-neutral-900 dark:text-white block">{{ $activeMembers->count() }} Anggota</span>
                    <span class="text-[10px] text-purple-600 dark:text-purple-400 font-semibold mt-1 block">Tim Aktif</span>
                </div>
            </div>

            <div class="bg-white dark:bg-[#161616] border border-neutral-200/80 dark:border-[#262626] rounded-2xl p-4 shadow-xs hover:border-emerald-500/50 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase font-bold tracking-wider text-neutral-400 dark:text-neutral-500">Tugas Selesai</span>
                    <div class="w-6 h-6 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                        <x-icon name="check" class="w-3.5 h-3.5 stroke-[2.5]" />
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-base sm:text-lg font-bold text-neutral-900 dark:text-white block">{{ $tasks->where('status', 'done')->count() }} / {{ $tasks->count() }}</span>
                    <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold mt-1 block">Tervalidasi Otomatis</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Workspace Tabs Navigation (6 Tabs) -->
    <div class="my-6 border-b border-neutral-200 dark:border-[#222222] overflow-x-auto">
        <nav class="flex space-x-6 text-sm font-medium">
            @php
                $tabsList = [
                    ['id' => 'ringkasan', 'label' => 'Ringkasan', 'icon' => 'home'],
                    ['id' => 'tugas', 'label' => 'Tugas', 'icon' => 'briefcase', 'count' => $tasks->count()],
                    ['id' => 'anggota', 'label' => 'Anggota', 'icon' => 'users', 'count' => $activeMembers->count(), 'pending' => ($isLead ? $pendingMembers->count() : 0)],
                    ['id' => 'file', 'label' => 'File', 'icon' => 'paperclip', 'count' => $files->count()],
                    ['id' => 'aktivitas', 'label' => 'Aktivitas', 'icon' => 'activity'],
                    ['id' => 'chat', 'label' => 'Chat Tim', 'icon' => 'message-square', 'count' => $messages->count()],
                ];
            @endphp

            @foreach($tabsList as $t)
                @php $isActive = $activeTab === $t['id']; @endphp
                <a 
                    href="{{ route('siswa.workspace', ['id' => $project->id, 'tab' => $t['id']]) }}"
                    class="py-3 px-1 border-b-2 flex items-center gap-2 transition-all whitespace-nowrap {{ $isActive ? 'border-blue-600 text-blue-600 dark:border-blue-400 dark:text-blue-400 font-bold' : 'border-transparent text-neutral-500 dark:text-neutral-400 hover:text-blue-600 dark:hover:text-blue-300' }}"
                >
                    <x-icon :name="$t['icon']" class="w-4 h-4 {{ $isActive ? 'text-blue-600 dark:text-blue-400' : '' }}" />
                    <span>{{ $t['label'] }}</span>
                    @if(isset($t['pending']) && $t['pending'] > 0)
                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-amber-500 text-white animate-pulse" title="{{ $t['pending'] }} pengajuan baru">
                            +{{ $t['pending'] }}
                        </span>
                    @elseif(isset($t['count']) && $t['count'] > 0)
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $isActive ? 'bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400' }}">
                            {{ $t['count'] }}
                        </span>
                    @endif
                </a>
            @endforeach
        </nav>
    </div>

    <!-- Tab Content Switcher -->
    <div>
        @if($activeTab === 'ringkasan')
            <!-- Ringkasan Tab -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <x-card padding="p-6">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-neutral-400 dark:text-neutral-500 mb-3">
                            Tentang Proyek Kolaborasi
                        </h3>
                        <p class="text-sm text-neutral-700 dark:text-neutral-300 leading-relaxed">
                            Proyek <strong>{{ $project->title }}</strong> menyatukan keahlian siswa lintas jurusan SMK dalam alur kerja berbasis <em>Project-Based Learning</em> yang terstruktur.
                        </p>
                        
                        <div class="mt-4 pt-4 border-t border-neutral-100 dark:border-[#262626] flex flex-wrap gap-2">
                            <span class="text-xs font-semibold text-neutral-500 self-center mr-1">Jurusan Terlibat:</span>
                            @foreach($project->jurusans as $jur)
                                <x-badge variant="neutral" size="sm">{{ $jur->kode }} - {{ $jur->nama_lengkap }}</x-badge>
                            @endforeach
                        </div>

                        @if($project->notes_guru)
                            <div class="mt-4 p-3.5 rounded-xl bg-neutral-50 dark:bg-[#141414] border border-neutral-200 dark:border-neutral-800 text-xs">
                                <span class="font-bold text-neutral-900 dark:text-white uppercase tracking-wider text-[10px] block mb-1 flex items-center gap-1.5">
                                    <x-icon name="message-square" class="w-3.5 h-3.5" /> Catatan Pembimbing:
                                </span>
                                <p class="text-neutral-700 dark:text-neutral-300 italic">"{{ $project->notes_guru }}"</p>
                            </div>
                        @endif
                    </x-card>

                    <x-card padding="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base font-bold text-neutral-900 dark:text-white">
                                Tugas Mendatang
                            </h3>
                            <a href="{{ route('siswa.workspace', ['id' => $project->id, 'tab' => 'tugas']) }}" class="text-xs font-semibold text-neutral-600 dark:text-neutral-400 hover:underline">
                                Buka Semua Tugas &rarr;
                            </a>
                        </div>

                        <div class="divide-y divide-neutral-100 dark:divide-[#242424]">
                            @forelse($tasks->take(4) as $task)
                                <div class="py-3 flex items-center justify-between gap-3 text-sm">
                                    <div class="flex items-center gap-3">
                                        <x-icon name="{{ $task->status === 'done' ? 'check' : 'clock' }}" class="w-4 h-4 {{ $task->status === 'done' ? 'text-emerald-500' : 'text-neutral-400' }}" />
                                        <span class="{{ $task->status === 'done' ? 'line-through text-neutral-400' : 'font-medium text-neutral-800 dark:text-neutral-200' }}">
                                            {{ $task->title }}
                                        </span>
                                    </div>
                                    @if($task->assignee_id)
                                        <a href="{{ route('siswa.profil', $task->assignee_id) }}" class="text-xs text-neutral-500 hover:text-neutral-900 dark:hover:text-white hover:underline shrink-0">
                                            {{ $task->assignee->name ?? 'Tim Siswa' }}
                                        </a>
                                    @else
                                        <span class="text-xs text-neutral-500 shrink-0">{{ $task->assignee->name ?? 'Tim Siswa' }}</span>
                                    @endif
                                </div>
                            @empty
                                <div class="py-4 text-center text-xs text-neutral-400">Belum ada tugas dibuat.</div>
                            @endforelse
                        </div>
                    </x-card>
                </div>

                <div class="space-y-6">
                    <x-card padding="p-5">
                        <h4 class="text-xs uppercase font-bold tracking-wider text-neutral-400 mb-3">
                            Project Lead
                        </h4>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-neutral-900 text-white font-bold flex items-center justify-center text-xs">
                                {{ strtoupper(substr($project->lead->name ?? 'Lead', 0, 2)) }}
                            </div>
                            <div>
                                <h5 class="text-sm font-bold text-neutral-900 dark:text-white">{{ $project->lead->name ?? 'Ketua Tim' }}</h5>
                                <span class="text-xs text-neutral-400">{{ $project->lead->kelas ?? 'Siswa' }} &bull; {{ $project->lead->jurusan->kode ?? 'SMK' }}</span>
                            </div>
                        </div>
                    </x-card>

                    <x-card padding="p-5">
                        <h4 class="text-xs uppercase font-bold tracking-wider text-neutral-400 mb-3">
                            Detail Kolaborasi
                        </h4>
                        <div class="space-y-3 text-xs">
                            <div class="flex items-center justify-between py-1 border-b border-neutral-100 dark:border-neutral-800">
                                <span class="text-neutral-500">Target Tim:</span>
                                <span class="font-bold text-neutral-800 dark:text-neutral-200">{{ $project->target_members }} Siswa</span>
                            </div>
                            <div class="flex items-center justify-between py-1 border-b border-neutral-100 dark:border-neutral-800">
                                <span class="text-neutral-500">Tenggat Waktu:</span>
                                <span class="font-bold text-neutral-800 dark:text-neutral-200">{{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->translatedFormat('d M Y') : 'Fleksibel' }}</span>
                            </div>
                            <div class="flex items-center justify-between py-1">
                                <span class="text-neutral-500">Status:</span>
                                <span class="font-bold text-blue-600 dark:text-blue-400">{{ $project->status }}</span>
                            </div>
                        </div>
                    </x-card>
                </div>
            </div>

        @elseif($activeTab === 'tugas')
            <!-- Tugas Tab -->
            <x-card padding="p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white">
                            Daftar Tugas Proyek ({{ $tasks->count() }})
                        </h3>
                        <p class="text-xs text-neutral-500">
                            Kelola pembagian tugas dan checklist progress implementasi tim.
                        </p>
                    </div>

                    <button 
                        type="button"
                        onclick="document.getElementById('modalTambahTugas').showModal()"
                        class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold rounded-lg bg-neutral-900 text-white hover:bg-neutral-800 dark:bg-white dark:text-neutral-900 dark:hover:bg-neutral-100 transition-colors shadow-xs shrink-0"
                    >
                        <x-icon name="plus" class="w-3.5 h-3.5" />
                        Tambah Tugas Baru
                    </button>
                </div>

                <div class="divide-y divide-neutral-200 dark:divide-[#262626]">
                    @forelse($tasks as $t)
                        <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-start gap-3">
                                <!-- Form Toggle Status Checklist -->
                                <form action="{{ route('siswa.workspace.task.status', ['id' => $project->id, 'taskId' => $t->id]) }}" method="POST" class="inline">
                                    @csrf
                                    <button 
                                        type="submit"
                                        title="Klik untuk ubah status tugas"
                                        class="mt-0.5 w-5 h-5 rounded border flex items-center justify-center transition-colors {{ $t->status === 'done' ? 'bg-neutral-900 text-white border-neutral-900 dark:bg-white dark:text-black dark:border-white' : 'border-neutral-300 dark:border-neutral-600 hover:border-neutral-900 dark:hover:border-white' }}"
                                    >
                                        @if($t->status === 'done')
                                            <x-icon name="check" class="w-3.5 h-3.5 stroke-[3]" />
                                        @endif
                                    </button>
                                </form>

                                <div>
                                    <span class="text-sm font-semibold {{ $t->status === 'done' ? 'line-through text-neutral-400 dark:text-neutral-500' : 'text-neutral-900 dark:text-white' }}">
                                        {{ $t->title }}
                                    </span>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                        {{ $t->description }}
                                    </p>
                                    <div class="flex items-center gap-2 mt-1 text-xs text-neutral-500">
                                        <span>PJ: 
                                            @if($t->assignee_id)
                                                <a href="{{ route('siswa.profil', $t->assignee_id) }}" class="font-bold text-neutral-800 dark:text-neutral-200 hover:underline">
                                                    {{ $t->assignee->name ?? 'Tim' }}
                                                </a>
                                            @else
                                                <strong class="text-neutral-700 dark:text-neutral-300">{{ $t->assignee->name ?? 'Tim' }}</strong>
                                            @endif
                                        </span>
                                        <span>&bull;</span>
                                        <span>Due: {{ $t->due_text ?? 'Segera' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 self-end sm:self-center">
                                @if($t->priority === 'Tinggi')
                                    <x-badge variant="error" size="xs">Tinggi</x-badge>
                                @elseif($t->priority === 'Sedang')
                                    <x-badge variant="warning" size="xs">Sedang</x-badge>
                                @else
                                    <x-badge variant="neutral" size="xs">Normal</x-badge>
                                @endif

                                @if($t->status === 'done')
                                    <x-badge variant="success" size="xs">Selesai</x-badge>
                                @else
                                    <x-badge variant="outline" size="xs">To Do</x-badge>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center">
                            <p class="text-sm text-neutral-500">Belum ada tugas dalam proyek ini.</p>
                            <button 
                                onclick="document.getElementById('modalTambahTugas').showModal()"
                                class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-neutral-900 dark:text-white underline"
                            >
                                + Buat tugas pertama sekarang
                            </button>
                        </div>
                    @endforelse
                </div>
            </x-card>

        @elseif($activeTab === 'anggota')
            <!-- Anggota Tab -->
            <x-card padding="p-6">
                @if($isPendingUser)
                    <div class="mb-6 p-4 rounded-xl border border-amber-300 dark:border-amber-700/60 bg-amber-50/80 dark:bg-amber-950/30 flex items-start gap-3">
                        <x-icon name="clock" class="w-5 h-5 text-amber-600 dark:text-amber-400 shrink-0 mt-0.5" />
                        <div>
                            <h4 class="text-sm font-bold text-amber-900 dark:text-amber-200">Pengajuan Bergabung Anda Sedang Ditinjau</h4>
                            <p class="text-xs text-amber-700 dark:text-amber-300 mt-0.5 leading-relaxed">
                                Anda telah mengajukan diri untuk bergabung ke proyek kolaborasi ini. Status Anda saat ini <strong>Menunggu Persetujuan</strong> dari Ketua Tim. Begitu disetujui, Anda dapat membagikan tugas dan berkolaborasi penuh.
                            </p>
                        </div>
                    </div>
                @endif

                @if($isLead && $pendingMembers->count() > 0)
                    <!-- Pending Approval Section for Project Lead -->
                    <div class="mb-8 p-5 rounded-xl border border-amber-300 dark:border-amber-800 bg-amber-50/70 dark:bg-amber-950/30">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping"></span>
                                <h4 class="text-sm font-bold text-amber-950 dark:text-amber-200">
                                    Pengajuan Calon Kolaborator Masuk ({{ $pendingMembers->count() }})
                                </h4>
                            </div>
                            <span class="text-xs text-amber-700 dark:text-amber-300 font-medium">
                                Menunggu Keputusan Anda sebagai Ketua
                            </span>
                        </div>

                        <div class="space-y-3">
                            @foreach($pendingMembers as $pm)
                                <div class="p-3.5 bg-white dark:bg-[#1a1a1a] rounded-xl border border-neutral-200 dark:border-neutral-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <a href="{{ route('siswa.profil', $pm->id) }}" class="w-10 h-10 rounded-lg bg-neutral-900 text-white dark:bg-white dark:text-neutral-900 font-bold text-xs flex items-center justify-center shrink-0 hover:opacity-80 transition-opacity">
                                            {{ strtoupper(substr($pm->name, 0, 2)) }}
                                        </a>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <a href="{{ route('siswa.profil', $pm->id) }}" class="text-sm font-bold text-neutral-900 dark:text-white hover:underline truncate">
                                                    {{ $pm->name }}
                                                </a>
                                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300">
                                                    {{ $pm->jurusan?->kode ?? 'SMK' }} &bull; {{ $pm->kelas ?? 'Siswa' }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-neutral-500 mt-0.5 truncate">
                                                Melamar Posisi: <strong class="text-neutral-800 dark:text-neutral-200">{{ $pm->pivot->role_in_project ?? 'Anggota Kolaborasi' }}</strong>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 shrink-0">
                                        <form method="POST" action="{{ route('siswa.proyek.member.approve', ['id' => $project->id, 'userId' => $pm->id]) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 text-xs font-bold rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white transition-colors flex items-center gap-1.5 shadow-xs cursor-pointer">
                                                <x-icon name="check" class="w-3.5 h-3.5" />
                                                Terima Gabung
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('siswa.proyek.member.reject', ['id' => $project->id, 'userId' => $pm->id]) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menolak pengajuan calon anggota ini?')">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-neutral-300 dark:border-neutral-700 hover:bg-rose-50 hover:text-rose-600 dark:hover:bg-rose-950/40 text-neutral-700 dark:text-neutral-300 transition-colors flex items-center gap-1 cursor-pointer">
                                                <x-icon name="x" class="w-3.5 h-3.5" />
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white">
                            Anggota Kolaborasi Tim Aktif ({{ $activeMembers->count() }})
                        </h3>
                        <p class="text-xs text-neutral-500">
                            Kolaborasi lintas jurusan resmi yang berpartisipasi dalam proyek ini.
                        </p>
                    </div>

                    <x-button :href="route('siswa.match')" variant="primary" size="sm" icon="cpu">
                        Cari Kolaborator di AI Match
                    </x-button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($activeMembers as $m)
                        <div class="p-4 rounded-xl border border-neutral-200 dark:border-[#2A2A2A] bg-neutral-50/60 dark:bg-[#141414] flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('siswa.profil', $m->id) }}" title="Lihat Profil {{ $m->name }}" class="w-10 h-10 rounded-lg bg-neutral-900 text-white dark:bg-white dark:text-neutral-900 font-bold text-xs flex items-center justify-center shrink-0 hover:opacity-85 transition-opacity">
                                    {{ strtoupper(substr($m->name, 0, 2)) }}
                                </a>
                                <div>
                                    <a href="{{ route('siswa.profil', $m->id) }}" class="text-sm font-bold text-neutral-900 dark:text-white hover:underline flex items-center gap-1">
                                        <span>{{ $m->name }}</span>
                                        <x-icon name="arrow-up-right" class="w-3 h-3 text-neutral-400 opacity-60" />
                                    </a>
                                    <span class="text-xs text-neutral-500 block">
                                        {{ $m->kelas ?? 'Siswa' }} &bull; {{ $m->jurusan->kode ?? 'SMK' }}
                                    </span>
                                    <span class="text-[11px] text-neutral-400 font-medium">
                                        {{ $m->pivot->role_in_project ?? 'Anggota' }}
                                    </span>
                                </div>
                            </div>

                            @if(($m->pivot->role_in_project ?? '') === 'Project Lead' || $m->id === $project->lead_id)
                                <x-badge variant="dark" size="xs">Lead</x-badge>
                            @else
                                <x-badge variant="neutral" size="xs">Member</x-badge>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-full py-8 text-center text-sm text-neutral-500">
                            Belum ada anggota yang resmi bergabung selain ketua proyek.
                        </div>
                    @endforelse
                </div>
            </x-card>

        @elseif($activeTab === 'file')
            <!-- File Tab -->
            <x-card padding="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white">
                            Berkas & Aset Kolaborasi ({{ $files->count() }})
                        </h3>
                        <p class="text-xs text-neutral-500">
                            File desain Figma, 3D model, video teaser, dan dokumentasi API.
                        </p>
                    </div>

                    @if($isActiveUser)
                        <button 
                            type="button"
                            onclick="document.getElementById('modalUnggahBerkas').showModal()"
                            class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold rounded-lg bg-neutral-900 text-white hover:bg-neutral-800 dark:bg-white dark:text-neutral-900 dark:hover:bg-neutral-100 transition-colors shadow-xs"
                        >
                            <x-icon name="plus" class="w-3.5 h-3.5" />
                            Unggah / Tautkan Aset
                        </button>
                    @endif
                </div>

                <div class="divide-y divide-neutral-200 dark:divide-[#262626]">
                    @forelse($files as $f)
                        <div class="py-3.5 flex items-center justify-between gap-3 text-sm">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-lg bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center text-neutral-600 dark:text-neutral-300 shrink-0">
                                    <x-icon name="file-text" class="w-4 h-4" />
                                </div>
                                <div class="min-w-0">
                                    <h5 class="font-bold text-neutral-900 dark:text-white truncate">
                                        {{ $f->name }}
                                    </h5>
                                    <span class="text-xs text-neutral-500">
                                        {{ $f->type }} &bull; {{ $f->size }} &bull; Diunggah oleh {{ $f->uploader->name ?? 'Anggota' }}
                                    </span>
                                </div>
                            </div>

                            @if($f->file_path && $f->file_path !== '#')
                                <a 
                                    href="{{ $f->file_path }}" 
                                    target="_blank" 
                                    class="px-3 py-1.5 rounded-lg border border-neutral-300 dark:border-neutral-700 text-xs font-semibold hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
                                >
                                    Buka Aset
                                </a>
                            @else
                                <span class="text-xs text-neutral-400">Tersimpan</span>
                            @endif
                        </div>
                    @empty
                        <div class="py-8 text-center">
                            <p class="text-sm text-neutral-500">Belum ada berkas aset tersimpan.</p>
                            <button 
                                onclick="document.getElementById('modalUnggahBerkas').showModal()"
                                class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-neutral-900 dark:text-white underline"
                            >
                                + Tautkan berkas desain / aset tim sekarang
                            </button>
                        </div>
                    @endforelse
                </div>
            </x-card>

        @elseif($activeTab === 'aktivitas')
            <!-- Aktivitas Tab -->
            <x-card padding="p-6">
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-6">
                    Log Aktivitas Proyek
                </h3>

                <div class="space-y-6 relative pl-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-neutral-200 dark:before:bg-neutral-800">
                    @forelse($activities as $act)
                        <div class="relative">
                            <span class="absolute -left-6 top-1 w-3 h-3 rounded-full bg-neutral-900 dark:bg-white border-2 border-white dark:border-[#181818]"></span>
                            <div class="text-sm">
                                <span class="font-bold text-neutral-900 dark:text-white">{{ $act->user->name ?? 'Anggota' }}</span>
                                <span class="text-neutral-500">{{ $act->action }}</span>
                                <span class="font-semibold text-neutral-800 dark:text-neutral-200">"{{ $act->target }}"</span>
                            </div>
                            <span class="text-xs text-neutral-400 mt-0.5 block">
                                {{ $act->created_at ? $act->created_at->diffForHumans() : 'Baru saja' }}
                            </span>
                        </div>
                    @empty
                        <div class="py-4 text-xs text-neutral-400">Belum ada aktivitas terekam.</div>
                    @endforelse
                </div>
            </x-card>

        @elseif($activeTab === 'chat')
            <!-- Chat Tab Interaktif -->
            <div class="max-w-4xl mx-auto">
                <div class="flex flex-col h-[560px] bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] rounded-xl overflow-hidden shadow-xs">
                    <!-- Chat Header -->
                    <div class="px-5 py-3.5 border-b border-neutral-200 dark:border-[#2A2A2A] flex items-center justify-between bg-neutral-50/50 dark:bg-[#151515]">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-neutral-900 text-white dark:bg-white dark:text-neutral-900 font-bold text-xs flex items-center justify-center">
                                <x-icon name="message-square" class="w-4 h-4" />
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-neutral-900 dark:text-white leading-tight">
                                    Ruang Diskusi: {{ $project->title }}
                                </h4>
                                <span class="text-[11px] text-neutral-500 dark:text-neutral-400 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    {{ $activeMembers->count() }} Anggota Tim Aktif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Container -->
                    <div class="flex-1 p-4 md:p-5 overflow-y-auto space-y-4 text-xs md:text-sm">
                        @forelse($messages as $msg)
                            @php 
                                $isMe = ($msg->user_id === 1); // Raka Pratama active student
                            @endphp
                            <div class="flex gap-3 {{ $isMe ? 'flex-row-reverse' : '' }}">
                                <div class="w-8 h-8 rounded-lg bg-neutral-200 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 font-bold text-xs flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($msg->user->name ?? 'User', 0, 2)) }}
                                </div>

                                <div class="max-w-[78%] space-y-1">
                                    <div class="flex items-center gap-2 {{ $isMe ? 'justify-end' : '' }}">
                                        <span class="font-bold text-xs text-neutral-900 dark:text-white">
                                            {{ $msg->user->name ?? 'Anggota' }}
                                        </span>
                                        <span class="text-[10px] text-neutral-400">
                                            {{ $msg->user->jurusan->kode ?? 'SMK' }} &bull; {{ $msg->created_at ? $msg->created_at->format('H:i') : 'Hari ini' }}
                                        </span>
                                    </div>

                                    <div class="p-3.5 rounded-xl {{ $isMe ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-tr-none shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-100 rounded-tl-none border border-slate-200/70 dark:border-slate-700/70' }} leading-relaxed">
                                        <p>{{ $msg->message }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center text-xs text-neutral-400">
                                Belum ada riwayat pesan. Kirim pesan pertama ke tim kolaborasi Anda di bawah!
                            </div>
                        @endforelse
                    </div>                    @if($isActiveUser)
                        <!-- Input Box Chat Form -->
                        <div class="p-3.5 border-t border-neutral-200 dark:border-[#2A2A2A] bg-white dark:bg-[#181818]">
                            <form action="{{ route('siswa.workspace.chat.send', $project->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <input 
                                    type="text" 
                                    name="message"
                                    required
                                    placeholder="Tulis pesan atau update tugas ke tim..." 
                                    class="flex-1 py-2.5 px-3.5 text-xs md:text-sm bg-neutral-100 dark:bg-[#141414] text-neutral-900 dark:text-white placeholder-neutral-400 rounded-lg border border-transparent focus:border-neutral-300 dark:focus:border-neutral-700 focus:outline-none focus:bg-white dark:focus:bg-[#111111] transition-all"
                                />

                                <button 
                                    type="submit" 
                                    class="inline-flex items-center gap-1.5 px-4 py-2.5 text-xs font-bold rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-md hover:shadow-blue-500/25 cursor-pointer shrink-0"
                                >
                                    <x-icon name="send" class="w-3.5 h-3.5" />
                                    Kirim
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="p-3.5 border-t border-neutral-200 dark:border-[#2A2A2A] bg-neutral-50 dark:bg-[#141414] text-center text-xs text-neutral-500 font-medium flex items-center justify-center gap-1.5">
                            <x-icon name="lock" class="w-3.5 h-3.5 text-amber-500 shrink-0" />
                            <span>Ruang diskusi tim hanya dapat diakses oleh ketua dan anggota resmi yang telah disetujui.</span>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL 1: Tambah Tugas Baru -->
    <!-- ========================================================================= -->
    <dialog id="modalTambahTugas" class="fixed inset-0 m-auto p-0 rounded-2xl bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] shadow-2xl backdrop:bg-black/60 max-w-lg w-[92vw] sm:w-full overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between pb-4 border-b border-neutral-100 dark:border-[#262626]">
                <div>
                    <h3 class="text-base font-bold text-neutral-900 dark:text-white">
                        Tambah Tugas Proyek Baru
                    </h3>
                    <p class="text-xs text-neutral-500">
                        Tetapkan butir pengerjaan untuk anggota tim lintas jurusan.
                    </p>
                </div>
                <button onclick="document.getElementById('modalTambahTugas').close()" class="text-neutral-400 hover:text-neutral-900 dark:hover:text-white text-lg font-bold">
                    &times;
                </button>
            </div>

            <form action="{{ route('siswa.workspace.task.store', $project->id) }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                        Judul Tugas <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        required 
                        placeholder="Contoh: Slicing UI Dashboard ke Blade & Tailwind" 
                        class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:border-neutral-900"
                    />
                </div>

                <div>
                    <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                        Deskripsi / Kriteria Capaian
                    </label>
                    <textarea 
                        name="description" 
                        rows="2" 
                        placeholder="Jelaskan kebutuhan teknis dan standar hasil tugas..." 
                        class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:border-neutral-900"
                    ></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                            Penanggung Jawab (PJ)
                        </label>
                        <select 
                            name="assignee_id" 
                            class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white"
                        >
                            @if($project->lead)
                                <option value="{{ $project->lead->id }}">{{ $project->lead->name }} (Ketua - {{ $project->lead->jurusan->kode ?? 'SMK' }})</option>
                            @endif
                            @foreach($activeMembers->where('id', '!=', $project->lead_id) as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->jurusan->kode ?? 'SMK' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                            Prioritas
                        </label>
                        <select 
                            name="priority" 
                            class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white"
                        >
                            <option value="Normal">Normal</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Tinggi">Tinggi</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                            Tenggat / Due Text
                        </label>
                        <input 
                            type="text" 
                            name="due_text" 
                            value="3 Hari Lagi" 
                            placeholder="Contoh: 3 Hari Lagi" 
                            class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white"
                        />
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                            Tanggal Target
                        </label>
                        <input 
                            type="date" 
                            name="due_date" 
                            value="{{ date('Y-m-d', strtotime('+7 days')) }}" 
                            class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white"
                        />
                    </div>
                </div>

                <div class="pt-4 border-t border-neutral-100 dark:border-[#262626] flex items-center justify-end gap-2">
                    <button 
                        type="button" 
                        onclick="document.getElementById('modalTambahTugas').close()"
                        class="px-4 py-2 text-xs font-bold text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 text-xs font-bold rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-md hover:shadow-blue-500/25 cursor-pointer"
                    >
                        Simpan Tugas Baru
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- ========================================================================= -->
    <!-- MODAL 2: Unggah Berkas & Tautkan Aset -->
    <!-- ========================================================================= -->
    <dialog id="modalUnggahBerkas" class="fixed inset-0 m-auto p-0 rounded-2xl bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] shadow-2xl backdrop:bg-black/60 max-w-lg w-[92vw] sm:w-full overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between pb-4 border-b border-neutral-100 dark:border-[#262626]">
                <div>
                    <h3 class="text-base font-bold text-neutral-900 dark:text-white">
                        Unggah / Tautkan Aset Kolaborasi
                    </h3>
                    <p class="text-xs text-neutral-500">
                        Bagikan link Figma, repository GitHub, file 3D, atau deliverable tim.
                    </p>
                </div>
                <button onclick="document.getElementById('modalUnggahBerkas').close()" class="text-neutral-400 hover:text-neutral-900 dark:hover:text-white text-lg font-bold">
                    &times;
                </button>
            </div>

            <form action="{{ route('siswa.workspace.file.store', $project->id) }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                        Nama Berkas / Judul Aset <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        required 
                        placeholder="Contoh: Figma UI High-Fidelity v2.1" 
                        class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none"
                    />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                            Kategori Aset
                        </label>
                        <select 
                            name="type" 
                            class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white"
                        >
                            <option value="Desain UI/UX (Figma)">Desain UI/UX (Figma)</option>
                            <option value="Asset 3D & Animasi">Asset 3D & Animasi</option>
                            <option value="Source Code (GitHub)">Source Code (GitHub)</option>
                            <option value="Video & Teaser (BCF)">Video & Teaser (BCF)</option>
                            <option value="Dokumen Spesifikasi">Dokumen Spesifikasi</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                            Estimasi Ukuran
                        </label>
                        <input 
                            type="text" 
                            name="size" 
                            value="Cloud Link" 
                            placeholder="Contoh: 18 MB / Cloud Link" 
                            class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white"
                        />
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                        Tautan URL Berkas (Figma / GitHub / Drive)
                    </label>
                    <input 
                        type="url" 
                        name="file_path" 
                        placeholder="https://figma.com/... atau https://github.com/..." 
                        class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none"
                    />
                </div>

                <div class="pt-4 border-t border-neutral-100 dark:border-[#262626] flex items-center justify-end gap-2">
                    <button 
                        type="button" 
                        onclick="document.getElementById('modalUnggahBerkas').close()"
                        class="px-4 py-2 text-xs font-bold text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 text-xs font-bold rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-md hover:shadow-blue-500/25 cursor-pointer"
                    >
                        Simpan Aset
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    @if(!$isActiveUser && !$isPendingUser)
    <!-- MODAL 3: Ajukan Gabung Langsung dari Pratinjau Workspace -->
    <dialog id="modalJoinWorkspace" class="fixed inset-0 m-auto p-0 rounded-2xl bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] shadow-2xl backdrop:bg-black/60 max-w-md w-[92vw] sm:w-full overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between pb-4 border-b border-neutral-100 dark:border-[#262626]">
                <div>
                    <h3 class="text-base font-bold text-neutral-900 dark:text-white">
                        Ajukan Gabung Kolaborasi
                    </h3>
                    <p class="text-xs text-neutral-500 font-medium truncate max-w-xs mt-0.5">
                        {{ $project->title }}
                    </p>
                </div>
                <button onclick="document.getElementById('modalJoinWorkspace').close()" class="text-neutral-400 hover:text-neutral-900 dark:hover:text-white text-lg font-bold">
                    &times;
                </button>
            </div>

            <form action="{{ route('siswa.proyek.join', $project->id) }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-1.5">
                        Posisi / Keahlian yang Diajukan <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="role_in_project" 
                        required 
                        placeholder="Contoh: UI/UX Designer, Backend Dev, 3D Animator"
                        class="w-full px-3.5 py-2.5 text-xs bg-neutral-50 dark:bg-[#141414] text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-700 rounded-lg focus:outline-none focus:border-neutral-900"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-1.5">
                        Pesan Singkat Pengajuan (Opsional)
                    </label>
                    <textarea 
                        name="join_message" 
                        rows="3" 
                        placeholder="Jelaskan keahlian yang dapat Anda berikan untuk kolaborasi tim ini..."
                        class="w-full px-3.5 py-2.5 text-xs bg-neutral-50 dark:bg-[#141414] text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-700 rounded-lg focus:outline-none focus:border-neutral-900 leading-relaxed"
                    ></textarea>
                </div>

                <div class="pt-3 border-t border-neutral-100 dark:border-[#262626] flex items-center justify-end gap-2">
                    <button 
                        type="button" 
                        onclick="document.getElementById('modalJoinWorkspace').close()"
                        class="px-4 py-2 text-xs font-semibold text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 text-xs font-bold rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-md hover:shadow-blue-500/25 cursor-pointer"
                    >
                        Kirim Pengajuan Gabung
                    </button>
                </div>
            </form>
        </div>
    </dialog>
    @endif
    @endif

    @push('scripts')
    <script>
        document.addEventListener('click', function(e) {
            const container = document.getElementById('workspaceSwitcherDropdown');
            if (container) {
                const details = container.querySelector('details');
                if (details && details.open && !container.contains(e.target)) {
                    details.removeAttribute('open');
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
