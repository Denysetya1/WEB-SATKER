<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use Filament\Facades\Filament;
use Filament\Panel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PageController::class, 'welcome'])->name('landing');

// Route::get('login', 'loginView')->name('login.index');
// Route::get('admin/login', null)->name('login');

// foreach (Filament::getPanels() as $panel) {
//     /** @var Panel $panel */
//     $panelId = $panel->getId();
//     $hasTenancy = $panel->hasTenancy();
//     $tenantRoutePrefix = $panel->getTenantRoutePrefix();
//     $tenantDomain = $panel->getTenantDomain();
//     $tenantSlugAttribute = $panel->getTenantSlugAttribute();
//     $domains = $panel->getDomains();

//     foreach ((empty($domains) ? [null] : $domains) as $domain) {
//         Route::domain($domain)
//             ->middleware($panel->getMiddleware())
//             ->name("{$panelId}." . ((filled($domain) && (count($domains) > 1)) ? "{$domain}." : ''))
//             ->prefix($panel->getPath())
//             ->group(function () use ($panel, $hasTenancy, $tenantDomain, $tenantRoutePrefix, $tenantSlugAttribute) {
//                 foreach ($panel->getRoutes() as $routes) {
//                     $routes($panel);
//                 }

//                 Route::name('auth.')->group(function () use ($panel) {
//                     Route::get($panel->getLoginRouteSlug(), $panel->getLoginRouteAction())
//                         ->name('login');
//                 });
//             });
//     }
// }
