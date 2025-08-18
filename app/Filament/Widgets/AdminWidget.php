<?php

namespace App\Filament\Widgets;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminWidget extends BaseWidget
{
    protected function getCards(): array
    {

        return [
            Stat::make('Jumlah Guru', Guru::count())
                ->description('Total guru yang terdaftar')
                ->icon('heroicon-o-user')
                ->color('success'),

            Stat::make('Jumlah Siswa', Siswa::where('status','Active')->count())
                ->description('Total siswa aktif')
                ->icon('heroicon-o-user-group')
                ->color('success'),

            Stat::make('Jumlah Kelas', Kelas::count())
                ->description('Total Kelas')
                ->chart([])
                ->icon('heroicon-o-building-library')
                ->color('success'),
        ];
    }
}
