<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk ke akun Anda terlebih dahulu.');
        }

        $user = auth()->user();

        // Akun All-Role (admin) memiliki hak akses penuh ke semua portal (Siswa, OSIS, Guru)
        if ($user->role === 'admin') {
            return $next($request);
        }

        if (!in_array($user->role, $roles)) {
            return match ($user->role) {
                'osis' => redirect()->route('osis.dashboard')->with('error', 'Akses ditolak. Anda dialihkan ke Portal OSIS yang sesuai dengan peran Anda.'),
                'guru' => redirect()->route('guru.dashboard')->with('error', 'Akses ditolak. Anda dialihkan ke Portal Guru Pembimbing yang sesuai dengan peran Anda.'),
                default => redirect()->route('siswa.dashboard')->with('error', 'Akses ditolak. Anda dialihkan ke Portal Siswa yang sesuai dengan peran Anda.'),
            };
        }

        return $next($request);
    }
}
