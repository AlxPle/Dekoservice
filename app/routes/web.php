<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PageController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

// Public site routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/galerie', [GalleryController::class, 'index'])->name('galerie');
Route::get('/ueber-uns', [PageController::class, 'ueberUns'])->name('ueber-uns');
Route::get('/leistungen', [PageController::class, 'leistungen'])->name('leistungen');
Route::get('/leistungen/hochzeiten', [PageController::class, 'hochzeiten'])->name('leistungen.hochzeiten');
Route::get('/leistungen/geburtstage', [PageController::class, 'geburtstagePartys'])->name('leistungen.geburtstage');
Route::get('/leistungen/firmenevents', [PageController::class, 'firmenevents'])->name('leistungen.firmenevents');
Route::get('/kontakt', [PageController::class, 'kontakt'])->name('kontakt');
Route::post('/kontakt', [ContactController::class, 'store'])->name('kontakt.store');
Route::get('/impressum', [PageController::class, 'impressum'])->name('impressum');

// Dynamic sitemap
Route::get('/sitemap.xml', function () {
    $base = rtrim(config('app.url'), '/');
    $pages = [
        ['loc' => $base . '/',            'changefreq' => 'weekly',  'priority' => '1.0'],
        ['loc' => $base . '/galerie',     'changefreq' => 'weekly',  'priority' => '0.8'],
        ['loc' => $base . '/ueber-uns',   'changefreq' => 'monthly', 'priority' => '0.7'],
        ['loc' => $base . '/leistungen',  'changefreq' => 'monthly', 'priority' => '0.9'],
        ['loc' => $base . '/kontakt',     'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => $base . '/impressum',         'changefreq' => 'yearly',  'priority' => '0.2'],
        ['loc' => $base . '/leistungen/hochzeiten', 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => $base . '/leistungen/geburtstage', 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => $base . '/leistungen/firmenevents', 'changefreq' => 'monthly', 'priority' => '0.8'],
    ];
    $xml = view('sitemap', ['pages' => $pages])->render();
    return Response::make($xml, 200, ['Content-Type' => 'application/xml']);
})->name('sitemap');

Route::fallback(function () {
    return Inertia::render('NotFound', [
        'canonicalUrl' => url('/'),
    ])->toResponse(request())->setStatusCode(404);
});
