<?php

namespace App\Filament\Resources;

use App\Konstanta;
use App\Filament\Resources\TahunAkademikResource\Pages;
use App\Filament\Resources\TahunAkademikResource\RelationManagers;
use App\Models\TahunAkademik;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class TahunAkademikResource extends Resource
{
    const RESOURCE_LABEL = "Tahun Akademik";

    protected static ?string $model = TahunAkademik::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = Konstanta::TAHUN_AKADEMIK;
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 1;
    protected static ?string $breadcrumb = Konstanta::TAHUN_AKADEMIK;
    protected static ?string $slug = Konstanta::TAHUN_AKADEMIK_SLUG;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('tahun_akademik')
                    ->label(Konstanta::TAHUN_AKADEMIK)
                    ->required()
                    ->maxLength(10),
                Select::make('semester')
                    ->label('Semester')
                    ->options([
                        'Ganjil' => 'GANJIL',
                        'Genap' => 'GENAP'
                    ])
                    ->preload()
                    ->required(),
                Toggle::make('is_active')
                    ->label('Semester Aktif'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tahun_akademik', 'asc')
            ->columns([
                TextColumn::make('index')
                    ->label('No.')
                    ->state(static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string)(
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1))
                        );
                    }),
                TextColumn::make('tahun_akademik')
                    ->label(Konstanta::TAHUN_AKADEMIK)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('semester')
                    ->label('Semester')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'GANJIL' => 'warning',
                        'GENAP' => 'success',
                    })
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('is_active')
                    ->disabled()
                    ->label('Aktif'),
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
                    ->label(Konstanta::TAHUN_AKADEMIK)
                    ->options(function () {
                        return TahunAkademik::query()
                            ->select('tahun_akademik')
                            ->orderBy('tahun_akademik', 'asc')
                            ->distinct()
                            ->pluck('tahun_akademik', 'tahun_akademik')
                            ->toArray();
                    }),

                SelectFilter::make('semester')
                    ->options([
                        'Ganjil' => 'GANJIL',
                        'Genap' => 'GENAP'
                    ]),

                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        0 => 'NON AKTIF',
                        1 => 'AKTIF',
                    ])->default(1),
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
            'index' => Pages\ListTahunAkademiks::route('/'),
            'create' => Pages\CreateTahunAkademik::route('/create'),
            'edit' => Pages\EditTahunAkademik::route('/{record}/edit'),
        ];
    }
}
