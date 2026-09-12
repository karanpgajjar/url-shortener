<?php

namespace Database\Factories;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ShortUrl>
 */
class ShortUrlFactory extends Factory
{
    /**
     * Define the model"s default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            "code" => Str::random(7),
            "original_url" => fake()->url(),
            "user_id" => $user->id,
            "company_id" => $user->company_id,
            "clicks" => fake()->numberBetween(0, 500),
        ];
    }
}
