<?php

return [
    'disk' => env('FILEPOND_DISK', 'public'),

    'temp_disk' => 'local',
    'temp_folder' => 'tmp',

    'middleware' => [
        'api', 'auth:sanctum',
    ],

    'soft_delete' => false,

    'expiration' => 30,

    'controller' => RahulHaque\Filepond\Http\Controllers\FilepondController::class,

    'validation_rules' => [
        'required',
        'file',
        'max:450000',
    ],

    'server' => [
        'url' => env('FILEPOND_URL', 'api/filepond'),
    ],
];
