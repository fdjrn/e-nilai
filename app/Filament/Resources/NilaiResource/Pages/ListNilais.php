<?php

namespace App\Filament\Resources\NilaiResource\Pages;

use App\Filament\Resources\NilaiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNilais extends ListRecords
{
    protected static string $resource = NilaiResource::class;
    protected ?string $heading = 'Nilai Siswa';
    protected static ?string $title = 'Nilai Siswa';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
