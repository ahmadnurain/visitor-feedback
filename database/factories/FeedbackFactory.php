<?php

namespace Database\Factories;

use App\Models\Destination;
use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition(): array
    {
        $cats = ['keluhan','saran','apresiasi'];
        $cat = $this->faker->randomElement($cats);
        $destinationId = Destination::inRandomOrder()->value('id');
        if (!$destinationId) {
            $destinationId = \Database\Factories\DestinationFactory::new()->create()->id;
        }

        return [
            'destination_id' => $destinationId,
            'category' => $cat,
            'rating' => $cat === 'saran' ? null : $this->faker->numberBetween(1, 5),
            'title' => $this->faker->sentence(6),
            'content' => $this->faker->paragraph(3),
            'status' => 'baru',
            'submitted_ip' => $this->faker->ipv4(),
            'submitted_at' => now()->subDays(rand(0, 60)),
        ];
    }
}
