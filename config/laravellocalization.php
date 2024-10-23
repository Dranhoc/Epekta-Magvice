<?php

return [
    'supportedLocales' => [
        'fr' => ['name' => 'French', 'script' => 'Latn', 'native' => 'français', 'regional' => 'fr_FR'],
    ],

    'useAcceptLanguageHeader' => false,

    'hideDefaultLocaleInURL' => false,

    'localesOrder' => ['fr'],

    'localesMapping' => [],

    'utf8suffix' => env('LARAVELLOCALIZATION_UTF8SUFFIX', '.UTF-8'),

    'urlsIgnored' => ['/api/*'],

    'httpMethodsIgnored' => ['POST', 'PUT', 'PATCH', 'DELETE'],
];
