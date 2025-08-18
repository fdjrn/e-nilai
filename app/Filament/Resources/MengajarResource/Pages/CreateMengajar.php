<?php

namespace App\Filament\Resources\MengajarResource\Pages;

use App\Filament\Resources\MengajarResource;
use App\Models\Mengajar;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

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
            return Mengajar::create($data);
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
