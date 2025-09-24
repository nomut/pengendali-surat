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

    public function kelompokKerja($pok = 'pokja-1')
    {
        if($pok=='pokja-1'){
            $page = 'blog/KelompokKerja1';
        }elseif($pok=='pokja-2'){
            $page = 'blog/KelompokKerja2';
        }elseif($pok=='pokja-3'){
            $page = 'blog/KelompokKerja3';
        }elseif($pok=='pokja-4'){
            $page = 'blog/KelompokKerja4';
        }

        return Inertia::render($page, [
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
