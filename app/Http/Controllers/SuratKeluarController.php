<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\SuratKeluar; // Model diubah menjadi SuratKeluar
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // Import Storage facade

class SuratKeluarController extends Controller
{
    private $tagType = 'surat-keluar'; // Tipe tag disesuaikan

    public function index(Request $request)
    {
        $suratKeluar = SuratKeluar::query()
            ->with(['tags' => fn ($query) => $query->where('type', $this->tagType)])
            ->withCount('files')
            // Logika filter disesuaikan untuk kolom Surat Keluar
            ->when($request->input('nomor_surat'), 
                fn ($query, $val) => $query->where('nomor_surat', 'like', "%{$val}%")
            )
            ->when($request->input('tujuan'), // Filter 'pengirim' diubah menjadi 'tujuan'
                fn ($query, $val) => $query->where('tujuan', 'like', "%{$val}%")
            )
            ->when($request->input('perihal'), 
                fn ($query, $val) => $query->where('perihal', 'like', "%{$val}%")
            )
            ->when($request->input('tanggal_surat'), // Filter 'tanggal_diterima' diubah menjadi 'tanggal_surat'
                fn ($query, $tanggal) => $query->whereDate('tanggal_surat', '=', Carbon::parse($tanggal)->toDateString())
            )
            ->when($request->input('tags') && is_array($request->input('tags')), 
                fn ($query) => $query->withAllTags($request->input('tags'))
            )
            ->when($request->input('sortField'), function ($query, $sortField) use ($request) {
                $sortOrder = $request->input('sortOrder') == -1 ? 'desc' : 'asc';
                $query->orderBy($sortField, $sortOrder);
            }, function ($query) {
                $query->latest();
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
        
        // Variabel filter yang dikirim ke frontend disesuaikan
        $filters = $request->only(['nomor_surat', 'tujuan', 'perihal', 'tags', 'sortField', 'sortOrder']);

        if (isset($filters['sortOrder'])) {
            $filters['sortOrder'] = (int)$filters['sortOrder'];
        }

        // Render view Index Surat Keluar
        return Inertia::render('surat-keluar/Index', [
            'suratKeluar' => $suratKeluar,
            'filters' => $filters
        ]);
    }

    public function create()
    {
        return Inertia::render('surat-keluar/Create');
    }

    public function store(Request $request)
    {
        // Aturan validasi disesuaikan untuk Surat Keluar
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'integer|exists:files,id',
            'tembusan' => 'nullable|string', // Kolom baru ditambahkan
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        // Transaksi database (logika sama persis)
        DB::transaction(function () use ($validated, $request) {
            $validated['tanggal_surat'] = Carbon::parse($request->tanggal_surat)->format('Y-m-d H:i:s');
            
            $suratKeluar = SuratKeluar::create($validated);

            // Lampirkan tag jika ada
            if (!empty($request->tags)) {
                $uniqueTags = collect($request->tags)->unique()->values()->all();
                $suratKeluar->attachTags($uniqueTags, $this->tagType);
            }

            // Asosiasikan file dengan surat yang baru dibuat
            if (!empty($validated['lampiran'])) {
                File::whereIn('id', $validated['lampiran'])->update([
                    'fileable_id' => $suratKeluar->id,
                    'fileable_type' => SuratKeluar::class
                ]);
            }
        });

        return Redirect::route('surat-keluar.index');
    }

    public function show(SuratKeluar $suratKeluar)
    {
        $suratKeluar->load(['files', 'tags' => fn ($query) => $query->where('type', $this->tagType)]);
        return Inertia::render('surat-keluar/Show', ['surat' => $suratKeluar]);
    }

    public function edit(SuratKeluar $suratKeluar)
    {
        $suratKeluar->load(['files', 'tags' => fn ($query) => $query->where('type', $this->tagType)]);
        return Inertia::render('surat-keluar/Edit', ['surat' => $suratKeluar]);
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        // Aturan validasi disesuaikan untuk Surat Keluar
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'integer|exists:files,id',
            'tembusan' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $validated['tanggal_surat'] = Carbon::parse($request->tanggal_surat)->format('Y-m-d H:i:s');

        // Transaksi database untuk update (logika sama persis)
        DB::transaction(function () use ($suratKeluar, $validated, $request) {
            $suratKeluar->update($validated);

            $tagsToSync = !empty($request->tags) ? collect($request->tags)->unique()->all() : [];
            $suratKeluar->syncTagsWithType($tagsToSync, $this->tagType);

            // Logika untuk sinkronisasi file (hapus yang lama, kaitkan yang baru)
            $finalFileIds = $validated['lampiran'] ?? [];
            $currentFileIds = $suratKeluar->files()->pluck('id')->all();
            $filesToDeleteIds = array_diff($currentFileIds, $finalFileIds);
            
            if (!empty($filesToDeleteIds)) {
                $filesToDelete = File::find($filesToDeleteIds);
                foreach ($filesToDelete as $file) {
                    Storage::disk('public')->delete($file->path);
                    $file->delete();
                }
            }
            
            if (!empty($finalFileIds)) {
                File::whereIn('id', $finalFileIds)->update([
                    'fileable_id' => $suratKeluar->id,
                    'fileable_type' => SuratKeluar::class
                ]);
            }
        });

        return Redirect::route('surat-keluar.index');
    }

    public function destroy(SuratKeluar $suratKeluar)
    {
        $suratKeluar->delete();
        return Redirect::route('surat-keluar.index');
    }
}