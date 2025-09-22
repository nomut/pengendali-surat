<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Application;

class GuestController extends Controller
{
    public function home()
    {
        return Inertia::render('blog/Home', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function programKerja()
    {
        return Inertia::render('blog/ProgramKerja', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function profilOrganisasi()
    {
        return Inertia::render('blog/ProfilOrganisasi', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }


}
