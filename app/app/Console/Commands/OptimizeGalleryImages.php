<?php

namespace App\Console\Commands;

use App\Jobs\GenerateGalleryThumbnail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class OptimizeGalleryImages extends Command
{
    protected $signature = 'gallery:optimize
                            {--sync : Run synchronously instead of dispatching to queue}';

    protected $description = 'Optimize all existing gallery images: resize originals to max 1920×1080, convert to WebP, and regenerate thumbnails';

    public function handle(): int
    {
        $disk = Storage::disk('public');
        $files = $disk->files('gallery');

        if (empty($files)) {
            $this->info('No gallery images found.');
            return self::SUCCESS;
        }

        $imageFiles = array_filter($files, function (string $file) {
            return preg_match('/\.(jpe?g|png|webp|heic|heif)$/i', $file);
        });

        $count = count($imageFiles);
        $this->info("Found {$count} gallery image(s) to optimize.");

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach ($imageFiles as $relativePath) {
            if ($this->option('sync')) {
                (new GenerateGalleryThumbnail($relativePath))->handle();
            } else {
                GenerateGalleryThumbnail::dispatch($relativePath);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        if ($this->option('sync')) {
            $this->info('All images optimized synchronously.');
        } else {
            $this->info("Dispatched {$count} optimization job(s) to the queue.");
            $this->comment('Run `php artisan queue:work` to process them.');
        }

        return self::SUCCESS;
    }
}
