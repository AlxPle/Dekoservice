<?php

namespace App\Models;

use App\Observers\GalleryImageObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[ObservedBy(GalleryImageObserver::class)]
class GalleryImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'filename',
        'alt_text',
        'category',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $appends = ['url', 'full_url', 'optimized_url', 'thumb_url', 'thumb_urls'];

    public function getUrlAttribute(): string
    {
        return $this->getFullUrlAttribute();
    }

    public function getFullUrlAttribute(): string
    {
        return asset('storage/' . $this->normalizedPath());
    }

    public function getThumbUrlAttribute(): string
    {
        return asset('storage/' . $this->thumbPath());
    }

    public function getThumbUrlsAttribute(): array
    {
        $urls = [];
        foreach ([184, 276, 552] as $size) {
            $urls[$size] = asset('storage/' . $this->thumbPath($size));
        }
        return $urls;
    }

    /**
     * Return the URL for the optimized full-size image (prefers .webp on disk).
     */
    public function getOptimizedUrlAttribute(): string
    {
        $normalized = $this->normalizedPath();

        if (Storage::disk('public')->exists($normalized)) {
            return asset('storage/' . $normalized);
        }

        $pathWithoutExt = preg_replace('/\.[\w]+$/', '', $normalized);
        foreach (['jpg', 'jpeg', 'png'] as $ext) {
            $testPath = $pathWithoutExt . '.' . $ext;
            if (Storage::disk('public')->exists($testPath)) {
                return asset('storage/' . $testPath);
            }
        }

        return asset('storage/' . $normalized);
    }

    public function normalizedPath(): string
    {
        return str_starts_with($this->filename, 'gallery/')
            ? $this->filename
            : 'gallery/' . $this->filename;
    }

    public function thumbPath(?int $size = null): string
    {
        $basename = pathinfo($this->normalizedPath(), PATHINFO_FILENAME);

        if ($size !== null) {
            return 'gallery/thumbs/' . $basename . '-' . $size . '.webp';
        }

        return 'gallery/thumbs/' . $basename . '.webp';
    }
}
