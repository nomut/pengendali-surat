<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('surat-masuk/Index', [
            'suratMasuk' => SuratMasuk::paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Method ini akan merender halaman Vue yang baru kita buat
        return Inertia::render('surat-masuk/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'penerima' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'nomor_surat' => 'required|string|max:255',
            'perihal' => 'required|string',
            'lampiran' => 'nullable|string|max:255',
            'status_disposisi' => 'required|string|in:Belum Didisposisi,Sudah Didisposisi',
        ]);

        SuratMasuk::create([
            'tanggal_surat'   => Carbon::parse($request->tanggal_surat)->format('Y-m-d H:i:s'),
            'tanggal_diterima'=> Carbon::parse($request->tanggal_diterima)->format('Y-m-d H:i:s'),
            'penerima'        => $request->penerima,
            'pengirim'        => $request->pengirim,
            'nomor_surat'     => $request->nomor_surat,
            'perihal'         => $request->perihal,
            'lampiran'        => $request->lampiran,
            'status_disposisi' => $request->status_disposisi,
        ]);
        
        return Redirect::route('surat-masuk.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratMasuk $suratMasuk)
    {
        return Inertia::render('surat-masuk/Show', [
            'surat' => $suratMasuk
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratMasuk $suratMasuk)
    {
        return Inertia::render('surat-masuk/Edit', [
            'surat' => $suratMasuk
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $request->validate([
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'penerima' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'nomor_surat' => 'required|string|max:255',
            'perihal' => 'required|string',
            'lampiran' => 'nullable|string|max:255',
            'status_disposisi' => 'required|string|in:Belum Didisposisi,Sudah Didisposisi',
        ]);
        
        $suratMasuk->update([
            'tanggal_surat'   => Carbon::parse($request->tanggal_surat)->format('Y-m-d H:i:s'),
            'tanggal_diterima'=> Carbon::parse($request->tanggal_diterima)->format('Y-m-d H:i:s'),
            'penerima'        => $request->penerima,
            'pengirim'        => $request->pengirim,
            'nomor_surat'     => $request->nomor_surat,
            'perihal'         => $request->perihal,
            'lampiran'        => $request->lampiran,
            'status_disposisi' => $request->status_disposisi,
        ]);

        return Redirect::route('surat-masuk.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratMasuk $suratMasuk)
    {
        $suratMasuk->delete();

        return Redirect::route('surat-masuk.index')->with('success', 'Surat masuk '. $suratMasuk->nomor_surat . ' berhasil dihapus.');
    }
}