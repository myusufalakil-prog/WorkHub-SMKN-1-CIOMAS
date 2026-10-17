<x-app-layout current="osis-events" role="osis" pageTitle="Agenda & Tantangan Hub">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-200 dark:border-[#222222]">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white">
                Agenda & Tantangan Kolaborasi Hub
            </h1>
            <p class="text-xs md:text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                Agenda kegiatan pameran inovasi, tantangan kolaborasi, dan demo day talenta lintas domain.
            </p>
        </div>

        <button 
            onclick="document.getElementById('modalTambahEvent').showModal()"
            class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold rounded-lg bg-neutral-900 text-white hover:bg-neutral-800 dark:bg-white dark:text-black dark:hover:bg-neutral-100 transition-colors shadow-xs"
        >
            <x-icon name="plus" class="w-3.5 h-3.5" />
            Tambah Agenda Kegiatan
        </button>
    </div>

    <div class="space-y-4 my-8">
        @forelse($events as $ev)
            <x-card padding="p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2">
                            <x-badge variant="neutral" size="xs" :dot="true">{{ $ev->status ?? 'Aktif' }}</x-badge>
                            <span class="text-xs text-neutral-400 flex items-center gap-1">
                                <x-icon name="calendar" class="w-3.5 h-3.5" />
                                {{ $ev->date_text }}
                            </span>
                            @if($ev->category)
                                <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400">
                                    {{ $ev->category }}
                                </span>
                            @endif
                        </div>

                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white">
                            {{ $ev->title }}
                        </h3>

                        <p class="text-xs md:text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed max-w-3xl">
                            {{ $ev->desc }}
                        </p>

                        <div class="flex items-center gap-4 text-xs text-neutral-500 pt-2">
                            <span>Penanggung Jawab: <strong>{{ $ev->lead ?? 'Tim Penyelenggara' }}</strong></span>
                            <span>&bull;</span>
                            <span>{{ $ev->participants_info ?? 'Terbuka untuk Semua Talenta' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <x-button :href="route('osis.kurasi')" variant="outline" size="sm">
                            Kurasi Proyek
                        </x-button>
                        <x-button :href="route('osis.projects')" variant="secondary" size="sm">
                            Daftar Proyek
                        </x-button>
                    </div>
                </div>
            </x-card>
        @empty
            <div class="py-12 text-center text-sm text-neutral-500">
                Belum ada agenda kegiatan dibuat. Klik "Tambah Agenda Kegiatan" di atas untuk membuat kegiatan baru.
            </div>
        @endforelse
    </div>

    <!-- Modal Tambah Agenda Kegiatan OSIS -->
    <dialog id="modalTambahEvent" class="fixed inset-0 m-auto p-0 rounded-2xl bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] shadow-2xl backdrop:bg-black/60 max-w-md w-[92vw] sm:w-full overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between pb-4 border-b border-neutral-100 dark:border-[#262626]">
                <div>
                    <h3 class="text-base font-bold text-neutral-900 dark:text-white">
                        Inisiasi Agenda & Tantangan Inovasi
                    </h3>
                    <p class="text-xs text-neutral-500">
                        Publikasikan agenda kegiatan dan siarkan pengumuman ke seluruh jaringan talenta.
                    </p>
                </div>
                <button onclick="document.getElementById('modalTambahEvent').close()" class="text-neutral-400 hover:text-neutral-900 dark:hover:text-white text-lg font-bold">
                    &times;
                </button>
            </div>

            <form action="{{ route('osis.events.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                        Nama Agenda / Festival <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        required 
                        placeholder="Contoh: SynapseHub Global Innovation Festival 2026" 
                        class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none"
                    />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                            Tanggal Pelaksanaan <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="date_text" 
                            required 
                            placeholder="Contoh: 18 Desember 2026" 
                            class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white"
                        />
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                            Status Kegiatan
                        </label>
                        <select 
                            name="status" 
                            class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white"
                        >
                            <option value="Pendaftaran Terbuka">Pendaftaran Terbuka</option>
                            <option value="Persiapan Teknis">Persiapan Teknis</option>
                            <option value="Tahap Kurasi">Tahap Kurasi</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                            Kategori Agenda
                        </label>
                        <select 
                            name="category" 
                            class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white"
                        >
                            <option value="Festival Inovasi">Festival Inovasi</option>
                            <option value="Kompetisi Inovasi">Kompetisi Inovasi</option>
                            <option value="Pameran Karya Terbuka">Pameran Karya Terbuka</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                            Penanggung Jawab / Divisi
                        </label>
                        <input 
                            type="text" 
                            name="lead" 
                            value="Tim Penyelenggara Komunitas" 
                            class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white"
                        />
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold uppercase text-neutral-600 dark:text-neutral-300 block mb-1">
                        Deskripsi Kegiatan & Ketentuan
                    </label>
                    <textarea 
                        name="desc" 
                        rows="3" 
                        placeholder="Tuliskan tujuan acara, peserta yang ditargetkan, dan ketentuan karya..."
                        class="w-full text-xs p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none"
                    ></textarea>
                </div>

                <div class="pt-4 border-t border-neutral-100 dark:border-[#262626] flex items-center justify-end gap-2">
                    <button 
                        type="button" 
                        onclick="document.getElementById('modalTambahEvent').close()"
                        class="px-4 py-2 text-xs font-bold text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 text-xs font-bold rounded-lg bg-neutral-900 text-white dark:bg-white dark:text-black hover:bg-neutral-800 transition-colors"
                    >
                        Publikasikan Agenda
                    </button>
                </div>
            </form>
        </div>
    </dialog>
</x-app-layout>
