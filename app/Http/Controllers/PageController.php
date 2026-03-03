<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('title')->get();

        return Inertia::render('cms/Index', [
            'pages' => $pages,
        ]);
    }

    public function edit(Page $page)
    {
        return Inertia::render('cms/Edit', [
            'page' => $page,
        ]);
    }

    public function update(Request $request, Page $page)
    {
        // If meta is sent as a string (e.g., from an empty object {} converted to string or JSON payload)
        if (is_string($request->meta)) {
            $request->merge([
                'meta' => json_decode($request->meta, true)
            ]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta' => 'nullable|array',
        ]);

        if (isset($validated['content'])) {
            $validated['content'] = str_replace(['&amp;nbsp;', '&nbsp;'], ' ', $validated['content']);
        }

        if (isset($validated['meta'])) {
            array_walk_recursive($validated['meta'], function(&$value) {
                if (is_string($value)) {
                    $value = str_replace(['&amp;nbsp;', '&nbsp;'], ' ', $value);
                }
            });
        }

        $page->update($validated);

        return redirect()->route('cms.index')->with('success', 'Halaman berhasil diperbarui.');
    }
}
