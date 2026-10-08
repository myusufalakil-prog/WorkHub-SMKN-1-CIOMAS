<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - WORKHUB SMKN 1 Ciomas' : 'WORKHUB SMKN 1 Ciomas - Connect. Collaborate. Create.' }}</title>
    <meta name="description" content="WORKHUB: Platform Kolaborasi Antarjurusan Resmi SMKN 1 Ciomas (PPLG, BCF, Animasi, TO, TPFL). Connect. Collaborate. Create.">

    <!-- Favicon & PWA Icons -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#111111">

    <!-- Typography: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Clean Vibrant Theme Init (Dark toggle removed per request) -->
    <script>
        localStorage.removeItem('theme');
        document.documentElement.classList.remove('dark');
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50/90 text-slate-900 font-sans antialiased min-h-screen flex flex-col selection:bg-blue-600 selection:text-white">
    <!-- Clean Minimal Header with Centered Navigation -->
    <header class="h-16 border-b border-slate-200/80 px-4 md:px-8 flex items-center justify-between bg-white/90 backdrop-blur-md sticky top-0 z-30">
        <!-- Left: Logo -->
        <div class="flex items-center">
            <x-logo variant="full" size="md" :href="route('home')" />
        </div>

        <!-- Center: Navigation Links (Beranda & Portal Peran) -->
        <nav class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100/90 border border-slate-200/90 text-xs font-semibold backdrop-blur-sm shadow-xs">
            <a 
                href="{{ route('home') }}" 
                class="px-3.5 py-1.5 rounded-full transition-all {{ request()->routeIs('home') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-950' }}"
            >
                Beranda
            </a>
            <a 
                href="{{ route('portal') }}" 
                class="px-3.5 py-1.5 rounded-full transition-all {{ request()->routeIs('portal') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold shadow-xs' : 'text-slate-600 hover:text-slate-950' }}"
            >
                Portal Peran
            </a>
        </nav>

        <!-- Right: Auth Actions -->
        <div class="flex items-center gap-2 sm:gap-3">
            @auth
                <a 
                    href="{{ route('portal') }}" 
                    class="text-xs font-bold px-3 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:opacity-95 transition-opacity shadow-xs"
                >
                    Portal ({{ auth()->user()->name }})
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs font-semibold text-slate-500 hover:text-rose-600 px-2 py-1 cursor-pointer">
                        Keluar
                    </button>
                </form>
            @else
                <a 
                    href="{{ route('login') }}" 
                    class="text-xs font-bold text-slate-700 hover:text-slate-950 px-3 py-2 rounded-xl border border-slate-300 hover:bg-slate-100 transition-colors"
                >
                    Masuk (Login)
                </a>
                <a 
                    href="{{ route('register') }}" 
                    class="text-xs font-bold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-3.5 py-2 rounded-xl transition-all shadow-xs"
                >
                    Daftar (Register)
                </a>
            @endauth
        </div>
    </header>

    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Clean Footer -->
    <footer class="border-t border-neutral-200 dark:border-[#222222] py-8 px-4 text-center text-xs text-neutral-500 dark:text-neutral-400">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <x-logo variant="compact" size="sm" />
                <span class="font-bold text-neutral-900 dark:text-white">WORKHUB</span>
                <span class="text-neutral-400 dark:text-neutral-600">&bull;</span>
                <span class="font-semibold text-neutral-700 dark:text-neutral-300">SMKN 1 Ciomas</span>
                <span class="text-neutral-400 dark:text-neutral-600">&bull;</span>
                <span>Connect. Collaborate. Create.</span>
            </div>
            <div>
                Platform Kolaborasi Lintas 5 Kejuruan &bull; SMKN 1 Ciomas Kabupaten Bogor
            </div>
        </div>
    </footer>
</body>
</html>
