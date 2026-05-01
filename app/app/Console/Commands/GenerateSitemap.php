<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

#[Signature('sitemap:generate')]
#[Description('Generate the sitemap.xml file')]
class GenerateSitemap extends Command
{
    public function handle(): int
    {
        $baseUrl = config('app.url');

        Sitemap::create()
            ->add(Url::create($baseUrl)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(1.0))
            ->add(Url::create($baseUrl . '/galerie')
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8))
            ->add(Url::create($baseUrl . '/ueber-uns')
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7))
            ->add(Url::create($baseUrl . '/kontakt')
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.8))
            ->add(Url::create($baseUrl . '/impressum')
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setPriority(0.2))
            ->writeToFile(public_path('sitemap.xml'));

        $this->info('sitemap.xml generated successfully.');

        return self::SUCCESS;
    }
}
