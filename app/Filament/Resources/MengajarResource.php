<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use App\Models\Mengajar;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MengajarResource\Pages;
use App\Models\Kelas;
use App\Models\TahunAkademik;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use stdClass;

class MengajarResource extends Resource
{
    protected static ?string $model = Mengajar::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = "Mengajar";
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 1;
    protected static ?string $breadcrumb = "Mengajar";
    protected static ?string $slug = 'mengajar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('tahun_akademik_id')
                    ->label('Tahun Akademik')
                    ->relationship(
                        name: 'tahunAkademik',
                        titleAttribute: 'tahun_akademik',
                        modifyQueryUsing: fn($query) => $query
                        ->where('is_active', 1)
                        ->orderBy('tahun_akademik', 'asc')
                    )
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->tahun_akademik_semester}")
                    ->required()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $ta = \App\Models\TahunAkademik::find($state);
                        if ($ta) {
                            $set('semester', ucfirst($ta->semester)); // isi field semester di form
                        } else {
                            $set('semester', null);
                        }
                    })->columnSpanFull(),

                Hidden::make('semester'),

                Forms\Components\Select::make('guru_id')
                    ->label('Guru Pengajar')
                    ->relationship('guru', 'nama')
                    ->required()
                    ->preload(),

                Forms\Components\Select::make('mapel_id')
                    ->label('Mata Pelajaran')
                    ->relationship('mataPelajaran', 'nama_mapel')
                    ->required()
                    ->preload()
                    ->reactive()
                    ->rules([
                        function (Get $get) {
                            return function (string $attribute, $value, \Closure $fail) use ($get) {
                                $mapel = $value;
                                $kelas = $get('kelas_id');
                                $tahun = $get('tahun_akademik_id');
                                $semester = $get('semester');

                                if (! $mapel || ! $kelas || ! $semester || ! $tahun) {
                                    return;
                                }

                                $query = Mengajar::query()
                                    ->where('tahun_akademik_id', $tahun)
                                    ->where('mapel_id', $mapel)
                                    ->where('kelas_id', $kelas)
                                    ->where('semester', $semester);

                                if ($recordId = request()->route('record')) {
                                    $query->where('id', '!=', $recordId);
                                }

                                if ($query->exists()) {
                                    $fail('Duplicate entry: Mata Pelajaran sudah ada untuk kelas & semester ini.');
                                }
                            };
                        },
                    ]),

                Forms\Components\Select::make('kelas_id')
                    ->label('Kelas')
                    ->relationship('kelas', 'nama_kelas')
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->kode_kelas} - {$record->nama_kelas}")
                    ->required()
                    ->preload()
                    ->reactive(),

                Forms\Components\TextInput::make('kkm')
                    ->label('Nilai KKM')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->extraAttributes([
                        'onkeydown' => 'return /^[0-9]$/.test(event.key) || event.key === "Backspace" || event.key === "Tab" || event.key === "ArrowLeft" || event.key === "ArrowRight" || event.key === "ArrowUp" || event.key === "ArrowDown"',
                        'inputmode' => 'numeric',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([

                TextColumn::make('index')
                    ->label('No.')
                    ->state(static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1))
                        );
                    }),

                TextColumn::make('tahunAkademik.tahun_akademik_semester')
                    ->label('Tahun Akademik')
                    ->sortable(
                        query: fn($query, $direction) =>
                        $query->orderByRaw("CONCAT(tahun_akademik_id, ' ', semester) {$direction}")
                    ),

                TextColumn::make('guru.nama')->label('Nama Guru')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('mataPelajaran.nama_mapel')->label('Mata Pelajaran')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kelas_info')
                    ->label('Kelas')
                    ->sortable(query: fn ($query, $direction) => $query->orderByKelasInfo($direction))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('kkm')
                    ->label('KKM')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('tahun_akademik')
                    ->label('Tahun Akademik')
                    ->options(fn() => TahunAkademik::getListTahunAkademik())
                    ->default(fn() => TahunAkademik::getDefaultTahunAkademik())
                    ->query(function (Builder $query, array $data): Builder {
                        if (! $data['value']) {
                            return $query;
                        }

                        return $query->whereHas('tahunAkademik', function ($q) use ($data) {
                            $q->where('tahun_akademik', $data['value']);
                        });
                    })
                    ->searchable()
                    ->preload(),

                SelectFilter::make('semester')
                    ->options([
                        'Ganjil' => 'GANJIL',
                        'Genap' => 'GENAP'
                    ]),

                SelectFilter::make('kelas')
                    ->label('Kelas')
                    ->options(fn() => Kelas::getListKelas())
                    ->query(function (Builder $query, array $data): Builder {
                        if (! $data['value']) {
                            return $query;
                        }

                        return $query->whereHas('kelas', function ($q) use ($data) {
                            $q->where('kode_kelas', $data['value']);
                        });
                    })
                    ->searchable()
                    ->preload(),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->modalHeading('Delete Confirmation'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMengajar::route('/'),
            'create' => Pages\CreateMengajar::route('/create'),
            'edit' => Pages\EditMengajar::route('/{record}/edit'),
        ];
    }
}
