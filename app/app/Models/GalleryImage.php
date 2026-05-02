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

    protected $appends = ['url', 'full_url', 'thumb_url', 'thumb_srcset'];

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
        $thumbPath = $this->thumbPath();

        if (!Storage::disk('public')->exists($thumbPath)) {
            return $this->getFullUrlAttribute();
        }

        return asset('storage/' . $thumbPath);
    }

    public function getThumbSrcsetAttribute(): string
    {
        $disk = Storage::disk('public');
        $sizes = [184, 276, 552];
        $entries = [];

        foreach ($sizes as $size) {
            $path = $this->thumbPath($size);

            if ($disk->exists($path)) {
                $entries[] = asset('storage/' . $path) . ' ' . $size . 'w';
            }
        }

        if (empty($entries)) {
            return $this->getThumbUrlAttribute() . ' 276w';
        }

        return implode(', ', $entries);
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
            return 'gallery/thumbs/' . $basename . '-' . $size . '.jpg';
        }

        return 'gallery/thumbs/' . $basename . '.jpg';
    }
}
