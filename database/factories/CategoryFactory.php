<?php

namespace Database\Factories;

use Str;
use App\Models\User;
use App\Models\frontend\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
        protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => \Str::uuid(),
            'name' => $this->faker->word,
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->sentence(),
            'metadata' => ['color' => 'red'],
            'set_order' => rand(1, 10),
            'image' => null,
            'is_active' => true,
            'user_id' => User::factory(),
        ];
    }
}
