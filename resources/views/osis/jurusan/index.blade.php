<x-app-layout current="osis-jurusan" role="osis" pageTitle="Aktivitas Kolaborasi Jurusan">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-200 dark:border-[#222222]">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white">
                Statistik & Keaktifan 5 Jurusan SMK
            </h1>
            <p class="text-xs md:text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                Data partisipasi siswa dan kontribusi karya per keahlian kejuruan.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-8">
        @foreach($jurusans as $j)
            <x-card padding="p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-lg font-extrabold text-neutral-900 dark:text-white tracking-tight">
                        {{ $j->kode }}
                    </span>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300">
                        {{ $j->projects_count }} Proyek
                    </span>
                </div>

                <h3 class="text-sm font-bold text-neutral-800 dark:text-neutral-200">
                    {{ $j->nama_lengkap }}
                </h3>

                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2 line-clamp-3 leading-relaxed">
                    {{ $j->deskripsi }}
                </p>

                <div class="mt-6 pt-4 border-t border-neutral-100 dark:border-[#262626] flex items-center justify-between text-xs">
                    <span class="text-neutral-500">Siswa Terdaftar:</span>
                    <span class="font-bold text-neutral-900 dark:text-white">{{ $j->students_count }} Siswa</span>
                </div>
            </x-card>
        @endforeach
    </div>
</x-app-layout>
