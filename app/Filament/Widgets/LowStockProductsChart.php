<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\ChartWidget;

class LowStockProductsChart extends ChartWidget
{
    protected static ?string $heading = 'Low Stock Products Chart';
    protected int|string|array $columnSpan = 'full';
    protected static ?string $maxHeight = '400px';

    protected function getData(): array
    {
        $lowStock = Product::where('stock', '<=', '10');

        return [
            'datasets' => [
                [
                    'label' => 'Low Stock',
                    'data' => $lowStock->pluck('stock')->toArray(),
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
            'labels' => $lowStock->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
