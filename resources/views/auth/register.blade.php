<x-guest-layout title="Daftar Akun Siswa - SMKN 1 Ciomas">
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Ambient Background Glows -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[350px] bg-gradient-to-tr from-blue-600/15 via-purple-600/15 to-amber-500/15 blur-[120px] rounded-full pointer-events-none -z-10"></div>
        <div class="absolute bottom-10 left-10 w-72 h-72 bg-blue-500/10 blur-[100px] rounded-full pointer-events-none -z-10"></div>
        <div class="absolute bottom-10 right-10 w-72 h-72 bg-purple-500/10 blur-[100px] rounded-full pointer-events-none -z-10"></div>

        <div class="max-w-xl w-full relative z-10 space-y-6">
            <!-- Header Card -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-extrabold text-lg shadow-md mb-4 shadow-blue-500/20">
                    WH
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-neutral-950 dark:text-white">
                    Pendaftaran Siswa SMKN 1 Ciomas
                </h1>
                <p class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 mt-1.5 max-w-md mx-auto">
                    Buat akun siswa untuk mulai berkolaborasi dalam proyek nyata lintas 5 kejuruan SMKN 1 Ciomas.
                </p>
            </div>

            <!-- Register Form Card -->
            <div class="bg-white/90 dark:bg-[#161616]/90 backdrop-blur-md border border-neutral-200/80 dark:border-[#262626] rounded-2xl p-6 sm:p-8 shadow-xl">
                <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-1.5">
                            Nama Lengkap Siswa <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            placeholder="Contoh: Raka Pratama"
                            class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#1C1C1C] text-neutral-900 dark:text-white placeholder-neutral-400 border {{ $errors->has('name') ? 'border-rose-500' : 'border-neutral-300 dark:border-neutral-700 focus:border-blue-500 dark:focus:border-blue-400' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all"
                        />
                        @error('name')
                            <p class="text-xs text-rose-600 dark:text-rose-400 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 2 Grid: Kelas & Jurusan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="kelas" class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-1.5">
                                Kelas Siswa <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="kelas" 
                                name="kelas" 
                                value="{{ old('kelas') }}" 
                                required 
                                placeholder="Contoh: XI PPLG 1"
                                class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#1C1C1C] text-neutral-900 dark:text-white placeholder-neutral-400 border {{ $errors->has('kelas') ? 'border-rose-500' : 'border-neutral-300 dark:border-neutral-700 focus:border-blue-500 dark:focus:border-blue-400' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all"
                            />
                            @error('kelas')
                                <p class="text-xs text-rose-600 dark:text-rose-400 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jurusan_id" class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-1.5">
                                Program Keahlian / Jurusan <span class="text-rose-500">*</span>
                            </label>
                            <select 
                                id="jurusan_id" 
                                name="jurusan_id" 
                                required
                                class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#1C1C1C] text-neutral-900 dark:text-white border {{ $errors->has('jurusan_id') ? 'border-rose-500' : 'border-neutral-300 dark:border-neutral-700 focus:border-blue-500 dark:focus:border-blue-400' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all"
                            >
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($jurusans as $j)
                                    <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>
                                        {{ $j->kode }} - {{ $j->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <p class="text-xs text-rose-600 dark:text-rose-400 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-1.5">
                            Alamat Email Gmail (@gmail.com) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            placeholder="nama.siswa@gmail.com"
                            class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#1C1C1C] text-neutral-900 dark:text-white placeholder-neutral-400 border {{ $errors->has('email') ? 'border-rose-500' : 'border-neutral-300 dark:border-neutral-700 focus:border-blue-500 dark:focus:border-blue-400' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all"
                        />
                        <p class="text-[11px] text-neutral-400 dark:text-neutral-500 mt-1">
                            Akun pendaftaran wajib menggunakan domain resmi <strong>@gmail.com</strong>
                        </p>
                        @error('email')
                            <p class="text-xs text-rose-600 dark:text-rose-400 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 2 Grid: Password & Konfirmasi Password -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-1.5">
                                Kata Sandi <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required
                                placeholder="Minimal 6 karakter"
                                class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#1C1C1C] text-neutral-900 dark:text-white placeholder-neutral-400 border {{ $errors->has('password') ? 'border-rose-500' : 'border-neutral-300 dark:border-neutral-700 focus:border-blue-500 dark:focus:border-blue-400' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all"
                            />
                            @error('password')
                                <p class="text-xs text-rose-600 dark:text-rose-400 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-1.5">
                                Ulangi Sandi <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required
                                placeholder="Ketik ulang sandi"
                                class="w-full px-3.5 py-2.5 text-sm bg-neutral-50 dark:bg-[#1C1C1C] text-neutral-900 dark:text-white placeholder-neutral-400 border border-neutral-300 dark:border-neutral-700 focus:border-blue-500 dark:focus:border-blue-400 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all"
                            />
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-3">
                        <button 
                            type="submit"
                            class="w-full py-2.5 px-4 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white transition-all shadow-md hover:shadow-lg hover:shadow-blue-500/25 cursor-pointer"
                        >
                            Daftar Sekarang & Masuk
                        </button>
                    </div>
                </form>

                <!-- Divider & Login Link -->
                <div class="mt-6 pt-5 border-t border-neutral-100 dark:border-[#222222] text-center">
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">
                        Sudah memiliki akun terdaftar? 
                        <a href="{{ route('login') }}" class="font-bold text-blue-600 dark:text-blue-400 hover:underline underline-offset-4 transition-all">
                            Masuk ke Akun Anda
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
