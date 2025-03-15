<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if categories exist, if not create them
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }
        
        // Create 1000 products
        Product::factory()->count(1000)->create();
    }
}