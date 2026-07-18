<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Fallback imagery
    |--------------------------------------------------------------------------
    |
    | image_url() resolves an uploaded path on the public disk first, and falls
    | back to these repo-shipped assets. That means a fresh install looks
    | complete before anyone has touched the dashboard.
    |
    */

    'images' => [
        'portrait' => 'images/portrait.png',
        'og'       => 'images/dishes/beef-wellington.jpeg',
        'fallback' => 'images/dishes/beef-wellington.jpeg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | The settings map is a plain array, so it is safe to cache persistently.
    | Eloquent collections are NOT cached here -- see SiteContent for why.
    |
    */

    'cache' => [
        'key' => 'site.settings.map',
        'ttl' => 60 * 60 * 24 * 30,
    ],

];
