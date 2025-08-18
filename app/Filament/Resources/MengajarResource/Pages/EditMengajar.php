<?php

namespace App\Filament\Resources\MengajarResource\Pages;

use Filament\Actions;
use Illuminate\Database\QueryException;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\MengajarResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

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
                    ->title('Duplikasi Data')
                    ->body('Kombinasi Mata Pelajaran, Kelas, Tahun Akademik, dan Semester sudah dibuat.')
                    ->danger()
                    ->send();

                throw ValidationException::withMessages([
                    'err' => 'Kombinasi tersebut sudah ada.',
                ]);
            }

            throw $e;
        }
    }
}
