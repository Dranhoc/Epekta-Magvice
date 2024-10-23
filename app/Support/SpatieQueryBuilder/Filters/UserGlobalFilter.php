<?php

declare(strict_types=1);

namespace App\Support\SpatieQueryBuilder\Filters;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

/**
 * @implements Filter<User>
 */
class UserGlobalFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function (Builder $query) use ($value) {
            $query->where('firstname', 'LIKE', '%'.$value.'%')
                ->orWhere('lastname', 'LIKE', '%'.$value.'%')
                ->orWhere('cursus', 'LIKE', '%'.$value.'%');
        });
    }
}
