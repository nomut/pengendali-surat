<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Application;

class GuestController extends Controller
{
    public function home()
    {
        $page = Page::where('slug', 'home')->first();

        return Inertia::render('blog/Home', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'page' => $page,
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
}
