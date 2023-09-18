<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Filament\Resources\PartnerResource\RelationManagers;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $modelLabel = 'Usuario';
    protected static ?string $pluralModelLabel = 'Usuarios';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Campo Nombre
                Forms\Components\TextInput::make('name')
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
                    ->required()
                    ->maxLength(15)
                    ->translateLabel(),
                // Campo username_odoo
                Forms\Components\TextInput::make('username_odoo')
                    ->required()
                    ->maxLength(15)
                    ->translateLabel(),
                // Campo username_odoo
                Forms\Components\TextInput::make('username_AS400')
                    ->required()
                    ->maxLength(15)
                    ->translateLabel(),
                // Campo email
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->regex('/^.+@.+$/i')
                    ->translateLabel(),
                // Campo Extension
                Forms\Components\TextInput::make('extension')
                    ->required()
                    ->maxLength(4)
                    ->translateLabel(),
                // Campo email
                Forms\Components\TextInput::make('company_position')
                    ->required()
                    ->translateLabel(),
                Forms\Components\Toggle::make('status')
                    ->onColor('success')
                    ->translateLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->translateLabel(),
                Tables\Columns\TextColumn::make('department.name')->translateLabel(),
                Tables\Columns\TextColumn::make('username_network')->translateLabel(),
                Tables\Columns\TextColumn::make('username_odoo')->translateLabel(),
                Tables\Columns\TextColumn::make('username_AS400')->translateLabel(),
                Tables\Columns\TextColumn::make('extension')->translateLabel(),
                Tables\Columns\TextColumn::make('email')->translateLabel(),
                Tables\Columns\TextColumn::make('company_position')->translateLabel(),
                Tables\Columns\ToggleColumn::make('status')->translateLabel()
                    ->onColor('success')
                    ->offColor('warning'),
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
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
