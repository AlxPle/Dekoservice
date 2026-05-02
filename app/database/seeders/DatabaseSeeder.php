<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminEmail = env('ADMIN_SEED_EMAIL', 'admin@example.com');
        $adminName = env('ADMIN_SEED_NAME', 'Admin');
        $adminPassword = env('ADMIN_SEED_PASSWORD');

        if (empty($adminPassword)) {
            if (! app()->environment('local')) {
                throw new \RuntimeException('Set ADMIN_SEED_PASSWORD before running seeders outside local environment.');
            }

            $adminPassword = 'password';
        }

        // Admin user for Filament panel
        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => $adminName,
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            PageSeeder::class,
            GalleryImageSeeder::class,
        ]);
    }
}
