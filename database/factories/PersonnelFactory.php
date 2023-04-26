<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personnel>
 */
class PersonnelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matricule'=> $this->faker->unique()->word(),
            'prenom'=> $this->faker->name,
            'id_assureur'=> $this->faker->numberBetween(3,15,20000),
            'id_personne'=> $this->faker->numberBetween(1,30,20000)
        ];
    }
}
