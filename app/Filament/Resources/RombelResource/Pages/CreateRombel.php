<?php

namespace App\Filament\Resources\RombelResource\Pages;

use App\Filament\Resources\RombelResource;
use App\Models\Rombel;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class CreateRombel extends CreateRecord
{
    protected static string $resource = RombelResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        try {
            return Rombel::create($data);
        } catch (QueryException $e) {
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] === 1062) {
                Notification::make()
                    ->title('Duplikasi Data')
                    ->body('Siswa sudah terdaftar pada Rombongan Belajar yang dipilih.')
                    ->danger()
                    ->send();

                throw ValidationException::withMessages([
                    'err' => 'Siswa sudah terdaftar pada Rombongan Belajar yang dipilih.',
                ]);
            }

            throw $e;
        }
    }

}
