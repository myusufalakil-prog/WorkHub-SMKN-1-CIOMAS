<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Jurusan;

class AuthController extends Controller
{
    /**
     * Tampilkan formulir login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi login (khusus Email Gmail & Password)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $credentials = [
            'email' => strtolower(trim($request->input('email'))),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            return $this->redirectBasedOnRole($user, "Selamat datang kembali, {$user->name}!");
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau kata sandi yang Anda masukkan tidak cocok.',
            ]);
    }

    /**
     * Tampilkan formulir pendaftaran akun (Khusus Siswa)
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        $jurusans = Jurusan::all();
        return view('auth.register', compact('jurusans'));
    }

    /**
     * Proses pendaftaran akun siswa baru (Tanpa NISN)
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'institution' => 'nullable|string|max:150',
            'kelas' => 'nullable|string|max:100',
            'jurusan_id' => 'required|exists:jurusans,id',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email aktif wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau masuk.',
            'jurusan_id.required' => 'Silakan pilih domain keahlian utama Anda.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $institution = trim((string) $request->input('institution')) ?: (trim((string) $request->input('kelas')) ?: 'Independen / Komunitas');

        $user = User::create([
            'name' => trim($request->name),
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'nisn_nip' => null,
            'kelas' => $institution,
            'institution' => $institution,
            'jurusan_id' => $request->jurusan_id,
            'jabatan' => 'Kolaborator & Kreator',
            'headline' => 'Talenta & Kolaborator Proyek',
            'bio' => 'Talenta aktif yang siap berkolaborasi dalam proyek inovasi multidisiplin di SynapseHub.',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('siswa.dashboard')->with('success', 'Akun berhasil dibuat! Selamat datang di jaringan kolaborasi SynapseHub.');
    }

    /**
     * Proses keluar akun (Logout)
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah keluar dari akun dengan aman.');
    }

    /**
     * Helper redirect berdasarkan role
     */
    protected function redirectBasedOnRole(User $user, ?string $message = null)
    {
        $redirect = match ($user->role) {
            'admin' => redirect()->route('portal'),
            'osis' => redirect()->route('osis.dashboard'),
            default => redirect()->route('siswa.dashboard'),
        };

        return $message ? $redirect->with('success', $message) : $redirect;
    }
}
