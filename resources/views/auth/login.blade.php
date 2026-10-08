<x-guest-layout title="Masuk ke Akun - SMKN 1 Ciomas">
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Ambient Background Glows -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-gradient-to-tr from-blue-600/15 via-purple-600/15 to-amber-500/15 blur-[120px] rounded-full pointer-events-none -z-10"></div>
        <div class="absolute bottom-10 left-10 w-64 h-64 bg-blue-500/10 blur-[90px] rounded-full pointer-events-none -z-10"></div>
        <div class="absolute bottom-10 right-10 w-64 h-64 bg-purple-500/10 blur-[90px] rounded-full pointer-events-none -z-10"></div>

        <div class="max-w-md w-full relative z-10 space-y-6">
            <!-- Header Card -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-extrabold text-lg shadow-md mb-4 shadow-blue-500/20">
                    WH
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-neutral-950 dark:text-white">
                    Masuk ke WORKHUB
                </h1>
                <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 mt-1.5">
                    Platform Kolaborasi Siswa & Guru SMKN 1 Ciomas.
                </p>
            </div>

            <!-- Login Form Card -->
            <div class="bg-white/90 dark:bg-[#161616]/90 backdrop-blur-md border border-neutral-200/80 dark:border-[#262626] rounded-2xl p-6 sm:p-8 shadow-xl">
                <!-- Session Alert -->
                @if(session('info'))
                    <div class="mb-5 p-3 rounded-xl bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-300 text-xs flex items-center gap-2">
                        <x-icon name="info" class="w-4 h-4 shrink-0" />
                        <span>{{ session('info') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-5 p-3 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-xs flex items-center gap-2">
                        <x-icon name="alert-circle" class="w-4 h-4 shrink-0" />
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email Gmail -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-1.5">
                            Alamat Email Gmail (@gmail.com)
                        </label>
                        <div class="relative">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus
                                placeholder="nama.anda@gmail.com"
                                class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#1C1C1C] text-neutral-900 dark:text-white placeholder-neutral-400 border {{ $errors->has('email') ? 'border-rose-500 focus:border-rose-500' : 'border-neutral-300 dark:border-neutral-700 focus:border-blue-500 dark:focus:border-blue-400' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all"
                            />
                        </div>
                        @error('email')
                            <p class="text-xs text-rose-600 dark:text-rose-400 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300">
                                Kata Sandi
                            </label>
                        </div>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required
                                placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                                class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#1C1C1C] text-neutral-900 dark:text-white placeholder-neutral-400 border border-neutral-300 dark:border-neutral-700 rounded-xl focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 transition-all pr-10"
                            />
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility('password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200"
                                title="Lihat kata sandi"
                            >
                                <x-icon name="eye" class="w-4 h-4" />
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-rose-600 dark:text-rose-400 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                class="rounded border-neutral-300 dark:border-neutral-700 text-blue-600 focus:ring-blue-500"
                            />
                            <span class="text-xs text-neutral-600 dark:text-neutral-400 font-medium">Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button 
                            type="submit"
                            class="w-full py-2.5 px-4 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-md hover:shadow-lg hover:shadow-blue-500/25 cursor-pointer"
                        >
                            Masuk Sekarang
                        </button>
                    </div>
                </form>

                <!-- Divider & Register Link -->
                <div class="mt-6 pt-5 border-t border-neutral-100 dark:border-[#222222] text-center">
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">
                        Belum memiliki akun siswa? 
                        <a href="{{ route('register') }}" class="font-bold text-blue-600 dark:text-blue-400 hover:underline underline-offset-4 transition-all">
                            Daftar Akun Siswa Baru
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function togglePasswordVisibility(fieldId) {
            const input = document.getElementById(fieldId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
    @endpush
</x-guest-layout>
