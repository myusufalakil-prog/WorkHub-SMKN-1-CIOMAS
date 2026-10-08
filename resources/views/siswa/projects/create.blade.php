<x-app-layout current="proyek" role="siswa" pageTitle="Buat Proyek Baru">
    <div class="max-w-2xl mx-auto">
        <!-- Top Back link & Title -->
        <div class="mb-6">
            <a href="{{ route('siswa.proyek.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-neutral-500 hover:text-neutral-900 dark:hover:text-white transition-colors mb-2">
                <x-icon name="arrow-right" class="w-3.5 h-3.5 rotate-180" />
                Kembali ke Daftar Proyek
            </a>
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white">
                Buat Proyek Kolaborasi Baru
            </h1>
            <p class="text-xs md:text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                Tulis ide proyekmu dan undang rekan lintas jurusan untuk berkolaborasi.
            </p>
        </div>

        <!-- Form Card -->
        <x-card padding="p-6 md:p-8">
            <form action="{{ route('siswa.proyek.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Project Title -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-2">
                        Judul Proyek <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        required
                        placeholder="Contoh: Festival Sekolah 2026 Digital Hub"
                        class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#141414] text-neutral-900 dark:text-white placeholder-neutral-400 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:outline-none focus:border-neutral-900 dark:focus:border-neutral-300 focus:bg-white dark:focus:bg-[#111111] transition-all"
                    />
                </div>

                <!-- Jurusan Kolaborator yang Dibutuhkan -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-2">
                        Kejuruan Kolaborasi yang Dibutuhkan (SMKN 1 Ciomas) <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-xs text-neutral-500 mb-3">
                        Pilih minimal 1 atau lebih dari 5 kejuruan resmi SMKN 1 Ciomas untuk membangun sinergi tim.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($jurusans as $j)
                            @php
                                $badgeColor = match($j->kode) {
                                    'PPLG' => 'hover:border-blue-500 hover:text-blue-600',
                                    'BCF' => 'hover:border-purple-500 hover:text-purple-600',
                                    'Animasi' => 'hover:border-amber-500 hover:text-amber-600',
                                    'TO' => 'hover:border-rose-500 hover:text-rose-600',
                                    'TPFL' => 'hover:border-cyan-500 hover:text-cyan-600',
                                    default => 'hover:border-blue-500 hover:text-blue-600',
                                };
                            @endphp
                            <label class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-[#181818] text-xs font-semibold text-neutral-800 dark:text-neutral-200 cursor-pointer {{ $badgeColor }} transition-all shadow-xs">
                                <input type="checkbox" name="jurusan[]" value="{{ $j->kode }}" class="rounded border-neutral-300 dark:border-neutral-700 text-blue-600 focus:ring-blue-500">
                                <span>{{ $j->kode }} &bull; {{ $j->nama_lengkap }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-2">
                        Deskripsi Singkat & Tujuan Proyek <span class="text-rose-500">*</span>
                    </label>
                    <textarea 
                        name="description" 
                        rows="3" 
                        required
                        placeholder="Jelaskan apa yang ingin dibuat, masalah yang diselesaikan, dan kontribusi yang diharapkan dari rekan tim..."
                        class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#141414] text-neutral-900 dark:text-white placeholder-neutral-400 border border-neutral-300 dark:border-neutral-700 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white dark:focus:bg-[#111111] transition-all leading-relaxed"
                    ></textarea>
                </div>

                <!-- 2 Columns: Target Anggota & Deadline -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-2">
                            Jumlah Target Anggota
                        </label>
                        <input 
                            type="number" 
                            name="members_target" 
                            value="6"
                            min="2"
                            max="20"
                            class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#141414] text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-700 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-2">
                            Target Deadline Selesai
                        </label>
                        <input 
                            type="date" 
                            name="deadline" 
                            value="{{ date('Y-m-d', strtotime('+30 days')) }}"
                            class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#141414] text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-700 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                        />
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="pt-4 border-t border-neutral-100 dark:border-[#262626] flex items-center justify-end gap-3">
                    <x-button :href="route('siswa.proyek.index')" variant="secondary" size="md">
                        Batal
                    </x-button>
                    <button 
                        type="submit" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-md hover:shadow-blue-500/25 cursor-pointer"
                    >
                        <x-icon name="plus" class="w-4 h-4 stroke-[3]" />
                        <span>Publikasikan Proyek</span>
                    </button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
