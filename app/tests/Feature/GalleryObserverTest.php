<?php

use App\Jobs\GenerateGalleryThumbnail;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    Queue::fake();
});

test('creating a gallery image dispatches thumbnail job', function () {
    Storage::disk('public')->put('gallery/test.jpg', 'fake-image-content');

    GalleryImage::factory()->create(['filename' => 'test.jpg']);

    Queue::assertPushed(GenerateGalleryThumbnail::class, function ($job) {
        return $job->filename === 'gallery/test.jpg';
    });
});

test('updating filename dispatches thumbnail job', function () {
    Storage::disk('public')->put('gallery/old.jpg', 'fake-image-content');
    Storage::disk('public')->put('gallery/new.jpg', 'fake-image-content');

    $image = GalleryImage::factory()->create(['filename' => 'old.jpg']);

    Queue::fake(); // reset after create

    $image->update(['filename' => 'new.jpg']);

    Queue::assertPushed(GenerateGalleryThumbnail::class, function ($job) {
        return $job->filename === 'gallery/new.jpg';
    });
});

test('updating other fields does not dispatch thumbnail job', function () {
    Storage::disk('public')->put('gallery/test.jpg', 'fake-image-content');

    $image = GalleryImage::factory()->create(['filename' => 'test.jpg']);

    Queue::fake(); // reset after create

    $image->update(['alt_text' => 'New alt text']);

    Queue::assertNothingPushed();
});

test('deleting a gallery image removes thumbnails', function () {
    Storage::disk('public')->put('gallery/test.jpg', 'fake-image-content');
    Storage::disk('public')->put('gallery/thumbs/test-184.jpg', 'fake-thumb');
    Storage::disk('public')->put('gallery/thumbs/test-276.jpg', 'fake-thumb');
    Storage::disk('public')->put('gallery/thumbs/test-552.jpg', 'fake-thumb');

    $image = GalleryImage::factory()->create(['filename' => 'test.jpg']);

    $image->delete();

    Storage::disk('public')->assertMissing('gallery/thumbs/test-184.jpg');
    Storage::disk('public')->assertMissing('gallery/thumbs/test-276.jpg');
    Storage::disk('public')->assertMissing('gallery/thumbs/test-552.jpg');
});
