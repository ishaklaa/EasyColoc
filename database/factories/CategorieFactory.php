<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categorie>
 */
class CategorieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre'=>fake()->words(3, true),
            'colocation_id' =>fake()->numberBetween(1, 20),
            'depense_id'=> fake()->numberBetween(1, 20),
        ];
    }
}
