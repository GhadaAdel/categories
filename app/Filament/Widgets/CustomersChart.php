<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Flowframe\Trend\Trend;
use Illuminate\Support\Carbon;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class CustomersChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Customers Chart';
    protected int|string|array $columnSpan = 'full';
    protected static ?string $maxHeight = '400px';

    protected function getData(): array
    {
        $startDate = $this->filters['start_date'] ?? null;
        $activeFilter = $this->filter;

        if ($startDate) {
            $startDate = Carbon::parse($this->filters['start_date'])->startOfDay();
            $endDate = Carbon::parse($this->filters['end_date'])->endOfDay();
        } else {
            $startDate = $this->filterValues($activeFilter)['start'];
            $endDate = $this->filterValues($activeFilter)['end'];
        }

        $trend = Trend::model(User::class)
            ->between(
                start: $startDate,
                end: $endDate,
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'New Customers',
                    'data' => $trend->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => $this->getAllColors(count($trend)),
                    'fill' => false,
                ],
            ],
            'labels' => $trend->map(fn(TrendValue $value) => Carbon::parse($value->date)->format('Y-m-d')),
        ];
    }

    private function filterValues($filterValue)
    {
        return match ($filterValue) {
            'today' => ['start' => now()->startOfDay(), 'end' => now()->endOfDay()],
            'week' => ['start' => now()->subWeeks()->startOfDay(), 'end' => now()->endOfDay()],
            'month' => ['start' => now()->subMonth()->startOfDay(), 'end' => now()->endOfDay()],
            'year' => ['start' => now()->subYear()->startOfDay(), 'end' => now()->endOfDay()],
            default => ['start' => now()->subWeek()->startOfDay(), 'end' => now()->endOfDay()],
        };
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year'
        ];
    }

    private function getAllColors(int $count): array
    {
        $baseColors = [
            '#AEC6CF', 
            '#FFB3BA', 
            '#FFDAC1',
            '#BFD8B8',
            '#CBAACB',
            '#FFFFD1',
            '#D6EADF',
            '#E2F0CB',
            '#F1CBFF',
            '#D0E1F9',
            '#FEE1E8'
        ];

        return array_slice(
            array_merge(...array_fill(0, ceil($count / count($baseColors)), $baseColors)),
            0,
            $count
        );
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
