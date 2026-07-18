<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pins the admin panel to English / LTR.
 *
 * The public site defaults to Arabic and RTL. Without this, /admin inherits that
 * and Filament's chrome flips -- which fights the bilingual editing forms, where
 * Arabic and English fields sit side by side and need a stable frame around
 * them. The content being edited is still bilingual; only the panel is not.
 */
final class SetPanelLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        App::setLocale('en');

        return $next($request);
    }
}
