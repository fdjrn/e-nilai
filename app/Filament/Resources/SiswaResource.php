<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs\Tab;
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
    protected static ?int $navigationSort = 2;
    protected static ?string $breadcrumb = "Siswa";
    protected static ?string $slug = 'siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->contained(false)
                    ->tabs([
                        Tab::make('Data Diri Siswa')
                            ->schema([
                                Forms\Components\TextInput::make('nis')
                                    ->label('NIS')
                                    ->required()
                                    ->maxLength(15),
                                Forms\Components\TextInput::make('nisn')
                                    ->label('NISN')
                                    ->required()
                                    ->maxLength(15),
                                Forms\Components\TextInput::make('nik')
                                    ->label('NIK')
                                    ->required()
                                    ->maxLength(25),
                                Forms\Components\TextInput::make('nama')
                                    ->label('Nama Siswa')
                                    ->required()
                                    ->maxLength(128),
                                Forms\Components\TextInput::make('tempat_lahir')
                                    ->label('Tempat Lahir')
                                    ->required()
                                    ->maxLength(128),
                                Forms\Components\DatePicker::make('tgl_lahir')
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->label('Tanggal Lahir')
                                    ->helperText('Tanggal / Bulan / Tahun')
                                    ->required(),
                                Forms\Components\Select::make('jenis_kelamin')
                                    ->label('Jenis Kelamin')
                                    ->options([
                                        'L' => 'Laki-Laki',
                                        'P' => 'Perempuan'
                                    ])
                                    ->preload()
                                    ->required(),
                                Forms\Components\TextInput::make('hobi')
                                    ->label('Hobi')
                                    ->required()
                                    ->maxLength(128),
                                Forms\Components\TextInput::make('cita_cita')
                                    ->label('Cita-Cita')
                                    ->required()
                                    ->maxLength(128),
                                Forms\Components\Select::make('status_anak')
                                    ->label('Status Anak')
                                    ->options([
                                        'Kandung' => 'Kandung',
                                        'Angkat' => 'Angkat'
                                    ])
                                    ->preload()
                                    ->required(),
                                Forms\Components\TextInput::make('jumlah_sdr')
                                    ->label('Jumlah Saudara')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->extraAttributes([
                                        'onkeydown' => 'return /^[0-9]$/.test(event.key) || event.key === "Backspace" || event.key === "Tab" || event.key === "ArrowLeft" || event.key === "ArrowRight" || event.key === "ArrowUp" || event.key === "ArrowDown"',
                                        'inputmode' => 'numeric',
                                    ])
                                    ->validationMessages([
                                        'max' => 'Jumlah Saudara must be less than 100.',
                                        'min' => 'Jumlah Saudara must be at least 0.',
                                    ]),

                                Forms\Components\TextInput::make('anak_ke')
                                    ->label('Anak Ke')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->extraAttributes([
                                        'onkeydown' => 'return /^[0-9]$/.test(event.key) || event.key === "Backspace" || event.key === "Tab" || event.key === "ArrowLeft" || event.key === "ArrowRight" || event.key === "ArrowUp" || event.key === "ArrowDown"',
                                        'inputmode' => 'numeric',
                                    ])
                                    ->validationMessages([
                                        'max' => 'Anak Ke must be less than 100.',
                                        'min' => 'Anak Ke must be at least 0.',
                                    ]),
                                Forms\Components\Textarea::make('alamat')
                                    ->label('Alamat')
                                    ->rows(5)
                                    ->columnSpanFull(),

                                Forms\Components\DatePicker::make('tgl_masuk')
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->label('Tanggal Masuk')
                                    ->helperText('Tanggal / Bulan / Tahun')
                                    ->required(),
                                Forms\Components\DatePicker::make('tgl_keluar')
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->label('Tanggal Keluar')
                                    ->helperText('Tanggal / Bulan / Tahun'),
                                Forms\Components\Select::make('status')
                                    ->required()
                                    ->options([
                                        'Active' => 'Aktif',
                                        'Inactive' => 'Lulus'
                                    ]),
                            ])
                            ->columns(2),

                        Tab::make('Data Orang Tua')
                            ->schema([
                                Section::make('Data Ayah')
                                    ->collapsible()
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('nik_ayah')
                                            ->label('NIK')
                                            ->required()
                                            ->maxLength(25)
                                            ->extraAttributes([
                                                'onkeydown' => 'return /^[0-9]$/.test(event.key) || event.key === "Backspace" || event.key === "Tab" || event.key === "ArrowLeft" || event.key === "ArrowRight"',
                                                'inputmode' => 'numeric',
                                            ]),
                                        Forms\Components\TextInput::make('nama_ayah')
                                            ->label('Nama')
                                            ->required()
                                            ->maxLength(128),
                                        Forms\Components\TextInput::make('pend_ayah')
                                            ->label('Pendidikan')
                                            ->required()
                                            ->maxLength(50),
                                        Forms\Components\TextInput::make('pkr_ayah')
                                            ->label('Pekerjaan')
                                            ->required()
                                            ->maxLength(50),
                                    ]),

                                Section::make('Data Ibu')
                                    ->collapsible()
                                    ->collapsed()
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('nik_ibu')
                                            ->label('NIK')
                                            ->required()
                                            ->maxLength(25)
                                            ->extraAttributes([
                                                'onkeydown' => 'return /^[0-9]$/.test(event.key) || event.key === "Backspace" || event.key === "Tab" || event.key === "ArrowLeft" || event.key === "ArrowRight"',
                                                'inputmode' => 'numeric',
                                            ]),

                                        Forms\Components\TextInput::make('nama_ibu')
                                            ->label('Nama')
                                            ->required()
                                            ->maxLength(128),
                                        Forms\Components\TextInput::make('pend_ibu')
                                            ->label('Pendidikan')
                                            ->required()
                                            ->maxLength(50),
                                        Forms\Components\TextInput::make('pkr_ibu')
                                            ->label('Pekerjaan')
                                            ->required()
                                            ->maxLength(50),

                                    ]),

                                Forms\Components\Textarea::make('alamat_ortu')
                                    ->label('Alamat Orang Tua')
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->label('Tanggal Lahir')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')->alignCenter(),
                Tables\Columns\TextColumn::make('hobi')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('cita_cita')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('jumlah_sdr')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('anak_ke')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('tgl_masuk')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tgl_keluar')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Active' => 'success',
                        'Inactive' => 'danger',
                    }),
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
