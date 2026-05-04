<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use Inertia\Inertia;
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
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::fallback(function () {
    return Inertia::render('NotFound', [
        'canonicalUrl' => url('/'),
    ])->toResponse(request())->setStatusCode(404);
});
