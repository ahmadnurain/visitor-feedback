<?php

namespace Database\Seeders;

use App\Models\FeedbackCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FeedbackCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Kebersihan' => 'Masalah terkait kebersihan lokasi, toilet, dan lingkungan.',
            'Fasilitas' => 'Kerusakan atau kekurangan fasilitas umum.',
            'Pelayanan' => 'Sikap dan kinerja petugas atau staf.',
            'Keamanan' => 'Gangguan keamanan atau ketertiban.',
            'Harga & Tiket' => 'Masalah harga tiket atau pungutan liar.',
            'Apresiasi' => 'Pujian untuk hal-hal yang sudah baik.',
            'Saran' => 'Usulan perbaikan atau ide baru.',
        ];

        foreach ($categories as $name => $desc) {
            FeedbackCategory::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $desc,
                    'is_active' => true,
                ]
            );
        }
    }
}
