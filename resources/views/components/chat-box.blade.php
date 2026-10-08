@props([
    'messages' => [
        [
            'id' => 1,
            'user' => 'Raka Pratama',
            'major' => 'XI PPLG 1',
            'avatar' => null,
            'isMe' => false,
            'text' => 'Halo tim! Desain UI untuk modul pendaftaran festival sudah selesai. Ada yang mau review prototipe figma-nya?',
            'time' => '10:14',
            'attachment' => 'figma-prototype-v2.fig',
        ],
        [
            'id' => 2,
            'user' => 'Alisha Nadia',
            'major' => 'XI Animasi 2',
            'avatar' => null,
            'isMe' => false,
            'text' => 'Keren Raka! Aset animasi 3D maskot sekolah juga sudah saya ekspor ke format GLTF dan siap diintegrasikan.',
            'time' => '10:20',
            'attachment' => null,
        ],
        [
            'id' => 3,
            'user' => 'Saya',
            'major' => 'XI PPLG 1',
            'avatar' => null,
            'isMe' => true,
            'text' => 'Mantap! Saya sambungkan ke backend API Laravel dan database SQLite hari ini.',
            'time' => '10:25',
            'attachment' => null,
        ],
    ]
])

<div class="flex flex-col h-[520px] bg-white dark:bg-[#181818] border border-neutral-200 dark:border-[#2A2A2A] rounded-xl overflow-hidden shadow-xs">
    <!-- Chat Header -->
    <div class="px-5 py-3.5 border-b border-neutral-200 dark:border-[#2A2A2A] flex items-center justify-between bg-neutral-50/50 dark:bg-[#151515]">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-neutral-900 text-white dark:bg-white dark:text-neutral-900 font-bold text-xs flex items-center justify-center">
                <x-icon name="message-square" class="w-4 h-4" />
            </div>
            <div>
                <h4 class="text-sm font-bold text-neutral-900 dark:text-white leading-tight">
                    Chat Kolaborasi Tim
                </h4>
                <span class="text-[11px] text-neutral-500 dark:text-neutral-400 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    3 Anggota Aktif &bull; Realtime
                </span>
            </div>
        </div>

        <button type="button" class="text-xs text-neutral-500 hover:text-neutral-900 dark:hover:text-white transition-colors">
            <x-icon name="more-horizontal" class="w-5 h-5" />
        </button>
    </div>

    <!-- Messages Container -->
    <div class="flex-1 p-4 md:p-5 overflow-y-auto space-y-4 text-xs md:text-sm">
        @foreach($messages as $msg)
            <div class="flex gap-3 {{ $msg['isMe'] ? 'flex-row-reverse' : '' }}">
                <!-- Avatar -->
                <div class="w-8 h-8 rounded-lg bg-neutral-200 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 font-bold text-xs flex items-center justify-center shrink-0">
                    {{ strtoupper(substr($msg['user'], 0, 2)) }}
                </div>

                <!-- Message bubble content -->
                <div class="max-w-[78%] space-y-1">
                    <div class="flex items-center gap-2 {{ $msg['isMe'] ? 'justify-end' : '' }}">
                        <span class="font-bold text-xs text-neutral-900 dark:text-white">
                            {{ $msg['user'] }}
                        </span>
                        <span class="text-[10px] text-neutral-400">
                            {{ $msg['major'] }} &bull; {{ $msg['time'] }}
                        </span>
                    </div>

                    <div class="p-3.5 rounded-xl {{ $msg['isMe'] ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-tr-none shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-100 rounded-tl-none border border-slate-200/70 dark:border-slate-700/70' }} leading-relaxed">
                        <p>{{ $msg['text'] }}</p>

                        @if($msg['attachment'])
                            <div class="mt-2.5 pt-2 border-t {{ $msg['isMe'] ? 'border-neutral-700 dark:border-neutral-200' : 'border-neutral-200 dark:border-neutral-700' }} flex items-center gap-2 text-xs">
                                <x-icon name="paperclip" class="w-3.5 h-3.5" />
                                <span class="truncate font-medium underline cursor-pointer">{{ $msg['attachment'] }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Input Box -->
    <div class="p-3.5 border-t border-neutral-200 dark:border-[#2A2A2A] bg-white dark:bg-[#181818]">
        <form class="flex items-center gap-2" onsubmit="event.preventDefault();">
            <button 
                type="button" 
                class="p-2 text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200 rounded-lg hover:bg-neutral-100 dark:hover:bg-[#222222] transition-colors"
                title="Lampirkan File"
            >
                <x-icon name="paperclip" class="w-4 h-4" />
            </button>

            <input 
                type="text" 
                placeholder="Tulis pesan ke tim..." 
                class="flex-1 py-2 px-3 text-xs md:text-sm bg-neutral-100 dark:bg-[#141414] text-neutral-900 dark:text-white placeholder-neutral-400 rounded-lg border border-transparent focus:border-neutral-300 dark:focus:border-neutral-700 focus:outline-none focus:bg-white dark:focus:bg-[#111111] transition-all"
            />

            <x-button variant="primary" size="sm" icon="send">
                Kirim
            </x-button>
        </form>
    </div>
</div>
