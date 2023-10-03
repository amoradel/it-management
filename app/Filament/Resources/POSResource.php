<?php

namespace App\Filament\Resources;

use App\Filament\Resources\POSResource\Pages;
use App\Models\Device;
use App\Models\Device_model;
use App\Models\Type;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Get;
use Illuminate\Support\Collection;

class POSResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $modelLabel = 'POS';
    protected static ?string $pluralModelLabel = "POS";
    protected static ?string $navigationGroup = 'Dispositivos';
    protected static ?string $navigationIcon = 'heroicon-o-server';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Campo Nombre
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignorable: fn ($record) => $record)
                    ->translateLabel(),
                // Campo Marca
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->translateLabel()
                    ->afterStateUpdated(function (callable $set) {
                        $set('model_id', null);
                        $set('type_id', null);
                    }),
                // Campo Ubicacion
                Forms\Components\TextInput::make('ubication')
                    ->required()
                    ->maxLength(50)
                    ->translateLabel(),
                // Campo Modelo
                Forms\Components\Select::make('model_id')
                    ->label('Model')
                    ->options(fn (Get $get): Collection => Device_model::query()->where('brand_id', $get('brand_id'))->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required()
                    ->translateLabel()
                    ->afterStateUpdated(function (callable $set) {
                        $set('type_id', null);
                    }),
                // Campo Numero de Serie
                Forms\Components\TextInput::make('serial_number')
                    ->required()
                    ->unique(ignorable: fn ($record) => $record)
                    ->translateLabel(),
                // Campo Tipo
                Forms\Components\Select::make('type_id')
                    ->label('Type')
                    ->options(fn (Get $get): Collection => Type::query()->where('model_id', $get('model_id'))->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->preload()
                    ->translateLabel(),
                // Campo Observacion
                Forms\Components\TextInput::make('observation')
                    ->translateLabel(),
                // Campo Condicion
                Forms\Components\Select::make('condition')
                    ->options((['Viejo' => 'Viejo', 'Nuevo' => 'Nuevo']))
                    ->required()
                    ->translateLabel(),
                // Campo Fecha de Ingreso
                Forms\Components\DatePicker::make('entry_date')
                    ->required()
                    ->maxDate(now())
                    ->translateLabel(),
                // Campo Estado
                Forms\Components\Toggle::make('status')
                    ->onColor('success')
                    ->default('true')
                    ->translateLabel(),
                // Columna que envia el tipo de equipo igual a computer
                Forms\Components\Hidden::make('device_type')
                    ->default('pos'),
            ]);
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
                // Columna Tipo
                Tables\Columns\TextColumn::make('type.name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Ubicacion
                Tables\Columns\TextColumn::make('ubication')
                    ->searchable()
                    ->translateLabel(),
                // Columna Marca
                Tables\Columns\TextColumn::make('brand.name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Modelo
                Tables\Columns\TextColumn::make('model.name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Numero de Serie
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Condicion
                Tables\Columns\TextColumn::make('condition')
                    ->searchable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Fecha de entrada
                Tables\Columns\TextColumn::make('entry_date')
                    ->searchable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Observacion
                Tables\Columns\TextColumn::make('observation')
                    ->searchable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Estado
                Tables\Columns\ToggleColumn::make('status')
                    ->translateLabel()
                    ->onColor('success'),

            ])
            ->filters([
                Tables\Filters\BaseFilter::make('device_type')
                    ->query(fn (Builder $query): Builder => $query->where('device_type', 'pos')),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('activities')->url(fn ($record) => POSResource::getUrl('activities', ['record' => $record]))
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
            'index' => Pages\ListPOS::route('/'),
            'create' => Pages\CreatePOS::route('/create'),
            'edit' => Pages\EditPOS::route('/{record}/edit'),
            'activities' => Pages\ListPOSActivities::route('/{record}/activities'),
        ];
    }
}
