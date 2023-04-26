<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activite>
 */
class ActiviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate= $this->faker->dateTimeBetween('now','+3 days')->format('Y-m-d');
        $endDate= $this->faker->dateTimeBetween($startDate,'+1 months')->format('Y-m-d');
        return [
            'nom'=> $this->faker->name,
            'details'=> $this->faker->sentence(),
            'debut'=> $startDate,
            'fin'=>$endDate,
            'couleur'=>$this->faker->hexColor()
        ];
    }
}
