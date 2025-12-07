<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('feedback', function (Request $request) {
            $max     = (int) env('FEEDBACK_RATE_LIMIT', 5);   // attempts
            $minutes = (int) env('FEEDBACK_WINDOW_MIN', 1);   // window (menit)

            // Key unik: user_id kalau login, fallback IP + per-destination
            $userOrIp = optional($request->user())->id ?? $request->ip();
            $dest     = (string) $request->input('destination_id');
            $key      = "{$userOrIp}|dest:{$dest}";

            return Limit::perMinutes($minutes, $max)
                ->by($key)
                ->response(function (Request $request, array $headers) {
                    $retryAfter = $headers['Retry-After'] ?? 60;
                    $msg = "Terlalu banyak permintaan. Coba lagi dalam {$retryAfter} detik.";

                    if ($request->expectsJson()) {
                        return response()->json(['message' => $msg], 429, $headers);
                    }
                    return back()->withErrors(['too_many_requests' => $msg])->withInput();
                });
        });
    }
}
