<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'total_cost' => fake()->randomFloat(2, 10, 500),
            'payment_key' => fake()->word(),
            'payment_url' => 'https://checkout.stripe.com/pay/' . fake()->uuid(),
            'status' => fake()->randomElement(['pending', 'completed', 'canceled']),
            'adress' => fake()->address(),
            'zip_code' => fake()->postcode(),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'user_id' => User::factory(), 
            'created_at' => fake()->dateTime(),
        ];
    }
}
