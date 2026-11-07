
<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PengaduanController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// LOGIN
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    // REDIRECT DASHBOARD BERDASARKAN ROLE
    Route::get('/redirect-dashboard', function () {
        /** @var User|null $user */
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/dashboard');
    })->name('redirect.dashboard');

    // ==================================================
    // MAHASISWA
    // ==================================================

    Route::middleware(['role:mahasiswa'])->group(function () {

        Route::get(
            '/dashboard',
            [PengaduanController::class, 'indexMahasiswa']
        )->name('mahasiswa.dashboard');

        Route::post(
            '/pengaduan',
            [PengaduanController::class, 'store']
        )->name('pengaduan.store');

        Route::get(
            '/pengaduan/{id}/edit',
            [PengaduanController::class, 'edit']
        )->name('pengaduan.edit');

        Route::put(
            '/pengaduan/{id}',
            [PengaduanController::class, 'update']
        )->name('pengaduan.update');

        Route::delete(
            '/pengaduan/{id}',
            [PengaduanController::class, 'destroy']
        )->name('pengaduan.destroy');
    });

    // ==================================================
    // ADMIN
    // ==================================================

    Route::middleware(['role:admin'])->group(function () {

        // Dashboard kartu laporan
        Route::get(
            '/admin/dashboard',
            [PengaduanController::class, 'indexAdmin']
        )->name('admin.dashboard');

        // Detail laporan ketika kartu diklik
        Route::get(
            '/admin/pengaduan/{id}',
            [PengaduanController::class, 'showAdmin']
        )->name('admin.pengaduan.show');

        // Update status dari halaman detail
        Route::put(
            '/admin/pengaduan/{id}/status',
            [PengaduanController::class, 'updateStatus']
        )->name('admin.pengaduan.status');
    });
});
