<x-app-layout current="proyek" role="siswa" pageTitle="Daftar Proyek Kolaborasi">
    <!-- Header with Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-200 dark:border-[#222222]">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white">
                Proyek Kolaborasi SMKN 1 Ciomas
            </h1>
            <p class="text-xs md:text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                Eksplorasi karya lintas 5 kejuruan SMKN 1 Ciomas, ajukan diri bergabung dengan tim, atau inisiasi proyek baru.
            </p>
        </div>

        <x-button :href="route('siswa.proyek.create')" variant="primary" size="md" icon="plus">
            Buat Proyek
        </x-button>
    </div>

    <!-- Filter Bar (Themed pill buttons for Jurusan) -->
    <div class="my-6 space-y-4">
        <!-- Jurusan Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs">
            <span class="text-neutral-400 font-bold mr-1 shrink-0">Jurusan:</span>
            <a 
                href="{{ route('siswa.proyek.index', ['jurusan' => 'Semua', 'status' => $statusFilter, 'q' => $search]) }}"
                class="px-3.5 py-1.5 rounded-full font-bold transition-all shrink-0 {{ $jurusanFilter === 'Semua' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-xs' : 'bg-white dark:bg-[#181818] text-neutral-700 dark:text-neutral-300 border border-neutral-200 dark:border-[#2A2A2A] hover:border-blue-400' }}"
            >
                Semua Jurusan
            </a>
            @foreach($jurusans as $j)
                @php
                    $isJSelected = $jurusanFilter === $j->kode;
                @endphp
                <a 
                    href="{{ route('siswa.proyek.index', ['jurusan' => $j->kode, 'status' => $statusFilter, 'q' => $search]) }}"
                    class="px-3 py-1.5 rounded-full font-bold transition-all shrink-0 {{ $isJSelected ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-xs' : 'bg-white dark:bg-[#181818] text-neutral-700 dark:text-neutral-300 border border-neutral-200 dark:border-[#2A2A2A] hover:border-blue-400' }}"
                >
                    {{ $j->kode }}
                </a>
            @endforeach
        </div>

        <!-- Secondary Filters & Search -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
            <!-- Status Filter -->
            <div class="flex items-center gap-1.5 text-xs w-full sm:w-auto overflow-x-auto">
                <span class="text-neutral-400 font-bold mr-1 shrink-0">Status:</span>
                @foreach(['Semua', 'Open Recruitment', 'Sedang Berjalan', 'Selesai'] as $st)
                    <a 
                        href="{{ route('siswa.proyek.index', ['status' => $st, 'jurusan' => $jurusanFilter, 'q' => $search]) }}"
                        class="px-3 py-1 rounded-full text-xs font-semibold transition-all shrink-0 {{ $statusFilter === $st ? 'bg-blue-50 text-blue-700 dark:bg-blue-950/80 dark:text-blue-300 font-bold border border-blue-200 dark:border-blue-800' : 'text-neutral-500 hover:text-neutral-900 dark:hover:text-white' }}"
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

    <!-- Project Cards Grid with Apply Feature -->
    @if($projects->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($projects as $p)
                @php
                    $userId = auth()->id();
                    $isLead = ($p->lead_id === $userId) || (auth()->user()?->role === 'admin');
                    $memberRecord = $p->members->firstWhere('id', $userId);
                    $isActiveMember = $memberRecord && ($memberRecord->pivot->status === 'active');
                    $isPendingMember = $memberRecord && ($memberRecord->pivot->status === 'pending');
                    $activeCount = $p->activeMembers ? $p->activeMembers->count() : $p->members->where('pivot.status', 'active')->count();
                    $progressColor = match(true) {
                        $p->progress >= 100 => 'from-emerald-500 to-teal-500',
                        $p->progress >= 60 => 'from-blue-600 via-indigo-500 to-purple-600',
                        $p->progress >= 30 => 'from-amber-500 to-orange-500',
                        default => 'from-neutral-500 to-neutral-400',
                    };
                @endphp
                <div class="flex flex-col justify-between rounded-2xl border border-neutral-200/80 dark:border-[#262626] bg-white dark:bg-[#161616] p-5 md:p-6 shadow-xs hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-lg transition-all">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200 dark:border-blue-800 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                {{ $p->jurusan_label }}
                            </span>
                            @if($p->status === 'Open Recruitment')
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Recruiting
                                </span>
                            @elseif($p->status === 'Selesai')
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-full bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-700">
                                    <x-icon name="check" class="w-3 h-3 text-emerald-500 stroke-[3]" />
                                    Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                    Aktif
                                </span>
                            @endif
                        </div>

                        <h3 class="text-base sm:text-lg font-bold text-neutral-950 dark:text-white line-clamp-1">
                            {{ $p->title }}
                        </h3>

                        <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 mt-2 line-clamp-2 leading-relaxed">
                            {{ $p->description }}
                        </p>

                        <!-- Progress Bar with Gradient -->
                        <div class="mt-4 pt-3 border-t border-neutral-100 dark:border-[#222222]">
                            <div class="flex justify-between text-xs font-semibold mb-1.5">
                                <span class="text-neutral-400">Progress PBL</span>
                                <span class="text-neutral-800 dark:text-neutral-200">{{ $p->progress }}%</span>
                            </div>
                            <div class="w-full h-2 bg-neutral-100 dark:bg-[#202020] rounded-full overflow-hidden p-0.5 border border-neutral-200/60 dark:border-neutral-800">
                                <div class="h-full bg-gradient-to-r {{ $progressColor }} rounded-full transition-all duration-500" style="width: {{ $p->progress }}%"></div>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center justify-between text-xs text-neutral-500 dark:text-neutral-400">
                            <span>Anggota Tim: <strong class="text-neutral-800 dark:text-neutral-200">{{ $activeCount }} / {{ $p->target_members }}</strong></span>
                            <span>Ketua: <strong class="text-neutral-800 dark:text-neutral-200">{{ $p->lead->name ?? 'Siswa' }}</strong></span>
                        </div>
                    </div>

                    <div class="mt-5 pt-3 border-t border-neutral-100 dark:border-[#222222] flex items-center gap-2">
                        @if($isLead)
                            <a 
                                href="{{ route('siswa.workspace', $p->id) }}" 
                                class="w-full inline-flex items-center justify-center gap-2 py-2 px-3 rounded-xl text-xs font-bold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-md shadow-blue-500/20"
                            >
                                <x-icon name="briefcase" class="w-3.5 h-3.5" />
                                <span>Kelola Workspace (Ketua)</span>
                            </a>
                        @elseif($isActiveMember)
                            <x-button :href="route('siswa.workspace', $p->id)" variant="secondary" size="sm" class="w-full justify-center" icon="briefcase">
                                Buka Workspace (Anggota)
                            </x-button>
                        @elseif($isPendingMember)
                            <div class="w-full py-2 px-3 rounded-lg bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 text-center">
                                <span class="text-xs font-semibold text-amber-700 dark:text-amber-300 flex items-center justify-center gap-1.5">
                                    <x-icon name="clock" class="w-3.5 h-3.5" />
                                    Menunggu Persetujuan Ketua
                                </span>
                            </div>
                        @else
                            <x-button :href="route('siswa.workspace', $p->id)" variant="secondary" size="sm" class="flex-1 justify-center">
                                Pratinjau
                            </x-button>

                            <button 
                                type="button"
                                onclick="bukaModalJoin('{{ $p->id }}', '{{ addslashes($p->title) }}')"
                                class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-lg bg-neutral-900 text-white hover:bg-neutral-800 dark:bg-white dark:text-black dark:hover:bg-neutral-100 transition-colors shadow-xs cursor-pointer"
                            >
                                <x-icon name="user-plus" class="w-3.5 h-3.5" />
                                Ajukan Gabung
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Standardized Empty State -->
        <x-empty-state 
            title="Belum ada proyek yang cocok"
            description="Tidak ada proyek dengan filter yang dipilih. Coba ganti kata kunci atau buat proyek baru."
            actionText="Buat Proyek Baru"
            :actionHref="route('siswa.proyek.create')"
        />
    @endif

    <!-- Modal Ajukan Bergabung (Apply to Project) -->
    <dialog id="modalJoinProject" class="fixed inset-0 m-auto p-0 rounded-2xl bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] shadow-2xl backdrop:bg-black/60 backdrop:backdrop-blur-xs max-w-md w-[92vw] sm:w-full overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between pb-4 border-b border-neutral-100 dark:border-[#262626]">
                <div>
                    <h3 class="text-base font-bold text-neutral-900 dark:text-white">
                        Ajukan Gabung Kolaborasi
                    </h3>
                    <p id="modalJoinTitle" class="text-xs text-neutral-500 font-medium truncate max-w-xs mt-0.5">
                        Nama Proyek
                    </p>
                </div>
                <button 
                    type="button" 
                    onclick="document.getElementById('modalJoinProject').close()" 
                    class="w-8 h-8 rounded-full flex items-center justify-center text-neutral-400 hover:text-neutral-900 hover:bg-neutral-100 dark:hover:bg-neutral-800 dark:hover:text-white transition-colors"
                >
                    <span class="text-lg leading-none">&times;</span>
                </button>
            </div>

            <form id="formJoinProject" method="POST" action="" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1.5">
                        Peran yang Anda Ajukan <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="role_in_project" 
                        class="w-full text-xs p-3 rounded-xl bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                    >
                        <option value="Software & Game Developer (PPLG)">Software & Game Developer (PPLG)</option>
                        <option value="3D & Character Animator (Animasi)">3D & Character Animator (Animasi)</option>
                        <option value="Sinematografi & Video Editor (BCF)">Sinematografi & Video Editor (BCF)</option>
                        <option value="Teknisi & Mekanik Otomotif (TO)">Teknisi & Mekanik Otomotif (TO)</option>
                        <option value="Fabrikasi & Pengelasan Logam (TPFL)">Fabrikasi & Pengelasan Logam (TPFL)</option>
                        <option value="Anggota Kolaborasi Tim">Anggota Kolaborasi Tim</option>
                    </select>
                </div>

                <div>
                    <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1.5">
                        Pesan Singkat ke Ketua Tim
                    </label>
                    <textarea 
                        name="join_message" 
                        rows="3" 
                        placeholder="Ceritakan keahlian Anda dan kontribusi yang ingin diberikan pada proyek ini..."
                        class="w-full text-xs p-3 rounded-xl bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 leading-relaxed transition-all resize-none"
                    ></textarea>
                </div>

                <div class="pt-4 border-t border-neutral-100 dark:border-[#262626] flex items-center justify-end gap-2.5">
                    <button 
                        type="button" 
                        onclick="document.getElementById('modalJoinProject').close()"
                        class="px-4 py-2.5 text-xs font-semibold rounded-xl text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 text-xs font-bold rounded-xl bg-neutral-900 text-white dark:bg-white dark:text-black hover:bg-neutral-800 dark:hover:bg-neutral-100 shadow-sm transition-all"
                    >
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        function bukaModalJoin(projectId, projectTitle) {
            document.getElementById('modalJoinTitle').innerText = projectTitle;
            document.getElementById('formJoinProject').action = '/siswa/proyek/' + projectId + '/join';
            const modal = document.getElementById('modalJoinProject');
            modal.showModal();
        }

        const modalJoin = document.getElementById('modalJoinProject');
        if (modalJoin) {
            modalJoin.addEventListener('click', function(e) {
                const rect = modalJoin.getBoundingClientRect();
                if (
                    e.clientX < rect.left ||
                    e.clientX > rect.right ||
                    e.clientY < rect.top ||
                    e.clientY > rect.bottom
                ) {
                    modalJoin.close();
                }
            });
        }
    </script>
</x-app-layout>
