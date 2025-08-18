<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Filament\Resources\KelasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKelas extends ListRecords
{
    protected static string $resource = KelasResource::class;
    protected ?string $heading = 'List of Kelas';
    protected static ?string $title = 'Data Kelas';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Data Kelas'),
        ];
    }
}
