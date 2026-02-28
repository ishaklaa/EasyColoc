<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Adhesion;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invitation>
 */
class InvitationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'email' => fake()->unique()->safeEmail(),
            'token' => fake()->sentence(),
            'statut' => fake()->randomElement(['en attente', 'accepter', 'resfuser']),
            'colocation_id' => fake()->numberBetween(1, 20),
        ];
    }
}
