<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;

class ConfigController
{
    public function __invoke(): JsonResponse
    {
        $config = [];

        return response()->json($config);
    }
}
