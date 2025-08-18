<?php

namespace App\Filament\Resources\MengajarResource\Pages;

use App\Filament\Resources\MengajarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMengajar extends ListRecords
{
    protected static string $resource = MengajarResource::class;
    protected ?string $heading = 'List of Mengajar';
    protected static ?string $title = 'Data Mengajar';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Data Mengajar'),
        ];
    }
}
