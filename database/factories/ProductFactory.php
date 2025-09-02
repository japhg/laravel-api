<?php
namespace Database\Factories;

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
        return [
            'name'          => fake()->words(2, true),
            'category'      => fake()->randomElement(['Electronics', 'Accessories', 'Fitness', 'Sportswear', 'Fashion', 'Home Appliances']),
            'description'   => fake()->realText(),
            'date_and_time' => fake()->dateTimeBetween('2022-11-30', '2025-02-30'),
        ];
    }
}
