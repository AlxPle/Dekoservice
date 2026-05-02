<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    private function leistungenData(): array
    {
        $hrefs = [
            'hochzeiten'   => '/leistungen/hochzeiten',
            'geburtstage'  => '/leistungen/geburtstage',
            'firmenevents' => '/leistungen/firmenevents',
        ];

        $pages = Page::whereIn('slug', array_keys($hrefs))
            ->get()
            ->keyBy('slug');

        return collect($hrefs)->map(function (string $href, string $slug) use ($pages) {
            $page = $pages->get($slug);
            return [
                'icon'  => $page?->icon  ?? '',
                'title' => $page?->title ?? $slug,
                'desc'  => $page?->excerpt ?? '',
                'href'  => $href,
            ];
        })->values()->all();
    }

    public function home(): Response
    {
        return Inertia::render('Home', [
            'canonicalUrl' => url('/'),
            'leistungen'   => $this->leistungenData(),
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
            'leistungen'   => $this->leistungenData(),
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
