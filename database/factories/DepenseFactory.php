<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use app\Models\Adhesion;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Depense>
 */
class DepenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre' => fake()->words(3, true), 
            'montant' => fake()->numberBetween(10, 500),
            'createur_id' =>fake()->numberBetween(1, 20),
            'payeur_id' => fake()->numberBetween(1, 20),
            'adhesion_id' => fake()->numberBetween(1, 20),
            'colocation_id' => fake()->numberBetween(1, 20),
            'paye' => fake()->boolean(20),
        ];
    }
}
