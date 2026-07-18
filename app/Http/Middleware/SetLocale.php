<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolves {locale} from the URL and makes it the ambient default.
 *
 * URL::defaults() is the important part: it means route('home') inside a view
 * keeps the visitor in their current language without every call site having to
 * pass the locale explicitly.
 */
final class SetLocale
{
    public function __invoke(Request $request, Closure $next): Response
    {
        return $this->handle($request, $next);
    }

    public function handle(Request $request, Closure $next): Response
    {
        $supported = config('locales.supported', []);
        $locale    = (string) $request->route('locale');

        if (! array_key_exists($locale, $supported)) {
            $locale = (string) config('locales.default', 'ar');
        }

        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);

        // Carbon and number formatting should follow the page language too.
        setlocale(LC_TIME, (string) ($supported[$locale]['iso'] ?? $locale));

        return $next($request);
    }
}
