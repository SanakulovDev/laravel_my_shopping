<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'detail' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'count' => $this->faker->numberBetween(1, 100),
            'photo' => $this->faker->imageUrl(640, 480),
            'category_id' => Category::exists() ? Category::inRandomOrder()->first()->id : null,
        ];
    }
}