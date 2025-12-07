<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Feedback;
use App\Models\Category;
use App\Models\Destination;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin default
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'full_name' => 'Administrator',
                'password' => Hash::make('ChangeMe!123'),
                'role' => 'admin',
            ]
        );

        // Seed kategori & destinasi contoh (minimal)
        if (Category::count() === 0) {
            Category::factory()->count(3)->create();
        }

        if (Destination::count() === 0) {
            Destination::factory()->count(5)->create();
        }

        // Seed feedback categories
        $this->call(FeedbackCategorySeeder::class);

        // Seed feedback contoh
        Feedback::factory(20)->create();
    }
}
