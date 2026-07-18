<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Supported locales
    |--------------------------------------------------------------------------
    |
    | Arabic is the default and the first-class language of the site; English is
    | an equal peer, not a translation afterthought. The first key is the default
    | locale that "/" redirects to.
    |
    */

    'supported' => [
        'ar' => [
            'name'      => 'العربية',
            'native'    => 'العربية',
            'english'   => 'Arabic',
            'direction' => 'rtl',
            'html_lang' => 'ar',
            'iso'       => 'ar_SA',
        ],
        'en' => [
            'name'      => 'English',
            'native'    => 'English',
            'english'   => 'English',
            'direction' => 'ltr',
            'html_lang' => 'en',
            'iso'       => 'en_US',
        ],
    ],

    'default' => 'ar',

];
