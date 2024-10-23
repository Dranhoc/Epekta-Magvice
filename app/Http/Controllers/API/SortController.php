<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\SortRequest;
use Illuminate\Http\JsonResponse;
use Str;

class SortController
{
    public function __invoke(SortRequest $request, string $resource): JsonResponse
    {
        $resourceClass = (string) Str::of($resource)->studly()->singular()->prepend('\\App\\Models\\');

        if (method_exists($resourceClass, 'setNewOrder') === false) {
            return response()->json([
                'status' => 'error',
                'message' => __('Resource not sortable !'),
            ]);
        }

        $resourceClass::setNewOrder($request->ids);

        return response()->json([
            'status' => 'Ok',
            'message' => __('Resource sorted !'),
        ]);
    }
}
