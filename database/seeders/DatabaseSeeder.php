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
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );



        // Seed real categories & destinations
        $this->call(DestinationSeeder::class);

        // Seed feedback categories
        $this->call(FeedbackCategorySeeder::class);

        // Seed feedback contoh
        $this->call(FeedbackSeeder::class);
    }
}
