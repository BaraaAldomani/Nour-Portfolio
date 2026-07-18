<?php

declare(strict_types=1);

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

/*
| The bare root is not a page -- it permanently redirects into the default
| language so there is exactly one canonical URL for the home page.
*/
Route::redirect('/', '/'.config('locales.default', 'ar'), 301);

Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('robots.txt', [SitemapController::class, 'robots'])->name('robots');

Route::prefix('{locale}')
    ->whereIn('locale', array_keys(config('locales.supported', [])))
    ->middleware(SetLocale::class)
    ->group(function (): void {
        Route::get('/', [PageController::class, 'home'])->name('home');
        Route::get('about', [PageController::class, 'about'])->name('about');
        Route::get('portfolio', [PageController::class, 'portfolio'])->name('portfolio');
        Route::get('experience', [PageController::class, 'experience'])->name('experience');
        Route::get('services', [PageController::class, 'services'])->name('services');

        Route::get('contact', [ContactController::class, 'show'])->name('contact');
        Route::post('contact', [ContactController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('contact.store');
    });
