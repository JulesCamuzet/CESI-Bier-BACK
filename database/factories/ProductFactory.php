<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 1, 100),
            'stock' => fake()->numberBetween(1, 20),
            'picture' => fake()->randomElement([
                'https://ih1.redbubble.net/image.5160944228.1058/raf,360x360,075,t,fafafa:ca443f4786.u6.jpg',
                'https://pictures.trbna.com/image/cfba80fb-24e6-4e1c-a911-57a8a0242358?width=1920&quality=70'
            ]),
            'status' => fake()->randomElement(['disponible', 'indisponible']),
            'supplier_id' => Supplier::inRandomOrder()->first()?->id ?? Supplier::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
        ];
        
    }
}
