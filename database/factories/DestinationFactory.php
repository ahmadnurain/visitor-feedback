<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DestinationFactory extends Factory
{
    protected $model = Destination::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->sentence(3);
        $categoryId = Category::inRandomOrder()->value('id') ?? Category::factory()->create()->id;

        return [
            'category_id' => $categoryId,
            'name' => trim($name, '.'),
            'slug' => Str::slug($name) . '-' . Str::random(5),
            'is_active' => true,
            'address' => $this->faker->optional()->address(),
            'latitude' => $this->faker->optional()->latitude(-7.0, -6.0),
            'longitude' => $this->faker->optional()->longitude(107.0, 109.0),
            'banner_path' => null,
        ];
    }
}
