<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
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
    public function definition(): array
    {
        $name = $this->faker->words(3, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'is_published' => $this->faker->boolean(),
            'sort' => $this->faker->numberBetween(1, 100),
            'category_id' => Category::factory(),
            'type' => $this->faker->randomElement(['perfume', 'eau_de_toilette', 'eau_de_parfum', 'cologne', 'body_spray']),
        ];
    }
}
