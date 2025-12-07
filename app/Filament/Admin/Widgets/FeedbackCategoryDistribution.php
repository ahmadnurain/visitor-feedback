<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Feedback;
use Filament\Widgets\ChartWidget;

class FeedbackCategoryDistribution extends ChartWidget
{
    // Di Filament 4: heading NON-static
    protected static ?int $sort = 4;

    protected ?string $heading = 'Feedback by Category';

    /**
     * Jenis chart yang dipakai (Chart.js)
     */
    protected function getType(): string
    {
        return 'bar'; // atau 'line' kalau mau garis
    }

    protected function getData(): array
    {
        $data = Feedback::query()
            ->with('category') // pastikan relasi di model Feedback: category()
            ->selectRaw('feedback_category_id, COUNT(*) as count')
            ->groupBy('feedback_category_id')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Feedback',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => [
                        '#f87171',
                        '#fbbf24',
                        '#34d399',
                        '#60a5fa',
                        '#a78bfa',
                    ],
                ],
            ],
            'labels' => $data
                ->map(fn($item) => $item->category->name ?? 'Uncategorized')
                ->toArray(),
        ];
    }
}
