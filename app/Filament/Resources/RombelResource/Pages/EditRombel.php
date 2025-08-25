<?php

namespace App\Filament\Resources\RombelResource\Pages;

use App\Filament\Resources\RombelResource;
use App\Models\WaliKelas;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class EditRombel extends EditRecord
{
    protected static string $resource = RombelResource::class;

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
            $wk = Walikelas::where('tahun_akademik_id', $data['tahun_akademik_id'])
                ->where('kelas_id', $data['kelas_id'])
                ->first();

            if (!$wk) {
                throw ValidationException::withMessages(['err' => 'Wali Kelas belum ditentukan']);
            }

            $data['wali_kelas_id'] = $wk->id;
            return parent::handleRecordUpdate($record, $data);
        } catch (QueryException $e) {
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] === 1062) {
                Notification::make()
                    ->title('Duplikasi Data')
                    ->body('Siswa sudah terdaftar pada rombongan belajar tertentu')
                    ->danger()
                    ->send();

                throw ValidationException::withMessages([
                    'err' => 'Siswa sudah terdaftar pada rombongan belajar tertentu',
                ]);
            }

            throw $e;
        } catch (ValidationException $e) {
            Notification::make()
                ->title('Gagal menyimpan data')
                ->body($e->getMessage())
                ->danger()
                ->send();
            throw $e;
        }
    }
}
