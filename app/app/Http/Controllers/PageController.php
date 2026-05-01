<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home');
    }

    public function ueberUns(): Response
    {
        return Inertia::render('UeberUns');
    }

    public function kontakt(): Response
    {
        return Inertia::render('Kontakt');
    }

    public function impressum(): Response
    {
        return Inertia::render('Impressum');
    }
}
