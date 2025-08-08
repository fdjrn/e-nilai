<?php

namespace App\Filament\Resources\WaliKelasResource\Pages;

use App\Filament\Resources\WaliKelasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWaliKelas extends ListRecords
{
    protected static string $resource = WaliKelasResource::class;
    protected ?string $heading = 'List of Wali Kelas';
    protected static ?string $title = 'Data Wali Kelas';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Data Wali Kelas'),
        ];
    }
}
