<x-app-layout current="osis-proyek" role="osis" pageTitle="Pemantauan Proyek Kolaborasi">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-200 dark:border-[#222222]">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white">
                Pemantauan Proyek Kolaborasi
            </h1>
            <p class="text-xs md:text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                Data terkini semua proyek yang sedang dikerjakan talenta lintas 12 bidang keahlian.
            </p>
        </div>

        <x-button :href="route('osis.kurasi')" variant="primary" size="md" icon="award">
            Kurasi Karya Unggulan ({{ $projects->where('is_showcase', false)->count() }})
        </x-button>
    </div>

    <!-- Table of projects -->
    <div class="my-8">
        <x-card padding="p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-neutral-50 dark:bg-[#151515] border-b border-neutral-200 dark:border-[#242424] text-neutral-500 uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="p-4">Proyek & Deskripsi</th>
                            <th class="p-4">Bidang Keahlian</th>
                            <th class="p-4">Ketua Tim</th>
                            <th class="p-4">Anggota Tim</th>
                            <th class="p-4">Kemajuan Proyek</th>
                            <th class="p-4">Status Galeri</th>
                            <th class="p-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-[#242424]">
                        @foreach($projects as $p)
                            <tr class="hover:bg-neutral-50/50 dark:hover:bg-[#141414] transition-colors">
                                <td class="p-4 max-w-xs">
                                    <span class="font-bold text-neutral-900 dark:text-white block">{{ $p->title }}</span>
                                    <span class="text-neutral-500 line-clamp-1 mt-0.5">{{ $p->description }}</span>
                                </td>
                                <td class="p-4">
                                    <span class="font-semibold text-neutral-800 dark:text-neutral-200 bg-neutral-100 dark:bg-neutral-800 px-2 py-0.5 rounded border border-neutral-200 dark:border-neutral-700">
                                        {{ $p->jurusan_label }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="font-bold text-neutral-900 dark:text-white block">{{ $p->lead->name ?? 'Ketua' }}</span>
                                    <span class="text-neutral-400">{{ $p->lead->institution ?? ($p->lead->headline ?? 'Talenta') }}</span>
                                </td>
                                <td class="p-4">
                                    <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $p->members->count() }} / {{ $p->target_members }} Talenta</span>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-neutral-900 dark:text-white">{{ $p->progress }}%</span>
                                        <div class="w-16 bg-neutral-100 dark:bg-neutral-800 h-1.5 rounded-full overflow-hidden">
                                            <div class="bg-neutral-900 dark:bg-white h-full" style="width: {{ $p->progress }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    @if($p->is_showcase)
                                        <x-badge variant="success" size="xs">Galeri Aktif</x-badge>
                                    @else
                                        <x-badge variant="neutral" size="xs">Belum Masuk</x-badge>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <x-button :href="route('siswa.workspace', $p->id)" variant="outline" size="sm">
                                        Buka Ruang Kerja
                                    </x-button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</x-app-layout>
