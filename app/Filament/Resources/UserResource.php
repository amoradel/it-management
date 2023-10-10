<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Gestión de Usuarios';

    protected static ?string $modelLabel = 'Usuarios';

    protected static ?string $pluralModelLabel = 'Usuarios';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Campo Nombre
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(25)
                    ->unique(ignorable: fn ($record) => $record)
                    ->translateLabel(),

                // Campo Nombre
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->regex('/^.+@.+$/i')
                    ->unique(ignorable: fn ($record) => $record)
                    ->translateLabel(),

                // Campo Contraseña
                Forms\Components\TextInput::make('password')
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)) // Envia la contraseña encriptada
                    ->dehydrated(fn ($state) => filled($state)) // hace la contraseña opcional cuando se edita el usuario y la contraseña está vacia
                    ->required(fn (string $context): bool => $context === 'create') // hace la contraseña obligatoria cuando se crea un usuario
                    ->unique(ignorable: fn ($record) => $record)
                    ->translateLabel(),

                // Checkbox Roles
                Forms\Components\Select::make('roles')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->relationship('roles', 'name')
                    ->searchable(),
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
                    ->wrap()
                    ->translateLabel(),
                // Columna Email
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->translateLabel(),
                // Columna Roles
                Tables\Columns\TextColumn::make('roles.name')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->wrap()
                    ->translateLabel(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (DeleteAction $action, User $record) {
                        if ($record->hasRole('super_admin')) {
                            Notification::make()
                                ->warning()
                                ->title('Advertencia')
                                ->body('Este usuario no se puede eliminar.')
                                ->send();

                            $action->cancel();
                        }
                    }),
                Tables\Actions\Action::make('activities')->url(fn ($record) => UserResource::getUrl('activities', ['record' => $record]))
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'activities' => Pages\ListUserActivities::route('/{record}/activities'),

        ];
    }
}
