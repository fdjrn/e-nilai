<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuruResource\Pages;
use App\Filament\Resources\GuruResource\RelationManagers;
use App\Models\Guru;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;
use stdClass;

class GuruResource extends Resource
{
    protected static ?string $model = Guru::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = "Guru";
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 1;
    protected static ?string $breadcrumb = "Guru";
    protected static ?string $slug = 'guru';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([

                TextInput::make('nip')
                    ->label('NIP')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(25),

                TextInput::make('nama')
                    ->label('Nama')
                    ->required()
                    ->maxLength(128)
                    ->columnSpan(2),

                TextInput::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->required()
                    ->maxLength(128),
                DatePicker::make('tgl_lahir')
                    ->label('Tanggal Lahir')
                    ->required(),
                Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-Laki',
                        'P' => 'Perempuan'
                    ])
                    ->preload()
                    ->required(),
                Textarea::make('alamat')
                    ->rows(5)
                    ->columnSpanFull(),

                Select::make('user_id')
                    ->label('Akun User')
                    ->unique(ignoreRecord: true)
                    ->validationMessages(['unique' => 'User ini sudah terhubung dengan Guru lain.'])
                    ->relationship('user', 'email') // tampilkan email user
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
                TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tempat_tgl_lahir')
                    ->label('Tempat, Tgl. Lahir')
                    ->searchable()
                    ->sortable(
                        query: fn($query, $direction) => $query->orderByRaw("CONCAT(tempat_lahir, ' ', tgl_lahir) {$direction}")
                    ),
                TextColumn::make('jenis_kelamin')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('alamat')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),

                TextColumn::make('user.email')
                    ->label('Akun User')
                    ->sortable()
                    ->searchable()
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
            'index' => Pages\ListGurus::route('/'),
            'create' => Pages\CreateGuru::route('/create'),
            'edit' => Pages\EditGuru::route('/{record}/edit'),
        ];
    }
}
