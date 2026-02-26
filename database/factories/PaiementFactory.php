<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Depense;
use app\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paiement>
 */
class PaiementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'montant' => fake()->numberBetween(100, 500),
            'user_id' => fake()->numberBetween(1, 20),
            'depense_id' => fake()->numberBetween(1, 20),
            'created_at' => now(),
        ];
    }
}
