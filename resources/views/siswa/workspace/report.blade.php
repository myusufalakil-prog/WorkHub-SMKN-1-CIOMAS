<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Proyek & Log Aktivitas - {{ $project->title }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: #ffffff !important;
                color: #0f172a !important;
                padding: 0 !important;
                margin: 0 !important;
                font-size: 11pt !important;
            }
            .print-container {
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .page-break {
                page-break-before: always;
            }
            tr {
                page-break-inside: avoid;
            }
            .avoid-break {
                page-break-inside: avoid;
            }
        }
        @page {
            size: A4;
            margin: 15mm 15mm 15mm 15mm;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased min-h-screen py-8 px-4 selection:bg-blue-600 selection:text-white">

    <!-- Sticky Toolbar (Hidden on Print) -->
    <div class="no-print max-w-4xl mx-auto mb-6">
        <div class="bg-white/90 backdrop-blur-md border border-slate-200/90 rounded-2xl p-4 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('siswa.workspace', ['id' => $project->id, 'tab' => 'aktivitas']) }}" 
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-semibold transition-colors"
                >
                    <x-icon name="arrow-left" class="w-3.5 h-3.5" />
                    <span>Kembali ke Workspace</span>
                </a>
                <div class="border-l border-slate-200 pl-3">
                    <span class="text-xs font-bold text-slate-900 block truncate max-w-xs sm:max-w-md">Pratinjau Cetak Laporan Proyek</span>
                    <span class="text-[11px] text-slate-500">Gunakan dialog cetak browser untuk cetak langsung atau "Simpan sebagai PDF"</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button 
                    type="button" 
                    onclick="window.print()" 
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 text-xs font-bold rounded-xl bg-blue-600 text-white hover:bg-blue-700 shadow-sm shadow-blue-500/25 transition-all cursor-pointer"
                >
                    <x-icon name="printer" class="w-4 h-4" />
                    <span>Cetak Dokumen / Simpan PDF</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Printable Document Container (A4 Style) -->
    <main class="print-container max-w-4xl mx-auto bg-white border border-slate-200/80 rounded-2xl p-8 sm:p-12 shadow-md">
        
        <!-- Header Dokumen / Kop Dokumen Resmi -->
        <header class="border-b-2 border-slate-900 pb-5 mb-6">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl bg-slate-950 text-white flex items-center justify-center font-black text-xl shadow-xs shrink-0">
                        W
                    </div>
                    <div>
                        <h1 class="text-lg font-black tracking-tight text-slate-950 uppercase leading-snug">
                            WORKHUB &bull; SISTEM KOLABORASI TALENTA PBL
                        </h1>
                        <p class="text-xs text-slate-600 font-medium">
                            Jaringan Kolaborasi Proyek & Inovasi Siswa Multi-Disiplin
                        </p>
                        <p class="text-[11px] text-slate-500 mt-0.5">
                            Dokumen Resmi Rekam Aktivitas & Perkembangan Proyek Kolaborasi
                        </p>
                    </div>
                </div>

                <div class="text-right text-[11px] text-slate-500 shrink-0">
                    <span class="block font-bold text-slate-800">KODE PROYEK: #PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}</span>
                    <span class="block">Tanggal Cetak:</span>
                    <span class="font-semibold text-slate-700">{{ now()->translatedFormat('d F Y, H:i') }} WIB</span>
                </div>
            </div>
        </header>

        <!-- Judul Laporan -->
        <div class="text-center my-6">
            <h2 class="text-xl font-extrabold text-slate-900 uppercase tracking-wide">
                LAPORAN KEMAJUAN & REKAM LOG AKTIVITAS PROYEK
            </h2>
            <p class="text-xs text-slate-600 mt-1 max-w-2xl mx-auto font-medium">
                Rekapitulasi resmi rencana kerja tim, capaian progres implementasi, dan catatan aktivitas kolaborasi anggota.
            </p>
        </div>

        <!-- 1. Metadata Proyek Kolaborasi -->
        <section class="mb-7">
            <div class="flex items-center gap-2 mb-3">
                <span class="w-2 h-4 bg-blue-600 rounded-xs"></span>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">
                    I. INFORMASI DASAR PROYEK
                </h3>
            </div>

            <div class="bg-slate-50/70 border border-slate-200 rounded-xl p-4.5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6 text-xs">
                    <div>
                        <span class="text-slate-500 block font-medium">Judul Proyek:</span>
                        <span class="text-slate-900 font-bold text-sm block mt-0.5">{{ $project->title }}</span>
                    </div>

                    <div>
                        <span class="text-slate-500 block font-medium">Domain / Kolaborasi Keahlian:</span>
                        <span class="text-blue-700 font-bold block mt-0.5">{{ $project->jurusan_label }}</span>
                    </div>

                    <div>
                        <span class="text-slate-500 block font-medium">Ketua Tim Proyek (Lead):</span>
                        <span class="text-slate-900 font-semibold block mt-0.5">
                            {{ $project->lead->name ?? '-' }}
                            <span class="text-slate-500">({{ $project->lead->institution ?? ($project->lead->headline ?? 'Talenta') }} &bull; {{ $project->lead->jurusan->kode ?? 'TECH' }})</span>
                        </span>
                    </div>

                    <div>
                        <span class="text-slate-500 block font-medium">Guru Pembimbing / Fasilitator:</span>
                        <span class="text-slate-900 font-semibold block mt-0.5">
                            {{ $project->guru->name ?? 'Belum ditentukan' }}
                        </span>
                    </div>

                    <div>
                        <span class="text-slate-500 block font-medium">Status Proyek Saat Ini:</span>
                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[11px] font-bold mt-0.5 {{ $project->status === 'Selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $project->status }} (Capaian: {{ $project->progress }}%)
                        </span>
                    </div>

                    <div>
                        <span class="text-slate-500 block font-medium">Tenggat Waktu / Target Selesai:</span>
                        <span class="text-slate-900 font-semibold block mt-0.5">
                            {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->translatedFormat('d F Y') : 'Fleksibel' }}
                        </span>
                    </div>

                    <div class="sm:col-span-2 pt-2 border-t border-slate-200/80">
                        <span class="text-slate-500 block font-medium mb-1">Deskripsi Singkat / Sasaran Proyek:</span>
                        <p class="text-slate-700 leading-relaxed text-justify">
                            {{ $project->description ?: 'Tidak ada deskripsi rinci proyek.' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. Tim Kolaborator -->
        <section class="mb-7">
            <div class="flex items-center gap-2 mb-3">
                <span class="w-2 h-4 bg-blue-600 rounded-xs"></span>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">
                    II. ANGGOTA TIM KOLABORASI ({{ $project->activeMembers->count() + 1 }} Talenta)
                </h3>
            </div>

            <div class="overflow-x-auto border border-slate-200 rounded-xl">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200">
                        <tr>
                            <th class="py-2.5 px-3 w-10 text-center">No</th>
                            <th class="py-2.5 px-3">Nama Anggota</th>
                            <th class="py-2.5 px-3">Jurusan / Domain</th>
                            <th class="py-2.5 px-3">Peran dalam Proyek</th>
                            <th class="py-2.5 px-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <!-- Ketua Tim -->
                        <tr class="bg-blue-50/30">
                            <td class="py-2.5 px-3 text-center font-bold text-slate-500">1</td>
                            <td class="py-2.5 px-3 font-bold text-slate-900">
                                {{ $project->lead->name ?? 'Ketua Tim' }}
                                <span class="text-[10px] text-blue-600 font-semibold block">Inisiator Proyek</span>
                            </td>
                            <td class="py-2.5 px-3 text-slate-600 font-medium">
                                {{ $project->lead->jurusan->nama ?? ($project->lead->jurusan->kode ?? 'TECH') }}
                            </td>
                            <td class="py-2.5 px-3 font-semibold text-slate-900">
                                Ketua Tim Proyek (Lead)
                            </td>
                            <td class="py-2.5 px-3 text-center">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    Aktif
                                </span>
                            </td>
                        </tr>

                        <!-- Anggota Aktif Lainnya -->
                        @php $memberIndex = 2; @endphp
                        @forelse($project->activeMembers as $mem)
                            @if($mem->id !== $project->lead_id)
                                <tr>
                                    <td class="py-2.5 px-3 text-center font-medium text-slate-500">{{ $memberIndex++ }}</td>
                                    <td class="py-2.5 px-3 font-semibold text-slate-900">
                                        {{ $mem->name }}
                                        <span class="text-[10px] text-slate-400 block">{{ $mem->institution ?? ($mem->headline ?? 'Talenta') }}</span>
                                    </td>
                                    <td class="py-2.5 px-3 text-slate-600">
                                        {{ $mem->jurusan->nama ?? ($mem->jurusan->kode ?? 'Domain') }}
                                    </td>
                                    <td class="py-2.5 px-3 text-slate-800">
                                        {{ $mem->pivot->role_in_project ?? 'Anggota Kolaborasi' }}
                                    </td>
                                    <td class="py-2.5 px-3 text-center">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            Aktif
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            @if(!$project->lead)
                                <tr>
                                    <td colspan="5" class="py-3 px-3 text-center text-slate-400">Belum ada anggota tim terdaftar.</td>
                                </tr>
                            @endif
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 3. Rekapitulasi Rencana Tugas (Task Checklist) -->
        <section class="mb-7">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-4 bg-blue-600 rounded-xs"></span>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">
                        III. REKAPITULASI TUGAS & PROGRES KERJA ({{ $totalTasks }} Tugas)
                    </h3>
                </div>
                <div class="text-[11px] font-bold text-slate-700">
                    Selesai: <span class="text-emerald-700">{{ $doneTasks }}/{{ $totalTasks }}</span> ({{ $tasksProgress }}%)
                </div>
            </div>

            <div class="overflow-x-auto border border-slate-200 rounded-xl">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200">
                        <tr>
                            <th class="py-2.5 px-3 w-10 text-center">No</th>
                            <th class="py-2.5 px-3">Nama Tugas & Rincian</th>
                            <th class="py-2.5 px-3">Penanggung Jawab</th>
                            <th class="py-2.5 px-3">Tenggat Waktu</th>
                            <th class="py-2.5 px-3 text-center">Prioritas</th>
                            <th class="py-2.5 px-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($project->tasks as $idx => $task)
                            <tr>
                                <td class="py-2.5 px-3 text-center font-medium text-slate-500">{{ $idx + 1 }}</td>
                                <td class="py-2.5 px-3">
                                    <span class="font-bold text-slate-900 block {{ $task->status === 'done' ? 'line-through text-slate-400' : '' }}">
                                        {{ $task->title }}
                                    </span>
                                    @if($task->description)
                                        <span class="text-[11px] text-slate-500 block mt-0.5">
                                            {{ $task->description }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-3 font-medium text-slate-800">
                                    {{ $task->assignee->name ?? 'Tim Umum' }}
                                </td>
                                <td class="py-2.5 px-3 text-slate-600">
                                    {{ $task->due_text ?? ($task->due_date ? \Carbon\Carbon::parse($task->due_date)->translatedFormat('d M Y') : 'Fleksibel') }}
                                </td>
                                <td class="py-2.5 px-3 text-center">
                                    <span class="font-semibold {{ $task->priority === 'Tinggi' ? 'text-rose-600' : ($task->priority === 'Sedang' ? 'text-amber-600' : 'text-slate-600') }}">
                                        {{ $task->priority ?: 'Normal' }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-3 text-center">
                                    @if($task->status === 'done')
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">
                                            Proses (To Do)
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-slate-400">Belum ada daftar tugas dalam proyek ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 4. Log Riwayat Aktivitas Lengkap Proyek -->
        <section class="mb-9">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-4 bg-blue-600 rounded-xs"></span>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">
                        IV. REKAM JEJAK LOG AKTIVITAS PROYEK ({{ $project->activities->count() }} Catatan)
                    </h3>
                </div>
                <span class="text-[11px] text-slate-500">Urutan Kronologis Terkini</span>
            </div>

            <div class="overflow-x-auto border border-slate-200 rounded-xl">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200">
                        <tr>
                            <th class="py-2.5 px-3 w-10 text-center">No</th>
                            <th class="py-2.5 px-3 w-40">Waktu & Tanggal</th>
                            <th class="py-2.5 px-3 w-44">Nama Pelaksana</th>
                            <th class="py-2.5 px-3">Aktivitas / Aksi yang Dilakukan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($project->activities as $idx => $act)
                            <tr>
                                <td class="py-2.5 px-3 text-center font-medium text-slate-500">{{ $idx + 1 }}</td>
                                <td class="py-2.5 px-3 text-slate-600 whitespace-nowrap">
                                    <span class="font-bold text-slate-800 block">
                                        {{ $act->created_at ? $act->created_at->translatedFormat('d M Y') : '-' }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 block">
                                        Pukul {{ $act->created_at ? $act->created_at->format('H:i') : '-' }} WIB
                                    </span>
                                </td>
                                <td class="py-2.5 px-3">
                                    <span class="font-bold text-slate-900 block">
                                        {{ $act->user->name ?? 'Anggota Kolaborasi' }}
                                    </span>
                                    <span class="text-[10px] text-slate-500 block">
                                        {{ $act->user->jurusan->kode ?? 'TECH' }} &bull; {{ $act->user->institution ?? 'Talenta' }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-3 text-slate-700">
                                    <span>{{ $act->action }}</span>
                                    @if($act->target)
                                        <strong class="text-slate-900 font-semibold">"{{ $act->target }}"</strong>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-slate-400">Belum ada riwayat aktivitas yang tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 5. Lembar Pengesahan / Tanda Tangan -->
        <section class="avoid-break mt-10 pt-6 border-t border-slate-300">
            <div class="text-right text-xs text-slate-600 mb-8 font-medium">
                Dibuat dan diverifikasi pada: <span class="font-bold text-slate-800">{{ now()->translatedFormat('d F Y') }}</span>
            </div>

            <div class="grid grid-cols-2 gap-8 text-center text-xs">
                <div>
                    <span class="block text-slate-500 font-medium">Mengetahui & Menyetujui,</span>
                    <span class="block font-bold text-slate-900 mt-0.5">Ketua Tim Proyek</span>
                    
                    <!-- Space Tanda Tangan -->
                    <div class="h-20 flex items-center justify-center">
                        <span class="text-[10px] text-slate-300 italic">[ Tanda Tangan Digital / Manual ]</span>
                    </div>

                    <span class="block font-bold text-slate-900 underline">
                        {{ $project->lead->name ?? 'Ketua Tim Proyek' }}
                    </span>
                    <span class="block text-[11px] text-slate-500 mt-0.5">
                        NISN: {{ $project->lead->nisn_nip ?? '.................................' }}
                    </span>
                </div>

                <div>
                    <span class="block text-slate-500 font-medium">Mengetahui & Memverifikasi,</span>
                    <span class="block font-bold text-slate-900 mt-0.5">Guru Pembimbing / Fasilitator</span>
                    
                    <!-- Space Tanda Tangan -->
                    <div class="h-20 flex items-center justify-center">
                        <span class="text-[10px] text-slate-300 italic">[ Tanda Tangan Digital / Manual ]</span>
                    </div>

                    <span class="block font-bold text-slate-900 underline">
                        {{ $project->guru->name ?? '( ............................................................ )' }}
                    </span>
                    <span class="block text-[11px] text-slate-500 mt-0.5">
                        NIP: {{ $project->guru->nisn_nip ?? '.................................' }}
                    </span>
                </div>
            </div>

            <!-- Footer Dokumen -->
            <div class="mt-12 pt-4 border-t border-slate-200 text-center text-[10px] text-slate-400">
                Dokumen ini dicetak secara otomatis melalui WorkHub Talent Network &bull; Platform Kolaborasi Berbasis Proyek (PBL) &bull; Hak Cipta &copy; {{ date('Y') }}
            </div>
        </section>

    </main>

</body>
</html>

