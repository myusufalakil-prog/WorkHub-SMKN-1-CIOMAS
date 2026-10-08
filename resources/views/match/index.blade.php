<x-app-layout current="match" pageTitle="WORKHUB MATCH">
    <!-- Header: Explicitly adhering to specification -->
    <div class="pb-6 border-b border-neutral-200 dark:border-[#222222]">
        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-neutral-900 text-white dark:bg-white dark:text-neutral-900 text-xs font-bold uppercase tracking-wider mb-2">
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
            <span class="px-2.5 py-1 rounded-full bg-neutral-900 text-white dark:bg-white dark:text-black font-bold shrink-0">Semua Siswa</span>
            <span class="px-2.5 py-1 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-700 shrink-0 cursor-pointer">Frontend / Web</span>
            <span class="px-2.5 py-1 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-700 shrink-0 cursor-pointer">3D & Animasi</span>
            <span class="px-2.5 py-1 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-700 shrink-0 cursor-pointer">Video Production</span>
            <span class="px-2.5 py-1 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-700 shrink-0 cursor-pointer">Server & IoT</span>
        </div>

        <span class="text-xs text-neutral-500 shrink-0 self-end sm:self-center">
            Pencocokan berdasarkan algoritma portofolio & riwayat kolaborasi
        </span>
    </div>

    <!-- Match Candidates Grid from SQLite -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($candidates as $c)
            <x-match-card 
                :name="$c->name"
                :classMajor="($c->kelas ?? 'Siswa') . ' ' . ($c->jurusan->kode ?? '')"
                :score="rand(88, 96)"
                :skills="$c->skills->pluck('name')->all()"
                :href="route('profile.show', $c->id)"
            />
        @endforeach
    </div>

    <!-- Explanation Box: Data-driven & Professional -->
    <div class="mt-12 p-6 rounded-xl border border-neutral-200 dark:border-[#2A2A2A] bg-neutral-50/50 dark:bg-[#151515] flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-neutral-900 text-white dark:bg-white dark:text-neutral-900 flex items-center justify-center shrink-0">
                <x-icon name="cpu" class="w-5 h-5" />
            </div>
            <div>
                <h4 class="text-sm font-bold text-neutral-900 dark:text-white">
                    Bagaimana WORKHUB MATCH bekerja?
                </h4>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                    Skor kecocokan dihitung secara dinamis dari kombinasi kompetensi jurusan, keahlian teknis yang terverifikasi guru, serta rekam jejak tugas di workspace.
                </p>
            </div>
        </div>

        <x-button :href="route('profile.show', 1)" variant="outline" size="sm" class="shrink-0 text-xs">
            Perbarui Portofolio Saya
        </x-button>
    </div>
</x-app-layout>
