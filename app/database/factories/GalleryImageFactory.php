<?php

namespace Database\Factories;

use App\Models\GalleryImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryImageFactory extends Factory
{
    protected $model = GalleryImage::class;

    public function definition(): array
    {
        return [
            'filename'   => $this->faker->slug() . '.jpg',
            'alt_text'   => $this->faker->sentence(4),
            'category'   => $this->faker->randomElement(['wedding', 'birthday', 'corporate', 'other']),
            'sort_order' => $this->faker->numberBetween(1, 100),
            'is_active'  => true,
        ];
    }
}
