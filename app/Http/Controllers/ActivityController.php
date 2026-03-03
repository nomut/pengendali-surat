<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    /**
     * PUBLIC VIEWS
     */
    public function indexPublic(Request $request)
    {
        $activities = Activity::where('is_published', true)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return Inertia::render('blog/Kegiatan', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'activities' => $activities,
        ]);
    }

    public function showPublic(Activity $activity)
    {
        if (!$activity->is_published) {
            abort(404);
        }

        // Increment views
        $activity->increment('views');

        return Inertia::render('blog/KegiatanDetail', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'activity' => $activity,
        ]);
    }

    /**
     * CMS BACKOFFICE VIEWS
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $activities = Activity::query()
            ->when($search, function ($query, $search) {
                $query->where('title', 'ilike', '%' . $search . '%')
                      ->orWhere('excerpt', 'ilike', '%' . $search . '%');
            })
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('activities/Index', [
            'activities' => $activities,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create()
    {
        return Inertia::render('activities/Form', [
            'activity' => new Activity([
                'is_published' => true, 
                'date' => now()->format('Y-m-d')
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'cover_image' => 'nullable|string',
            'date' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();

        Activity::create($validated);

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Activity $activity)
    {
        return Inertia::render('activities/Form', [
            'activity' => $activity,
        ]);
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'cover_image' => 'nullable|string',
            'date' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        if ($request->title !== $activity->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        }

        $activity->update($validated);

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
