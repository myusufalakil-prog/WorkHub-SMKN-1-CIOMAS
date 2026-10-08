<x-app-layout current="proyek" pageTitle="Buat Proyek Baru">
    <div class="max-w-2xl mx-auto">
        <!-- Top Back link & Title -->
        <div class="mb-6">
            <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-neutral-500 hover:text-neutral-900 dark:hover:text-white transition-colors mb-2">
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
            <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
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
                        Jurusan Kolaborasi yang Dibutuhkan <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-xs text-neutral-500 mb-3">
                        Pilih minimal 1 atau lebih jurusan untuk membangun sinergi tim.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['PPLG (Software & Gim)', 'Animasi (3D & 2D)', 'BCF (Broadcasting & Film)', 'TJKT (Jaringan & Server)', 'DKV (Desain Komunikasi)'] as $j)
                            <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-[#181818] text-xs font-medium text-neutral-800 dark:text-neutral-200 cursor-pointer hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                                <input type="checkbox" name="jurusan[]" value="{{ $j }}" class="rounded border-neutral-300 dark:border-neutral-700 text-black focus:ring-black">
                                <span>{{ $j }}</span>
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
                        class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#141414] text-neutral-900 dark:text-white placeholder-neutral-400 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:outline-none focus:border-neutral-900 dark:focus:border-neutral-300 focus:bg-white dark:focus:bg-[#111111] transition-all leading-relaxed"
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
                            class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#141414] text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-700 rounded-lg focus:outline-none focus:border-neutral-900 dark:focus:border-neutral-300 transition-all"
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
                            class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#141414] text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-700 rounded-lg focus:outline-none focus:border-neutral-900 dark:focus:border-neutral-300 transition-all"
                        />
                    </div>
                </div>

                <!-- Skill Tags -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-2">
                        Keahlian / Skill Tags (Pisahkan dengan koma)
                    </label>
                    <input 
                        type="text" 
                        name="tags" 
                        placeholder="Web, UI/UX, Blender, Video, Laravel"
                        class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#141414] text-neutral-900 dark:text-white placeholder-neutral-400 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:outline-none focus:border-neutral-900 dark:focus:border-neutral-300 transition-all"
                    />
                </div>

                <!-- Form Action Buttons -->
                <div class="pt-4 border-t border-neutral-100 dark:border-[#262626] flex items-center justify-end gap-3">
                    <x-button :href="route('projects.index')" variant="secondary" size="md">
                        Batal
                    </x-button>

                    <x-button type="submit" variant="primary" size="md" icon="plus">
                        Publikasikan Proyek
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
