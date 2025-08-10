<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NilaiResource\Pages;
use App\Filament\Resources\NilaiResource\RelationManagers;
use App\Models\Nilai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NilaiResource extends Resource
{
    protected static ?string $model = Nilai::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = "Input Nilai Siswa";

    protected static ?int $navigationSort = 999;
    protected static ?string $breadcrumb = "Nilai Siswa";
    protected static ?string $slug = 'nilai';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tahun_akademik_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('semester')
                    ->required(),
                Forms\Components\TextInput::make('kelas_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('mapel_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('siswa_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_tp1')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_tp2')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_tp3')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_tp4')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_tp5')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_tp6')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_tp7')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('rata_tp')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_uh1')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_uh2')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_uh3')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_uh4')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_uh5')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_uh6')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_uh7')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('rata_uh')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_pts')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_uas')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_akhir')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nilai_huruf')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('deskripsi')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahun_akademik_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester'),
                Tables\Columns\TextColumn::make('kelas_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mapel_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('siswa_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_tp1')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_tp2')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_tp3')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_tp4')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_tp5')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_tp6')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_tp7')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rata_tp')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_uh1')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_uh2')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_uh3')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_uh4')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_uh5')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_uh6')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_uh7')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rata_uh')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_pts')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_uas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_akhir')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_huruf')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->searchable(),
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
            'index' => Pages\ListNilais::route('/'),
            'create' => Pages\CreateNilai::route('/create'),
            'edit' => Pages\EditNilai::route('/{record}/edit'),
        ];
    }
}
