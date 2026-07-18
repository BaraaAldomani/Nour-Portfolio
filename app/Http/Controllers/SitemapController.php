<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;

/**
 * sitemap.xml and robots.txt.
 *
 * Every URL is emitted once per locale with xhtml:link alternates pointing at
 * its counterparts, which is what tells a crawler these are translations of one
 * page rather than duplicate content.
 */
final class SitemapController extends Controller
{
    /**
     * Routes that belong in the sitemap, in priority order.
     *
     * @var array<string, string>
     */
    private const ROUTES = [
        'home'       => '1.0',
        'portfolio'  => '0.9',
        'about'      => '0.8',
        'experience' => '0.8',
        'services'   => '0.8',
        'contact'    => '0.7',
    ];

    public function index(): Response
    {
        $locales = array_keys(config('locales.supported', []));

        $entries = [];

        foreach (self::ROUTES as $name => $priority) {
            foreach ($locales as $locale) {
                $alternates = [];

                foreach ($locales as $alternate) {
                    $alternates[$alternate] = route($name, ['locale' => $alternate]);
                }

                $entries[] = [
                    'loc'        => route($name, ['locale' => $locale]),
                    'priority'   => $priority,
                    'alternates' => $alternates,
                    'default'    => $alternates[config('locales.default', 'ar')] ?? reset($alternates),
                ];
            }
        }

        return response()
            ->view('sitemap', ['entries' => $entries])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $body = implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            '',
            'Sitemap: '.route('sitemap'),
            '',
        ]);

        return response($body)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
