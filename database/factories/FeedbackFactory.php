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
        // Pastikan ada kategori, atau buat baru jika kosong
        // Sesuaikan nama kategori dengan yang biasa dipakai (Keluhan, Saran, Apresiasi)
        $catName = $this->faker->randomElement(['Keluhan', 'Saran', 'Apresiasi']);

        $feedbackCategory = \App\Models\FeedbackCategory::firstOrCreate(
            ['name' => $catName],
            [
                'slug' => \Illuminate\Support\Str::slug($catName),
                'is_active' => true
            ]
        );

        $destinationId = Destination::inRandomOrder()->value('id');
        if (!$destinationId) {
            $destinationId = \Database\Factories\DestinationFactory::new()->create()->id;
        }

        return [
            'destination_id' => $destinationId,
            'feedback_category_id' => $feedbackCategory->id,
            'rating' => $catName === 'Saran' ? null : $this->faker->numberBetween(1, 5),
            'title' => $this->faker->sentence(6),
            'content' => $this->faker->paragraph(3),
            'status' => 'new', // Ubah default status jadi 'new' sesuai controller, atau 'baru' jika enum database begitu
            'submitted_ip' => $this->faker->ipv4(),
            'submitted_at' => now()->subDays(rand(0, 60)),
        ];
    }
}
