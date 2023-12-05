<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use App\Models\School;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use Filament\Pages\Tenancy\EditTenantProfile;
use App\Filament\Pages\Tenancy\RegisterSchool;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Filament\Pages\Tenancy\EditSchoolProfile;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class SuperadminPanelProvider extends PanelProvider
{

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('superadmin')
            ->path('superadmin')
            ->login()
            ->passwordReset()
            ->profile()
            ->sidebarCollapsibleOnDesktop()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->font('Lato')
            ->globalSearchKeybindings(['command+k', 'ctrl+k'])
            ->discoverResources(in: app_path('Filament/Superadmin/Resources'), for: 'App\\Filament\\Superadmin\\Resources')
            ->discoverPages(in: app_path('Filament/Superadmin/Pages'), for: 'App\\Filament\\Superadmin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Superadmin/Widgets'), for: 'App\\Filament\\Superadmin\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()->label('Edit profile'),
                MenuItem::make()
                    ->label('Settings')
                    ->url(fn () => "/superadmin/" . getCurrentTenant()?->code . "/settings")
                    ->icon('heroicon-o-cog-8-tooth')
                    ->visible(fn () => auth()->user()->can('create school settings')),
                MenuItem::make()
                    ->label('Switch to Admin')
                    ->url("/admin")
                    ->icon('heroicon-m-user')
                    ->visible(fn () => auth()->user()->hasRole('admin')),
            ])
            ->tenantMenuItems([
                'register' => MenuItem::make()
                    ->label('Add New School')
                    ->visible(fn (): bool => auth()->user()->can('create school')),
                'profile' => MenuItem::make()
                    ->label('Edit School Profile')
                    ->visible(fn (): bool => auth()->user()->can('update school settings')),
            ])
            ->navigationItems([
                // NavigationItem::make('School Setting')
                //     ->url(fn (): string => SettingResource::getUrl())
                //     ->label('School Settings')
                //     ->group('Configuration')
                //     ->icon('heroicon-o-cog-6-tooth')
                //     ->isActiveWhen(fn () => request()->routeIs('filament.superadmin.resources.settings.index'))
                //     ->visible(fn (): bool => auth()->user()->can('create school settings'))
                // ...
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
            ->tenantMiddleware([
                'role:super-admin',
            ], isPersistent: true)
            ->tenant(School::class, ownershipRelationship: 'school', slugAttribute: 'code')
            ->tenantRegistration(RegisterSchool::class)
            ->tenantProfile(EditSchoolProfile::class);
    }
}
