<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratTugasController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Permission\Contracts\Role;

Route::get('/', [GuestController::class, "home"])->name('home');
Route::get('/kelompok-kerja/{kelompokKerja?}', [GuestController::class, "kelompokKerja"])->name('kelompok-kerja');
Route::get('/profil-organisasi', [GuestController::class, "profilOrganisasi"])->name('profil-organisasi');
Route::get('/struktur-organisasi', [GuestController::class, "strukturOrganisasi"])->name('struktur-organisasi');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Roles
    Route::get('users/roles', [RoleController::class, 'index'])->name('users.roles.index')->middleware('can:user-role-index');
    Route::get('users/roles/create', [RoleController::class, 'create'])->name('users.roles.create')->middleware('can:user-role-create');
    Route::post('users/roles', [RoleController::class, 'store'])->name('users.roles.store')->middleware('can:user-role-create');
    Route::get('users/roles/{role}/edit', [RoleController::class, 'edit'])->name('users.roles.edit')->middleware('can:user-role-update');
    Route::put('users/roles/{role}', [RoleController::class, 'update'])->name('users.roles.update')->middleware('can:user-role-update');
    Route::delete('users/roles/{role}', [RoleController::class, 'destroy'])->name('users.roles.destroy')->middleware('can:user-role-delete');

    // Users
    Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware('can:user-index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create')->middleware('can:user-create');
    Route::post('users', [UserController::class, 'store'])->name('users.store')->middleware('can:user-create');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('can:user-update');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('can:user-update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('can:user-delete');
    
    // Surat Masuk
    Route::get('surat-masuk', [SuratMasukController::class, 'index'])->name('surat-masuk.index')->middleware('can:surat-masuk-index');
    Route::get('surat-masuk/create', [SuratMasukController::class, 'create'])->name('surat-masuk.create')->middleware('can:surat-masuk-create');
    Route::post('surat-masuk', [SuratMasukController::class, 'store'])->name('surat-masuk.store')->middleware('can:surat-masuk-create');
    Route::get('surat-masuk/{surat_masuk}/show', [SuratMasukController::class, 'show'])->name('surat-masuk.show')->middleware('can:surat-masuk-index');
    Route::get('surat-masuk/{surat_masuk}/edit', [SuratMasukController::class, 'edit'])->name('surat-masuk.edit')->middleware('can:surat-masuk-update');
    Route::put('surat-masuk/{surat_masuk}', [SuratMasukController::class, 'update'])->name('surat-masuk.update')->middleware('can:surat-masuk-update');
    Route::delete('surat-masuk/{surat_masuk}', [SuratMasukController::class, 'destroy'])->name('surat-masuk.destroy')->middleware('can:surat-masuk-delete');

    // Surat Keluar
    Route::get('surat-keluar', [SuratKeluarController::class, 'index'])->name('surat-keluar.index')->middleware('can:surat-keluar-index');
    Route::get('surat-keluar/create', [SuratKeluarController::class, 'create'])->name('surat-keluar.create')->middleware('can:surat-keluar-create');
    Route::post('surat-keluar', [SuratKeluarController::class, 'store'])->name('surat-keluar.store')->middleware('can:surat-keluar-create');
    Route::get('surat-keluar/{surat_keluar}/show', [SuratKeluarController::class, 'show'])->name('surat-keluar.show')->middleware('can:surat-keluar-index');
    Route::get('surat-keluar/{surat_keluar}/edit', [SuratKeluarController::class, 'edit'])->name('surat-keluar.edit')->middleware('can:surat-keluar-update');
    Route::put('surat-keluar/{surat_keluar}', [SuratKeluarController::class, 'update'])->name('surat-keluar.update')->middleware('can:surat-keluar-update');
    Route::delete('surat-keluar/{surat_keluar}', [SuratKeluarController::class, 'destroy'])->name('surat-keluar.destroy')->middleware('can:surat-keluar-delete');
    
    // Surat Tugas
    Route::get('surat-tugas', [SuratTugasController::class, 'index'])->name('surat-tugas.index')->middleware('can:surat-tugas-index');
    Route::get('surat-tugas/create', [SuratTugasController::class, 'create'])->name('surat-tugas.create')->middleware('can:surat-tugas-create');
    Route::post('surat-tugas', [SuratTugasController::class, 'store'])->name('surat-tugas.store')->middleware('can:surat-tugas-create');
    Route::get('surat-tugas/{surat_tugas}/show', [SuratTugasController::class, 'show'])->name('surat-tugas.show')->middleware('can:surat-tugas-index');
    Route::get('surat-tugas/{surat_tugas}/edit', [SuratTugasController::class, 'edit'])->name('surat-tugas.edit')->middleware('can:surat-tugas-update');
    Route::put('surat-tugas/{surat_tugas}', [SuratTugasController::class, 'update'])->name('surat-tugas.update')->middleware('can:surat-tugas-update');
    Route::delete('surat-tugas/{surat_tugas}', [SuratTugasController::class, 'destroy'])->name('surat-tugas.destroy')->middleware('can:surat-tugas-delete');

    // File Management
    Route::post('/files', [FileController::class, 'store'])->name('files.store');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');
    Route::get('/files/{file}/preview', [FileController::class, 'preview'])->name('files.preview');
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
