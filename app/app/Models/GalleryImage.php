<?php

namespace App\Models;

use App\Observers\GalleryImageObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(GalleryImageObserver::class)]
class GalleryImage extends Model
{
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

    protected $appends = ['url'];

    public function getUrlAttribute(): string
    {
        return asset('storage/gallery/' . $this->filename);
    }
}
