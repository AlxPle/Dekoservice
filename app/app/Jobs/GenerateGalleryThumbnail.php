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

    /** Maximum width for the full-size gallery image. */
    private const MAX_WIDTH = 1920;

    /** Maximum height for the full-size gallery image. */
    private const MAX_HEIGHT = 1080;

    /** WebP quality (0-100). 82 is a good balance of quality vs size. */
    private const WEBP_QUALITY = 82;

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
        $sourceImage = @imagecreatefromstring($sourceBinary);

        if ($sourceImage === false) {
            return;
        }

        $sourceWidth = imagesx($sourceImage);
        $sourceHeight = imagesy($sourceImage);

        if ($sourceWidth <= 0 || $sourceHeight <= 0) {
            imagedestroy($sourceImage);
            return;
        }

        // ── Resize the original if it exceeds maximum dimensions ──
        $sourceImage = $this->resizeOriginalIfNeeded(
            $sourceImage,
            $sourceWidth,
            $sourceHeight,
            $disk->path($relativePath),
        );

        // Refresh dimensions after potential resize
        $sourceWidth = imagesx($sourceImage);
        $sourceHeight = imagesy($sourceImage);

        // ── Generate square thumbnails ──
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

            // Preserve transparency for WebP
            imagealphablending($thumbImage, false);
            imagesavealpha($thumbImage, true);

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

            // Save as WebP
            $thumbPath = 'gallery/thumbs/' . $basename . '-' . $size . '.webp';
            $thumbAbsolutePath = $disk->path($thumbPath);

            imagewebp($thumbImage, $thumbAbsolutePath, self::WEBP_QUALITY);
            imagedestroy($thumbImage);

            ImageOptimizer::optimize($thumbAbsolutePath);

            // Also generate legacy JPEG fallback for old browsers
            $jpegThumbPath = 'gallery/thumbs/' . $basename . '-' . $size . '.jpg';
            $jpegAbsolutePath = $disk->path($jpegThumbPath);

            if (file_exists($jpegAbsolutePath)) {
                // Remove old JPEG thumb — WebP replaces it
                unlink($jpegAbsolutePath);
            }
        }

        // Remove legacy thumbnail copy (basename.jpg) if it exists
        $legacyPath = $disk->path('gallery/thumbs/' . $basename . '.jpg');
        if (file_exists($legacyPath)) {
            unlink($legacyPath);
        }

        imagedestroy($sourceImage);
    }

    /**
     * Resize the original image to fit within MAX_WIDTH × MAX_HEIGHT
     * and convert to WebP on disk. Returns the (possibly new) GD resource.
     */
    private function resizeOriginalIfNeeded(
        \GdImage $image,
        int $width,
        int $height,
        string $absolutePath,
    ): \GdImage {
        $needsResize = $width > self::MAX_WIDTH || $height > self::MAX_HEIGHT;
        $isAlreadyWebp = str_ends_with(strtolower($absolutePath), '.webp');

        // If it's already small enough AND already WebP, nothing to do
        if (!$needsResize && $isAlreadyWebp) {
            return $image;
        }

        if ($needsResize) {
            $ratio = min(self::MAX_WIDTH / $width, self::MAX_HEIGHT / $height);
            $newWidth = (int) round($width * $ratio);
            $newHeight = (int) round($height * $ratio);

            $resized = imagecreatetruecolor($newWidth, $newHeight);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);

            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resized;
        }

        // Convert to WebP on disk (replace the original file)
        if (!$isAlreadyWebp) {
            $webpPath = preg_replace('/\.\w+$/', '.webp', $absolutePath);
            imagewebp($image, $webpPath, self::WEBP_QUALITY);
            ImageOptimizer::optimize($webpPath);

            // Remove old non-WebP original
            if ($absolutePath !== $webpPath && file_exists($absolutePath)) {
                unlink($absolutePath);
            }
        } else {
            // Already WebP, just overwrite with resized version
            imagewebp($image, $absolutePath, self::WEBP_QUALITY);
            ImageOptimizer::optimize($absolutePath);
        }

        return $image;
    }
}
