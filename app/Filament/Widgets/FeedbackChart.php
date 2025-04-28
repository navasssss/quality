<?php

namespace App\Filament\Widgets;

use App\Models\Feedback;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Carbon\Carbon;
class FeedbackChart extends ChartWidget
{
    protected static ?string $heading = 'Satisfaction trends';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $maxHeight = '300px';
    protected static ?string $minHeight = '300px';
    protected function getData(): array
    {
        $data = Trend::model(Feedback::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->average('satisfaction_rating');
        return [
            'datasets' => [
                [
                    'label' => 'Satisfaction Rating',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],


            'labels' => $data->map(fn(TrendValue $value) => Carbon::parse($value->date)->format('M')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
