<?php

namespace App\Filament\Widgets;

use App\Models\Feedback;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;

class FeedbackStatss extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {

        $positiveFeedbackCount = Feedback::whereBetween('satisfaction_rating', [4, 5])->count();
        $neutralFeedbackCount = Feedback::where('satisfaction_rating', 3)->count();
        $negativeFeedbackCount = Feedback::whereBetween('satisfaction_rating', [1, 2])->count();


        $rawCounts = Feedback::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('count', 'month')
            ->toArray();

        // Merge with all months, keeping DB data
        $allMonths = array_fill(1, 12, 0);
        $feedbackCounts = $rawCounts + $allMonths;
        ksort($feedbackCounts); // Make sure it's sorted by month

        // Build the string
        $monthNames = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
        $currentMonthNumber = now()->month;
        $currentMonthCount = $feedbackCounts[$currentMonthNumber] ?? 0;
        $lastMonthCount = $feedbackCounts[$currentMonthNumber - 1] ?? 0;
        if ($currentMonthCount > $lastMonthCount) {
            $description = 'Increased to ' . $currentMonthCount . ' this month (' . $monthNames[$currentMonthNumber] . ') from ' . $lastMonthCount . ' last month (' . $monthNames[$currentMonthNumber - 1] . ')';
            $color = 'success';
        } elseif ($currentMonthCount < $lastMonthCount) {
            $description = 'Decreased to ' . $currentMonthCount . ' this month (' . $monthNames[$currentMonthNumber] . ') from ' . $lastMonthCount . ' last month (' . $monthNames[$currentMonthNumber - 1] . ')';
            $color = 'danger';
        } else {
            $description = 'No change: ' . $currentMonthCount . ' feedbacks in both ' . $monthNames[$currentMonthNumber - 1] . ' and ' . $monthNames[$currentMonthNumber];
            $color = 'warning';
        }

        $data = Trend::model(Feedback::class)
            ->between(
                start: now()->startOfYear(),
                end: now(),
            )
            ->perMonth()
            ->count();


        return [
            Stat::make('Total Feedbacks', array_sum($feedbackCounts))  // total feedbacks as the sum of counts
                ->description($description)
                ->color($color)
                ->chart(
                    $data->map(fn(TrendValue $value) => $value->aggregate)->toArray()
                ),


            // ->chart(
            //     array_slice(array_values($feedbackCounts), 0, $currentMonthNumber)
            // ),
            // Stat::make('Positive Feedback', $currentMonth),
            Stat::make('Positive Feedback', $positiveFeedbackCount),
            Stat::make('Nuetral Feedback', $neutralFeedbackCount),
            Stat::make('Negative Feedback', $negativeFeedbackCount),
        ];
    }
    protected function getViewData(): array
    {
        // You can add custom grid classes here
        return [
            'gridClass' => 'grid grid-cols-4 gap-4',  // Adjust the grid as needed
        ];
    }
}
