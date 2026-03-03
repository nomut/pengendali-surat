<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * PUBLIC VIEWS
     */
    public function indexPublic(Request $request)
    {
        $galleries = Gallery::where('is_published', true)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return Inertia::render('blog/Galeri', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'galleries' => $galleries,
        ]);
    }

    public function showPublic(Gallery $gallery)
    {
        if (!$gallery->is_published) {
            abort(404);
        }

        return Inertia::render('blog/GaleriDetail', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'gallery' => $gallery,
        ]);
    }

    /**
     * CMS BACKOFFICE VIEWS
     */

    public function index(Request $request)
    {
        $search = $request->input('search');

        $galleries = Gallery::query()
            ->when($search, function ($query, $search) {
                $query->where('title', 'ilike', '%' . $search . '%')
                      ->orWhere('description', 'ilike', '%' . $search . '%');
            })
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('galleries/Index', [
            'galleries' => $galleries,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create()
    {
        return Inertia::render('galleries/Form', [
            'gallery' => new Gallery(['images' => [], 'is_published' => true, 'date' => now()->format('Y-m-d')]),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'images' => 'nullable|array',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();

        Gallery::create($validated);

        return redirect()->route('galleries.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        // Ensure images is an array
        if (!is_array($gallery->images)) {
            $gallery->images = [];
        }

        return Inertia::render('galleries/Form', [
            'gallery' => $gallery,
        ]);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'images' => 'nullable|array',
            'is_published' => 'boolean',
        ]);

        // Only update slug if title changed significantly (optional, but good practice)
        if ($request->title !== $gallery->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        }

        $gallery->update($validated);

        return redirect()->route('galleries.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        return redirect()->route('galleries.index')->with('success', 'Galeri berhasil dihapus.');
    }
}
