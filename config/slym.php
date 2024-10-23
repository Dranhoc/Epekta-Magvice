<?php

return [

    'tools' => [
        'marker' => [
            'id' => env('MARKER_ID'),
        ],
    ],

    'sitemap' => [
        \App\Models\Page::class => ['priority' => 0.9],
        \App\Models\Post::class => ['priority' => 0.9],
    ],

    'media' => [
        'mime-types' => [
            'image' => ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'],
            'video' => ['video/mp4', 'video/ogg', 'video/x-msvideo', 'video/x-m4v'],
            'pdf' => ['application/pdf'],
            'css' => ['text/css', 'text/plain'],
            'file' => ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'application/pdf', 'video/mp4', 'video/ogg', 'video/x-msvideo', 'video/x-m4v'],
        ],
    ],

    'staging' => [
        'root' => env('STAGING_ROOT'),
        'mail_always_to_address' => env('MAIL_ALWAYS_TO_ADDRESS'),
    ],

    'production' => [
        'root' => env('PRODUCTION_ROOT'),
    ],

    'locales' => [
        'fr',
    ],
];
