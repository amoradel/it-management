<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $modelLabel = 'Empleado';

    protected static ?string $pluralModelLabel = 'Empleados';

    protected static ?string $navigationGroup = 'Personal';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Campo Nombre
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(100)
                    ->unique(ignorable: fn ($record) => $record)
                    ->translateLabel(),
                // Campo Numero de empleado
                Forms\Components\TextInput::make('employee_number')
                    ->required()
                    ->maxLength(30)
                    ->translateLabel(),
                // Campo Cargo
                Forms\Components\TextInput::make('job_position')
                    ->required()
                    ->maxLength(50)
                    ->translateLabel(),
                // Campo Departamento
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(50)
                            ->translateLabel(),
                    ])
                    ->required()
                    ->translateLabel(),
                // Campo username_network
                Forms\Components\TextInput::make('username_network')
                    ->maxLength(15)
                    ->unique(ignorable: fn ($record) => $record)
                    ->translateLabel(),
                // Campo username_odoo
                Forms\Components\TextInput::make('username_odoo')
                    ->maxLength(15)
                    ->unique(ignorable: fn ($record) => $record)
                    ->translateLabel(),
                // Campo username_odoo
                Forms\Components\TextInput::make('username_jde')
                    ->maxLength(15)
                    ->unique(ignorable: fn ($record) => $record)
                    ->translateLabel(),
                // Campo email
                Forms\Components\TextInput::make('email')
                    ->maxLength(50)
                    ->email()
                    ->regex('/^.+@.+$/i')
                    ->prefixIcon('heroicon-m-envelope')
                    ->unique(ignorable: fn ($record) => $record)
                    ->translateLabel(),
                // Campo Extension
                Forms\Components\TextInput::make('extension')
                    ->prefixIcon('heroicon-m-phone')
                    ->maxLength(4)
                    ->translateLabel(),
                // Campo Selección Equipos
                Forms\Components\Select::make('device_id')
                    ->relationship('devices', 'name')
                    ->prefixIcon('heroicon-m-computer-desktop')
                    ->preload()
                    ->multiple()
                    ->translateLabel(),
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
                // Columna Departamento
                Tables\Columns\TextColumn::make('department.name')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Usuario de Red
                Tables\Columns\TextColumn::make('username_network')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Usuario de Odoo
                Tables\Columns\TextColumn::make('username_odoo')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Extension
                Tables\Columns\TextColumn::make('extension')
                    ->searchable()
                    ->sortable()
                    ->translateLabel(),
                // Columna Correo
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna Puesto
                Tables\Columns\TextColumn::make('job_position')
                    ->searchable()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('activities')->url(fn ($record) => PartnerResource::getUrl('activities', ['record' => $record]))
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
            'activities' => Pages\ListPartnerActivities::route('/{record}/activities'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
