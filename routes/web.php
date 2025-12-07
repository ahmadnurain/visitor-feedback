<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destinations.show');

// Submit feedback (rate-limited)
Route::middleware('throttle:feedback')->group(function () {
    Route::post('/feedbacks', [FeedbackController::class, 'store'])->name('feedbacks.store');
});

Route::view('/thanks', 'thanks')->name('thanks');
