<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypeResource\Pages;
use App\Models\Type;
use App\Models\Device_model;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Illuminate\Support\Collection;

class TypeResource extends Resource
{
    protected static ?string $model = Type::class;
    protected static ?string $navigationGroup = 'Marcas y Más';
    protected static ?string $modelLabel = 'Tipo';
    protected static ?string $pluralModelLabel = 'Tipos';

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                // Campo Marca
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->translateLabel()
                    ->afterStateUpdated(function (callable $set) {
                        $set('model_id', null);
                    }),
                // Campo Modelo
                Forms\Components\Select::make('model_id')
                    ->label('Model')
                    ->options(fn (Get $get): Collection => Device_model::query()->where('brand_id', $get('brand_id'))->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required()
                    ->translateLabel(),
                // Campo Nombre Tipo
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignorable: fn ($record) => $record)
                    ->translateLabel(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Columna Marca
                Tables\Columns\TextColumn::make('brand.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                // Columna Modelo
                Tables\Columns\TextColumn::make('model.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                // Columna Tipo
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('activities')->url(fn ($record) => TypeResource::getUrl('activities', ['record' => $record]))
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
            'index' => Pages\ListTypes::route('/'),
            'create' => Pages\CreateType::route('/create'),
            'edit' => Pages\EditType::route('/{record}/edit'),
            'activities' => Pages\ListTypeActivities::route('/{record}/activities'),
        ];
    }
}
