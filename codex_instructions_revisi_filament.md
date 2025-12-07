# codex_instructions.md — Revisi (Filament, tanpa Spatie/Breeze, Tema “CrystalDB”)

> Dokumen instruksi **siap pakai** untuk Coding Agent/Codex.  
> Konteks proyek: **Sistem Umpan Balik Pengunjung Destinasi Wisata** (Disparbud Kab. Majalengka).  
> Teknologi: **Laravel 12 (PHP ≥ 8.3)**, **Filament v4** (panel admin), **Blade + Tailwind** (UI publik), **MySQL**.  
> **Tanpa Spatie Permission** dan **tanpa Breeze**. RBAC sederhana via kolom `users.role` + Policy/Gate.  
> Tema UI publik mengikuti **design JSON “CrystalDB”** (Inter/Poppins, aksen gradien ungu, dark & light).

---

## 1) Peran, Tujuan, & Gaya Penulisan
**Peran:** Kamu adalah *Coding Agent* yang meng-output **kode lengkap**, bukan diff.  
**Tujuan:** Menyelesaikan fitur MVP: form umpan balik publik, CRUD & dashboard admin (Filament), ekspor CSV.  
**Gaya:** Indonesia, profesional, rapi, responsif, aksesibel. Sertakan **perintah terminal**, **daftar file**, dan **isi file lengkap**.

---

## 2) Format Jawaban (WAJIB)
Setiap langkah ditulis dengan format ini:

### 2.1. Header Langkah
- **Langkah N/9 – Judul Singkat**  
Ringkasan 1–3 kalimat.

### 2.2. Perintah Terminal (jika ada)
```bash
# contoh
php artisan make:policy DestinationPolicy --model=Destination
```

### 2.3. Daftar File Dibuat/Diubah
- `path/fileA.php` (baru)
- `path/fileB.php` (ubah)

### 2.4. Isi File Lengkap
````markdown
**FILE:** path/fileA.php
```php
<?php
// isi lengkap
```
````

### 2.5. Catatan Pasca-Instal (opsional)

### 2.6. Hasil yang Diharapkan

> **PENTING:** Tunjukkan **isi file penuh** setiap kali ada perubahan.

---

## 3) Scope & Batasan MVP
**Dalam scope:**
- Landing publik + daftar/detil destinasi (kamu sudah punya CRUD Kategori & Destinasi di Filament).
- Form umpan balik publik (`/destinations/{slug}`) dengan validasi & rate-limit.
- Panel admin **Filament**: **CategoryResource**, **DestinationResource** (sudah), **FeedbackResource** (buat), **Dashboard**.
- Ekspor CSV dari tabel Feedback (sesuai filter).
- Upload lampiran (opsional) ke `storage/app/public` + `php artisan storage:link`.
- Policy berbasis `users.role` (tanpa Spatie).

**Di luar scope (fase berikutnya):**
- Tiketing/pembayaran.
- NLP/sentimen.

---

## 4) Data Model & Relasi

### 4.1. Tabel
- **categories** *(sudah ada)*: `id`, `name`, `slug`, timestamps.  
- **destinations** *(sudah ada)*: `id`, `category_id`, `name`, `slug`, `address?`, `latitude?`, `longitude?`, `is_active`, `banner_path?`, timestamps.  
- **feedbacks** *(buat baru)*:
  - `id`, `destination_id` FK
  - `user_id?` (nullable)
  - `category` enum-like: `keluhan|saran|apresiasi`
  - `rating` tinyint 1..5 (opsional untuk `saran`)
  - `title` string(150), `content` text
  - `attachments` json? (null)
  - `status` `baru|diproses|selesai|ditolak` default `baru`
  - `contact_email?`, `contact_phone?`
  - `submitted_ip?`, `submitted_at`
  - timestamps, index: `destination_id`, `status`, `submitted_at`
- **users**: tambah kolom `role` (`admin|user`, default `user`), opsional `full_name`.

### 4.2. Seeder
- Admin default (`role=admin`), beberapa kategori/destinasi contoh.

---

## 5) Tema UI “CrystalDB” (Blade + Tailwind)
- **Font:** Headings = *Poppins* 700; Body = *Inter* 16px/1.6.  
- **Light:** bg `#FFFFFF`, text `#4A4A4A`, heading `#111015`, card `#F7F7F7`, border `#EAEAEA`.  
- **Dark:** bg `#111015`, text `#F5F5F5`, heading `#FFFFFF`, card `#1A1A1E`, border `#333333`.  
- **Aksen (gradient):** `#8E44AD` → `#C850C0`.  
- **Layout:** `container mx-auto max-w-[1140px] px-4 sm:px-6 lg:px-8`, whitespace lega, alignment terpusat.

**Kelas Tailwind contoh:**
- Button primer (gradient): `inline-flex items-center rounded-xl px-4 py-2 text-white bg-gradient-to-r from-[#8E44AD] to-[#C850C0] hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-[#C850C0]/40`
- Card: `rounded-2xl border bg-[var(--card)] border-[var(--border)] shadow-sm p-6`
- Heading: `font-[Poppins] text-3xl sm:text-4xl font-bold tracking-tight`
- Body: `font-[Inter] text-base leading-7`

> Toggle tema via atribut `<html data-theme="dark|light">` dan variabel CSS `--bg --text --heading --card --border`.

---

## 6) Rencana Eksekusi (9 langkah)  
> **Catatan:** Kamu **sudah** install Filament & buat CRUD **Kategori** dan **Destinasi**. Maka **Langkah 1–2 dianggap selesai**. Lanjut **Langkah 3–9**.

### **Langkah 3/9 – Migration & Model Feedback + Kolom Role User**
Ringkasan: Tambah tabel `feedbacks` dan kolom `role` di `users`. Buat model, factory, dan seeder admin.

```bash
php artisan make:migration create_feedbacks_table
php artisan make:migration add_role_to_users_table
php artisan make:model Feedback -mf
php artisan migrate
```

**Daftar File:**
- `database/migrations/xxxx_xx_xx_xxxxxx_create_feedbacks_table.php` (baru)
- `database/migrations/xxxx_xx_xx_xxxxxx_add_role_to_users_table.php` (baru)
- `app/Models/Feedback.php` (baru)
- `database/factories/FeedbackFactory.php` (baru)
- `database/seeders/DatabaseSeeder.php` (ubah)

````markdown
**FILE:** database/migrations/xxxx_xx_xx_xxxxxx_create_feedbacks_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('category', ['keluhan','saran','apresiasi']);
            $table->tinyInteger('rating')->nullable(); // 1..5, opsional utk 'saran'
            $table->string('title', 150);
            $table->text('content');
            $table->json('attachments')->nullable();
            $table->enum('status', ['baru','diproses','selesai','ditolak'])->default('baru');
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('submitted_ip', 45)->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();

            $table->index(['destination_id', 'status']);
            $table->index('submitted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
```
````

````markdown
**FILE:** database/migrations/xxxx_xx_xx_xxxxxx_add_role_to_users_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('email'); // 'admin' | 'user'
            $table->string('full_name')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role','full_name']);
        });
    }
};
```
````

````markdown
**FILE:** app/Models/Feedback.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id','user_id','category','rating','title','content',
        'attachments','status','contact_email','contact_phone','submitted_ip','submitted_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```
````

````markdown
**FILE:** database/factories/FeedbackFactory.php
```php
<?php

namespace Database\Factories;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    public function definition(): array
    {
        $cats = ['keluhan','saran','apresiasi'];
        $cat = $this->faker->randomElement($cats);
        return [
            'destination_id' => Destination::inRandomOrder()->value('id') ?? 1,
            'category' => $cat,
            'rating' => $cat === 'saran' ? null : $this->faker->numberBetween(1,5),
            'title' => $this->faker->sentence(6),
            'content' => $this->faker->paragraph(3),
            'status' => 'baru',
            'submitted_ip' => $this->faker->ipv4(),
            'submitted_at' => now()->subDays(rand(0,60)),
        ];
    }
}
```
````

````markdown
**FILE:** database/seeders/DatabaseSeeder.php  (potongan relevan)
```php
<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Feedback;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
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

        // Seed feedback contoh (butuh destinasi sudah ada)
        Feedback::factory(20)->create();
    }
}
```
````

**Hasil yang diharapkan:** Tabel `feedbacks` dan kolom `users.role` ada. Admin siap login.

---

### **Langkah 4/9 – Routing Publik & Controller + Request Validation**
Ringkasan: Tambah route publik, controller untuk landing, daftar/detil destinasi, dan submit feedback. Rate-limit endpoint submit.

```bash
php artisan make:controller HomeController
php artisan make:controller DestinationController
php artisan make:controller FeedbackController
php artisan make:request StoreFeedbackRequest
```

**Daftar File:**
- `routes/web.php` (ubah)
- `app/Http/Controllers/HomeController.php` (baru)
- `app/Http/Controllers/DestinationController.php` (baru)
- `app/Http/Controllers/FeedbackController.php` (baru)
- `app/Http/Requests/StoreFeedbackRequest.php` (baru)

````markdown
**FILE:** routes/web.php
```php
<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destinations.show');

// Submit feedback (rate-limited)
Route::middleware('throttle:' . (int) env('FEEDBACK_RATE_LIMIT', 5) . ',60')->group(function () {
    Route::post('/feedbacks', [FeedbackController::class, 'store'])->name('feedbacks.store');
});

Route::view('/thanks', 'thanks')->name('thanks');
```
````

````markdown
**FILE:** app/Http/Controllers/HomeController.php
```php
<?php

namespace App\Http\Controllers;

use App\Models\Destination;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Destination::query()
            ->where('is_active', true)
            ->latest('id')
            ->take(6)->get();

        return view('home', compact('featured'));
    }
}
```
````

````markdown
**FILE:** app/Http/Controllers/DestinationController.php
```php
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $category = $request->integer('category');

        $base = Destination::query()->where('is_active', true);
        if ($q) $base->where('name', 'like', "%{$q}%");
        if ($category) $base->where('category_id', $category);

        $destinations = $base->latest('id')->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('destinations.index', compact('destinations','categories','q','category'));
    }

    public function show(string $slug)
    {
        $destination = Destination::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('destinations.show', compact('destination'));
    }
}
```
````

````markdown
**FILE:** app/Http/Requests/StoreFeedbackRequest.php
```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'destination_id' => ['required','exists:destinations,id'],
            'category' => ['required','in:keluhan,saran,apresiasi'],
            'rating' => ['nullable','integer','between:1,5'],
            'title' => ['required','string','max:150'],
            'content' => ['required','string','max:5000'],
            'contact_email' => ['nullable','email'],
            'contact_phone' => ['nullable','string','max:30'],
            'attachments.*' => ['nullable','file','mimes:jpg,jpeg,png,pdf','max:2048'],
        ];
    }
}
```
````

````markdown
**FILE:** app/Http/Controllers/FeedbackController.php
```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FeedbackController extends Controller
{
    /** Normalisasi nomor HP ringan (62→0) */
    private function normalizePhone(?string $s): ?string
    {
        if (!$s) return null;
        $digits = preg_replace('/\D+/', '', $s);
        if (Str::startsWith($digits, '62')) {
            return '0' . substr($digits, 2);
        }
        return $digits;
    }

    public function store(StoreFeedbackRequest $request)
    {
        $data = $request->validated();

        // kategori vs rating (opsional untuk 'saran')
        if ($data['category'] !== 'saran' && empty($data['rating'])) {
            return back()->withErrors(['rating' => 'Rating wajib untuk keluhan/apresiasi'])->withInput();
        }

        // upload lampiran (opsional)
        $paths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if (!$file) continue;
                $paths[] = $file->store('public/feedbacks/'.now()->format('Y/m'));
            }
        }

        $fb = Feedback::create([
            'destination_id' => $data['destination_id'],
            'user_id' => auth()->id(),
            'category' => $data['category'],
            'rating' => $data['rating'] ?? null,
            'title' => $data['title'],
            'content' => $data['content'],
            'attachments' => array_map(fn($p) => Storage::url($p), $paths),
            'status' => 'baru',
            'contact_email' => $data['contact_email'] ?? null,
            'contact_phone' => $this->normalizePhone($data['contact_phone'] ?? null),
            'submitted_ip' => $request->ip(),
            'submitted_at' => now(),
        ]);

        return to_route('thanks')->with('ok', true);
    }
}
```
````

**Hasil yang diharapkan:** Endpoint publik siap untuk menampilkan destinasi dan menyimpan feedback dengan rate-limit.

---

### **Langkah 5/9 – Views Publik + Tema CrystalDB (Dark/Light)**
Ringkasan: Buat layout, komponen tombol, halaman home, daftar destinasi, detail destinasi (form feedback), dan halaman `thanks`.

**Daftar File:**
- `resources/views/layouts/app.blade.php` (baru)
- `resources/views/components/ui/button.blade.php` (baru)
- `resources/views/home.blade.php` (baru)
- `resources/views/destinations/index.blade.php` (baru)
- `resources/views/destinations/show.blade.php` (baru)
- `resources/views/thanks.blade.php` (baru)

````markdown
**FILE:** resources/views/layouts/app.blade.php
```blade
<!doctype html>
<html lang="id" data-theme="light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name','Majalengka Visitor Feedback') }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@700&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    :root{ --bg:#FFFFFF; --text:#4A4A4A; --heading:#111015; --card:#F7F7F7; --border:#EAEAEA; }
    html[data-theme="dark"]{ --bg:#111015; --text:#F5F5F5; --heading:#FFFFFF; --card:#1A1A1E; --border:#333333; }
    body{ background:var(--bg); color:var(--text); }
    .card{ background:var(--card); border-color:var(--border); }
  </style>
</head>
<body class="font-[Inter]">
  <header class="border-b border-[var(--border)]">
    <div class="container mx-auto max-w-[1140px] px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      <a href="{{ route('home') }}" class="font-[Poppins] text-xl">CrystalDB<span class="sr-only">brand</span></a>
      <nav class="hidden md:flex items-center gap-6">
        <a href="{{ route('home') }}" class="hover:opacity-80">Home</a>
        <a href="{{ route('destinations.index') }}" class="hover:opacity-80">Destinations</a>
        <a href="#" class="hover:opacity-80">About</a>
        <a href="#" class="hover:opacity-80">Pricing</a>
      </nav>
      <div class="flex items-center gap-3">
        <button id="toggle-theme" class="rounded-xl px-3 py-2 border border-[var(--border)]">Toggle</button>
        <a href="/admin" class="rounded-xl px-4 py-2 border border-[var(--border)]">Sign In</a>
        <a href="{{ route('destinations.index') }}" class="inline-flex items-center rounded-xl px-4 py-2 text-white bg-gradient-to-r from-[#8E44AD] to-[#C850C0] hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-[#C850C0]/40">Try for Free</a>
      </div>
    </div>
  </header>

  <main class="container mx-auto max-w-[1140px] px-4 sm:px-6 lg:px-8 py-10">
    @yield('content')
  </main>

  <footer class="mt-10 border-t border-[var(--border)]">
    <div class="container mx-auto max-w-[1140px] px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
      <div>
        <div class="font-[Poppins] text-xl">CrystalDB</div>
        <p class="text-sm mt-2 opacity-80">© 2025 CrystalDB. All rights reserved.</p>
      </div>
      <div class="text-sm space-y-2">
        <div class="font-semibold">Links</div>
        <a href="{{ route('home') }}" class="block hover:opacity-80">Home</a>
        <a href="{{ route('destinations.index') }}" class="block hover:opacity-80">Features</a>
        <a href="#" class="block hover:opacity-80">About Us</a>
        <a href="#" class="block hover:opacity-80">Free Tier</a>
      </div>
      <div class="text-sm">
        <div class="font-semibold">Contact</div>
        <p class="opacity-80 mt-2">Disbudpar Majalengka</p>
      </div>
    </div>
  </footer>

  <script>
    document.getElementById('toggle-theme')?.addEventListener('click',()=>{
      const html=document.documentElement;
      html.dataset.theme = html.dataset.theme === 'dark' ? 'light' : 'dark';
    });
  </script>
</body>
</html>
```
````

````markdown
**FILE:** resources/views/components/ui/button.blade.php
```blade
@props(['href'=>null,'type'=>'button'])
@php $base='inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2 text-white bg-gradient-to-r from-[#8E44AD] to-[#C850C0] hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-[#C850C0]/40'; @endphp
@if($href)
  <a {{ $attributes->class($base) }} href="{{ $href }}">{{ $slot }}</a>
@else
  <button type="{{ $type }}" {{ $attributes->class($base) }}>{{ $slot }}</button>
@endif
```
````

````markdown
**FILE:** resources/views/home.blade.php
```blade
@extends('layouts.app')

@section('content')
  <section class="text-center space-y-6">
    <p class="uppercase tracking-widest text-sm opacity-80">CrystalDB</p>
    <h1 class="font-[Poppins] text-4xl sm:text-5xl font-bold">
      Focus on <span class="bg-gradient-to-r from-[#8E44AD] to-[#C850C0] bg-clip-text text-transparent">logic</span>, not on the DB.
    </h1>
    <p class="text-lg opacity-90">The self-managed, serverless Postgres — untuk umpan balik wisata yang rapi & terukur.</p>
    <x-ui.button :href="route('destinations.index')">Start for free</x-ui.button>
  </section>

  <section class="mt-12">
    <h2 class="font-[Poppins] text-2xl font-bold mb-4">Destinations</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($featured as $d)
      <a href="{{ route('destinations.show',$d->slug) }}" class="card rounded-2xl border p-6 hover:shadow">
        <div class="text-lg font-semibold">{{ $d->name }}</div>
        <div class="text-sm opacity-80 mt-1">{{ $d->address }}</div>
      </a>
      @endforeach
    </div>
  </section>
@endsection
```
````

````markdown
**FILE:** resources/views/destinations/index.blade.php
```blade
@extends('layouts.app')

@section('content')
  <h1 class="font-[Poppins] text-3xl font-bold mb-6">Destinations</h1>
  <form method="GET" class="mb-6 grid grid-cols-1 sm:grid-cols-3 gap-3">
    <input name="q" value="{{ $q }}" placeholder="Cari destinasi…" class="rounded-xl border border-[var(--border)] bg-transparent px-4 py-2">
    <select name="category" class="rounded-xl border border-[var(--border)] bg-transparent px-4 py-2">
      <option value="">Semua Kategori</option>
      @foreach($categories as $c)
        <option value="{{ $c->id }}" @selected($category==$c->id)>{{ $c->name }}</option>
      @endforeach
    </select>
    <button class="rounded-xl px-4 py-2 border border-[var(--border)]">Filter</button>
  </form>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($destinations as $d)
    <a href="{{ route('destinations.show',$d->slug) }}" class="card rounded-2xl border p-6 hover:shadow">
      <div class="text-lg font-semibold">{{ $d->name }}</div>
      <div class="text-sm opacity-80 mt-1">{{ $d->address }}</div>
    </a>
    @endforeach
  </div>

  <div class="mt-6">{{ $destinations->links() }}</div>
@endsection
```
````

````markdown
**FILE:** resources/views/destinations/show.blade.php
```blade
@extends('layouts.app')

@section('content')
  <article class="space-y-6">
    <header>
      <h1 class="font-[Poppins] text-3xl sm:text-4xl font-bold">{{ $destination->name }}</h1>
      @if($destination->address)
        <p class="opacity-80 mt-1">{{ $destination->address }}</p>
      @endif
    </header>

    <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2 space-y-4">
        <div class="card rounded-2xl border p-6">
          <h2 class="font-semibold text-xl mb-2">Tentang</h2>
          <p class="opacity-90">Deskripsi singkat destinasi…</p>
        </div>
      </div>

      <aside class="space-y-4">
        <div class="card rounded-2xl border p-6">
          <h2 class="font-semibold text-xl mb-4">Kirim Umpan Balik</h2>
          <form method="POST" action="{{ route('feedbacks.store') }}" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <input type="hidden" name="destination_id" value="{{ $destination->id }}">

            <label class="block">
              <span class="text-sm">Kategori</span>
              <select name="category" class="mt-1 w-full rounded-xl border border-[var(--border)] bg-transparent px-3 py-2" required>
                <option value="keluhan">Keluhan</option>
                <option value="saran">Saran</option>
                <option value="apresiasi">Apresiasi</option>
              </select>
            </label>

            <label class="block">
              <span class="text-sm">Rating (1–5) — opsional utk saran</span>
              <input type="number" name="rating" min="1" max="5" class="mt-1 w-full rounded-xl border border-[var(--border)] bg-transparent px-3 py-2">
            </label>

            <label class="block">
              <span class="text-sm">Judul</span>
              <input name="title" maxlength="150" required class="mt-1 w-full rounded-xl border border-[var(--border)] bg-transparent px-3 py-2">
            </label>

            <label class="block">
              <span class="text-sm">Isi</span>
              <textarea name="content" rows="4" required class="mt-1 w-full rounded-xl border border-[var(--border)] bg-transparent px-3 py-2"></textarea>
            </label>

            <div class="grid grid-cols-2 gap-3">
              <label class="block">
                <span class="text-sm">Email (opsional)</span>
                <input type="email" name="contact_email" class="mt-1 w-full rounded-xl border border-[var(--border)] bg-transparent px-3 py-2">
              </label>
              <label class="block">
                <span class="text-sm">No HP (opsional)</span>
                <input name="contact_phone" class="mt-1 w-full rounded-xl border border-[var(--border)] bg-transparent px-3 py-2">
              </label>
            </div>

            <label class="block">
              <span class="text-sm">Lampiran (jpg/png/pdf, maks 2MB)</span>
              <input type="file" name="attachments[]" multiple class="mt-1 block w-full">
            </label>

            <button class="inline-flex items-center rounded-xl px-4 py-2 text-white bg-gradient-to-r from-[#8E44AD] to-[#C850C0] hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-[#C850C0]/40">
              Kirim
            </button>
          </form>
        </div>
      </aside>
    </section>
  </article>
@endsection
```
````

````markdown
**FILE:** resources/views/thanks.blade.php
```blade
@extends('layouts.app')

@section('content')
  <div class="text-center space-y-4">
    <h1 class="font-[Poppins] text-3xl font-bold">Terima kasih!</h1>
    <p class="opacity-90">Umpan balik Anda telah kami terima.</p>
    <x-ui.button :href="route('destinations.index')">Kembali ke Destinations</x-ui.button>
  </div>
@endsection
```
````

**Hasil yang diharapkan:** UI publik tampil rapi, tema dark/light bisa toggle, form submit berjalan.

---

### **Langkah 6/9 – Filament FeedbackResource & Policies (RBAC sederhana)**
Ringkasan: Tambah Policy berbasis `users.role`, buat Resource untuk kelola Feedback (filter, badge status, aksi ubah status).

```bash
php artisan make:policy DestinationPolicy --model=Destination
php artisan make:policy CategoryPolicy --model=Category
php artisan make:policy FeedbackPolicy --model=Feedback
php artisan make:filament-resource Feedback
```

**Daftar File:**
- `app/Policies/*Policy.php` (baru)
- `app/Filament/Resources/FeedbackResource.php` (baru)
- `app/Filament/Resources/FeedbackResource/Pages/*` (baru)
- `app/Providers/AuthServiceProvider.php` (ubah)

````markdown
**FILE:** app/Policies/FeedbackPolicy.php
```php
<?php

namespace App\Policies;

use App\Models\Feedback;
use App\Models\User;

class FeedbackPolicy
{
    public function viewAny(User $user): bool { return $user->role === 'admin'; }
    public function view(User $user, Feedback $fb): bool { return $user->role === 'admin'; }
    public function create(User $user): bool { return $user->role === 'admin'; }
    public function update(User $user, Feedback $fb): bool { return $user->role === 'admin'; }
    public function delete(User $user, Feedback $fb): bool { return $user->role === 'admin'; }
}
```
````

````markdown
**FILE:** app/Policies/DestinationPolicy.php
```php
<?php

namespace App\Policies;

use App\Models\Destination;
use App\Models\User;

class DestinationPolicy
{
    public function viewAny(User $user): bool { return $user->role === 'admin'; }
    public function view(User $user, Destination $d): bool { return $user->role === 'admin'; }
    public function create(User $user): bool { return $user->role === 'admin'; }
    public function update(User $user, Destination $d): bool { return $user->role === 'admin'; }
    public function delete(User $user, Destination $d): bool { return $user->role === 'admin'; }
}
```
````

````markdown
**FILE:** app/Policies/CategoryPolicy.php
```php
<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function viewAny(User $user): bool { return $user->role === 'admin'; }
    public function view(User $user, Category $c): bool { return $user->role === 'admin'; }
    public function create(User $user): bool { return $user->role === 'admin'; }
    public function update(User $user, Category $c): bool { return $user->role === 'admin'; }
    public function delete(User $user, Category $c): bool { return $user->role === 'admin'; }
}
```
````

````markdown
**FILE:** app/Providers/AuthServiceProvider.php  (potongan)
```php
<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Laravel auto-discovers with convention if using correct namespace.
    ];

    public function boot(): void
    {
        //
    }
}
```
````

````markdown
**FILE:** app/Filament/Resources/FeedbackResource.php
```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedbackResource\Pages;
use App\Models\Feedback;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Feedback';
    protected static ?string $pluralLabel = 'Feedback';
    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('destination_id')->relationship('destination','name')->required()->searchable(),
            Forms\Components\Select::make('category')->options([
                'keluhan'=>'Keluhan','saran'=>'Saran','apresiasi'=>'Apresiasi'
            ])->required(),
            Forms\Components\TextInput::make('rating')->numeric()->minValue(1)->maxValue(5),
            Forms\Components\TextInput::make('title')->required()->maxLength(150),
            Forms\Components\Textarea::make('content')->rows(4)->required(),
            Forms\Components\FileUpload::make('attachments')
                ->multiple()->directory('feedbacks/'.date('Y/m'))->visibility('public'),
            Forms\Components\Select::make('status')->options([
                'baru'=>'Baru','diproses'=>'Diproses','selesai'=>'Selesai','ditolak'=>'Ditolak'
            ])->required()->default('baru'),
            Forms\Components\TextInput::make('contact_email')->email(),
            Forms\Components\TextInput::make('contact_phone'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('destination.name')->label('Destinasi')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category')->badge()->color(fn($state)=>match($state){
                    'keluhan'=>'danger','saran'=>'warning','apresiasi'=>'success', default=>'gray'
                }),
                Tables\Columns\TextColumn::make('rating')->sortable(),
                Tables\Columns\TextColumn::make('title')->wrap()->limit(40)->searchable(),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn($state)=>match($state){
                    'baru'=>'info','diproses'=>'warning','selesai'=>'success','ditolak'=>'danger', default=>'gray'
                })->sortable(),
                Tables\Columns\TextColumn::make('submitted_at')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'baru'=>'Baru','diproses'=>'Diproses','selesai'=>'Selesai','ditolak'=>'Ditolak'
                ]),
                SelectFilter::make('category')->options([
                    'keluhan'=>'Keluhan','saran'=>'Saran','apresiasi'=>'Apresiasi'
                ]),
            ])
            ->actions([
                Action::make('to_diproses')->label('Set Diproses')->action(fn(Feedback $r)=>$r->update(['status'=>'diproses']));
                Action::make('to_selesai')->label('Set Selesai')->color('success')->action(fn(Feedback $r)=>$r->update(['status'=>'selesai']));
                Action::make('to_ditolak')->label('Set Ditolak')->color('danger')->action(fn(Feedback $r)=>$r->update(['status'=>'ditolak']));
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('set_selesai')
                    ->label('Set Selesai (Bulk)')->color('success')
                    ->action(fn($records)=>$records->each->update(['status'=>'selesai'])),
                Tables\Actions\BulkAction::make('export_csv')
                    ->label('Export CSV')->action(function($records){
                        $csv = "destination,category,rating,title,status,submitted_at\n";
                        foreach ($records as $r){
                            $csv .= sprintf(
                                "\"%s\",%s,%s,\"%s\",%s,%s\n",
                                $r->destination?->name, $r->category, $r->rating ?? '',
                                str_replace('"','""',$r->title), $r->status, $r->submitted_at
                            );
                        }
                        $name = 'feedback-export-'.now()->format('Ymd-His').'.csv';
                        \Storage::disk('public')->put($name, $csv);
                        return \Filament\Notifications\Notification::make()
                            ->title('CSV diekspor')
                            ->body('Lihat di storage/public/'.$name)->success()->send();
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeedback::route('/'),
            'create' => Pages\CreateFeedback::route('/create'),
            'edit' => Pages\EditFeedback::route('/{record}/edit'),
        ];
    }
}
```
````

> **Catatan:** Di Filament v4, pastikan namespace resource/halaman sesuai struktur default generator.

**Hasil yang diharapkan:** Admin (`role=admin`) dapat melihat & mengelola feedback, mengubah status, dan ekspor CSV.

---

### **Langkah 7/9 – Dashboard Filament (Widgets & Grafik)**
Ringkasan: Tambah dashboard custom: metrik ringkas & grafik waktu.

```bash
php artisan make:filament-widget FeedbackStats
php artisan make:filament-widget FeedbackTrends
```

**Daftar File:**
- `app/Filament/Widgets/FeedbackStats.php` (baru)
- `app/Filament/Widgets/FeedbackTrends.php` (baru)

````markdown
**FILE:** app/Filament/Widgets/FeedbackStats.php
```php
<?php

namespace App\Filament\Widgets;

use App\Models\Feedback;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class FeedbackStats extends BaseWidget
{
    protected function getCards(): array
    {
        $total = Feedback::count();
        $avg = round(Feedback::whereNotNull('rating')->avg('rating'), 2);
        $baru = Feedback::where('status','baru')->count();

        return [
            Card::make('Total Feedback', (string) $total),
            Card::make('Rata-Rata Rating', (string) $avg),
            Card::make('Baru', (string) $baru),
        ];
    }
}
```
````

````markdown
**FILE:** app/Filament/Widgets/FeedbackTrends.php
```php
<?php

namespace App\Filament\Widgets;

use App\Models\Feedback;
use Filament\Widgets\LineChartWidget;

class FeedbackTrends extends LineChartWidget
{
    protected static ?string $heading = 'Feedback (12 minggu)';

    protected function getData(): array
    {
        $labels = [];
        $series = [];

        for ($i=11; $i>=0; $i--) {
            $start = now()->startOfWeek()->subWeeks($i);
            $end = now()->startOfWeek()->subWeeks($i-1);
            $count = Feedback::whereBetween('submitted_at', [$start, $end])->count();
            $labels[] = $start->format('d M');
            $series[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Feedback',
                    'data' => $series,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
```
````

**Hasil yang diharapkan:** Dashboard menampilkan angka ringkas & tren mingguan.

---

### **Langkah 8/9 – Upload Lampiran & Ekspor CSV**
Ringkasan: Upload sudah di Langkah 4 & 6. Pastikan `php artisan storage:link` dan folder publik tersedia. Ekspor CSV via bulk action sudah ada.

```bash
php artisan storage:link
```

**Catatan:** Lampiran disimpan ke `public/feedbacks/Y/m`. Tautan akses via `Storage::url()`.

**Hasil yang diharapkan:** Admin bisa mengunduh CSV hasil filter & lampiran tersaji publik (opsional).

---

### **Langkah 9/9 – Testing + Pint + README**
Ringkasan: Tambahkan uji minimum & format kode.

```bash
composer require pestphp/pest --dev laravel/pint --dev
php artisan pest:install
./vendor/bin/pint
php artisan test
```

**Daftar File:**
- `tests/Feature/FeedbackSubmitTest.php` (baru)
- `tests/Feature/FilamentAccessTest.php` (baru)
- `README.md` (ubah / tambah instruksi cepat)

````markdown
**FILE:** tests/Feature/FeedbackSubmitTest.php
```php
<?php

use App\Models\Destination;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can submit feedback', function () {
    Storage::fake('public');
    $dest = Destination::factory()->create(['is_active'=>true]);

    $res = $this->post('/feedbacks', [
        'destination_id' => $dest->id,
        'category' => 'apresiasi',
        'rating' => 5,
        'title' => 'Mantap',
        'content' => 'Sangat bagus',
        'attachments' => [UploadedFile::fake()->image('a.jpg')],
    ]);

    $res->assertRedirect('/thanks');
});
```
````

````markdown
**FILE:** tests/Feature/FilamentAccessTest.php
```php
<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('blocks non-admin to filament panel', function () {
    $user = User::factory()->create(['role'=>'user']);
    $this->actingAs($user);
    $this->get('/admin')->assertStatus(403);
});

it('allows admin to filament panel', function () {
    $admin = User::factory()->create(['role'=>'admin']);
    $this->actingAs($admin);
    $this->get('/admin')->assertStatus(200);
});
```
````

**Hasil yang diharapkan:** Test minimal lulus, Pint merapikan kode.

---

## 7) Konfigurasi Tambahan & Tips
- **ENV:**
  ```dotenv
  FEEDBACK_RATE_LIMIT=5
  ```
- **Storage:** Jalankan `php artisan storage:link` agar URL lampiran bisa diakses.  
- **Auth Filament:** Pakai guard & login bawaan Filament. Batasi akses resource via Policy & `role=admin`.  
- **Akses Panel:** `/admin`.  
- **Akses Publik:** `/`, `/destinations`, `/destinations/{slug}`, POST `/feedbacks`, `/thanks`.

---

## 8) Definisi Selesai (DoD)
- Form umpan balik publik berfungsi & tervalidasi (upload opsional).  
- Panel admin Filament dengan **FeedbackResource** + aksi status + ekspor CSV.  
- Dashboard admin (stats & tren).  
- UI publik tema “CrystalDB” dark/light responsif.  
- Tests & Pint berjalan.

---

## 9) Output yang Diharapkan dari Kamu (Coding Agent)
Ketika menjalankan langkah-langkah di atas, **kirim setiap langkah** dalam format bagian **2)** dengan **isi file lengkap** yang berubah/dibuat. Prioritaskan Langkah **3 s/d 9** karena 1–2 sudah kamu selesaikan sebelumnya.
