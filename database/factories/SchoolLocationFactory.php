<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SchoolLocation>
 */
class SchoolLocationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Gedung A', 'Perpustakaan', 'Laboratorium', 'Lapangan', 'Kantin']).' '.fake()->numberBetween(1, 9),
            'description' => fake()->sentence(),
            'latitude' => fake()->latitude(-7, -6),
            'longitude' => fake()->longitude(106, 107),
            'image_path' => null,
            'status' => 'active',
        ];
    }
}
