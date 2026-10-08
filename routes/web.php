<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkhubController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\OsisController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes - WORKHUB
| "Connect. Collaborate. Create."
| URL Siswa dan OSIS Dibedakan Secara Terstruktur dengan Auth & Role
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. PUBLIC ROUTES & AUTHENTICATION
// =========================================================================
Route::get('/', [WorkhubController::class, 'welcome'])->name('home');
Route::get('/portal', [WorkhubController::class, 'portal'])->name('portal');

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Authenticated Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Global Dynamic Dashboard Redirect (Mengarah ke portal yang sesuai dengan sesi login)
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('portal');
    }

    return match (auth()->user()->role) {
        'admin' => redirect()->route('portal')->with('success', 'Selamat datang Administrator! Anda memiliki akses penuh ke portal Siswa dan OSIS.'),
        'osis' => redirect()->route('osis.dashboard'),
        default => redirect()->route('siswa.dashboard'),
    };
})->name('dashboard');

// =========================================================================
// 2. URL KHUSUS SISWA (/siswa/...) - Terproteksi Auth & Role Siswa
// =========================================================================
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/proyek', [SiswaController::class, 'projects'])->name('proyek.index');
    Route::get('/proyek/buat', [SiswaController::class, 'createProject'])->name('proyek.create');
    Route::post('/proyek', [SiswaController::class, 'storeProject'])->name('proyek.store');
    Route::post('/proyek/{id}/join', [SiswaController::class, 'applyJoinProject'])->name('proyek.join');
    Route::post('/proyek/{id}/members/{userId}/approve', [SiswaController::class, 'approveMember'])->name('proyek.member.approve');
    Route::post('/proyek/{id}/members/{userId}/reject', [SiswaController::class, 'rejectMember'])->name('proyek.member.reject');
    
    // Workspace Interaktif
    Route::get('/workspace/{id?}', [SiswaController::class, 'workspace'])->name('workspace');
    Route::post('/workspace/{id}/tugas', [SiswaController::class, 'storeTask'])->name('workspace.task.store');
    Route::post('/workspace/{id}/tugas/{taskId}/status', [SiswaController::class, 'updateTaskStatus'])->name('workspace.task.status');
    Route::post('/workspace/{id}/chat', [SiswaController::class, 'sendMessage'])->name('workspace.chat.send');
    Route::post('/workspace/{id}/file', [SiswaController::class, 'storeFile'])->name('workspace.file.store');

    Route::get('/match', [SiswaController::class, 'match'])->name('match');
    
    // Profil, Portfolio & Skills
    Route::get('/profil/{id?}', [SiswaController::class, 'profile'])->name('profil');
    Route::post('/profil/update', [SiswaController::class, 'updateProfile'])->name('profil.update');
    Route::post('/portofolio/store', [SiswaController::class, 'storePortfolio'])->name('portofolio.store');
    Route::post('/skill/store', [SiswaController::class, 'storeSkill'])->name('skill.store');

    Route::get('/notifikasi', [SiswaController::class, 'notifications'])->name('notifikasi');
    Route::post('/notifikasi/read-all', [SiswaController::class, 'markAllNotificationsRead'])->name('notifikasi.readAll');
    Route::get('/showcase', [SiswaController::class, 'showcase'])->name('showcase');
});

// =========================================================================
// 3. URL KHUSUS OSIS (/osis/...) - Terproteksi Auth & Role OSIS
// =========================================================================
Route::prefix('osis')->name('osis.')->middleware(['auth', 'role:osis'])->group(function () {
    Route::get('/dashboard', [OsisController::class, 'dashboard'])->name('dashboard');
    Route::get('/events', [OsisController::class, 'events'])->name('events');
    Route::post('/events', [OsisController::class, 'storeEvent'])->name('events.store');
    Route::get('/proyek', [OsisController::class, 'projects'])->name('proyek');
    Route::get('/projects', [OsisController::class, 'projects'])->name('projects');
    Route::get('/kurasi', [OsisController::class, 'kurasi'])->name('kurasi');
    Route::post('/kurasi/{id}/approve', [OsisController::class, 'approveKurasi'])->name('kurasi.approve');
    Route::get('/jurusan', [OsisController::class, 'jurusan'])->name('jurusan');
    Route::match(['get', 'post'], '/broadcast', [OsisController::class, 'broadcast'])->name('broadcast');
});

// =========================================================================
// 4. ALIAS ROUTES UNTUK KOMPATIBILITAS GLOBAL
// =========================================================================
Route::get('/proyek', function () { return redirect()->route('siswa.proyek.index'); })->name('projects.index');
Route::get('/proyek/buat', function () { return redirect()->route('siswa.proyek.create'); })->name('projects.create');
Route::post('/proyek', [SiswaController::class, 'storeProject'])->name('projects.store');
Route::get('/workspace/{id?}', function ($id = 1) { return redirect()->route('siswa.workspace', $id); })->name('workspace.show');
Route::get('/match', function () { return redirect()->route('siswa.match'); })->name('match.index');
Route::get('/profil/{id?}', function ($id = 1) { return redirect()->route('siswa.profil', $id); })->name('profile.show');
Route::get('/notifikasi', function () { return redirect()->route('siswa.notifikasi'); })->name('notifications.index');
Route::get('/showcase', function () { return redirect()->route('siswa.showcase'); })->name('showcase.index');
Route::get('/dashboard/siswa', function () { return redirect()->route('siswa.dashboard'); })->name('dashboard.siswa');
Route::get('/dashboard/osis', function () { return redirect()->route('osis.dashboard'); })->name('dashboard.osis');
Route::get('/dashboard/guru', function () { return redirect()->route('siswa.dashboard'); })->name('dashboard.guru');
Route::get('/guru/dashboard', function () { return redirect()->route('siswa.dashboard'); })->name('guru.dashboard');
