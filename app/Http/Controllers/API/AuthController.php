<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Resources\BaseResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function show(Request $request): BaseResource
    {
        return (new UserResource(Auth::user()))->withAutoLoadRelations($request->get('include'));
    }
}
