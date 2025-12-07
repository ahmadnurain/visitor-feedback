<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter; // ⬅️ tambahkan ini

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'address',
        'latitude',
        'longitude',
        'banner_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['cover_url'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    /** URL gambar siap pakai untuk <img> */
    public function getCoverUrlAttribute(): ?string
    {
        $path = $this->banner_path;
        if (!$path) {
            return null;
        }

        // Jika sudah URL absolut, langsung pakai
        if (preg_match('~^https?://~i', $path)) {
            return $path;
        }

        /** @var FilesystemAdapter $disk */      // ⬅️ bantu IDE paham tipenya
        $disk = Storage::disk('public');

        // Jika file ada di disk 'public', pakai URL disk (contoh: /storage/...)
        if ($disk->exists($path)) {
            return $disk->url($path);
        }

        // Fallback: jika bukan di disk 'public', coba relative ke public/
        // (pastikan sudah jalankan `php artisan storage:link` untuk /storage)
        return asset(ltrim($path, '/')) ?: null;
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }
}
