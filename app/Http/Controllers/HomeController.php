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
            ->take(6)
            ->get();

        return view('home', compact('featured'));
    }
}

