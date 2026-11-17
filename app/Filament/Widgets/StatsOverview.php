<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\User;
use App\Models\Verification;
use App\Models\Report;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $paidRevenue = \App\Models\Payment::where('status', 'Paid')->sum('amount');

        return [
            Stat::make('Total Users', User::count())
                ->description('Total registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
            Stat::make('Active Users', User::where('is_active', true)->count())
                ->description('Active user accounts')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
            Stat::make('Total Revenue', '₹' . number_format($paidRevenue, 2))
                ->description('Paid transactions')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
            Stat::make('Pending Verifications', Verification::where('status', 'Pending')->count())
                ->description('Awaiting document review')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('warning'),
            Stat::make('Pending Reports', Report::where('status', 'Pending')->count())
                ->description('Unresolved safety complaints')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }
}
