<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Picture;
use App\Models\Supplier;
use App\Models\OrderItem;
use App\Models\Feedback;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory(10)->create();
        Feedback::factory()->count(10)->create();
        OrderItem::factory(10)->create();
        Order::factory(10)->create();
        Picture::factory(10)->create();  
        Product::factory(30)->create();
        Supplier::factory(10)->create();
        User::factory()->count(10)->create(); 

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
