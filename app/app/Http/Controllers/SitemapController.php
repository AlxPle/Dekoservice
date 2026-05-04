<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseFacade;

class SitemapController extends Controller
{
    private function pages(): array
    {
        $base = rtrim(config('app.url'), '/');

        return [
            ['loc' => $base . '/',                        'changefreq' => 'weekly',  'priority' => '1.0'],
            ['loc' => $base . '/galerie',                 'changefreq' => 'weekly',  'priority' => '0.8'],
            ['loc' => $base . '/ueber-uns',               'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => $base . '/leistungen',              'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => $base . '/kontakt',                 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => $base . '/impressum',               'changefreq' => 'yearly',  'priority' => '0.2'],
            ['loc' => $base . '/leistungen/hochzeiten',   'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => $base . '/leistungen/geburtstage',  'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => $base . '/leistungen/firmenevents', 'changefreq' => 'monthly', 'priority' => '0.8'],
        ];
    }

    public function index(): Response
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
            . view('sitemap', ['pages' => $this->pages()])->render();

        return ResponseFacade::make($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
