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
use stdClass;

class NilaiResource extends Resource
{
    protected static ?string $model = Nilai::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = "Nilai Akademik";
    protected static ?string $navigationGroup = 'Akademik';
    protected static ?int $navigationSort = 1;
    protected static ?string $breadcrumb = "Nilai Akademik";
    protected static ?string $slug = 'nilai-akademik';
        public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('NO.')
                    ->state(static function (Tables\Contracts\HasTable $livewire, stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1))
                        );
                    }),

                Tables\Columns\TextColumn::make('siswa.nis')
                    ->label('NIS')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('siswa.nama')
                    ->label('NAMA SISWA')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('nslm_1')
                    ->type('number')
                    ->label('NSLM 1')
                    ->rules(['numeric','min:0','max:100'])
                    ->alignEnd()
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('nslm_2')
                    ->type('number')
                    ->label('NSLM 2')
                    ->rules(['numeric','min:0','max:100'])
                    ->alignEnd()
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('nslm_3')
                    ->type('number')
                    ->label('NSLM 3')
                    ->rules(['numeric','min:0','max:100'])
                    ->alignEnd()
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('nslm_4')
                    ->type('number')
                    ->label('NSLM 4')
                    ->rules(['numeric','min:0','max:100'])
                    ->alignEnd()
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('nslm_5')
                    ->type('number')
                    ->label('NSLM 5')
                    ->rules(['numeric','min:0','max:100'])
                    ->alignEnd()
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('nslm_6')
                    ->type('number')
                    ->label('NSLM 6')
                    ->rules(['numeric','min:0','max:100'])
                    ->alignEnd()
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('nslm_7')
                    ->type('number')
                    ->label('NSLM 7')
                    ->rules(['numeric','min:0','max:100'])
                    ->alignEnd()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rata_nslm')
                    ->numeric()
                    ->label('RATA-RATA NSLM')
                    ->alignEnd()
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('nsas')
                    ->type('number')
                    ->label('NSAS')
                    ->rules(['numeric','min:0','max:100'])
                    ->alignEnd()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nr')
                    ->numeric()
                    ->label('NR')
                    ->alignEnd()
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
            'index' => Pages\ListNilai::route('/'),
            // 'create' => Pages\CreateNilai::route('/create'),
            // 'edit' => Pages\EditNilai::route('/{record}/edit'),
        ];
    }
}
