<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Livewire\LoginCostume;
use App\Livewire\ProfileCostume;
use App\Livewire\UpdatePasswordCostume;
use Filament\Forms\Components\FileUpload;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Firefly\FilamentBlog\Blog;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\View\View;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Rmsramos\Activitylog\ActivitylogPlugin;
use SolutionForest\FilamentSimpleLightBox\SimpleLightBoxPlugin;
use Tapp\FilamentAuthenticationLog\FilamentAuthenticationLogPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->registration()
            ->passwordReset()
            ->colors([
                'primary' => Color::rgb('rgb(22, 78, 99)'),
                'danube' => Color::rgb('rgb(124, 166, 216)'),
                'danger2' => Color::rgb('rgb(232, 75, 80)'),
                'wisteria' => Color::rgb('rgb(175, 127, 182)'),
                'grey' => Color::rgb('rgb(63, 63, 70)'),
                'breaker' => Color::rgb('rgb(77, 134, 141)'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->navigationGroups([
                'Blog',
                'Pidum',
                'Pidsus',
                'Settings',
                'Filament Shild',
                'Development',
            ])
            ->pages([
                Pages\Dashboard::class,
            ])
            ->resources([
                config('filament-logger.activity_resource')
            ])
            ->plugins([
                BreezyCore::make()
                    ->myProfileComponents(['personal_info' => ProfileCostume::class, 'update_password' => UpdatePasswordCostume::class])
                    ->myProfile(
                        shouldRegisterUserMenu: true, // Sets the 'account' link in the panel User Menu (default = true)
                        shouldRegisterNavigation: true, // Adds a main navigation item for the My Profile page (default = false)
                        navigationGroup: 'Settings', // Sets the navigation group for the My Profile page (default = null)
                        hasAvatars: true, // Enables the avatar upload form component (default = false)
                        slug: 'my-profile' // Sets the slug for the profile page (default = 'my-profile')
                    )
                    ->avatarUploadComponent(fn() => FileUpload::make('profile_photo_path')->disk('profile-photos'))
                    ->enableSanctumTokens(
                        // permissions: ['my','custom','permissions'] // optional, customize the permissions (default = ["create", "view", "update", "delete"])
                    ),
                FilamentApexChartsPlugin::make(),
                SimpleLightBoxPlugin::make(),
                Blog::make(),
                \BezhanSalleh\FilamentExceptions\FilamentExceptionsPlugin::make(),
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
                // ActivitylogPlugin::make()
                //     // ->resource(\Path\For\Your\CustomResource::class)
                //     ->label('Log')
                //     ->pluralLabel('Logs')
                //     ->navigationGroup('Development')
                //     ->navigationIcon('heroicon-o-shield-check')
                //     ->navigationCountBadge(true)
                //     ->navigationSort(2),
                // FilamentAuthenticationLogPlugin::make(),
            ])
            ->authGuard('web')
            ->viteTheme('resources/css/filament/admin/theme.css')
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
            ->favicon(asset('images/Pagimana_Logo.ico'))
            ->brandLogo(asset('images/logo_ckn_pagimana.png'))
            ->brandLogoHeight('5rem')
            ->renderHook(
                PanelsRenderHook::FOOTER,
                fn (): View => view('hooks.footer'),
            )
            ->renderHook(
                PanelsRenderHook::BODY_START,
                fn (): View => view('hooks.loader'),
            );
    }
}
