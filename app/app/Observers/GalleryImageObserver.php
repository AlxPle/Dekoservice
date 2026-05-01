<?php

namespace App\Observers;

use App\Models\GalleryImage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use Illuminate\Support\Facades\Storage;

class GalleryImageObserver
{
    public function created(GalleryImage $galleryImage): void
    {
        $this->optimizeImage($galleryImage);
    }

    public function updated(GalleryImage $galleryImage): void
    {
        if ($galleryImage->wasChanged('filename')) {
            $this->optimizeImage($galleryImage);
        }
    }

    private function optimizeImage(GalleryImage $galleryImage): void
    {
        if (!$galleryImage->filename) {
            return;
        }

        $path = Storage::disk('public')->path($galleryImage->filename);

        if (file_exists($path)) {
            ImageOptimizer::optimize($path);
        }
    }

    /**
     * Handle the GalleryImage "deleted" event.
     */
    public function deleted(GalleryImage $galleryImage): void
    {
        //
    }

    /**
     * Handle the GalleryImage "restored" event.
     */
    public function restored(GalleryImage $galleryImage): void
    {
        //
    }

    /**
     * Handle the GalleryImage "force deleted" event.
     */
    public function forceDeleted(GalleryImage $galleryImage): void
    {
        //
    }
}
