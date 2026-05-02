<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home', [
            'canonicalUrl' => url('/'),
        ]);
    }

    public function ueberUns(): Response
    {
        return Inertia::render('UeberUns', [
            'canonicalUrl' => url('/ueber-uns'),
        ]);
    }

    public function leistungen(): Response
    {
        return Inertia::render('Leistungen', [
            'canonicalUrl' => url('/leistungen'),
        ]);
    }

    public function hochzeiten(): Response
    {
        return Inertia::render('Hochzeiten', [
            'canonicalUrl' => url('/leistungen/hochzeiten'),
        ]);
    }

    public function geburtstagePartys(): Response
    {
        return Inertia::render('GeburtstagePartys', [
            'canonicalUrl' => url('/leistungen/geburtstage'),
        ]);
    }

    public function firmenevents(): Response
    {
        return Inertia::render('Firmenevents', [
            'canonicalUrl' => url('/leistungen/firmenevents'),
        ]);
    }

    public function kontakt(): Response
    {
        return Inertia::render('Kontakt', [
            'canonicalUrl' => url('/kontakt'),
        ]);
    }

    public function impressum(): Response
    {
        return Inertia::render('Impressum', [
            'canonicalUrl' => url('/impressum'),
        ]);
    }
}
