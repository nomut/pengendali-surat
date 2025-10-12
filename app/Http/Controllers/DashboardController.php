<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\SuratTugas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        

        $now = Carbon::now();
        $upcomingMeetings = Meeting::where('starts_at', '>=', $now)->orderBy('starts_at', 'asc')->take(5)->get();
        $pastMeetings = Meeting::where('starts_at', '<', $now)->orderBy('starts_at', 'desc')->take(5)->get();

        // Data untuk tabel Surat
        $latestSuratMasuk = SuratMasuk::latest('tanggal_diterima')->take(5)->get();
        $latestSuratKeluar = SuratKeluar::latest('tanggal_surat')->take(5)->get();
        $latestSuratTugas = SuratTugas::latest('tanggal_surat')->take(5)->get();



        $stats = [
            'total_meetings' => Meeting::count(),
            'total_surat_masuk' => SuratMasuk::count(),
            'total_surat_keluar' => SuratKeluar::count(),
            'total_surat_tugas' => SuratTugas::count(),
            'total_users' => User::count(),
        ];

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'upcomingMeetings' => $upcomingMeetings,
            'pastMeetings' => $pastMeetings,
            'latestSuratMasuk' => $latestSuratMasuk,
            'latestSuratKeluar' => $latestSuratKeluar,
            'latestSuratTugas' => $latestSuratTugas,
        ]);
    }
}
