<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Feedback;
use App\Models\FeedbackCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = Destination::all();
        $categories = FeedbackCategory::all();

        if ($destinations->isEmpty() || $categories->isEmpty()) {
            return;
        }

        $feedbacks = [
            [
                'visitor_name' => 'Sheny Jasmine',
                'content' => 'Toiletnya di area parkir agak kotor tadi pas saya dateng, mohon lebih sering dibersihin ya min bau soalnya.',
                'rating' => 3,
                'category' => 'Kebersihan',
                'days_ago' => 15,
                'status' => 'resolved',
            ],
            [
                'visitor_name' => 'Afriani Sri',
                'content' => 'Musholanya bersih, mukenanya juga wangi. Tapi sajadahnya mungkin perlu ditambah lagi kalau pas jumatan rame.',
                'rating' => 5,
                'category' => 'Fasilitas',
                'days_ago' => 4,
                'status' => 'processing',
            ],
            [
                'visitor_name' => 'Nafisa',
                'content' => 'Kak penjaga loketnya ramah banget tadi, ngejelasin rutenya detail banget. Makasih yaa!',
                'rating' => 5,
                'category' => 'Pelayanan',
                'days_ago' => 1,
                'status' => 'new',
            ],
            [
                'visitor_name' => 'Najla',
                'content' => 'Harga tiketnya worth it sih sama viewnya. Cuma kalau bisa ada promo member dong hehe biar makin rajin kesini.',
                'rating' => 4,
                'category' => 'Harga & Tiket',
                'days_ago' => 20,
                'status' => 'resolved',
            ],
            [
                'visitor_name' => 'Yesa',
                'content' => 'Parkiran motornya aman, ada cctv juga jadi tenang ninggalin helm. Cuma agak sempit aja akses keluarnya.',
                'rating' => 4,
                'category' => 'Keamanan',
                'days_ago' => 25,
                'status' => 'resolved',
            ],
            [
                'visitor_name' => 'Putma',
                'content' => 'Vibesnya enak banget buat healing! Spot fotonya ga ada obat keren semua. Wajib banget kesini pas sore.',
                'rating' => 5,
                'category' => 'Apresiasi',
                'days_ago' => 2,
                'status' => 'new',
            ],
            [
                'visitor_name' => 'Aby',
                'content' => 'Min, tambahin tempat sampah di jalur trekking dong. Kasian banyak yang buang sampah sembarangan di semak-semak.',
                'rating' => 3,
                'category' => 'Saran',
                'days_ago' => 6,
                'status' => 'processing',
            ],
            [
                'visitor_name' => 'Anin',
                'content' => 'Makanannya enak-enak di kantin, tapi nunggunya agak lama pas jam makan siang. Mungkin kokinya perlu ditambah?',
                'rating' => 4,
                'category' => 'Pelayanan',
                'days_ago' => 18,
                'status' => 'resolved',
            ],
            [
                'visitor_name' => 'Agis',
                'content' => 'Tong sampahnya penuh banget tadi di deket pintu masuk, sampe tumpah-tumpah. Tolong segera diangkut ya min.',
                'rating' => 2,
                'category' => 'Kebersihan',
                'days_ago' => 0, // Hari ini
                'status' => 'new',
            ],
            [
                'visitor_name' => 'Elsa',
                'content' => 'Kolam renangnya airnya jernih, anak-anak seneng banget main di sini. Perosotannya juga aman ga ada yang tajem.',
                'rating' => 5,
                'category' => 'Fasilitas',
                'days_ago' => 12,
                'status' => 'resolved',
            ],
            [
                'visitor_name' => 'Nafasya',
                'content' => 'Tadi sempet liat ada beberapa keramik lantai yang pecah di deket kolam, takut bikin kaki luka. Tolong diperbaiki min.',
                'rating' => 3,
                'category' => 'Keamanan',
                'days_ago' => 5,
                'status' => 'processing',
            ],
            [
                'visitor_name' => 'Fina',
                'content' => 'Sunset di sini juara banget! Bakal balik lagi fix ajak temen-temen se-geng.',
                'rating' => 5,
                'category' => 'Apresiasi',
                'days_ago' => 1,
                'status' => 'new',
            ],
            [
                'visitor_name' => 'Fhira',
                'content' => 'Kalau ada penyewaan powerbank atau charging station bakal lebih oke sih, soalnya susah cari colokan pas hape lowbat.',
                'rating' => 4,
                'category' => 'Saran',
                'days_ago' => 22,
                'status' => 'resolved',
            ],
            [
                'visitor_name' => 'Puput',
                'content' => 'Tiket weekend agak kemahalan sedikit menurutku Rp 35rb, tapi yaa kebayar sih sama fasilitasnya yang lengkap.',
                'rating' => 4,
                'category' => 'Harga & Tiket',
                'days_ago' => 8,
                'status' => 'processing',
            ],
            [
                'visitor_name' => 'Hanifah Lulu',
                'content' => 'Gazebonya nyaman buat istirahat sekeluarga. Tapi atapnya ada yang bocor dikit pas ujan tadi sore.',
                'rating' => 4,
                'category' => 'Fasilitas',
                'days_ago' => 28,
                'status' => 'resolved',
            ],
            [
                'visitor_name' => 'Dila',
                'content' => 'Respon admin di sosmed cepet, pas sampe lokasi juga stafnya gercep bantuin bawain barang.',
                'rating' => 5,
                'category' => 'Pelayanan',
                'days_ago' => 3,
                'status' => 'new',
            ],
            [
                'visitor_name' => 'Wafa',
                'content' => 'Keren banget pengelolaannya, rapi dan teratur. Gak nyesel jauh-jauh main ke sini dari luar kota.',
                'rating' => 5,
                'category' => 'Apresiasi',
                'days_ago' => 14,
                'status' => 'resolved',
            ],
            [
                'visitor_name' => 'Nabila',
                'content' => 'Min adain live music dong pas malem minggu biar makin asik suasananya kalau lagi nongkrong di cafe-nya.',
                'rating' => 5,
                'category' => 'Saran',
                'days_ago' => 7,
                'status' => 'processing',
            ],
            [
                'visitor_name' => 'Aurora',
                'content' => 'Suka banget karena tempatnya bersih dari sampah plastik. Jarang ada wisata alam sebersih ini.',
                'rating' => 5,
                'category' => 'Kebersihan',
                'days_ago' => 2,
                'status' => 'new',
            ],
            [
                'visitor_name' => 'Nirmala',
                'content' => 'Jalan menuju lokasi ada yang berlubang parah sekitar 500m dari gerbang, hati-hati buat yang bawa motor matic.',
                'rating' => 3,
                'category' => 'Fasilitas',
                'days_ago' => 1,
                'status' => 'new',
            ],
        ];

        foreach ($feedbacks as $data) {
            $category = $categories->firstWhere('name', $data['category']) ?? $categories->first();
            $destination = $destinations->random();

            Feedback::create([
                'destination_id' => $destination->id,
                'feedback_category_id' => $category->id,
                'visitor_name' => $data['visitor_name'],
                'rating' => $data['rating'],
                'title' => \Illuminate\Support\Str::limit($data['content'], 40),
                'content' => $data['content'],
                'status' => $data['status'],
                'submitted_at' => Carbon::now()->subDays($data['days_ago'])->subHours(rand(1, 12)),
            ]);
        }
    }
}
