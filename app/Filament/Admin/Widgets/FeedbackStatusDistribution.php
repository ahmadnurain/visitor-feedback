<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Feedback;
use Filament\Widgets\ChartWidget;

class FeedbackStatusDistribution extends ChartWidget
{
    // HAPUS "static" DI SINI
    protected static ?int $sort = 3;

    protected ?string $heading = 'Feedback by Status';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $data = Feedback::query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Status',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => [
                        '#9ca3af', // new - gray
                        '#fbbf24', // processing - warning
                        '#34d399', // resolved - success
                        '#f87171', // ignored - danger
                    ],
                ],
            ],
            'labels' => $data
                ->pluck('status')
                ->map(fn($status) => ucfirst($status))
                ->toArray(),
        ];
    }
}
