<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSiswas extends ListRecords
{
    protected static string $resource = SiswaResource::class;
    protected ?string $heading = 'List of Siswa';
    protected static ?string $title = 'Data Siswa';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Data Siswa'),
        ];
    }
}
