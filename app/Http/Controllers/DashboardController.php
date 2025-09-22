<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalSuratMasuk = SuratMasuk::count();
        // $totalSuratKeluar = SuratKeluar::count();
        $latestSuratMasuk = SuratMasuk::latest()->take(5)->get();
        // $latestSuratKeluar = SuratKeluar::latest()->take(5)->get();


        // --- DATA DUMMY (untuk sementara, jika model belum ada) ---
        $stats = [
            'total_users' => $totalUsers,
            'total_surat_masuk' => $totalSuratMasuk,
            'total_surat_keluar' => 8 . ' Dummy',  // Ganti dengan $totalSuratKeluar
        ];

        $latestSuratKeluar = [
            ['tujuan' => 'Dummy - Gubernur DIY', 'perihal' => 'Laporan Bulanan', 'tanggal_surat' => '2025-09-20'],
            ['tujuan' => 'Dummy - Semua Anggota', 'perihal' => 'Pengumuman Libur', 'tanggal_surat' => '2025-09-18'],
        ];

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'latestSuratMasuk' => $latestSuratMasuk,
            'latestSuratKeluar' => $latestSuratKeluar,
        ]);
    }
}
