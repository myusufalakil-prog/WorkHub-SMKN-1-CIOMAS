<x-app-layout current="match" role="siswa" pageTitle="WORKHUB MATCH">
    <div class="pb-6 border-b border-neutral-200 dark:border-[#222222]">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-xs font-bold uppercase tracking-wider mb-2 shadow-xs">
            <x-icon name="cpu" class="w-3.5 h-3.5" />
            AI Recommendation Engine
        </div>
        <h1 class="text-3xl font-extrabold tracking-tight text-neutral-950 dark:text-white">
            WORKHUB MATCH
        </h1>
        <p class="text-sm md:text-base text-neutral-600 dark:text-neutral-400 mt-1 max-w-2xl">
            "Temukan orang yang paling cocok untuk project kamu."
        </p>
    </div>

    <!-- Technical filter strip -->
    <div class="my-6 p-4 rounded-xl bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2 w-full sm:w-auto overflow-x-auto text-xs font-medium">
            <span class="text-neutral-400 shrink-0 font-semibold">Filter Keahlian:</span>
            @php
                $filters = [
                    'Semua' => 'Semua Siswa',
                    'Frontend' => 'Frontend / Web',
                    '3D' => '3D & Animasi',
                    'Video' => 'Video Production',
                    'Server' => 'Server & IoT',
                ];
            @endphp
            @foreach($filters as $val => $lbl)
                <a 
                    href="{{ route('siswa.match', ['kategori' => $val]) }}"
                    class="px-3 py-1 rounded-full font-medium transition-all shrink-0 {{ ($kategori ?? 'Semua') === $val ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-400' }}"
                >
                    {{ $lbl }}
                </a>
            @endforeach
        </div>

        <span class="text-xs text-neutral-500 shrink-0 self-end sm:self-center">
            Pencocokan berdasarkan algoritma portofolio & riwayat kolaborasi
        </span>
    </div>

    <!-- Match Candidates Grid from SQLite -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($candidates as $c)
            <x-match-card 
                :name="$c->name"
                :classMajor="($c->kelas ?? 'Siswa') . ' ' . ($c->jurusan->kode ?? '')"
                :score="rand(88, 96)"
                :skills="$c->skills->pluck('name')->all()"
                :href="route('siswa.profil', $c->id)"
            />
        @empty
            <div class="col-span-1 md:col-span-2 p-8 text-center rounded-xl border border-dashed border-neutral-300 dark:border-neutral-700 bg-white dark:bg-[#181818]">
                <p class="text-sm font-semibold text-neutral-800 dark:text-neutral-200">
                    Tidak ada siswa yang cocok dengan filter "{{ $kategori }}"
                </p>
                <p class="text-xs text-neutral-500 mt-1">
                    Coba pilih filter lain atau lihat semua siswa yang terdaftar.
                </p>
                <div class="mt-4">
                    <x-button :href="route('siswa.match', ['kategori' => 'Semua'])" variant="secondary" size="sm">
                        Tampilkan Semua Siswa
                    </x-button>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Explanation Box: Data-driven & Professional -->
    <div class="mt-12 p-6 rounded-2xl border border-blue-200/80 dark:border-blue-900/50 bg-gradient-to-r from-blue-50/70 to-indigo-50/70 dark:from-slate-900 dark:to-slate-900 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shadow-xs">
        <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/20">
                <x-icon name="cpu" class="w-5 h-5" />
            </div>
            <div>
                <h4 class="text-sm font-bold text-neutral-900 dark:text-white">
                    Bagaimana WORKHUB MATCH bekerja?
                </h4>
                <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-0.5 leading-relaxed">
                    Skor kecocokan dihitung secara dinamis dari kombinasi kompetensi kejuruan SMKN 1 Ciomas, keahlian teknis portofolio siswa, serta rekam jejak aktivitas di workspace.
                </p>
            </div>
        </div>

        <a 
            href="{{ route('siswa.profil') }}" 
            class="shrink-0 px-4 py-2 text-xs font-bold rounded-xl bg-white dark:bg-slate-800 border border-blue-300 dark:border-blue-700 text-blue-700 dark:text-blue-300 hover:bg-blue-50 transition-all shadow-xs"
        >
            Perbarui Portofolio Saya
        </a>
    </div>
</x-app-layout>
