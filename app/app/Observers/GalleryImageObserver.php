<?php

namespace App\Observers;

use App\Jobs\GenerateGalleryThumbnail;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class GalleryImageObserver
{
    public function created(GalleryImage $galleryImage): void
    {
        $this->optimizeAndQueueThumbnail($galleryImage);
    }

    public function updated(GalleryImage $galleryImage): void
    {
        if ($galleryImage->wasChanged('filename')) {
            $oldFilename = $galleryImage->getOriginal('filename');

            if ($oldFilename) {
                $oldBase = pathinfo(
                    str_starts_with($oldFilename, 'gallery/') ? $oldFilename : 'gallery/' . $oldFilename,
                    PATHINFO_FILENAME,
                );

                $disk = Storage::disk('public');

                foreach ($disk->files('gallery/thumbs') as $path) {
                    if (str_starts_with(pathinfo($path, PATHINFO_FILENAME), $oldBase)) {
                        $disk->delete($path);
                    }
                }
            }

            $this->optimizeAndQueueThumbnail($galleryImage);
        }
    }

    private function optimizeAndQueueThumbnail(GalleryImage $galleryImage): void
    {
        if (!$galleryImage->filename) {
            return;
        }

        $relativePath = $galleryImage->normalizedPath();
        $path = Storage::disk('public')->path($relativePath);

        if (file_exists($path)) {
            ImageOptimizer::optimize($path);
            GenerateGalleryThumbnail::dispatch($relativePath);
        }
    }

    /**
     * Handle the GalleryImage "deleted" event.
     */
    public function deleted(GalleryImage $galleryImage): void
    {
        $disk = Storage::disk('public');
        $base = pathinfo($galleryImage->normalizedPath(), PATHINFO_FILENAME);

        foreach ($disk->files('gallery/thumbs') as $path) {
            if (str_starts_with(pathinfo($path, PATHINFO_FILENAME), $base)) {
                $disk->delete($path);
            }
        }
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
