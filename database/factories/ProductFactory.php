<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;

    public function definition()
    {
        return [
            'code' => $this->faker->unique()->bothify('PRD-####'), // Generates a unique product code
            'name' => $this->faker->word,                         // Random single word
            'quantity' => $this->faker->numberBetween(1, 100),    // Random quantity between 1 and 100
            'price' => $this->faker->randomFloat(2, 10, 1000),    // Random price between 10 and 1000
            'description' => $this->faker->sentence,              // Random short sentence
        ];
    }
}
