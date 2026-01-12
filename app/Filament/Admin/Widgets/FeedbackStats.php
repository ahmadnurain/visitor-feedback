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
        $stats = Feedback::query()
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as baru,
                SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) as diproses,
                SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as selesai,
                AVG(rating) as avg_rating
            ")
            ->first();

        $total = $stats->total ?? 0;
        $baru = $stats->baru ?? 0;
        $diproses = $stats->diproses ?? 0;
        $selesai = $stats->selesai ?? 0;
        $avgRating = round((float) ($stats->avg_rating ?? 0), 2);

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
                ->description('Masukan diselesaikan')
                ->color('success')
                ->icon('heroicon-o-check-badge'),

            Stat::make('Rata-rata Rating', $avgRating > 0 ? (string) $avgRating : 'N/A')
                ->description('Dari penilaian publik')
                ->color('info')
                ->icon('heroicon-o-star'),
        ];
    }
}
