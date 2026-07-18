<?php

declare(strict_types=1);

/*
| Fallback meta only. Anything set in the dashboard (settings group "pages" or
| "seo") wins over these -- see App\Support\PageMeta.
*/

return [
    'about' => [
        'title'       => 'About',
        'description' => 'The training, the kitchens, and the standards behind the plate.',
    ],
    'portfolio' => [
        'title'       => 'Portfolio',
        'description' => 'Hot and cold dishes plated and photographed in working kitchens.',
    ],
    'experience' => [
        'title'       => 'Experience',
        'description' => 'Executive chef, control chef and hotel kitchen roles in full.',
    ],
    'services' => [
        'title'       => 'Services',
        'description' => 'Menu development, kitchen management, cost control and food safety.',
    ],
    'contact' => [
        'title'       => 'Contact',
        'description' => 'Available for restaurant and hotel roles in Riyadh and the Kingdom.',
    ],
];
