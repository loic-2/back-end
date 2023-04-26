<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Validation\Rules\Unique;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tache>
 */
class TacheFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom'=> $this->faker->word(),
            'debut'=> $this->faker->date(),
            'fin'=> $this->faker->date(),
            'id_activite'=> $this->faker->numberBetween(1,15,20000),
            'id_personnel'=> $this->faker->numberBetween(1,15,20000)
        ];
    }
}
