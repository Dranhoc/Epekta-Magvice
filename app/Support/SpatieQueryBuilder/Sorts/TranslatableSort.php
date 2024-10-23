<?php

namespace App\Support\SpatieQueryBuilder\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class TranslatableSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $locale = app()->getLocale();

        $query->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT({$property}, '$.{$locale}')) ".($descending ? 'desc' : 'asc'));
    }
}
