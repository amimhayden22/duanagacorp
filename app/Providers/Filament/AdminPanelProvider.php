<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make())
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    NavigationGroup::make()
                        ->items([
                            NavigationItem::make('Dashboard')
                                ->icon('heroicon-o-home')
                                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                                ->url(fn (): string => Dashboard::getUrl()),
                        ]),
                    NavigationGroup::make('Setting')
                        ->items([
                            NavigationItem::make('User')
                                ->icon('heroicon-s-users')
                                ->visible(Auth::user()->can('Read User'))
                                ->isActiveWhen(fn (): bool => request()->routeIs(
                                    'filament.admin.resources.users.index',
                                    'filament.admin.resources.users.create',
                                    'filament.admin.resources.users.view',
                                    'filament.admin.resources.users.edit'
                                ))
                                ->url(route('filament.admin.resources.users.index')),
                            NavigationItem::make('Roles')
                                ->icon('heroicon-o-user-group')
                                ->visible(Auth::user()->can('Role & Permission'))
                                ->isActiveWhen(fn (): bool => request()->routeIs(
                                    'filament.admin.resources.roles.index',
                                    'filament.admin.resources.roles.create',
                                    'filament.admin.resources.roles.view',
                                    'filament.admin.resources.roles.edit'
                                ))
                                ->url(route('filament.admin.resources.roles.index')),
                            NavigationItem::make('Permissions')
                                ->icon('heroicon-o-lock-closed')
                                ->visible(Auth::user()->can('Role & Permission'))
                                ->isActiveWhen(fn (): bool => request()->routeIs(
                                    'filament.admin.resources.permissions.index',
                                    'filament.admin.resources.permissions.create',
                                    'filament.admin.resources.permissions.view',
                                    'filament.admin.resources.permissions.edit'
                                ))
                                ->url(route('filament.admin.resources.permissions.index')),

                        ]),
                    NavigationGroup::make('Menu')
                        ->items([
                            NavigationItem::make('Kategori')
                                ->icon('heroicon-s-tag')
                                ->visible(Auth::user()->can('Read Category'))
                                ->isActiveWhen(fn (): bool => request()->routeIs(
                                    'filament.admin.resources.categories.index',
                                    'filament.admin.resources.categories.create',
                                    'filament.admin.resources.categories.view',
                                    'filament.admin.resources.categories.edit'
                                ))
                                ->url(route('filament.admin.resources.categories.index')),
                            NavigationItem::make('Barang')
                                ->icon('heroicon-o-building-storefront')
                                ->visible(Auth::user()->can('Read Material'))
                                ->isActiveWhen(fn (): bool => request()->routeIs(
                                    'filament.admin.resources.materials.index',
                                    'filament.admin.resources.materials.create',
                                    'filament.admin.resources.materials.view',
                                    'filament.admin.resources.materials.edit'
                                ))
                                ->url(route('filament.admin.resources.materials.index')),
                        ]),
                ]);
            });
    }
}
