<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'photo_id' => Photo::factory(),
            'reason' => fake()->randomElement(['inappropriate', 'blurry', 'wrong_album', 'copyright', 'other']),
            'description' => fake()->optional()->sentence(),
            'status' => 'pending',
        ];
    }
}
