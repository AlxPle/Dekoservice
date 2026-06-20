<?php

namespace App\Console\Commands;

use App\Jobs\GenerateGalleryThumbnail;
use App\Models\GalleryImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class OptimizeGalleryImages extends Command
{
    protected $signature = 'gallery:optimize
                            {--sync : Run synchronously instead of dispatching to queue}';

    protected $description = 'Optimize all existing gallery images: resize originals to max 1920×1080, convert to WebP, regenerate thumbnails, and update the database';

    public function handle(): int
    {
        $images = GalleryImage::all();

        if ($images->isEmpty()) {
            $this->info('No gallery images found in the database.');
            return self::SUCCESS;
        }

        $count = $images->count();
        $this->info("Found {$count} gallery image(s) in the database to optimize.");

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach ($images as $image) {
            $oldFilename = $image->filename;
            $relativePath = $image->normalizedPath();

            // Run optimization / thumbnail generation
            if ($this->option('sync')) {
                (new GenerateGalleryThumbnail($relativePath))->handle();
            } else {
                GenerateGalleryThumbnail::dispatch($relativePath);
            }

            // Update database filename to .webp
            if (!str_ends_with(strtolower($oldFilename), '.webp')) {
                $newFilename = preg_replace('/\.\w+$/', '.webp', $oldFilename);
                
                // Temporarily disable the observer during this update to prevent duplicate jobs
                GalleryImage::withoutEvents(function () use ($image, $newFilename) {
                    $image->update(['filename' => $newFilename]);
                });
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        if ($this->option('sync')) {
            $this->info('All images optimized and database updated synchronously.');
        } else {
            $this->info("Dispatched {$count} optimization job(s) to the queue and updated database references.");
            $this->comment('Run `php artisan queue:work` to process the image conversions.');
        }

        return self::SUCCESS;
    }
}
