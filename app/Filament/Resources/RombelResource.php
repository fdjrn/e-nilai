<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RombelResource\Pages;
use App\Filament\Resources\RombelResource\RelationManagers;
use App\Models\Rombel;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\ValidationException;

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
                Select::make('wali_kelas_id')
                    ->label('Wali Kelas')
                    ->relationship('waliKelas', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->guru->nama ?? "-")
                    ->required()
                    ->preload(),
                    // ->reactive(),
                Select::make('kelas_id')
                    ->label('Kelas')
                    ->relationship('kelas', 'nama_kelas')
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->kode_kelas} - {$record->nama_kelas}")
                    ->required()
                    ->preload(),
                    // ->reactive(),
                Select::make('siswa_id')
                    ->label('Siswa')
                    ->relationship('siswa', 'nama')
                    ->required()
                    ->preload(),
                    // ->reactive(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahunAkademik.tahun_akademik_semester')
                    ->label('Tahun Akademik')
                    ->sortable(),
                Tables\Columns\TextColumn::make('waliKelas.guru.nama')
                    ->label('Wali Kelas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kelas.kode_nama_kelas')
                    ->label('Kelas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('siswa.nama')
                    ->label('Nama Siswa')
                    ->sortable(),
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
        ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
        ->exists();

    if ($exists) {
        throw ValidationException::withMessages([
            'siswa_id' => 'Siswa ini sudah terdaftar dalam rombel untuk tahun akademik tersebut.',
        ]);
    }
}
}
