<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->company(),
            'location' => fake()->country(),
            'description' => fake()->paragraph(),
            'picture' => fake()->randomElement([
                'https://logo-marque.com/wp-content/uploads/2020/09/Heineken-Logo.png',
                'https://logo-marque.com/wp-content/uploads/2022/03/Kronenbourg-1664-Logo.png',
                'https://logo-marque.com/wp-content/uploads/2022/03/Leffe-Logo.png',
                'https://logos-marques.com/wp-content/uploads/2022/03/Corona-logo.png',
            ]),
        ];
    }
}
