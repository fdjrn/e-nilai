<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RombelResource\Pages;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\TahunAkademik;
use App\Models\WaliKelas;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\ValidationException;
use stdClass;

class RombelResource extends Resource
{
    protected static ?string $model = Rombel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = "Rombongan Belajar";
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 1;
    protected static ?string $breadcrumb = "Rombongan Belajar";
    protected static ?string $slug = 'rombel';


    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
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
                    ->preload(),
                Select::make('kelas_id')
                    ->label('Kelas')
                    ->relationship('kelas', 'nama_kelas')
                    ->required()
                    ->preload(),

                Select::make('siswa_id')
                    ->label('Siswa')
                    ->relationship('siswa', 'nama')
                    ->required()
                    ->searchable()
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
                        return (string)(
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1))
                        );
                    }),

                TextColumn::make('tahunAkademik.tahun_akademik_semester')
                    ->label('Tahun Akademik')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('waliKelas.guru.nama')
                    ->label('Wali Kelas')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('kelas.kode_nama_kelas')
                    ->label('Kelas')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('siswa.nis')
                    ->label('NIS')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('siswa.nama')
                    ->label('Nama Lengkap Siswa')
                    ->sortable()
                    ->searchable(),
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
                        if (!$data['value']) {
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
                    ])
                    ->default('Ganjil')
                    ->query(function (Builder $query, array $data): Builder {
                        if (!$data['value']) {
                            return $query;
                        }

                        return $query->whereHas('tahunAkademik', function ($q) use ($data) {
                            $q->where('semester', $data['value']);
                        });
                    })
                    ->searchable()
                    ->preload(),

                // SelectFilter::make('tahunAkademik.semester')
                //     ->label('Semester')
                //     ->options([
                //         'Ganjil' => 'GANJIL',
                //         'Genap' => 'GENAP'
                //     ])
                //     ->default(fn() => TahunAkademik::getDefaultSemester())
                //     ->query(function (Builder $query, array $data): Builder {
                //         if (! $data['value']) {
                //             return $query;
                //         }

                //         return $query->whereHas('tahunAkademik', function ($q) use ($data) {
                //             $q->where('semester', $data['value']);
                //         });
                //     })
                //     ->searchable()
                //     ->preload(),

                SelectFilter::make('kelas')
                    ->label('Kelas')
                    ->relationship('kelas', 'nama_kelas')
//                    ->options(function () {
//                        return \App\Models\Kelas::query()
//                            ->select('kode_kelas')
//                            ->distinct()
//                            ->orderBy('kode_kelas', 'asc')
//                            ->pluck('kode_kelas', 'kode_kelas'); // key => label
//                    })
////                    ->default('X IPA')
//                    ->query(function (Builder $query, array $data): Builder {
//                        if (!$data['value']) {
//                            return $query;
//                        }
//
//                        return $query->whereHas('kelas', function ($q) use ($data) {
//                            $q->where('kode_kelas', $data['value']);
//                        });
//                    })
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
            'index' => Pages\ListRombels::route('/'),
            'create' => Pages\CreateRombel::route('/create'),
            'edit' => Pages\EditRombel::route('/{record}/edit'),
        ];
    }

    public static function beforeCreate(array $data): array
    {
        static::validateUniqueRombel($data);
        return $data;
    }

    public static function beforeUpdate($record, array $data): array
    {
        static::validateUniqueRombel($data, $record->id);
        return $data;
    }

    protected static function validateUniqueRombel(array $data, ?int $ignoreId = null): void
    {
        $exists = Rombel::where('siswa_id', $data['siswa_id'])
            ->where('tahun_akademik_id', $data['tahun_akademik_id'])
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'siswa_id' => 'Siswa ini sudah terdaftar dalam rombel untuk tahun akademik tersebut.',
            ]);
        }
    }
}
