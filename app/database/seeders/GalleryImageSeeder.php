<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use Illuminate\Database\Seeder;

class GalleryImageSeeder extends Seeder
{
    public function run(): void
    {
        // Placeholder entries — actual image files should be uploaded via Filament Admin
        // or placed manually in storage/app/public/gallery/
        $images = [
            // Hochzeit (wedding)
            ['filename' => 'wedding-01.jpg', 'alt_text' => 'Tischdekoration mit Rosen und Kerzen', 'category' => 'wedding', 'sort_order' => 1],
            ['filename' => 'wedding-02.jpg', 'alt_text' => 'Blumenbogen für die Trauung', 'category' => 'wedding', 'sort_order' => 2],
            ['filename' => 'wedding-03.jpg', 'alt_text' => 'Festlich gedeckte Hochzeitstafel', 'category' => 'wedding', 'sort_order' => 3],
            ['filename' => 'wedding-04.jpg', 'alt_text' => 'Brautstrauß mit Pfingstrosen', 'category' => 'wedding', 'sort_order' => 4],

            // Geburtstag (birthday)
            ['filename' => 'birthday-01.jpg', 'alt_text' => 'Ballonbogen zum Geburtstag', 'category' => 'birthday', 'sort_order' => 5],
            ['filename' => 'birthday-02.jpg', 'alt_text' => 'Festliche Geburtstagsdekoration', 'category' => 'birthday', 'sort_order' => 6],
            ['filename' => 'birthday-03.jpg', 'alt_text' => 'Candy Bar Aufbau', 'category' => 'birthday', 'sort_order' => 7],

            // Corporate (Firmenevent)
            ['filename' => 'corporate-01.jpg', 'alt_text' => 'Firmenveranstaltung elegant dekoriert', 'category' => 'corporate', 'sort_order' => 8],
            ['filename' => 'corporate-02.jpg', 'alt_text' => 'Galaabend Tischdekoration', 'category' => 'corporate', 'sort_order' => 9],

            // Sonstiges (other)
            ['filename' => 'other-01.jpg', 'alt_text' => 'Weihnachtsfeier Dekoration', 'category' => 'other', 'sort_order' => 10],
            ['filename' => 'other-02.jpg', 'alt_text' => 'Taufe Dekoration in Rosa und Gold', 'category' => 'other', 'sort_order' => 11],
        ];

        foreach ($images as $image) {
            GalleryImage::updateOrCreate(
                ['filename' => $image['filename']],
                array_merge($image, ['is_active' => true])
            );
        }
    }
}
