<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\RaportController;

// Halaman Publik
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/berita/{id}', [BerandaController::class, 'beritaShow'])->name('berita.show');
Route::get('/fasilitas', [BerandaController::class, 'fasilitas'])->name('fasilitas');

// Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/logout', [AuthController::class, 'logout']);

// Panel Dashboard (Harus Login)
Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');

    // Khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('siswa', SiswaController::class);
        Route::delete('siswa/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    });

    // Khusus Guru
    Route::middleware('role:guru')->group(function () {
        Route::resource('nilai', NilaiController::class);
        Route::post('nilai/bulk', [NilaiController::class, 'bulkStore'])->name('nilai.bulk');
        Route::post('nilai/add-uh', [NilaiController::class, 'addUh'])->name('nilai.add-uh');
        Route::post('nilai/update-uh/{id}', [NilaiController::class, 'updateUh'])->name('nilai.update-uh');
        Route::post('nilai/delete-uh/{id}', [NilaiController::class, 'deleteUh'])->name('nilai.delete-uh');
    });

    // Raport
    Route::get('raport/{siswa}', [RaportController::class, 'show'])->name('raport.show');
    Route::get('raport/{siswa}/cetak', [RaportController::class, 'cetak'])->name('raport.cetak');

    // API Data Chart
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('chart/mapel', [DashboardController::class, 'chartMapel'])->name('chart.mapel');
        Route::get('chart/tren', [DashboardController::class, 'chartTren'])->name('chart.tren');
        Route::get('chart/grade', [DashboardController::class, 'chartGrade'])->name('chart.grade');
        Route::get('raport/{siswa}', [RaportController::class, 'apiRaport'])->name('raport.api');
    });
});
