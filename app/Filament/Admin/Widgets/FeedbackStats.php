<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Feedback;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FeedbackStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $total = Feedback::count();
        $baru = Feedback::where('status', 'new')->count();
        $diproses = Feedback::where('status', 'processing')->count();
        $selesai = Feedback::where('status', 'resolved')->count();
        $avgRating = round((float) Feedback::whereNotNull('rating')->avg('rating'), 2);

        return [
            Stat::make('Total Feedback', number_format($total))
                ->description('Semua masukan publik')
                ->color('primary')
                ->icon('heroicon-o-chat-bubble-left-right'),

            Stat::make('Baru / Diproses', $baru . ' / ' . $diproses)
                ->description('Antrian & progres')
                ->color('warning')
                ->icon('heroicon-o-queue-list'),

            Stat::make('Selesai', number_format($selesai))
                ->description('Tiket diselesaikan')
                ->color('success')
                ->icon('heroicon-o-check-badge'),

            Stat::make('Rata-rata Rating', $avgRating > 0 ? (string) $avgRating : 'N/A')
                ->description('Dari penilaian publik')
                ->color('info')
                ->icon('heroicon-o-star'),
        ];
    }
}
