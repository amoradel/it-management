<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('/')
            ->login()
            ->maxContentWidth('screen-2xl')
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            // ->navigationGroups([
            //     'Dispositivos',
            //     'Personal',
            //     'Marcas y Más',
            //     'Gestión de Usuarios',
            // ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Dispositivos')->collapsed(),
                NavigationGroup::make()
                    ->label('Procesos')->collapsed(),
                NavigationGroup::make()
                    ->label('Personal')->collapsed(),
                NavigationGroup::make()
                    ->label('Marcas y Más')->collapsed(),
                NavigationGroup::make()
                    ->label('Gestión de Usuarios')->collapsed(),

                // NavigationGroup::make()
                //     ->label(fn (): string => __('navigation.settings'))
                //     ->icon('heroicon-o-cog-6-tooth')
                //     ->collapsed(),
            ])
            ->plugins([
                BreezyCore::make()
                    ->myProfile(
                        shouldRegisterUserMenu: true, // Coloca el enlace 'account'en el panel del menu de usuario (default = true)
                        slug: 'my-profile'
                    )
                    ->passwordUpdateRules(
                        rules: [Password::default()->letters()->numbers()->mixedCase()->uncompromised(3)], // you may pass an array of validation rules as well. (default = ['min:8'])
                        requiresCurrentPassword: true, // cuando se coloca "false", el usuario puede actualizar su contraseña sin necesidad de intrdocir la actual.
                    )
                    ->enableTwoFactorAuthentication(
                        force: false, // force the user to enable 2FA before they can use the application (default = false)
                    )
                    ->enableSanctumTokens(
                        permissions: ['aqui', 'lo', 'que', 'necesiten'], // optional, customize the permissions (default = ["create", "view", "update", "delete"])
                    ),

                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),

            ]);
    }
}
