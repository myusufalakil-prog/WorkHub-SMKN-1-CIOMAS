<x-app-layout current="showcase" pageTitle="Showcase Karya Kolaborasi">
    <div class="pb-6 border-b border-neutral-200 dark:border-[#222222]">
        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-neutral-900 text-white dark:bg-white dark:text-neutral-900 text-xs font-bold uppercase tracking-wider mb-2">
            <x-icon name="sparkles" class="w-3.5 h-3.5" />
            Galeri Prestasi Siswa SMK
        </div>
        <h1 class="text-3xl font-extrabold tracking-tight text-neutral-950 dark:text-white">
            Showcase Karya Kolaborasi
        </h1>
        <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1 max-w-2xl">
            Kumpulan proyek terbaik yang telah berhasil diselesaikan oleh kolaborasi antarjurusan siswa SMK dan terverifikasi untuk dipamerkan.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-8">
        @foreach($projects as $p)
            <x-project-card 
                :title="$p['title']"
                :jurusan="$p['jurusan']"
                :description="$p['description']"
                :tags="$p['tags']"
                :members="$p['members']"
                :deadline="$p['deadline']"
                :progress="$p['progress']"
                :status="$p['status']"
                :href="route('workspace.show', $p['id'])"
            />
        @endforeach
    </div>
</x-app-layout>
