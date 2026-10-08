<x-guest-layout title="Pilih Portal Peran - SMKN 1 Ciomas">
    <div class="relative overflow-hidden py-12 md:py-20">
        <!-- Ambient Background Glows -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[350px] bg-gradient-to-tr from-blue-600/15 via-purple-600/15 to-amber-500/15 blur-[120px] rounded-full pointer-events-none -z-10"></div>
        <div class="absolute bottom-10 left-10 w-72 h-72 bg-blue-500/10 blur-[100px] rounded-full pointer-events-none -z-10"></div>
        <div class="absolute bottom-10 right-10 w-72 h-72 bg-purple-500/10 blur-[100px] rounded-full pointer-events-none -z-10"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-12">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-neutral-900/5 dark:bg-white/10 border border-neutral-200/80 dark:border-white/10 text-xs font-semibold text-neutral-800 dark:text-neutral-200 mb-5 shadow-xs backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    <span>Gerbang Akses Multi-Role WORKHUB &bull; SMKN 1 Ciomas</span>
                </div>

                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-neutral-950 dark:text-white leading-tight">
                    Pilih Lingkungan Kerja Anda
                </h1>
                <p class="text-sm md:text-base text-neutral-600 dark:text-neutral-400 mt-3.5 leading-relaxed">
                    Setiap peran memiliki alur kerja, hak akses, dan halaman dashboard mandiri untuk mendukung kolaborasi antar 5 kejuruan SMKN 1 Ciomas secara profesional.
                </p>
            </div>

            @auth
                @if(auth()->user()->role === 'admin')
                    <div class="mb-10 p-5 rounded-2xl bg-neutral-950 text-white dark:bg-[#181818] border border-neutral-800 dark:border-[#282828] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xl">
                        <div class="flex items-start sm:items-center gap-3.5">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-black text-xs tracking-wider shrink-0 shadow-md">
                                ALL
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h2 class="text-sm font-bold text-white">Mode Akun All-Role (Super Administrator) Aktif</h2>
                                    <span class="px-2 py-0.5 text-[10px] uppercase font-black bg-white/20 text-white rounded-full backdrop-blur-sm">Akses Bebas Semua Portal</span>
                                </div>
                                <p class="text-xs text-neutral-400 mt-1">
                                    Anda login sebagai <strong>{{ auth()->user()->name }}</strong> (<span class="font-mono text-neutral-300">{{ auth()->user()->email }}</span>). Anda memiliki hak akses penuh untuk masuk ke Dashboard Siswa maupun OSIS kapan pun.
                                </p>
                            </div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="shrink-0 w-full sm:w-auto">
                            @csrf
                            <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl text-xs font-semibold bg-neutral-800 hover:bg-neutral-700 border border-neutral-700 text-neutral-200 hover:text-white transition-colors cursor-pointer">
                                Keluar Akun (Logout)
                            </button>
                        </form>
                    </div>
                @endif
            @else
                <div class="mb-10 p-4 sm:p-5 rounded-2xl bg-white/80 dark:bg-[#181818]/80 backdrop-blur-md border border-neutral-200/80 dark:border-[#282828] flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm">
                    <div class="flex items-center gap-3 text-center sm:text-left">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-sm">
                            <x-icon name="user" class="w-5 h-5" />
                        </div>
                        <div>
                            <h2 class="text-xs sm:text-sm font-bold text-neutral-900 dark:text-white">
                                Belum masuk ke akun WORKHUB?
                            </h2>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                Silakan masuk menggunakan email Gmail atau daftarkan akun siswa baru untuk mulai berkolaborasi.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                        <a 
                            href="{{ route('login') }}" 
                            class="flex-1 sm:flex-none px-4 py-2 text-center rounded-xl text-xs font-bold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-xs cursor-pointer"
                        >
                            Masuk (Login)
                        </a>
                        <a 
                            href="{{ route('register') }}" 
                            class="flex-1 sm:flex-none px-4 py-2 text-center rounded-xl text-xs font-bold border border-blue-600/70 text-blue-700 bg-white hover:bg-blue-50 transition-colors shadow-xs"
                        >
                            Daftar (Register)
                        </a>
                    </div>
                </div>
            @endauth

            <!-- 2 Role Portals Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 max-w-4xl mx-auto">
                <!-- 1. PORTAL SISWA -->
                <div class="relative rounded-2xl border border-neutral-200/80 dark:border-[#2A2A2A] bg-white/90 dark:bg-[#161616]/90 backdrop-blur-md p-6 sm:p-7 flex flex-col justify-between transition-all duration-300 hover:border-blue-500/80 hover:shadow-xl hover:-translate-y-1 group">
                    <div class="absolute -top-3 left-6">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-blue-50 dark:bg-blue-950/80 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800 shadow-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                            Portal Siswa
                        </span>
                    </div>

                    <div class="pt-2">
                        <div class="flex items-center justify-between mb-4 mt-2">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-800/50 flex items-center justify-center font-bold text-lg shadow-xs group-hover:scale-105 transition-transform">
                                <x-icon name="user" class="w-6 h-6" />
                            </div>
                        </div>

                        <h2 class="text-xl font-bold text-neutral-950 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            Portal Siswa
                        </h2>
                        <p class="text-xs font-semibold text-blue-600 dark:text-blue-400 mt-1">
                            PPLG &bull; BCF &bull; Animasi &bull; TO &bull; TPFL
                        </p>

                        <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-3 leading-relaxed">
                            Bangun portofolio karya industri, inisiasi proyek kolaborasi bersama, kerjakan tugas di workspace tim, dan temukan kolaborator lewat AI Match.
                        </p>

                        <!-- Fitur Utama Siswa -->
                        <div class="mt-6 pt-5 border-t border-neutral-100 dark:border-[#222222] space-y-2.5 text-xs">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-neutral-400 block mb-2">Fitur Utama:</span>
                            <div class="flex items-center gap-2 text-neutral-700 dark:text-neutral-300">
                                <x-icon name="check" class="w-3.5 h-3.5 text-blue-500 shrink-0 stroke-[2.5]" />
                                <span>Beranda & Tracking Proyek Siswa</span>
                            </div>
                            <div class="flex items-center gap-2 text-neutral-700 dark:text-neutral-300">
                                <x-icon name="check" class="w-3.5 h-3.5 text-blue-500 shrink-0 stroke-[2.5]" />
                                <span>Workspace Tim (Tugas, File, Chat Realtime)</span>
                            </div>
                            <div class="flex items-center gap-2 text-neutral-700 dark:text-neutral-300">
                                <x-icon name="check" class="w-3.5 h-3.5 text-blue-500 shrink-0 stroke-[2.5]" />
                                <span>WORKHUB MATCH (AI Pencarian Partner)</span>
                            </div>
                            <div class="flex items-center gap-2 text-neutral-700 dark:text-neutral-300">
                                <x-icon name="check" class="w-3.5 h-3.5 text-blue-500 shrink-0 stroke-[2.5]" />
                                <span>Biodata & Portofolio Karya Terverifikasi</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-neutral-100 dark:border-[#222222]">
                        @auth
                            @if(auth()->user()->role === 'siswa' || auth()->user()->role === 'admin')
                                <a 
                                    href="{{ route('siswa.dashboard') }}"
                                    class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white transition-all shadow-md hover:shadow-blue-500/25 cursor-pointer"
                                >
                                    <span>Buka Dashboard Siswa</span>
                                    <x-icon name="arrow-right" class="w-4 h-4" />
                                </a>
                                <span class="text-[10px] text-center text-blue-600 dark:text-blue-400 block mt-2 font-medium">
                                    @if(auth()->user()->role === 'admin')
                                        Akses Penuh (Mode Admin)
                                    @else
                                        Login sebagai: {{ auth()->user()->name }}
                                    @endif
                                </span>
                            @else
                                <a 
                                    href="{{ route('siswa.dashboard') }}"
                                    class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold border border-neutral-300 dark:border-neutral-700 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all"
                                >
                                    Masuk Portal Siswa
                                </a>
                            @endif
                        @else
                            <div class="space-y-2">
                                <a 
                                    href="{{ route('login') }}"
                                    class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-sm"
                                >
                                    Masuk Akun Siswa
                                    <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                                </a>
                                <a 
                                    href="{{ route('register') }}"
                                    class="w-full inline-flex items-center justify-center gap-2 py-2 px-4 rounded-xl text-xs font-bold border border-blue-600/60 text-blue-700 bg-white hover:bg-blue-50 transition-all"
                                >
                                    Daftar Siswa Baru
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- 2. PORTAL OSIS -->
                <div class="relative rounded-2xl border border-neutral-200/80 dark:border-[#2A2A2A] bg-white/90 dark:bg-[#161616]/90 backdrop-blur-md p-6 sm:p-7 flex flex-col justify-between transition-all duration-300 hover:border-purple-500/80 hover:shadow-xl hover:-translate-y-1 group">
                    <div class="absolute -top-3 left-6">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-purple-50 dark:bg-purple-950/80 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800 shadow-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse"></span>
                            Pengurus OSIS
                        </span>
                    </div>

                    <div class="pt-2">
                        <div class="flex items-center justify-between mb-4 mt-2">
                            <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 border border-purple-100 dark:border-purple-800/50 flex items-center justify-center font-bold text-lg shadow-xs group-hover:scale-105 transition-transform">
                                <x-icon name="award" class="w-6 h-6" />
                            </div>
                        </div>

                        <h2 class="text-xl font-bold text-neutral-950 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                            Portal Pengurus OSIS
                        </h2>
                        <p class="text-xs font-semibold text-purple-600 dark:text-purple-400 mt-1">
                            Koordinator Event & Showcase Festival
                        </p>

                        <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-3 leading-relaxed">
                            Inisiasi agenda kegiatan sekolah, kurasi proyek karya siswa untuk pameran festival resmi, dan broadcast informasi penting ke seluruh jurusan.
                        </p>

                        <!-- Fitur Utama OSIS -->
                        <div class="mt-6 pt-5 border-t border-neutral-100 dark:border-[#222222] space-y-2.5 text-xs">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-neutral-400 block mb-2">Fitur Utama:</span>
                            <div class="flex items-center gap-2 text-neutral-700 dark:text-neutral-300">
                                <x-icon name="check" class="w-3.5 h-3.5 text-purple-500 shrink-0 stroke-[2.5]" />
                                <span>Dashboard Monitoring Kolaborasi Sekolah</span>
                            </div>
                            <div class="flex items-center gap-2 text-neutral-700 dark:text-neutral-300">
                                <x-icon name="check" class="w-3.5 h-3.5 text-purple-500 shrink-0 stroke-[2.5]" />
                                <span>Manajemen Event & Festival Tahunan</span>
                            </div>
                            <div class="flex items-center gap-2 text-neutral-700 dark:text-neutral-300">
                                <x-icon name="check" class="w-3.5 h-3.5 text-purple-500 shrink-0 stroke-[2.5]" />
                                <span>Meja Kurasi Karya untuk Galeri Showcase</span>
                            </div>
                            <div class="flex items-center gap-2 text-neutral-700 dark:text-neutral-300">
                                <x-icon name="check" class="w-3.5 h-3.5 text-purple-500 shrink-0 stroke-[2.5]" />
                                <span>Broadcast Pengumuman Terpusat</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-neutral-100 dark:border-[#222222]">
                        @auth
                            @if(auth()->user()->role === 'osis' || auth()->user()->role === 'admin')
                                <a 
                                    href="{{ route('osis.dashboard') }}"
                                    class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold bg-purple-600 hover:bg-purple-700 text-white transition-all shadow-md hover:shadow-purple-500/25 cursor-pointer"
                                >
                                    <span>Buka Dashboard OSIS</span>
                                    <x-icon name="arrow-right" class="w-4 h-4" />
                                </a>
                                <span class="text-[10px] text-center text-purple-600 dark:text-purple-400 block mt-2 font-medium">
                                    @if(auth()->user()->role === 'admin')
                                        Akses Penuh (Mode Admin)
                                    @else
                                        Login sebagai: {{ auth()->user()->name }}
                                    @endif
                                </span>
                            @else
                                <a 
                                    href="{{ route('osis.dashboard') }}"
                                    class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold border border-neutral-300 dark:border-neutral-700 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-all"
                                >
                                    Masuk Portal OSIS
                                </a>
                            @endif
                        @else
                            <a 
                                href="{{ route('login') }}"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white transition-all shadow-sm"
                            >
                                Masuk Portal OSIS
                                <x-icon name="arrow-right" class="w-3.5 h-3.5" />
                            </a>
                            <span class="text-[10px] text-center text-neutral-400 block mt-2">
                                Gunakan akun pengurus OSIS
                            </span>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- 5 Kejuruan Strip -->
            <div class="mt-16 pt-10 border-t border-neutral-200/80 dark:border-[#222222] text-center">
                <span class="text-xs font-semibold uppercase tracking-wider text-neutral-400 dark:text-neutral-500 block mb-4">
                    Mendukung 5 Kompetensi Keahlian SMKN 1 Ciomas
                </span>
                <div class="flex flex-wrap items-center justify-center gap-2.5">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300 border border-blue-200/80 dark:border-blue-800">
                        <x-icon name="code" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" />
                        <span>PPLG (Perangkat Lunak & Gim)</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-purple-50 text-purple-700 dark:bg-purple-950/40 dark:text-purple-300 border border-purple-200/80 dark:border-purple-800">
                        <x-icon name="video" class="w-3.5 h-3.5 text-purple-600 dark:text-purple-400" />
                        <span>BCF (Broadcasting & Film)</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200/80 dark:border-amber-800">
                        <x-icon name="sparkles" class="w-3.5 h-3.5 text-amber-600 dark:text-amber-400" />
                        <span>Animasi (3D & 2D)</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300 border border-rose-200/80 dark:border-rose-800">
                        <x-icon name="wrench" class="w-3.5 h-3.5 text-rose-600 dark:text-rose-400" />
                        <span>TO (Teknik Otomotif)</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-cyan-50 text-cyan-700 dark:bg-cyan-950/40 dark:text-cyan-300 border border-cyan-200/80 dark:border-cyan-800">
                        <x-icon name="zap" class="w-3.5 h-3.5 text-cyan-600 dark:text-cyan-400" />
                        <span>TPFL (Pengelasan & Logam)</span>
                    </span>
                </div>
            </div>

            <!-- Footer Link -->
            <div class="mt-10 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-neutral-500 hover:text-neutral-900 dark:hover:text-white transition-colors">
                    &larr; Kembali ke Beranda Utama WORKHUB
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
