<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [GuestController::class, "home"])->name('home');
Route::get('/program-kerja', [GuestController::class, "programKerja"])->name('program-kerja');
Route::get('/profil-organisasi', [GuestController::class, "profilOrganisasi"])->name('profil-organisasi');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class)->names('users');
    Route::resource('surat-masuk', SuratMasukController::class)->names('surat-masuk');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
