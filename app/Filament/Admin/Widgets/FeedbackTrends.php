<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Feedback;
use Filament\Widgets\LineChartWidget;

class FeedbackTrends extends LineChartWidget
{
    protected static ?int $sort = 5;

    protected ?string $heading = 'Feedback (12 minggu)';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $labels = [];
        $series = [];

        for ($i = 11; $i >= 0; $i--) {
            $start = now()->startOfWeek()->subWeeks($i);
            $end = now()->startOfWeek()->subWeeks($i - 1);
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
