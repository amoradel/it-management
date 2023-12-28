<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrinterResource\Pages;
use App\Models\Device;
use App\Models\DeviceModel;
use App\Models\Type;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PrinterResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationGroup = 'Dispositivos';

    protected static ?string $modelLabel = 'Impresora';

    protected static ?string $pluralModelLabel = 'Impresoras';

    protected static ?string $navigationIcon = 'heroicon-o-printer';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Campo Nombre
                Forms\Components\TextInput::make('name')
                    ->maxLength(30)
                    ->unique(ignorable: fn ($record) => $record)
                    ->columnSpan([
                        'xl' => '2',
                    ])
                    ->translateLabel(),
                // Campo Ubicación
                Forms\Components\TextInput::make('location')
                    ->datalist(fn () => getGroupedColumnValues(table: 'devices', column: 'location'))
                    ->required()
                    ->maxLength(50)
                    ->columnSpan([
                        'xl' => '2',
                    ])
                    ->translateLabel(),
                // Campo Tipo
                Forms\Components\Select::make('type_id')
                    ->label('Type')
                    ->options(fn (): Collection => Type::query()->where('device_type', 'printer')->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->preload()
                    ->prefixIcon('heroicon-m-rectangle-stack')
                    ->columnSpan([
                        'xl' => '2',
                    ])
                    ->translateLabel(),
                // Campo Marca
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive()
                    ->prefixIcon('heroicon-m-tag')
                    ->translateLabel(),
                // Campo Modelo
                Forms\Components\Select::make('model_id')
                    ->label('Model')
                    ->options(fn (Get $get): Collection => DeviceModel::query()->where('brand_id', $get('brand_id'))->pluck('name', 'id'))
                    ->searchable()
                    ->prefixIcon('heroicon-m-swatch')
                    ->required()
                    ->translateLabel(),
                // Campo Numero de Activo
                Forms\Components\TextInput::make('asset_number')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignorable: fn ($record) => $record)
                    ->prefixIcon('heroicon-m-hashtag')
                    ->translateLabel(),
                // Campo Numero de Serie
                Forms\Components\TextInput::make('serial_number')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignorable: fn ($record) => $record)
                    ->prefixIcon('heroicon-m-hashtag')
                    ->translateLabel(),
                Forms\Components\Select::make('partner_id')
                    ->relationship('partners', 'name')
                    ->searchable()
                    ->preload()
                    // ->multiple()
                    ->prefixIcon('heroicon-m-user')
                    ->columnSpan([
                        'xl' => '2',
                    ])
                    ->translateLabel(),

                // Campo Condición
                Forms\Components\Select::make('condition')
                    ->options((['used' => 'En uso', 'new' => 'Nuevo']))
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->translateLabel(),
                // Campo Fecha de Ingreso
                Forms\Components\DatePicker::make('entry_date')
                    ->required(fn ($get) => $get('condition') == 'new' ? true : false)
                    ->maxDate(now())
                    ->translateLabel(),
                // Campo Selección Usuarios

                // Campo Descripción
                Forms\Components\Textarea::make('description')
                    ->maxLength(150)
                    ->columnSpan([
                        'xl' => '2',
                    ])
                    ->translateLabel(),
                // Columna que envía el tipo de equipo igual a printer
                Forms\Components\Hidden::make('device_type')
                    ->default('printer'),

            ])->columns(['sm' => 2, 'xl' => 4]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Columna Nombre
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Ubicacion
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Marca
                Tables\Columns\TextColumn::make('brand.name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Modelo
                Tables\Columns\TextColumn::make('model.name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Tipo
                Tables\Columns\TextColumn::make('type.name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Descripcion
                Tables\Columns\TextColumn::make('description')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Numero de Activo
                Tables\Columns\TextColumn::make('asset_number')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Numero de Serie
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Ip
                Tables\Columns\TextColumn::make('ip.ip_address')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Condicion
                Tables\Columns\TextColumn::make('condition')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Condicion
                Tables\Columns\TextColumn::make('entry_date')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\BaseFilter::make('device_type')
                    ->query(fn (Builder $query): Builder => $query->where('device_type', 'printer')),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('activities')->url(fn ($record) => PrinterResource::getUrl('activities', ['record' => $record]))
                    ->icon('heroicon-m-information-circle')
                    ->translateLabel(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListPrinters::route('/'),
            'create' => Pages\CreatePrinter::route('/create'),
            'edit' => Pages\EditPrinter::route('/{record}/edit'),
            'activities' => Pages\ListPrinterActivities::route('/{record}/activities'),
        ];
    }
}
