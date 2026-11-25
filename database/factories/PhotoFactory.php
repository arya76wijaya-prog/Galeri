<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'album_id' => Album::factory(),
            'image_path' => 'photos/sample-'.fake()->numberBetween(1, 8).'.jpg',
            'caption' => fake()->optional()->sentence(),
            'uploaded_by' => User::factory(),
        ];
    }
}
