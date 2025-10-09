<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratTugasController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [GuestController::class, "home"])->name('home');
Route::get('/kelompok-kerja/{kelompokKerja?}', [GuestController::class, "kelompokKerja"])->name('kelompok-kerja');
Route::get('/profil-organisasi', [GuestController::class, "profilOrganisasi"])->name('profil-organisasi');
Route::get('/struktur-organisasi', [GuestController::class, "strukturOrganisasi"])->name('struktur-organisasi');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class)->names('users');

    Route::resource('surat-masuk', SuratMasukController::class)->names('surat-masuk');
    Route::resource('surat-keluar', SuratKeluarController::class)->names('surat-keluar');
    Route::resource('surat-tugas', SuratTugasController::class)->names('surat-tugas')->parameters([
        'surat-tugas' => 'surat_tugas'
    ]);

    Route::post('/files', [FileController::class, 'store'])->name('files.store');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');
    Route::get('/files/{file}/preview', [FileController::class, 'preview'])->name('files.preview');
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
