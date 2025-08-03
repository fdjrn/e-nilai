<?php

namespace App\Filament\Resources\MengajarResource\Pages;

use App\Filament\Resources\MengajarResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class CreateMengajar extends CreateRecord
{
    protected static string $resource = MengajarResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

      protected function handleRecordCreation(array $data): Model
    {
        try {
            return parent::handleRecordCreation($data);
        } catch (QueryException $e) {
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] === 1062) {
                Notification::make()
                    ->title('Duplikat Penugasan')
                    ->body('Kombinasi guru, mata pelajaran, kelas, tahun akademik, dan semester sudah pernah dibuat.')
                    ->danger()
                    ->send();

                // Kembalikan instance kosong atau baru untuk mencegah crash;
                // parent gagal, jadi buat model manual supaya form tetap di layar
                return $this->getRecord();
            }

            throw $e;
        }
    }
}
