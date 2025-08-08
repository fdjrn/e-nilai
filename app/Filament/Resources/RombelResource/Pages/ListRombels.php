<?php

namespace App\Filament\Resources\RombelResource\Pages;

use App\Filament\Resources\RombelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRombels extends ListRecords
{
    protected static string $resource = RombelResource::class;

    protected ?string $heading = 'List of Rombel';
    protected static ?string $title = 'Data Rombel';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Data Rombel'),
        ];
    }
}
