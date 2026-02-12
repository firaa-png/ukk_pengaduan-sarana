<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Siswa\SiswaAreaController;

// Public routes
// Redirect root to login so opening the project goes directly to the login page
Route::get('/', function () {
    // use the named 'login' route, or fallback to the /login URL
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public student dashboard (temporary): allow visiting /dashboard without admin login
Route::get('/dashboard', [SiswaAreaController::class, 'dashboard'])->name('dashboard');

    // Temporary debug route: check siswa by nis and kelas (returns JSON) — remove in production
Route::get('/debug/siswa-check', function (\Illuminate\Http\Request $request) {
    $nis = $request->query('nis');
    $kelas = $request->query('kelas');
    if (!$nis || !$kelas) {
        return response()->json(['ok' => false, 'error' => 'Provide nis and kelas as query params'], 400);
    }

    $siswa = \App\Models\Siswa::whereRaw('LOWER(TRIM(nis)) = ?', [strtolower(trim($nis))])->first();
    if (!$siswa) {
        return response()->json(['ok' => false, 'found' => false, 'reason' => 'nis_not_found']);
    }

    $kelasDb = isset($siswa->kelas) ? strtolower(trim($siswa->kelas)) : '';
    $match = ($kelasDb === strtolower(trim($kelas)));
    return response()->json(['ok' => true, 'found' => true, 'id' => $siswa->id, 'nis' => $siswa->nis, 'kelas_db' => $siswa->kelas, 'kelas_match' => $match]);
});

// Public pengaduan show (allow siswa to view details without admin auth)
Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');

// Admin routes (grouped under /admin and protected)
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Admin resources
    Route::resource('siswa', SiswaController::class);
    Route::get('/data-siswa', [SiswaController::class, 'index'])->name('data-siswa');

    Route::resource('kategori', KategoriController::class);
    Route::get('/data-kategori', [KategoriController::class, 'index'])->name('data-kategori');

    Route::resource('pengaduan', PengaduanController::class);
    Route::get('/daftar-pengaduan', [PengaduanController::class, 'index'])->name('daftar-pengaduan');

    // Protected admin-only actions
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::post('/pengaduan/{pengaduan}/selesai', [PengaduanController::class, 'selesai'])->name('pengaduan.selesai');
    // Update status and feedback (admin)
    Route::post('/pengaduan/{pengaduan}/update-status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.update_status');
    Route::get('/pengaduan-export', [PengaduanController::class, 'export'])->name('pengaduan.export');
});

    // Siswa area (accessible without admin login)
Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaAreaController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [SiswaAreaController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [SiswaAreaController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [SiswaAreaController::class, 'updateProfile'])->name('profile.update');
    Route::get('/aspirasi', [SiswaAreaController::class, 'createAspirasi'])->name('create-aspirasi');
    Route::get('/aspirasi/tambah', [SiswaAreaController::class, 'tambahAspirasi'])->name('tambah-aspirasi');
    Route::post('/aspirasi', [SiswaAreaController::class, 'storeAspirasi'])->name('store-aspirasi');
    Route::get('/history', [SiswaAreaController::class, 'history'])->name('history');
    // NOTE: quick-login removed — students now login via the main login form (username/password or NIS)
    // Allow siswa to edit/delete their own pengaduan from the siswa area
    Route::get('/pengaduan/{pengaduan}/edit', [SiswaAreaController::class, 'editPengaduan'])->name('pengaduan.edit');
    Route::put('/pengaduan/{pengaduan}', [SiswaAreaController::class, 'updatePengaduan'])->name('pengaduan.update');
    Route::delete('/pengaduan/{pengaduan}', [SiswaAreaController::class, 'destroyPengaduan'])->name('pengaduan.destroy');
});


