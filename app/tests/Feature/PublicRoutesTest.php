<?php

use App\Models\GalleryImage;

test('home page returns 200', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

test('galerie page returns 200', function () {
    $response = $this->get('/galerie');
    $response->assertStatus(200);
});

test('ueber-uns page returns 200', function () {
    $response = $this->get('/ueber-uns');
    $response->assertStatus(200);
});

test('kontakt page returns 200', function () {
    $response = $this->get('/kontakt');
    $response->assertStatus(200);
});

test('impressum page returns 200', function () {
    $response = $this->get('/impressum');
    $response->assertStatus(200);
});

test('sitemap.xml returns valid xml', function () {
    $response = $this->get('/sitemap.xml');
    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/xml');
    $response->assertSee('<urlset', false);
    $response->assertSee('/galerie', false);
});

test('robots.txt file exists', function () {
    expect(file_exists(public_path('robots.txt')))->toBeTrue();
});

test('contact form stores request', function () {
    $response = $this->post('/kontakt', [
        'first_name' => 'Max',
        'last_name'  => 'Mustermann',
        'email'      => 'max@example.com',
        'phone'      => '',
        'message'    => 'Ich hätte gerne eine Anfrage für meine Hochzeit.',
        'event_type' => 'wedding',
        'event_date' => '2026-09-15',
    ]);

    $response->assertRedirect(route('kontakt'));
    $this->assertDatabaseHas('contact_requests', [
        'email'      => 'max@example.com',
        'first_name' => 'Max',
    ]);
});

test('contact form requires email', function () {
    $response = $this->post('/kontakt', [
        'first_name' => 'Max',
        'last_name'  => 'Mustermann',
        'email'      => '',
        'message'    => 'Test',
    ]);

    $response->assertSessionHasErrors('email');
});

test('gallery only returns active images', function () {
    GalleryImage::factory()->create(['is_active' => true,  'filename' => 'active.jpg']);
    GalleryImage::factory()->create(['is_active' => false, 'filename' => 'inactive.jpg']);

    $response = $this->get('/galerie');
    $response->assertStatus(200);

    $images = $response->original->getData()['page']['props']['images'];
    $filenames = collect($images)->pluck('filename');

    expect($filenames)->toContain('active.jpg')
        ->not->toContain('inactive.jpg');
});
