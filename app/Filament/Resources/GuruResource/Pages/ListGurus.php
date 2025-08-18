<?php

namespace App\Filament\Resources\GuruResource\Pages;

use App\Filament\Resources\GuruResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGurus extends ListRecords
{
    protected static string $resource = GuruResource::class;
    protected ?string $heading = 'List of Guru';
    protected static ?string $title = 'Data Guru';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Data Guru'),
        ];
    }
}
