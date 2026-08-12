<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'Monthly Revenue Analytics';

    protected function getData(): array
    {
        $data = [];
        $months = [];

        for ($m = 1; $m <= 12; $m++) {
            $date = \Carbon\Carbon::create(date('Y'), $m, 1);
            $months[] = $date->format('M');
            $data[] = \App\Models\Payment::where('status', 'Paid')
                ->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', $m)
                ->sum('amount');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue ($)',
                    'data' => $data,
                    'backgroundColor' => '#fc144c', // Matching new primary color #fc144c
                    'borderColor' => '#fc144c',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
