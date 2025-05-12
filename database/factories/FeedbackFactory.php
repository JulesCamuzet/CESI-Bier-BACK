<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Product;

class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraph(),
            'rate' => fake()->numberBetween(1, 5),
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'created_at' => fake()->dateTime(),
        ];
    }
}
