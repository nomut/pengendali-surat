<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\SuratTugas; // 1. Model diubah menjadi SuratTugas
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuratTugasController extends Controller
{
    private $tagType = 'surat-tugas'; // 2. Tipe tag disesuaikan

    public function index(Request $request)
    {
        
        $suratTugas = SuratTugas::query()
            ->with(['tags' => fn ($query) => $query->where('type', $this->tagType)])
            ->withCount('files')
            // 3. Logika filter disesuaikan untuk kolom Surat Tugas
            ->when($request->input('nomor_surat'), 
                fn ($query, $val) => $query->where('nomor_surat', 'like', "%{$val}%")
            )
            ->when($request->input('tujuan'), 
                fn ($query, $val) => $query->where('tujuan', 'like', "%{$val}%")
            )
            ->when($request->input('perihal'), 
                fn ($query, $val) => $query->where('perihal', 'like', "%{$val}%")
            )
            ->when($request->input('tanggal_surat'), 
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
        
        // 4. Variabel filter yang dikirim ke frontend disesuaikan
        $filters = $request->only(['nomor_surat', 'tujuan', 'perihal', 'tanggal_surat', 'tags', 'sortField', 'sortOrder']);

        if (isset($filters['sortOrder'])) {
            $filters['sortOrder'] = (int)$filters['sortOrder'];
        }

        // 5. Render view Index Surat Tugas
        return Inertia::render('surat-tugas/Index', [
            'suratTugas' => $suratTugas, // Variabel diubah menjadi suratTugas
            'filters' => $filters
        ]);
    }

    public function create()
    {
        // 6. Render view Create Surat Tugas
        return Inertia::render('surat-tugas/Create');
    }

    public function store(Request $request)
    {
        // 7. Aturan validasi disesuaikan untuk Surat Tugas
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'integer|exists:files,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        // Logika transaksi database sama persis dengan file patokan Anda
        DB::transaction(function () use ($validated, $request) {
            $validated['tanggal_surat'] = Carbon::parse($request->tanggal_surat)->format('Y-m-d H:i:s');
            
            $suratTugas = SuratTugas::create($validated);

            if (!empty($request->tags)) {
                $uniqueTags = collect($request->tags)->unique()->values()->all();
                $suratTugas->attachTags($uniqueTags, $this->tagType);
            }

            if (!empty($validated['lampiran'])) {
                File::whereIn('id', $validated['lampiran'])->update([
                    'fileable_id' => $suratTugas->id,
                    'fileable_type' => SuratTugas::class
                ]);
            }
        });

        return Redirect::route('surat-tugas.index'); // 8. Route diubah
    }

    public function show(SuratTugas $suratTugas)
    {
        $suratTugas->load(['files', 'tags' => fn ($query) => $query->where('type', $this->tagType)]);
        return Inertia::render('surat-tugas/Show', ['surat' => $suratTugas]);
    }

    public function edit(SuratTugas $suratTugas)
    {
        $suratTugas->load(['files', 'tags' => fn ($query) => $query->where('type', $this->tagType)]);
        return Inertia::render('surat-tugas/Edit', ['surat' => $suratTugas]);
    }

    public function update(Request $request, SuratTugas $suratTugas)
    {
        // 9. Aturan validasi untuk update disesuaikan
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'integer|exists:files,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $validated['tanggal_surat'] = Carbon::parse($request->tanggal_surat)->format('Y-m-d H:i:s');

        // Logika transaksi database untuk update sama persis
        DB::transaction(function () use ($suratTugas, $validated, $request) {
            $suratTugas->update($validated);

            $tagsToSync = !empty($request->tags) ? collect($request->tags)->unique()->all() : [];
            $suratTugas->syncTagsWithType($tagsToSync, $this->tagType);

            $finalFileIds = $validated['lampiran'] ?? [];
            $currentFileIds = $suratTugas->files()->pluck('id')->all();
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
                    'fileable_id' => $suratTugas->id,
                    'fileable_type' => SuratTugas::class
                ]);
            }
        });

        return Redirect::route('surat-tugas.index'); // 10. Route diubah
    }

    public function destroy(SuratTugas $suratTugas)
    {
        $suratTugas->delete();
        return Redirect::route('surat-tugas.index'); // 11. Route diubah
    }
}