<x-app-layout current="profil" role="siswa" pageTitle="Profil Siswa Kolaborator">
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Profile Header Card -->
        <x-card padding="p-6 md:p-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 pb-6 border-b border-neutral-100 dark:border-[#262626]">
                <div class="flex items-center gap-5">
                    <!-- Avatar with initials -->
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-extrabold text-2xl flex items-center justify-center shrink-0 shadow-lg shadow-blue-500/25">
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
                            {{ $student->email ?? 'siswa@gmail.com' }} &bull; {{ $student->jabatan ?? 'Anggota Kolaborasi' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 self-stretch sm:self-auto">
                    <button 
                        type="button"
                        onclick="document.getElementById('modalEditProfil').showModal()"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-3.5 py-2 text-xs font-bold rounded-lg border border-neutral-300 dark:border-neutral-700 text-neutral-800 dark:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors shadow-xs"
                    >
                        <x-icon name="edit" class="w-3.5 h-3.5" />
                        Edit Biodata
                    </button>
                    <button 
                        type="button"
                        onclick="document.getElementById('modalTambahPorto').showModal()"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-3.5 py-2 text-xs font-bold rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-xs cursor-pointer"
                    >
                        <x-icon name="plus" class="w-3.5 h-3.5" />
                        Tambah Karya
                    </button>
                </div>
            </div>

            <!-- Bio -->
            <div class="mt-6">
                <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400 block mb-1">
                    Tentang / Bio Siswa
                </span>
                <p class="text-sm text-neutral-700 dark:text-neutral-300 leading-relaxed max-w-3xl">
                    {{ $student->bio ?? 'Siswa aktif berkolaborasi dalam proyek lintas jurusan di SMK.' }}
                </p>
            </div>

            <!-- Skills List & Form Tambah Skill -->
            <div class="mt-6 pt-5 border-t border-neutral-100 dark:border-[#262626]">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400 block">
                        Skills & Kompetensi Keahlian
                    </span>

                    <!-- Form Tambah Skill Cepat -->
                    <form action="{{ route('siswa.skill.store') }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        <input 
                            type="text" 
                            name="skill_name" 
                            required
                            placeholder="Ketik skill (cth: Blender 3D, Figma)..." 
                            class="text-xs px-2.5 py-1 rounded-md bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none"
                        />
                        <button 
                            type="submit" 
                            class="px-2.5 py-1 text-xs font-bold rounded-md bg-blue-600 hover:bg-blue-700 text-white transition-colors cursor-pointer"
                        >
                            + Tambah
                        </button>
                    </form>
                </div>

                <div class="flex flex-wrap gap-2">
                    @forelse($student->skills as $skill)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-neutral-100 dark:bg-[#202020] text-neutral-800 dark:text-neutral-200 border border-neutral-200 dark:border-neutral-700">
                            {{ $skill->name }}
                        </span>
                    @empty
                        <span class="text-xs text-neutral-400">Belum ada skill ditambahkan. Tambahkan skill keahlian Anda di atas.</span>
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
                                <a href="{{ route('siswa.workspace', $pl->id) }}" class="text-sm font-bold text-neutral-900 dark:text-white hover:underline">
                                    {{ $pl->title }}
                                </a>
                                <x-badge variant="neutral" size="xs">Lead</x-badge>
                            </div>
                            <span class="text-xs text-neutral-500 mt-0.5 block">Status: {{ $pl->status }} &bull; {{ $pl->jurusan_label }}</span>
                        </div>
                    @endforeach

                    @foreach($student->projectsJoined as $pj)
                        <div class="py-3">
                            <div class="flex items-center justify-between">
                                <a href="{{ route('siswa.workspace', $pj->id) }}" class="text-sm font-bold text-neutral-900 dark:text-white hover:underline">
                                    {{ $pj->title }}
                                </a>
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
                        Portofolio Karya Siswa
                    </h3>
                    <p class="text-xs text-neutral-500">
                        Hasil karya nyata yang diajukan untuk divalidasi guru pembimbing.
                    </p>
                </div>

                <button 
                    onclick="document.getElementById('modalTambahPorto').showModal()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-xs cursor-pointer"
                >
                    <x-icon name="plus" class="w-3.5 h-3.5" />
                    Tambah Portofolio
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @forelse($student->portfolios as $port)
                    <div class="p-4 rounded-xl border border-neutral-200 dark:border-[#2A2A2A] bg-neutral-50/50 dark:bg-[#151515] flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between text-xs text-neutral-400 mb-2">
                                <span class="font-semibold text-neutral-700 dark:text-neutral-300">{{ $port->category }}</span>
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
                            <span class="font-medium text-neutral-500">Status Validasi</span>
                            @if($port->verified_by_guru_id)
                                <span class="text-emerald-600 dark:text-emerald-400 font-bold flex items-center gap-1">
                                    <x-icon name="check" class="w-3.5 h-3.5 stroke-[3]" /> Terverifikasi
                                </span>
                            @else
                                <span class="text-amber-600 dark:text-amber-400 font-medium">
                                    Menunggu Guru
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-8 text-xs text-neutral-400">
                        Belum ada karya portofolio. Klik tombol "Tambah Portofolio" di atas untuk menambahkan karya Anda.
                    </div>
                @endforelse
            </div>
        </x-card>
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL 1: Edit Profil Biodata -->
    <!-- ========================================================================= -->
    <dialog id="modalEditProfil" class="fixed inset-0 m-auto p-0 rounded-2xl bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] shadow-2xl backdrop:bg-black/60 max-w-md w-[92vw] sm:w-full overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between pb-4 border-b border-neutral-100 dark:border-[#262626]">
                <div>
                    <h3 class="text-base font-bold text-neutral-900 dark:text-white">
                        Edit Biodata Profil Siswa
                    </h3>
                    <p class="text-xs text-neutral-500">
                        Perbarui informasi kelas, minat, dan bio kolaborasi Anda.
                    </p>
                </div>
                <button onclick="document.getElementById('modalEditProfil').close()" class="text-neutral-400 hover:text-neutral-900 dark:hover:text-white text-lg font-bold">
                    &times;
                </button>
            </div>

            <form action="{{ route('siswa.profil.update') }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                            Kelas
                        </label>
                        <input 
                            type="text" 
                            name="kelas" 
                            value="{{ $student->kelas ?? 'XI PPLG 1' }}" 
                            class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white"
                        />
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                            Email Akun Gmail
                        </label>
                        <input 
                            type="email" 
                            disabled 
                            value="{{ $student->email }}" 
                            class="w-full text-xs p-2.5 rounded-lg bg-neutral-100 dark:bg-[#202020] border border-neutral-300 dark:border-neutral-700 text-neutral-500 cursor-not-allowed"
                        />
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                        Jabatan / Fokus Peran
                    </label>
                    <input 
                        type="text" 
                        name="jabatan" 
                        value="{{ $student->jabatan ?? 'Frontend & Game Developer' }}" 
                        placeholder="Contoh: UI/UX & Motion Graphic Designer"
                        class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white"
                    />
                </div>

                <div>
                    <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                        Bio Singkat
                    </label>
                    <textarea 
                        name="bio" 
                        rows="3" 
                        class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none"
                    >{{ $student->bio }}</textarea>
                </div>

                <div class="pt-4 border-t border-neutral-100 dark:border-[#262626] flex items-center justify-end gap-2">
                    <button 
                        type="button" 
                        onclick="document.getElementById('modalEditProfil').close()"
                        class="px-4 py-2 text-xs font-bold text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 text-xs font-bold rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-sm cursor-pointer"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- ========================================================================= -->
    <!-- MODAL 2: Tambah Portofolio -->
    <!-- ========================================================================= -->
    <dialog id="modalTambahPorto" class="fixed inset-0 m-auto p-0 rounded-2xl bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] shadow-2xl backdrop:bg-black/60 max-w-md w-[92vw] sm:w-full overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between pb-4 border-b border-neutral-100 dark:border-[#262626]">
                <div>
                    <h3 class="text-base font-bold text-neutral-900 dark:text-white">
                        Tambah Karya Portofolio
                    </h3>
                    <p class="text-xs text-neutral-500">
                        Ajukan karya digital Anda agar divalidasi guru pembimbing.
                    </p>
                </div>
                <button onclick="document.getElementById('modalTambahPorto').close()" class="text-neutral-400 hover:text-neutral-900 dark:hover:text-white text-lg font-bold">
                    &times;
                </button>
            </div>

            <form action="{{ route('siswa.portofolio.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                        Judul Karya / Proyek <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        required 
                        placeholder="Contoh: Skenik Virtual Tour 3D & Web Hub" 
                        class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none"
                    />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                            Kategori Karya
                        </label>
                        <select 
                            name="category" 
                            class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white"
                        >
                            <option value="UI/UX & Web Dev">UI/UX & Web Dev</option>
                            <option value="Asset 3D & Animasi">Asset 3D & Animasi</option>
                            <option value="Video & Sinematografi">Video & Sinematografi</option>
                            <option value="Jaringan & IoT">Jaringan & IoT</option>
                            <option value="Brand Identity & Ilustrasi">Brand Identity & Ilustrasi</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                            Tahun Pembuatan
                        </label>
                        <input 
                            type="text" 
                            name="year" 
                            value="2026" 
                            class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white"
                        />
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                        Deskripsi Karya <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="desc" 
                        rows="3" 
                        required
                        placeholder="Jelaskan peran Anda, teknologi yang dipakai, dan hasil karya..."
                        class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none"
                    ></textarea>
                </div>

                <div class="pt-4 border-t border-neutral-100 dark:border-[#262626] flex items-center justify-end gap-2">
                    <button 
                        type="button" 
                        onclick="document.getElementById('modalTambahPorto').close()"
                        class="px-4 py-2 text-xs font-bold text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 text-xs font-bold rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-sm cursor-pointer"
                    >
                        Simpan Karya
                    </button>
                </div>
            </form>
        </div>
    </dialog>
</x-app-layout>
