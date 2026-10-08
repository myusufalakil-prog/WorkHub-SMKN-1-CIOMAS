@props([
    'current' => 'beranda',
])

@php
    $tabs = [
        ['id' => 'beranda', 'label' => 'Beranda', 'icon' => 'home', 'href' => route('dashboard')],
        ['id' => 'proyek', 'label' => 'Proyek', 'icon' => 'folder-kanban', 'href' => route('projects.index')],
        ['id' => 'create', 'label' => 'Buat', 'icon' => 'plus', 'href' => route('projects.create'), 'isAction' => true],
        ['id' => 'notifikasi', 'label' => 'Notifikasi', 'icon' => 'bell', 'href' => route('notifications.index')],
        ['id' => 'profil', 'label' => 'Profil', 'icon' => 'user', 'href' => route('profile.show', auth()->id() ?? 1)],
    ];
@endphp

<nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white/95 dark:bg-[#0f172a]/95 backdrop-blur-md border-t border-slate-200/90 dark:border-slate-800 z-40 px-3 py-1.5 safe-area-pb">
    <div class="flex items-center justify-around max-w-lg mx-auto">
        @foreach($tabs as $tab)
            @if(!empty($tab['isAction']))
                <!-- Elevated '+' Action button for creating projects -->
                <a 
                    href="{{ $tab['href'] }}" 
                    class="-mt-5 w-12 h-12 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/30 active:scale-95 transition-transform"
                    title="Buat Proyek Baru"
                >
                    <x-icon name="plus" class="w-6 h-6 stroke-[2.5]" />
                </a>
            @else
                @php $isActive = $current === $tab['id']; @endphp
                <a 
                    href="{{ $tab['href'] }}" 
                    class="flex flex-col items-center justify-center py-1 px-2.5 rounded-lg text-xs font-medium transition-colors {{ $isActive ? 'text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-white' }}"
                >
                    <div class="relative">
                        <x-icon :name="$tab['icon']" class="w-5 h-5 {{ $isActive ? 'stroke-[2.2]' : 'stroke-[1.6]' }}" />
                        @if($tab['id'] === 'notifikasi')
                            <span class="absolute -top-1 -right-1 w-2 h-2 rounded-full bg-rose-500 ring-1 ring-white dark:ring-[#0f172a] animate-pulse"></span>
                        @endif
                    </div>
                    <span class="text-[10px] mt-1 tracking-tight">{{ $tab['label'] }}</span>
                </a>
            @endif
        @endforeach
    </div>
</nav>
