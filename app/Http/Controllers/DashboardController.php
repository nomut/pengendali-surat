<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\SuratTugas;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        $totalSuratTugas = SuratTugas::count();

        $latestSuratMasuk = SuratMasuk::latest()->take(5)->get();
        $latestSuratKeluar = SuratKeluar::latest()->take(5)->get();
        $latestSuratTugas = SuratTugas::latest()->take(5)->get();


        // --- DATA DUMMY (untuk sementara, jika model belum ada) ---
        $stats = [
            'total_users' => $totalUsers,
            'total_surat_masuk' => $totalSuratMasuk,
            'total_surat_keluar' => $totalSuratKeluar,
            'total_surat_tugas' => $totalSuratTugas,
        ];

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'latestSuratMasuk' => $latestSuratMasuk,
            'latestSuratKeluar' => $latestSuratKeluar,
            'latestSuratTugas' => $latestSuratTugas,
        ]);
    }
}
