<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MengajarResource\Pages;
use App\Filament\Resources\MengajarResource\RelationManagers;
use App\Models\Mengajar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Forms\Components\Select::make('tahun_akademik_id')
                    ->label('Tahun Akademik')
                    ->relationship('tahunAkademik', 'tahun_akademik')
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->tahun_akademik} - {$record->semester}")
                    ->required()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $ta = \App\Models\TahunAkademik::find($state);
                        if ($ta) {
                            $set('semester', $ta->semester); // isi field semester di form
                        } else {
                            $set('semester', null);
                        }
                    }),

                Forms\Components\TextInput::make('semester')
                    ->label('Semester')
                    ->disabled()
                    ->required()
                    ->reactive(),

                Forms\Components\Select::make('guru_id')
                    ->label('Guru Pengajar')
                    ->relationship('guru', 'nama')
                    ->required()
                    ->preload()
                    ->reactive(),

                Forms\Components\Select::make('mapel_id')
                    ->label('Mata Pelajaran')
                    ->relationship('mataPelajaran', 'nama_mapel')
                    ->required()
                    ->preload()
                    ->reactive()
                    ->rules([
                        function (Get $get) {
                            return function (string $attribute, $value, \Closure $fail) use ($get) {
                                $guru = $get('guru_id');
                                $mapel = $value;
                                $kelas = $get('kelas_id');
                                $tahun = $get('tahun_akademik_id');
                                $semester = $get('semester');

                                if (! $guru || ! $mapel || ! $kelas || ! $semester) {
                                    return;
                                }

                                $query = Mengajar::query()
                                    ->where('guru_id', $guru)
                                    ->where('mapel_id', $mapel)
                                    ->where('kelas_id', $kelas)
                                    ->where('semester', $semester);

                                if ($tahun) {
                                    $query->where('tahun_akademik_id', $tahun);
                                } else {
                                    $query->whereNull('tahun_akademik_id');
                                }

                                if ($recordId = request()->route('record')) {
                                    $query->where('id', '!=', $recordId);
                                }

                                if ($query->exists()) {
                                    $fail('Penugasan guru untuk mata pelajaran ini di kelas, tahun akademik dan semester yang dipilih sudah ada.');
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
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahunAkademik.tahun_akademik_semester')
                    ->label('Tahun Akademik')
                    ->sortable(),
                Tables\Columns\TextColumn::make('guru.nama')->label('Nama Guru')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('mataPelajaran.nama_mapel')->label('Mata Pelajaran')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kelas.kode_nama_kelas')
                    ->label('Kelas')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('kkm')
                    ->label('KKM')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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
            'index' => Pages\ListMengajars::route('/'),
            'create' => Pages\CreateMengajar::route('/create'),
            'edit' => Pages\EditMengajar::route('/{record}/edit'),
        ];
    }
}
