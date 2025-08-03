<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = "Siswa";
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 1;
    protected static ?string $breadcrumb = "Siswa";
    protected static ?string $slug = 'siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nis')
                    ->required()
                    ->maxLength(15),
                Forms\Components\TextInput::make('nisn')
                    ->required()
                    ->maxLength(15),
                Forms\Components\TextInput::make('nik')
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(128),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->required()
                    ->maxLength(128),
                Forms\Components\DatePicker::make('tgl_lahir')
                    ->required(),
                Forms\Components\TextInput::make('jenis_kelamin')
                    ->required(),
                Forms\Components\TextInput::make('hobi')
                    ->required()
                    ->maxLength(128),
                Forms\Components\TextInput::make('cita_cita')
                    ->required()
                    ->maxLength(128),
                Forms\Components\TextInput::make('status_anak')
                    ->required(),
                Forms\Components\TextInput::make('jumlah_sdr')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('anak_ke')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('alamat')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('nik_ayah')
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('nama_ayah')
                    ->required()
                    ->maxLength(128),
                Forms\Components\TextInput::make('pend_ayah')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('pkr_ayah')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('nik_ibu')
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('nama_ibu')
                    ->required()
                    ->maxLength(128),
                Forms\Components\TextInput::make('pend_ibu')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('pkr_ibu')
                    ->required()
                    ->maxLength(50),
                Forms\Components\Textarea::make('alamat_ortu')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('tgl_masuk')
                    ->required(),
                Forms\Components\DatePicker::make('tgl_keluar')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin'),
                Tables\Columns\TextColumn::make('hobi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cita_cita')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_anak'),
                Tables\Columns\TextColumn::make('jumlah_sdr')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('anak_ke')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nik_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pend_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pkr_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pend_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pkr_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_masuk')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tgl_keluar')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
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
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
