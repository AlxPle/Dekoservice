<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Public site routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/galerie', [GalleryController::class, 'index'])->name('galerie');
Route::get('/ueber-uns', [PageController::class, 'ueberUns'])->name('ueber-uns');
Route::get('/kontakt', [PageController::class, 'kontakt'])->name('kontakt');
Route::post('/kontakt', [ContactController::class, 'store'])->name('kontakt.store');
Route::get('/impressum', [PageController::class, 'impressum'])->name('impressum');
