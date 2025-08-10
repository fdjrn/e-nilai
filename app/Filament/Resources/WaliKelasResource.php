<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\WaliKelas;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\WaliKelasResource\Pages;
use App\Models\Kelas;
use App\Models\TahunAkademik;
use Filament\Forms\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use stdClass;

class WaliKelasResource extends Resource
{
    protected static ?string $model = WaliKelas::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = "Wali Kelas";
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 1;
    protected static ?string $slug = 'wali-kelas';

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
                        $ta = TahunAkademik::find($state);
                        if ($ta) {
                            $set('semester', ucfirst($ta->semester)); // isi field semester di form
                        } else {
                            $set('semester', null);
                        }
                    }),

                Hidden::make('semester'),

                Forms\Components\Select::make('kelas_id')
                    ->label('Kelas')
                    ->relationship('kelas', 'nama_kelas')
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->kode_kelas} - {$record->nama_kelas}")
                    ->required()
                    ->preload()
                    ->reactive()
                    ->rules([
                        function (Get $get) {
                            return function (string $attribute, $value, \Closure $fail) use ($get) {
                                $kelas = $value;
                                $tahun = $get('tahun_akademik_id');
                                $semester = $get('semester');
                                $guru = $get('guru_id');

                                if (! $kelas || ! $semester || !$tahun || !$guru) {
                                    return;
                                }

                                $query = WaliKelas::query()
                                    ->where('tahun_akademik_id', $tahun)
                                    ->where('kelas_id', $kelas)
                                    ->where('guru_id', $guru)
                                    ->where('semester', $semester);

                                if ($recordId = request()->route('record')) {
                                    $query->where('id', '!=', $recordId);
                                }

                                if ($query->exists()) {
                                    $fail('Kombinasi Kelas, Tahun Akademik dan Semester sudah dibuat');
                                }
                            };
                        },
                    ]),

                Forms\Components\Select::make('guru_id')
                    ->label('Wali Kelas')
                    ->relationship('guru', 'nama')
                    ->required()
                    ->preload(),
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

                TextColumn::make('tahunAkademik.tahun_akademik')
                    ->label('Tahun Akademik')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('semester')
                    ->label('Semester')
                    ->sortable(
                        query: fn(Builder $query, string $direction) =>
                        $query->orderBy('wali_kelas.semester', $direction)
                    )
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('kelas.kode_nama_kelas')
                    ->label('Kelas')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('guru.nama')
                    ->label('Wali Kelas')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_siswa')
                    ->label('Jumlah Siswa')
                    ->getStateUsing(fn($record) => ($record->jumlahSiswa() . ' Orang')),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable("")
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
                    ->default('Ganjil')
                    ->options([
                        'Ganjil' => 'GANJIL',
                        'Genap' => 'GENAP'
                    ]),

                // SelectFilter::make('kelas')
                //     ->label('Kelas')
                //     ->options(fn() => Kelas::getListKelas())
                //     ->query(function (Builder $query, array $data): Builder {
                //         if (! $data['value']) {
                //             return $query;
                //         }

                //         return $query->whereHas('kelas', function ($q) use ($data) {
                //             $q->where('kode_kelas', $data['value']);
                //         });
                //     })
                //     ->searchable()
                //     ->preload(),
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
            'index' => Pages\ListWaliKelas::route('/'),
            'create' => Pages\CreateWaliKelas::route('/create'),
            'edit' => Pages\EditWaliKelas::route('/{record}/edit'),
        ];
    }
}
