<?php

namespace App\Filament\Resources\MengajarResource\Pages;

use Filament\Actions;
use Illuminate\Database\QueryException;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\MengajarResource;
use Illuminate\Database\Eloquent\Model;

class EditMengajar extends EditRecord
{
    protected static string $resource = MengajarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            return parent::handleRecordUpdate($record, $data);
        } catch (QueryException $e) {
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] === 1062) {
                Notification::make()
                    ->title('Duplikat Penugasan')
                    ->body('Kombinasi guru, mata pelajaran, kelas, tahun akademik, dan semester sudah ada.')
                    ->danger()
                    ->send();

                // kembalikan record asal tanpa perubahan supaya form tetap terbuka
                return $record;
            }

            throw $e;
        }
    }
}
