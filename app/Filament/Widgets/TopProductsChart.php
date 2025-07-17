<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TopProductsChart extends ChartWidget
{
    protected static ?string $heading = 'Top Products Chart';
    protected int|string|array $columnSpan = 'full';
    protected static ?string $maxHeight = '400px';

    protected function getData(): array
    {
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total'))
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->with('product')
            ->take(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Units Sold',
                    'data' => $topProducts->pluck('total')->toArray(),
                    'backgroundColor' => [
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
                    ],
                ],
            ],
            'labels' => $topProducts->pluck('product.name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
