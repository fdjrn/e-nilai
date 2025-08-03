<?php

namespace App\Filament\Resources\TahunAkademikResource\Pages;

use App\Filament\Resources\TahunAkademikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTahunAkademiks extends ListRecords
{
    protected static string $resource = TahunAkademikResource::class;
    protected ?string $heading = 'List of Tahun Akademik';
    protected static ?string $title = 'Data Tahun Akademik';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Tahun Akademik'),
        ];
    }
}
