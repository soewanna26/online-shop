<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubCategory>
 */
class SubCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->name();
        $slug = Str::slug($name);

        $categories = [];

        // Generate 2 random numbers between 1 and 30
        for ($i = 0; $i < 2; $i++) {
            $randomNumber = rand(1, 30);
            $categories[] = $randomNumber;
        }
        $catRandKey = array_rand($categories);
        $categoryId = $categories[$catRandKey];
        return [
            'name' => $name,
            'slug' => $slug,
            'status' => 1,
            'showHome' => rand(0, 1) ? "Yes" : "No",
            'category_id' => $categoryId,
        ];
    }
}
