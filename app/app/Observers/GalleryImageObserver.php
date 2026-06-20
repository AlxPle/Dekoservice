<?php

namespace App\Observers;

use App\Jobs\GenerateGalleryThumbnail;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class GalleryImageObserver
{
    public function saving(GalleryImage $galleryImage): void
    {
        if ($galleryImage->filename && !str_ends_with(strtolower($galleryImage->filename), '.webp')) {
            $galleryImage->filename = preg_replace('/\.\w+$/', '.webp', $galleryImage->filename);
        }
    }

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

                $this->deleteThumbsByBasename($oldBase);
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
        $base = pathinfo($galleryImage->normalizedPath(), PATHINFO_FILENAME);
        $this->deleteThumbsByBasename($base);
    }

    /**
     * Delete all thumbnail files (both .webp and legacy .jpg) for a given basename.
     */
    private function deleteThumbsByBasename(string $basename): void
    {
        $disk = Storage::disk('public');

        foreach ($disk->files('gallery/thumbs') as $path) {
            $fileBasename = pathinfo($path, PATHINFO_FILENAME);

            // Match "basename-184", "basename-276", "basename-552", or just "basename"
            if ($fileBasename === $basename || str_starts_with($fileBasename, $basename . '-')) {
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
