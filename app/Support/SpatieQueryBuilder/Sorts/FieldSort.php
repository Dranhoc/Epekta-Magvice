<?php

namespace App\Support\SpatieQueryBuilder\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class FieldSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $direction = $descending ? 'DESC' : 'ASC';

        $sortFields = request()?->input('sort_ids_fields');

        if (empty($sortFields)) {
            return;
        }

        $sortFields = explode(',', $sortFields);
        $sortFields = array_map('intval', $sortFields);

        $query->orderByRaw("FIELD(`{$property}`, ".implode(',', $sortFields).") {$direction}");
    }
}
