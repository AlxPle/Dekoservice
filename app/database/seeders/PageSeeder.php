<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'home',
                'title' => 'Startseite',
                'content' => [
                    'hero_heading' => 'Jeder Moment verdient einen unvergesslichen Rahmen',
                    'hero_subtext' => 'Hochwertiger Deko-Verleih und professionelle Eventgestaltung in Ihrer Region — persönlich, kreativ, zuverlässig.',
                    'services_heading' => 'Unsere Leistungen',
                ],
                'meta_title' => 'Helena Kunz – Dekoration & Event-Verleih',
                'meta_description' => 'Hochwertiger Deko-Verleih für Hochzeiten, Geburtstage und Firmenevents. Jetzt Angebot anfragen!',
            ],
            [
                'slug' => 'ueber-uns',
                'title' => 'Über uns',
                'content' => [
                    'heading' => 'Über Helena Kunz',
                    'intro' => 'Seit über 10 Jahren gestalte ich mit Leidenschaft besondere Momente – von romantischen Hochzeiten über festliche Geburtstage bis hin zu professionellen Firmenevents.',
                    'description' => 'Mein Name ist Helena Kunz. Dekorieren ist meine Leidenschaft – und diese Leidenschaft bringe ich in jeden Auftrag ein. Gemeinsam mit Ihnen entwickle ich ein individuelles Konzept, das Ihre Vorstellungen in ein unvergessliches Erlebnis verwandelt.',
                    'values' => [
                        'Persönliche Beratung',
                        'Individuelle Gestaltung',
                        'Zuverlässige Umsetzung',
                        'Hochwertiges Material',
                    ],
                ],
                'meta_title' => 'Über uns – Helena Kunz Dekoservice',
                'meta_description' => 'Erfahren Sie mehr über Helena Kunz und unser Angebot für Hochzeiten, Geburtstage und Firmenevents.',
            ],
            [
                'slug' => 'kontakt',
                'title' => 'Kontakt',
                'content' => [
                    'heading' => 'Nehmen Sie Kontakt auf',
                    'subtext' => 'Wir freuen uns auf Ihre Anfrage und beraten Sie gerne persönlich.',
                    'phone' => '+49 170 58 65 783',
                    'email' => 'info@dekoservice-kunz.de',
                ],
                'meta_title' => 'Kontakt – Helena Kunz Dekoservice',
                'meta_description' => 'Kontaktieren Sie Helena Kunz für Ihr nächstes Event. Wir beraten Sie gerne persönlich und unverbindlich.',
            ],
            [
                'slug' => 'impressum',
                'title' => 'Impressum',
                'content' => [
                    'company' => 'Helena Kunz Dekoservice',
                    'owner' => 'Helena Kunz',
                    'phone' => '+49 170 58 65 783',
                    'email' => 'info@dekoservice-kunz.de',
                    'ust_id' => 'Gemäß § 19 UStG wird keine Umsatzsteuer erhoben.',
                ],
                'meta_title' => 'Impressum – Helena Kunz Dekoservice',
                'meta_description' => 'Impressum und rechtliche Informationen von Helena Kunz Dekoservice.',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }

        $leistungen = [
            [
                'slug'             => 'hochzeiten',
                'icon'             => '💍',
                'excerpt'          => 'Romantische Tischdekoration, Blumenarrangements, Lichterketten, Bögen und mehr – für Ihren unvergesslichsten Tag.',
                'title'            => 'Hochzeiten',
                'meta_title'       => 'Hochzeits-Dekoration – Helena Kunz Dekoservice',
                'meta_description' => 'Romantische Hochzeitsdekoration: Tische, Blumenarrangements, Bögen und Lichterketten. Jetzt anfragen!',
            ],
            [
                'slug'             => 'geburtstage',
                'icon'             => '🎂',
                'excerpt'          => 'Luftballons, Dekosäulen, Thementische – wir zaubern die perfekte Atmosphäre für jede Feier.',
                'title'            => 'Geburtstage & Partys',
                'meta_title'       => 'Geburtstags-Dekoration – Helena Kunz Dekoservice',
                'meta_description' => 'Luftballons, Dekosäulen, Thementische für Geburtstage und Partys. Wir gestalten Ihre Feier!',
            ],
            [
                'slug'             => 'firmenevents',
                'icon'             => '🏢',
                'excerpt'          => 'Professionelle Raumgestaltung für Messen, Konferenzen und Firmenveranstaltungen – mit klarem Stil.',
                'title'            => 'Firmenevents',
                'meta_title'       => 'Firmenevent-Dekoration – Helena Kunz Dekoservice',
                'meta_description' => 'Professionelle Raumgestaltung für Messen, Konferenzen und Firmenveranstaltungen.',
            ],
        ];

        foreach ($leistungen as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
