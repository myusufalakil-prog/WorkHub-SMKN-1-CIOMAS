<x-guest-layout title="Platform Kolaborasi Talenta & Proyek Inovasi - SynapseHub">
    <!-- Ambient Gradient Background Lights -->
    <div class="relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[600px] pointer-events-none -z-10 overflow-hidden">
            <div class="absolute -top-32 left-1/4 w-96 h-96 bg-blue-500/15 dark:bg-blue-600/10 rounded-full blur-3xl"></div>
            <div class="absolute top-10 right-1/4 w-96 h-96 bg-purple-500/15 dark:bg-purple-600/10 rounded-full blur-3xl"></div>
            <div class="absolute top-40 left-1/2 -translate-x-1/2 w-[500px] h-72 bg-amber-500/10 dark:bg-amber-600/10 rounded-full blur-3xl"></div>
        </div>

        <!-- ========================================================================= -->
        <!-- 1. HERO SECTION -->
        <!-- ========================================================================= -->
        <section class="pt-12 md:pt-20 pb-16 md:pb-24 border-b border-neutral-200/80 dark:border-[#222222]">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <!-- Glowing Announcement Pill -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/80 dark:bg-[#181818]/90 border border-neutral-200 dark:border-neutral-700/80 text-xs font-semibold text-neutral-800 dark:text-neutral-200 mb-6 shadow-xs backdrop-blur-md">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Jaringan Kolaborasi & Talenta Terbuka &bull; <strong class="text-neutral-950 dark:text-white">SynapseHub</strong></span>
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-neutral-950 dark:text-white max-w-4xl mx-auto leading-[1.12]">
                    Connect. Collaborate. <br class="hidden sm:inline" />
                    <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-400 dark:via-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">
                        Create Together.
                    </span>
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-lg md:text-xl text-neutral-600 dark:text-neutral-400 max-w-3xl mx-auto mt-6 leading-relaxed">
                    Wadah terpadu kolaborasi karya dan proyek multidisiplin. Hubungkan talenta <strong>Software Engineering, Desain Kreatif, Multimedia, Rekayasa Teknik, dan Strategi Bisnis</strong> dalam proyek nyata berstandar industri.
                </p>

                <!-- Action Buttons -->
                <div class="mt-9 flex flex-wrap items-center justify-center gap-3.5">
                    @guest
                        <a 
                            href="{{ route('login') }}" 
                            class="inline-flex items-center gap-2.5 px-6 py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-md hover:shadow-lg hover:shadow-blue-500/25 hover:-translate-y-0.5 cursor-pointer"
                        >
                            <x-icon name="arrow-right" class="w-4 h-4" />
                            <span>Masuk ke Akun (Login)</span>
                        </a>

                        <a 
                            href="{{ route('register') }}" 
                            class="inline-flex items-center gap-2.5 px-6 py-3 rounded-xl text-sm font-bold bg-white text-blue-700 border-2 border-blue-600/70 hover:bg-blue-50 transition-all shadow-xs hover:-translate-y-0.5"
                        >
                            <x-icon name="user" class="w-4 h-4" />
                            <span>Daftar Talenta Baru</span>
                        </a>

                        <a 
                            href="{{ route('portal') }}" 
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl text-sm font-semibold border border-slate-300 bg-white/80 text-slate-700 hover:bg-slate-100 transition-all shadow-xs"
                        >
                            <span>Pilih Portal Peran &rarr;</span>
                        </a>
                    @else
                        <a 
                            href="{{ route('portal') }}" 
                            class="inline-flex items-center gap-2.5 px-8 py-3.5 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-md hover:shadow-lg hover:shadow-blue-500/25 hover:-translate-y-0.5 cursor-pointer"
                        >
                            <span>Buka Portal Dasbor</span>
                            <x-icon name="arrow-right" class="w-4 h-4" />
                        </a>
                    @endguest
                </div>

                <!-- Multidisciplinary Domain Interactive Cards Grid (Dynamic for all disciplines) -->
                <div class="mt-14 max-w-6xl mx-auto">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-xs uppercase font-extrabold tracking-widest text-neutral-400 dark:text-neutral-500">
                            {{ $jurusans->count() }} Pilar Domain & Disiplin Keahlian di SynapseHub
                        </p>
                        <a href="{{ route('projects.index') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">
                            Eksplorasi Semua &rarr;
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                        @foreach($jurusans as $j)
                            <a 
                                href="{{ route('projects.index', ['jurusan' => $j->kode]) }}"
                                class="p-3.5 rounded-xl bg-white/90 dark:bg-[#161616]/90 border border-neutral-200/80 dark:border-neutral-800/80 shadow-xs hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-md transition-all text-left group block"
                            >
                                <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-xs mb-2 group-hover:scale-110 transition-transform">
                                    <x-icon :name="$j->icon" class="w-4 h-4" />
                                </div>
                                <h4 class="text-xs font-extrabold text-neutral-900 dark:text-white tracking-wide">{{ $j->kode }}</h4>
                                <p class="text-[11px] text-neutral-500 dark:text-neutral-400 mt-0.5 line-clamp-1 leading-snug">{{ $j->nama_lengkap }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 2. VALUE STATS STRIP -->
        <!-- ========================================================================= -->
        <section class="py-8 bg-neutral-100/60 dark:bg-[#131313] border-b border-neutral-200/80 dark:border-[#222222]">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div>
                        <span class="text-2xl md:text-3xl font-extrabold text-neutral-950 dark:text-white">{{ $jurusans->count() }} Bidang</span>
                        <p class="text-xs text-neutral-500 mt-1">Sinergi Multidisiplin</p>
                    </div>
                    <div>
                        <span class="text-2xl md:text-3xl font-extrabold text-neutral-950 dark:text-white">100% Nyata</span>
                        <p class="text-xs text-neutral-500 mt-1">Inkubasi Proyek & Portofolio</p>
                    </div>
                    <div>
                        <span class="text-2xl md:text-3xl font-extrabold text-neutral-950 dark:text-white">Pencocokan Cerdas</span>
                        <p class="text-xs text-neutral-500 mt-1">Rekomendasi Partner Tim (AI)</p>
                    </div>
                    <div>
                        <span class="text-2xl md:text-3xl font-extrabold text-neutral-950 dark:text-white">Galeri Karya</span>
                        <p class="text-xs text-neutral-500 mt-1">Pameran Inovasi Terkurasi</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 3. ROLE PORTALS: 2 VIBRANT DEDICATED CARDS -->
        <!-- ========================================================================= -->
        <section class="py-16 md:py-24 bg-white dark:bg-[#0F0F0F] border-b border-neutral-200 dark:border-[#222222]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-14">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 block mb-1">
                        Gerbang Kerja Terstruktur
                    </span>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-neutral-950 dark:text-white">
                        Masuk ke Lingkungan Kerja Sesuai Peran
                    </h2>
                    <p class="text-xs md:text-sm text-neutral-600 dark:text-neutral-400 mt-2.5 leading-relaxed">
                        Dirancang khusus untuk kebutuhan kreator, pengembang, desainer, dan penyelenggara kegiatan komunitas dengan kontrol hak akses yang aman dan profesional.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 max-w-4xl mx-auto">
                    <!-- 1. Portal Talenta Card (Blue/Indigo Glow) -->
                    <div class="rounded-2xl border border-blue-200/80 dark:border-blue-900/40 bg-gradient-to-b from-blue-50/50 via-white to-white dark:from-blue-950/20 dark:via-[#161616] dark:to-[#161616] p-7 flex flex-col justify-between shadow-xs hover:shadow-xl hover:border-blue-400 dark:hover:border-blue-600 transition-all group">
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-bold shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform">
                                    <x-icon name="user" class="w-6 h-6" />
                                </div>
                                <span class="text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300">
                                    Talenta & Kreator
                                </span>
                            </div>

                            <h3 class="text-xl font-extrabold text-neutral-900 dark:text-white">
                                Portal Kolaborator
                            </h3>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2 leading-relaxed">
                                Ruang inisiasi proyek bersama, pengelolaan tugas tim, diskusi kelompok, dan pencarian rekan kolaborasi lewat fitur pencocokan cerdas.
                            </p>

                            <!-- Features List -->
                            <ul class="mt-5 space-y-2.5 text-xs text-neutral-700 dark:text-neutral-300 border-t border-neutral-100 dark:border-neutral-800/80 pt-4">
                                <li class="flex items-center gap-2">
                                    <x-icon name="check" class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0 stroke-[2.5]" />
                                    <span>Ruang kerja tim & manajemen tugas kolaboratif</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <x-icon name="check" class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0 stroke-[2.5]" />
                                    <span>Pencocokan talenta cerdas lintas 12 bidang keahlian</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <x-icon name="check" class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0 stroke-[2.5]" />
                                    <span>Portofolio karya & validasi keahlian terkurasi</span>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-8 pt-4 border-t border-neutral-100 dark:border-neutral-800">
                            <a 
                                href="{{ route('siswa.dashboard') }}"
                                class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-xs cursor-pointer"
                            >
                                <span>Buka Portal Kolaborator</span>
                                <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                            </a>
                        </div>
                    </div>

                    <!-- 2. Portal Penyelenggara Card (Amber/Orange Glow) -->
                    <div class="rounded-2xl border border-amber-200/80 dark:border-amber-900/40 bg-gradient-to-b from-amber-50/50 via-white to-white dark:from-amber-950/20 dark:via-[#161616] dark:to-[#161616] p-7 flex flex-col justify-between shadow-xs hover:shadow-xl hover:border-amber-400 dark:hover:border-amber-600 transition-all group">
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center font-bold shadow-md shadow-amber-500/20 group-hover:scale-105 transition-transform">
                                    <x-icon name="award" class="w-6 h-6" />
                                </div>
                                <span class="text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">
                                    Komunitas & Kurator
                                </span>
                            </div>

                            <h3 class="text-xl font-extrabold text-neutral-900 dark:text-white">
                                Portal Penyelenggara & Komunitas
                            </h3>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2 leading-relaxed">
                                Pusat koordinasi hackathon, tantangan inovasi, kurasi karya unggulan untuk galeri publik, dan siaran pengumuman.
                            </p>

                            <!-- Features List -->
                            <ul class="mt-5 space-y-2.5 text-xs text-neutral-700 dark:text-neutral-300 border-t border-neutral-100 dark:border-neutral-800/80 pt-4">
                                <li class="flex items-center gap-2">
                                    <x-icon name="check" class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0 stroke-[2.5]" />
                                    <span>Kurasi karya terbaik untuk Galeri Inovasi Publik</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <x-icon name="check" class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0 stroke-[2.5]" />
                                    <span>Manajemen Tantangan, Hackathon & Agenda Kegiatan</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <x-icon name="check" class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0 stroke-[2.5]" />
                                    <span>Siaran pengumuman ke seluruh jaringan talenta</span>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-8 pt-4 border-t border-neutral-100 dark:border-neutral-800">
                            <a 
                                href="{{ route('osis.dashboard') }}"
                                class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white transition-all shadow-xs cursor-pointer"
                            >
                                <span>Buka Portal Penyelenggara</span>
                                <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                            </a>
                        </div>
                </div>
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 4. LIVE PROJECT SHOWCASE SECTION -->
        <!-- ========================================================================= -->
        <section class="py-16 md:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-bold uppercase tracking-wider text-neutral-500">Inovasi Kolaboratif</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-neutral-950 dark:text-white">
                        Proyek Kolaborasi di SynapseHub
                    </h2>
                    <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                        Eksplorasi proyek nyata multidisiplin yang sedang aktif dibangun oleh komunitas talenta.
                    </p>
                </div>

                <a 
                    href="{{ route('siswa.proyek.index') }}" 
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold border border-neutral-300 dark:border-neutral-700 hover:bg-neutral-100 dark:hover:bg-[#181818] transition-colors shrink-0"
                >
                    <span>Lihat Semua Proyek</span>
                    <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                </a>
            </div>

            <!-- Project Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($projects as $p)
                    @php
                        $activeCount = $p->activeMembers ? $p->activeMembers->count() : $p->members->where('pivot.status', 'active')->count();
                    @endphp
                    <x-project-card 
                        :title="$p->title"
                        :jurusan="$p->jurusan_label ?: 'Kolaborasi Terbuka'"
                        :description="$p->description"
                        :tags="['Inovasi', $p->category]"
                        :members="$activeCount . ' / ' . $p->target_members"
                        :deadline="$p->deadline ? $p->deadline->format('d M Y') : '-'"
                        :progress="$p->progress"
                        :status="$p->status"
                        :href="route('siswa.workspace', $p->id)"
                    />
                @empty
                    <div class="col-span-full bg-white dark:bg-[#161616] border border-dashed border-neutral-300 dark:border-neutral-700 rounded-2xl p-10 text-center">
                        <div class="w-12 h-12 rounded-2xl bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center mx-auto mb-3 text-neutral-400">
                            <x-icon name="folder-kanban" class="w-6 h-6" />
                        </div>
                        <h3 class="text-sm font-bold text-neutral-900 dark:text-white">Belum Ada Proyek Publik</h3>
                        <p class="text-xs text-neutral-500 mt-1 max-w-sm mx-auto">Daftar sekarang di SynapseHub dan inisiasi proyek kolaborasi pertamamu.</p>
                        <div class="mt-4">
                            <x-button :href="route('register')" variant="primary" size="sm">
                                Mulai Proyek Pertama
                            </x-button>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- ========================================================================= -->
        <!-- 5. SYNAPSE MATCH SECTION -->
        <!-- ========================================================================= -->
        <section class="py-16 md:py-24 bg-neutral-100/70 dark:bg-[#131313] border-t border-neutral-200 dark:border-[#222222]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-neutral-900 dark:text-white bg-white dark:bg-[#1E1E1E] px-3 py-1 rounded-full border border-neutral-300 dark:border-neutral-700 mb-3 shadow-xs">
                            <x-icon name="cpu" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" />
                            <span>PENCOCOKAN REKAN (Pencarian Talenta Cerdas)</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-neutral-950 dark:text-white">
                            Temukan partner yang paling cocok untuk proyekmu.
                        </h2>
                        <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400 mt-1.5 max-w-2xl">
                            Algoritma pencocokan kompetensi multidisiplin yang menganalisis keahlian talenta untuk kolaborasi optimal.
                        </p>
                    </div>

                    <a 
                        href="{{ route('siswa.match') }}" 
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-neutral-950 text-white dark:bg-white dark:text-neutral-950 hover:bg-neutral-800 dark:hover:bg-neutral-100 transition-colors shrink-0 shadow-xs"
                    >
                        <span>Buka Pencocokan Rekan</span>
                        <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                    </a>
                </div>

                <!-- Candidates Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @forelse($candidates as $c)
                        <x-match-card 
                            :name="$c->name"
                            :classMajor="($c->institution ?? ($c->headline ?? 'Talenta')) . ' • ' . ($c->jurusan->kode ?? 'TECH')"
                            :score="95"
                            :skills="$c->skills->pluck('name')->all()"
                            :href="route('siswa.profil', $c->id)"
                        />
                    @empty
                        <div class="col-span-full bg-white dark:bg-[#181818] border border-dashed border-neutral-300 dark:border-neutral-700 rounded-2xl p-8 text-center text-xs text-neutral-500">
                            Belum ada talenta terdaftar. Ajak rekan-rekanmu bergabung dan bangun portofolio kolaborasi bersama!
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</x-guest-layout>
