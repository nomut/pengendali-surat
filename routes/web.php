<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [GuestController::class, "home"])->name('home');
Route::get('/kelompok-kerja/{kelompokKerja?}', [GuestController::class, "kelompokKerja"])->name('kelompok-kerja');
Route::get('/profil-organisasi', [GuestController::class, "profilOrganisasi"])->name('profil-organisasi');
Route::get('/struktur-organisasi', [GuestController::class, "strukturOrganisasi"])->name('struktur-organisasi');

// Public File Access for Images
Route::get('/files/{file}/preview', [FileController::class, 'preview'])->name('files.preview');

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

    // CMS - Halaman
    Route::get('cms', [PageController::class, 'index'])->name('cms.index')->middleware('can:cms-index');
    Route::get('cms/{page}/edit', [PageController::class, 'edit'])->name('cms.edit')->middleware('can:cms-update');
    Route::put('cms/{page}', [PageController::class, 'update'])->name('cms.update')->middleware('can:cms-update');

    // File Management
    Route::post('/files', [FileController::class, 'store'])->name('files.store');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
