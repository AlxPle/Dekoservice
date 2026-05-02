<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class GenerateGalleryThumbnail implements ShouldQueue
{
    use Queueable;

    private const THUMB_SIZES = [184, 276, 552];

    public function __construct(
        public string $filename,
    ) {}

    public function handle(): void
    {
        $relativePath = str_starts_with($this->filename, 'gallery/')
            ? $this->filename
            : 'gallery/' . $this->filename;

        $disk = Storage::disk('public');

        if (!$disk->exists($relativePath)) {
            return;
        }

        $sourceBinary = $disk->get($relativePath);
        $sourceImage = imagecreatefromstring($sourceBinary);

        if ($sourceImage === false) {
            return;
        }

        $sourceWidth = imagesx($sourceImage);
        $sourceHeight = imagesy($sourceImage);

        if ($sourceWidth <= 0 || $sourceHeight <= 0) {
            imagedestroy($sourceImage);
            return;
        }

        $sourceAspect = $sourceWidth / $sourceHeight;

        if ($sourceAspect >= 1) {
            $cropHeight = $sourceHeight;
            $cropWidth = (int) round($sourceHeight);
            $cropX = (int) floor(($sourceWidth - $cropWidth) / 2);
            $cropY = 0;
        } else {
            $cropWidth = $sourceWidth;
            $cropHeight = (int) round($sourceWidth);
            $cropX = 0;
            $cropY = (int) floor(($sourceHeight - $cropHeight) / 2);
        }

        $basename = pathinfo($relativePath, PATHINFO_FILENAME);
        $thumbDir = $disk->path('gallery/thumbs');

        if (!is_dir($thumbDir)) {
            mkdir($thumbDir, 0755, true);
        }

        foreach (self::THUMB_SIZES as $size) {
            $thumbImage = imagecreatetruecolor($size, $size);

            imagecopyresampled(
                $thumbImage,
                $sourceImage,
                0,
                0,
                $cropX,
                $cropY,
                $size,
                $size,
                $cropWidth,
                $cropHeight,
            );

            $thumbPath = 'gallery/thumbs/' . $basename . '-' . $size . '.jpg';
            $thumbAbsolutePath = $disk->path($thumbPath);

            imagejpeg($thumbImage, $thumbAbsolutePath, 82);
            imagedestroy($thumbImage);
            ImageOptimizer::optimize($thumbAbsolutePath);
        }

        imagedestroy($sourceImage);

        // Keep legacy path for backwards compatibility with existing references.
        $primaryPath = $disk->path('gallery/thumbs/' . $basename . '-276.jpg');
        $legacyPath = $disk->path('gallery/thumbs/' . $basename . '.jpg');

        if (file_exists($primaryPath)) {
            copy($primaryPath, $legacyPath);
        }
    }
}
