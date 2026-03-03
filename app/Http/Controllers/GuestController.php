<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Activity;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Application;

class GuestController extends Controller
{
    public function home()
    {
        $page = Page::where('slug', 'home')->first();

        $latestActivities = Activity::where('is_published', true)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $latestGalleries = Gallery::where('is_published', true)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return Inertia::render('blog/Home', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'page' => $page,
            'latestActivities' => $latestActivities,
            'latestGalleries' => $latestGalleries,
        ]);
    }

    public function kelompokKerja($pok = 'pokja-1')
    {
        $slugMap = [
            'pokja-1' => ['slug' => 'pokja-1', 'view' => 'blog/KelompokKerja1'],
            'pokja-2' => ['slug' => 'pokja-2', 'view' => 'blog/KelompokKerja2'],
            'pokja-3' => ['slug' => 'pokja-3', 'view' => 'blog/KelompokKerja3'],
            'pokja-4' => ['slug' => 'pokja-4', 'view' => 'blog/KelompokKerja4'],
        ];

        $config = $slugMap[$pok] ?? $slugMap['pokja-1'];
        $page = Page::where('slug', $config['slug'])->first();

        return Inertia::render($config['view'], [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'page' => $page,
        ]);
    }

    public function strukturOrganisasi()
    {
        $page = Page::where('slug', 'struktur-organisasi')->first();

        return Inertia::render('blog/StrukturOrganisasi', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'page' => $page,
        ]);
    }

    public function profilOrganisasi()
    {
        $page = Page::where('slug', 'profil-organisasi')->first();

        return Inertia::render('blog/ProfilOrganisasi', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'page' => $page,
        ]);
    }

    public function galeri()
    {
        // First try to get the galeri page. If it doesn't exist yet, we'll create a dummy empty page
        $page = Page::where('slug', 'galeri')->first();
        if (!$page) {
            $page = new Page();
            $page->title = 'Galeri Kegiatan';
            $page->meta = ['galleries' => []];
        }

        return Inertia::render('blog/Galeri', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'page' => $page,
        ]);
    }
}
