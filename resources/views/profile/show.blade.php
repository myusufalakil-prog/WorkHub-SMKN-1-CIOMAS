<x-app-layout current="profil" pageTitle="Profil Siswa Kolaborator">
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Profile Header Card -->
        <x-card padding="p-6 md:p-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 pb-6 border-b border-neutral-100 dark:border-[#262626]">
                <div class="flex items-center gap-5">
                    <!-- Avatar with initials -->
                    <div class="w-20 h-20 rounded-2xl bg-neutral-900 text-white dark:bg-white dark:text-neutral-950 font-extrabold text-2xl flex items-center justify-center shrink-0 shadow-md">
                        {{ strtoupper(substr($student->name ?? 'User', 0, 2)) }}
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-2xl font-extrabold tracking-tight text-neutral-900 dark:text-white">
                                {{ $student->name ?? 'Raka Pratama' }}
                            </h1>
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 dark:bg-emerald-950/60 dark:text-emerald-300 px-2 py-0.5 rounded-full border border-emerald-200 dark:border-emerald-800">
                                <x-icon name="check" class="w-3 h-3" /> Terverifikasi
                            </span>
                        </div>

                        <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mt-0.5">
                            {{ $student->kelas ?? 'Siswa' }} &bull; {{ $student->jurusan->nama_lengkap ?? 'SMK' }}
                        </p>

                        <p class="text-xs text-neutral-400 mt-0.5">
                            {{ $student->email ?? 'siswa@gmail.com' }} &bull; {{ $student->jabatan ?? 'Siswa Kolaborator' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 self-stretch sm:self-auto">
                    <x-button variant="secondary" size="sm" icon="message-square" class="flex-1 sm:flex-none justify-center">
                        Kirim Pesan
                    </x-button>
                    <x-button variant="primary" size="sm" icon="plus" class="flex-1 sm:flex-none justify-center">
                        Ajak Kolaborasi
                    </x-button>
                </div>
            </div>

            <!-- Bio -->
            <div class="mt-6">
                <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400 block mb-1">
                    Tentang / Bio
                </span>
                <p class="text-sm text-neutral-700 dark:text-neutral-300 leading-relaxed max-w-3xl">
                    {{ $student->bio ?? 'Siswa aktif berkolaborasi dalam proyek lintas jurusan di SMK.' }}
                </p>
            </div>

            <!-- Skills List (Pill badges as requested) -->
            <div class="mt-6 pt-5 border-t border-neutral-100 dark:border-[#262626]">
                <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400 block mb-2.5">
                    Skills & Kompetensi
                </span>
                <div class="flex flex-wrap gap-2">
                    @forelse($student->skills as $skill)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-neutral-100 dark:bg-[#202020] text-neutral-800 dark:text-neutral-200 border border-neutral-200 dark:border-neutral-700">
                            {{ $skill->name }}
                        </span>
                    @empty
                        <span class="text-xs text-neutral-400">Belum ada skill ditambahkan.</span>
                    @endforelse
                </div>
            </div>
        </x-card>

        <!-- 2 Columns: Project yang Diikuti & Achievement -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Project Partisipasi -->
            <x-card padding="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                        <x-icon name="folder-kanban" class="w-4 h-4 text-neutral-500" />
                        Proyek Kolaborasi
                    </h3>
                    <span class="text-xs text-neutral-500 font-medium">
                        {{ $student->projectsJoined->count() + $student->projectsLed->count() }} Proyek Diikuti
                    </span>
                </div>

                <div class="divide-y divide-neutral-100 dark:divide-[#262626]">
                    @foreach($student->projectsLed as $pl)
                        <div class="py-3">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-bold text-neutral-900 dark:text-white">{{ $pl->title }}</h4>
                                <x-badge variant="neutral" size="xs">Lead</x-badge>
                            </div>
                            <span class="text-xs text-neutral-500 mt-0.5 block">Status: {{ $pl->status }} &bull; {{ $pl->jurusan_label }}</span>
                        </div>
                    @endforeach

                    @foreach($student->projectsJoined as $pj)
                        <div class="py-3">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-bold text-neutral-900 dark:text-white">{{ $pj->title }}</h4>
                                <x-badge variant="outline" size="xs">Member</x-badge>
                            </div>
                            <span class="text-xs text-neutral-500 mt-0.5 block">Role: {{ $pj->pivot->role_in_project ?? 'Anggota' }}</span>
                        </div>
                    @endforeach
                </div>
            </x-card>

            <!-- Prestasi / Achievement -->
            <x-card padding="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                        <x-icon name="award" class="w-4 h-4 text-neutral-500" />
                        Prestasi & Sertifikasi
                    </h3>
                    <span class="text-xs text-neutral-500 font-medium">{{ $student->achievements->count() }} Prestasi</span>
                </div>

                <div class="divide-y divide-neutral-100 dark:divide-[#262626]">
                    @forelse($student->achievements as $ach)
                        <div class="py-3">
                            <h4 class="text-sm font-bold text-neutral-900 dark:text-white">
                                {{ $ach->title }}
                            </h4>
                            <span class="text-xs text-neutral-500 mt-0.5 block">
                                {{ $ach->issuer }} &bull; {{ $ach->year }}
                            </span>
                        </div>
                    @empty
                        <div class="py-3 text-xs text-neutral-400">Belum ada prestasi tercatat.</div>
                    @endforelse
                </div>
            </x-card>
        </div>

        <!-- Portfolio Showcase -->
        <x-card padding="p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                        <x-icon name="sparkles" class="w-4 h-4 text-neutral-500" />
                        Portofolio Unggulan
                    </h3>
                    <p class="text-xs text-neutral-500">
                        Hasil karya nyata yang telah divalidasi pembimbing.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @forelse($student->portfolios as $port)
                    <div class="p-4 rounded-xl border border-neutral-200 dark:border-[#2A2A2A] bg-neutral-50/50 dark:bg-[#151515] flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between text-xs text-neutral-400 mb-2">
                                <span>{{ $port->category }}</span>
                                <span>{{ $port->year }}</span>
                            </div>
                            <h4 class="text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                                {{ $port->title }}
                            </h4>
                            <p class="text-xs text-neutral-600 dark:text-neutral-400 leading-relaxed">
                                {{ $port->desc }}
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-neutral-200/60 dark:border-neutral-800 flex items-center justify-between text-xs">
                            <span class="font-medium text-neutral-500">Validasi Guru</span>
                            <x-icon name="check" class="w-3.5 h-3.5 text-emerald-600" />
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-4 text-xs text-neutral-400">Belum ada portofolio diunggah.</div>
                @endforelse
            </div>
        </x-card>
    </div>
</x-app-layout>
