<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - WORKHUB SMKN 1 Ciomas' : 'WORKHUB SMKN 1 Ciomas - Connect. Collaborate. Create.' }}</title>
    <meta name="description" content="Platform kolaborasi lintas jurusan resmi siswa SMKN 1 Ciomas. Temukan tim impian, kelola proyek bersama, dan bangun portofolio industri nyata.">

    <!-- Favicon & PWA Icons (Mandatory WORKHUB Connection Hub Icon) -->
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
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen flex selection:bg-blue-600 selection:text-white">
    <!-- Desktop Sidebar -->
    <x-sidebar :current="$current ?? 'beranda'" :role="$role ?? 'student'" />

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen pb-20 lg:pb-0">
        <!-- Top Navbar -->
        <x-navbar :title="$pageTitle ?? null" />

        <!-- Notification Toast Flash (if any) -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto w-full px-4 md:px-8 mt-4">
                <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-4 py-3 rounded-xl flex items-center justify-between text-sm shadow-xs">
                    <div class="flex items-center gap-2">
                        <x-icon name="check" class="w-4 h-4 text-emerald-600 dark:text-emerald-400 stroke-[2.5]" />
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main class="flex-1 px-4 md:px-8 py-6 md:py-8 max-w-7xl w-full mx-auto">
            {{ $slot }}
        </main>
    </div>

    <!-- Mobile Bottom Navigation -->
    <x-bottom-nav :current="$current ?? 'beranda'" />

    @stack('scripts')
</body>
</html>
