<x-app-layout current="notifikasi" pageTitle="Pusat Notifikasi">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between pb-6 border-b border-neutral-200 dark:border-[#222222]">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white">
                    Notifikasi
                </h1>
                <p class="text-xs md:text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                    Pembaruan aktivitas proyek, undangan tim, dan penugasan kerja.
                </p>
            </div>

            <form action="{{ route('siswa.notifikasi.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs font-semibold text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white transition-colors cursor-pointer">
                    Tandai semua sudah dibaca
                </button>
            </form>
        </div>

        <!-- Notification List -->
        <div class="mt-6 space-y-3">
            @foreach($notifications as $n)
                <div class="p-4 rounded-xl border border-neutral-200 dark:border-[#2A2A2A] bg-white dark:bg-[#181818] shadow-xs flex items-start gap-4 transition-all duration-150 {{ $n['status'] === 'unread' ? 'ring-1 ring-neutral-900/10 dark:ring-white/20' : 'opacity-85' }}">
                    <!-- Icon based on type -->
                    <div class="w-10 h-10 rounded-xl bg-neutral-100 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 flex items-center justify-center shrink-0 border border-neutral-200 dark:border-neutral-700">
                        <x-icon :name="$n['icon']" class="w-5 h-5" />
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-500">
                                {{ $n['type'] }}
                            </span>
                            <span class="text-[11px] text-neutral-400">
                                {{ $n['time'] }}
                            </span>
                        </div>

                        <h4 class="text-sm font-bold text-neutral-900 dark:text-white mt-1">
                            {{ $n['title'] }}
                        </h4>

                        <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-1 leading-relaxed">
                            {{ $n['desc'] }}
                        </p>

                        @if($n['action'])
                            <div class="mt-3 flex items-center gap-2">
                                <x-button variant="primary" size="sm" class="text-xs">
                                    {{ $n['action'] }}
                                </x-button>
                                <x-button variant="ghost" size="sm" class="text-xs">
                                    Abaikan
                                </x-button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
