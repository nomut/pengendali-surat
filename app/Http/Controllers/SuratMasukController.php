<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\SuratMasuk; // Gunakan model SuratMasuk
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\DB;

class SuratMasukController extends Controller
{
    private $tagType = 'surat-masuk';

    public function index(Request $request)
    {
        $suratMasuk = SuratMasuk::query()
            ->with(['tags' => fn ($query) => $query->where('type', $this->tagType)])
            ->withCount('files')
            ->when($request->input('nomor_surat'), 
                fn ($query, $val) => $query->where('nomor_surat', 'like', "%{$val}%")
            )
            ->when($request->input('pengirim'), 
                fn ($query, $val) => $query->where('pengirim', 'like', "%{$val}%")
            )
            ->when($request->input('perihal'), 
                fn ($query, $val) => $query->where('perihal', 'like', "%{$val}%")
            )
            ->when($request->input('tanggal_diterima'), 
                fn ($query, $tanggal) => $query->whereDate('tanggal_diterima', '=', Carbon::parse($tanggal)->toDateString())
            )
            ->when($request->input('status_disposisi'), 
                fn ($query, $val) => $query->where('status_disposisi', $val)
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
        
        $filters = $request->only(['nomor_surat', 'pengirim', 'perihal', 'tags', 'sortField', 'sortOrder']);

        if (isset($filters['sortOrder'])) {
            $filters['sortOrder'] = (int)$filters['sortOrder'];
        }

        return Inertia::render('surat-masuk/Index', [
            'suratMasuk' => $suratMasuk,
            'filters' => $filters
        ]);
    }

    public function create()
    {
        return Inertia::render('surat-masuk/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'penerima' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string',
            'lampiran' => 'nullable|array', // Validasi 'lampiran' sebagai array
            'lampiran.*' => 'integer|exists:files,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $validated['tanggal_surat'] = Carbon::parse($request->tanggal_surat)->format('Y-m-d H:i:s');
        $validated['tanggal_diterima'] = Carbon::parse($request->tanggal_diterima)->format('Y-m-d H:i:s');

        
        $suratMasuk = SuratMasuk::create(array_merge($validated, ['lampiran'=>'test']));

        if (!empty($validated['lampiran'])) {
            File::whereIn('id', $validated['lampiran'])
            ->update([
                'fileable_id' => $suratMasuk->id,
                'fileable_type' => SuratMasuk::class
            ]);
        }

        if (!empty($request->tags)) {
            $uniqueTags = collect($request->tags)->unique()->values()->all();
            $suratMasuk->attachTags($uniqueTags, $this->tagType);
        }

        return Redirect::route('surat-masuk.index');
    }

    public function show(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load([
            'files', 
            'tags' => fn ($query) => $query->where('type', $this->tagType)
        ]);

        return Inertia::render('surat-masuk/Show', [
            'surat' => $suratMasuk
        ]);
    }

    public function edit(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load([
            'files', 
            'tags' => fn ($query) => $query->where('type', $this->tagType)
        ]);
        
        return Inertia::render('surat-masuk/Edit', [
            'surat' => $suratMasuk
        ]);
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'integer|exists:files,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $validated['tanggal_surat'] = Carbon::parse($request->tanggal_surat)->format('Y-m-d H:i:s');
        $validated['tanggal_diterima'] = Carbon::parse($request->tanggal_diterima)->format('Y-m-d H:i:s');

        // Gunakan transaksi database untuk memastikan integritas data
        DB::transaction(function () use ($suratMasuk, $validated, $request) {
            $suratMasuk->update($validated);

            $tagsToSync = !empty($request->tags) ? collect($request->tags)->unique()->all() : [];
            
            $suratMasuk->syncTagsWithType($tagsToSync, $this->tagType);

            $finalFileIds = $validated['lampiran'] ?? [];
            $currentFileIds = $suratMasuk->files()->pluck('id')->all();

            $filesToDeleteIds = array_diff($currentFileIds, $finalFileIds);
            
            if (!empty($filesToDeleteIds)) {
                $filesToDelete = File::find($filesToDeleteIds);
                foreach ($filesToDelete as $file) {
                    Storage::disk('public')->delete($file->path);
                    $file->delete();
                }
            }
            
            // Asosiasikan file baru atau yang sudah ada dengan SuratMasuk
            if (!empty($finalFileIds)) {
                File::whereIn('id', $finalFileIds)->update([
                    'fileable_id' => $suratMasuk->id,
                    'fileable_type' => SuratMasuk::class
                ]);
            }
        });

        return Redirect::route('surat-masuk.index');
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        $suratMasuk->delete();
        return Redirect::route('surat-masuk.index');
    }
}