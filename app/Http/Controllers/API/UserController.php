<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Support\SpatieQueryBuilder\Filters\UserGlobalFilter;
use App\Support\SpatieQueryBuilder\Sorts\FieldSort;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class UserController
{
    public function index(Request $request): UserCollection
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters(['id', 'email', 'role', AllowedFilter::custom('global', new UserGlobalFilter)])
            ->defaultSort('id')
            ->allowedSorts(['id', 'email', AllowedSort::custom('ids_field', new FieldSort, 'id')])
            ->paginate($request->get('per_page', 15))
            ->appends($request->query());

        return new UserCollection($users);
    }

    public function store(UserStoreRequest $request): UserResource
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' => $request->get('role'),
            'password' => Hash::make($request->get('password')),
        ]);

        return new UserResource($user);
    }

    public function show(Request $request, User $user): BaseResource
    {
        return (new UserResource($user))->withAutoLoadRelations($request->get('include'));
    }

    public function update(UserUpdateRequest $request, User $user): BaseResource
    {
        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' => $request->get('role'),
        ]);

        if ($request->get('password')) {
            $user->update(['password' => Hash::make($request->get('password'))]);
        }

        return (new UserResource($user))->withAutoLoadRelations($request->get('include'));
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}
