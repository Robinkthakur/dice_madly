<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class UsersChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'User Registration Growth';

    // protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = [];
        $months = [];

        for ($m = 1; $m <= 12; $m++) {
            $date = \Carbon\Carbon::create(date('Y'), $m, 1);
            $months[] = $date->format('M');
            $data[] = \App\Models\User::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', $m)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'New Registrations',
                    'data' => $data,
                    'borderColor' => '#e11d48',
                    'backgroundColor' => 'rgba(225, 29, 72, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
