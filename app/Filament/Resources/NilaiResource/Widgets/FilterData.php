<?php

namespace App\Filament\Resources\NilaiResource\Widgets;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAkademik;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;

class FilterData extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.resources.nilai-resource.widgets.filter-data';

    protected int|string|array $columnSpan = 'full';
    public ?array $filterData = [];

    public function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Select::make('tahun_akademik_id')
                    ->label('Tahun Akademik')
                    ->options(TahunAkademik::all()
                        ->where('is_active', 1)
                        ->pluck('tahun_akademik_semester', 'id'))
                    ->required()
                    ->validationMessages([
                        'required' => 'Tahun Akademik tidak boleh kosong',
                    ]),

                Hidden::make('semester'),

                Forms\Components\Select::make('kelas_id')
                    ->label('Kelas')
                    ->options(Kelas::all()
                        ->pluck('kode_nama_kelas', 'id'))
                    ->required()
                    ->validationMessages([
                        'required' => 'Kelas tidak boleh kosong',
                    ]),

                Forms\Components\Select::make('mapel_id')
                    ->label('Mata Pelajaran')
                    ->options(MataPelajaran::pluck('nama_mapel', 'id'))
                    ->required()
                    ->validationMessages([
                        'required' => 'Mata Pelajaran tidak boleh kosong',
                    ]),

                Forms\Components\Actions::make([
                    Forms\Components\Actions\Action::make('apply')
                        ->label('Tampilkan Data')
                        ->action(fn() => $this->applyFilter())
                ])
                    ->columnSpanFull()
                    ->alignEnd(),
            ])
            ->statePath('filterData');
    }

    public function applyFilter(): void
    {
        $state = $this->form->getState();
        $this->dispatch('filter-updated', $state);

        Notification::make()
            ->title('Filter successfully applied')
            ->success()
            ->send();
    }
}
