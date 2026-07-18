<?php

declare(strict_types=1);

use App\Services\SiteContent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Site helpers
|--------------------------------------------------------------------------
|
| Registered through composer's `autoload.files`. These are thin wrappers over
| the SiteContent singleton so Blade stays readable.
|
*/

if (! function_exists('site')) {
    /**
     * The shared read layer.
     */
    function site(): SiteContent
    {
        return app(SiteContent::class);
    }
}

if (! function_exists('setting')) {
    /**
     * A raw setting by "group.key".
     */
    function setting(string $path, mixed $default = null): mixed
    {
        return site()->setting($path, $default);
    }
}

if (! function_exists('setting_text')) {
    /**
     * A bilingual setting for the active locale, e.g. setting_text('home.hero_lead').
     */
    function setting_text(string $path, string $default = ''): string
    {
        return site()->text($path, $default);
    }
}

if (! function_exists('setting_list')) {
    /**
     * A bilingual setting split into a list on newlines.
     *
     * @return array<int, string>
     */
    function setting_list(string $path): array
    {
        return site()->list($path);
    }
}

if (! function_exists('image_url')) {
    /**
     * Resolve an image to a public URL.
     *
     * Order of preference: an absolute URL as given, then a file uploaded to the
     * public disk, then the repo-shipped asset of the same path, then the
     * configured fallback. This is what lets a fresh install look finished
     * before anyone has uploaded anything.
     */
    function image_url(?string $path, ?string $fallbackKey = 'fallback'): string
    {
        $path = trim((string) $path);

        if ($path !== '') {
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }

            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->url($path);
            }

            if (is_file(public_path($path))) {
                return asset($path);
            }
        }

        $fallback = (string) config("site.images.{$fallbackKey}", config('site.images.fallback'));

        return $fallback === '' ? '' : asset($fallback);
    }
}

if (! function_exists('locale_url')) {
    /**
     * The current route in another locale, used by the language switcher.
     * Falls back to that locale's home page when the route has no counterpart.
     */
    function locale_url(string $locale): string
    {
        $route = request()->route();

        if ($route === null) {
            return url("/{$locale}");
        }

        $name = $route->getName();

        if ($name === null || ! Route::has($name)) {
            return url("/{$locale}");
        }

        return route($name, array_merge($route->parameters(), ['locale' => $locale]));
    }
}
