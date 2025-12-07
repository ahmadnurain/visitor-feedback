<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use App\Models\FeedbackCategory;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        // Ambil query string yang bersih
        $q = trim((string) $request->query('q', ''));
        $kategoriSlug = trim((string) $request->query('kategori', ''));

        // Backward-compat: jika masih ada ?category=ID, redirect ke ?kategori=slug (URL lebih bersih)
        if (!$kategoriSlug && $request->filled('category')) {
            $legacyId = $request->query('category');
            $cat = Category::find($legacyId);

            // Susun ulang query yang rapi (tanpa parameter kosong)
            $params = array_filter([
                'q'        => $q ?: null,
                'kategori' => $cat?->slug,
            ], fn($v) => filled($v));

            return redirect()->route('destinations.index', $params);
        }

        // Ambil semua kategori untuk dropdown
        $categories = Category::orderBy('name')->get();

        // Temukan kategori dari slug (kalau ada)
        $category = $kategoriSlug
            ? $categories->firstWhere('slug', $kategoriSlug)
            : null;

        // Base query destinasi aktif
        $base = Destination::query()->where('is_active', true);

        // Pencarian: nama / alamat
        if ($q !== '') {
            $base->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('address', 'like', "%{$q}%");
            });
        }

        // Filter kategori (jika slug valid)
        if ($category) {
            $base->where('category_id', $category->id);
        }

        // Paginate + pertahankan hanya param yang penting (q & kategori)
        $destinations = $base->latest('id')->paginate(12)->appends(array_filter([
            'q'        => $q ?: null,
            'kategori' => $kategoriSlug ?: null,
        ], fn($v) => filled($v)));

        return view('destinations.index', [
            'destinations' => $destinations,
            'categories'   => $categories,
            'q'            => $q,
            'kategori'     => $kategoriSlug,
        ]);
    }

    public function show(string $slug)
    {
        $destination = Destination::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $feedbackCategories = FeedbackCategory::where('is_active', true)->orderBy('name')->get();

        return view('destinations.show', compact('destination', 'feedbackCategories'));
    }
}
