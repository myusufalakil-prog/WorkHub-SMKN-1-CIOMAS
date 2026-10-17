<x-app-layout current="osis-broadcast" role="osis" pageTitle="Siaran Pengumuman Hub">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between pb-6 border-b border-neutral-200 dark:border-[#222222]">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white">
                    Siaran Pengumuman Hub
                </h1>
                <p class="text-xs md:text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                    Kirim notifikasi agenda kegiatan, panggilan kolaborasi, atau pengumuman penting ke seluruh talenta terdaftar.
                </p>
            </div>
        </div>

        <!-- Form Broadcast -->
        <div class="my-6">
            <x-card padding="p-6">
                <form action="{{ route('osis.broadcast') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-neutral-700 dark:text-neutral-300 mb-1">
                            Judul Pengumuman <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="title" 
                            required 
                            placeholder="Contoh: Panggilan Terbuka Kolaborator Desain 3D Festival" 
                            class="w-full text-xs md:text-sm p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-neutral-700 dark:text-neutral-300 mb-1">
                            Isi Pengumuman / Pesan <span class="text-rose-500">*</span>
                        </label>
                        <textarea 
                            name="desc" 
                            rows="3" 
                            required 
                            placeholder="Tuliskan rincian pengumuman yang akan muncul pada notifikasi talenta..." 
                            class="w-full text-xs md:text-sm p-2.5 rounded-lg bg-neutral-50 dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white focus:outline-none"
                        ></textarea>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <x-button type="submit" variant="primary" size="sm" icon="send">
                            Kirim Siaran Pengumuman
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>

        <!-- Riwayat Broadcast Terakhir -->
        <div class="mt-8 space-y-3">
            <h3 class="text-sm font-bold text-neutral-900 dark:text-white">
                Riwayat Siaran Pengumuman
            </h3>

            @forelse($recentBroadcasts as $b)
                <div class="p-4 rounded-xl border border-neutral-200 dark:border-[#2A2A2A] bg-white dark:bg-[#181818] shadow-xs flex items-start justify-between gap-3">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                            <x-icon name="bell" class="w-4 h-4" />
                        </div>
                        <div>
                            <span class="text-[10px] text-neutral-400 block">{{ $b->created_at ? $b->created_at->diffForHumans() : 'Baru saja' }}</span>
                            <h4 class="text-sm font-bold text-neutral-900 dark:text-white">{{ $b->title }}</h4>
                            <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-0.5">{{ $b->desc }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200/80 dark:border-purple-800 shrink-0">
                        <x-icon name="users" class="w-3 h-3" />
                        {{ $b->recipient_count ?? 1 }} Talenta Penerima
                    </span>
                </div>
            @empty
                <div class="text-xs text-neutral-400">Belum ada riwayat siaran pengumuman.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
