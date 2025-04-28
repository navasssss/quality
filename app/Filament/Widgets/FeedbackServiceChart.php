<?php

namespace App\Filament\Widgets;

use App\Models\Feedback;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class FeedbackServiceChart extends ChartWidget
{
    protected static ?string $heading = 'Feedback by service type';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '232px';
    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $statuses = Feedback::service_type();
        $query = Feedback::query();

        // Apply date range based on selected filter
        if ($activeFilter) {
            switch ($activeFilter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', Carbon::now()->month);
                    break;
                case 'year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }

        // Get counts per status
        $statusCounts = $query->select('service_type', \DB::raw('count(*) as count'))
            ->groupBy('service_type')
            ->pluck('count', 'service_type')
            ->toArray();

        // Ensure all statuses are included, even with 0
        $data = [];
        foreach ($statuses as $key => $label) {
            $data[] = $statusCounts[$key] ?? 0;
        }

        return [
            'labels' => array_values($statuses),
            'datasets' => [
                [
                    'label' => 'Feedback by Service Type',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',    // Testing
                        'rgb(54, 162, 235)',    // Calibration
                        'rgb(255, 205, 86)',    // Inspection
                        'rgb(75, 192, 192)',    // Other
                    ],
                    'hoverOffset' => 4
                ],
            ],
        ];
    }
    protected function getFilters(): ?array
    {
        return [
            '' => 'All',
            'month' => 'Last month',
            'today' => 'Today',
            'week' => 'Last week',
            'year' => 'This year',
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
