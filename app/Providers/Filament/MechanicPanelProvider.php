<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use App\Models\ServicePoint;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use App\Http\Middleware\AssignGlobalScopes;
use Filament\SpatieLaravelTranslatablePlugin;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class MechanicPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('mechanic')
            ->path('mechanic')
            ->tenant(ServicePoint::class)
            ->login()
            ->passwordReset()
            ->colors([
                'primary' => Color::Orange,
                'danger'  => Color::Red,
                'gray'    => Color::Zinc,
                'info'    => Color::Blue,
                'success' => Color::Green,
                'warning' => Color::Yellow,
            ])
            ->discoverResources(in: app_path('Filament/Mechanic/Resources'), for: 'App\\Filament\\Mechanic\\Resources')
            ->discoverPages(in: app_path('Filament/Mechanic/Pages'), for: 'App\\Filament\\Mechanic\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Mechanic/Widgets'), for: 'App\\Filament\\Mechanic\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
            ->tenantMiddleware([
                AssignGlobalScopes::class,
            ], isPersistent: true)  // This makes sure the scope is always applied.
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(
                SpatieLaravelTranslatablePlugin::make()
                    ->defaultLocales(['en', 'nl']),
            )
            ->plugins([

            ]);
    }
}
