<?php

declare(strict_types=1);

namespace App\Support\SpatieQueryBuilder\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

/**
 * @implements Filter<Model>
 */
class FiltersJsonField implements Filter
{
    /**
     * @return Builder<Model>
     */
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        $locale = request()->get('locale', 'en');

        return $query->where("{$property}->{$locale}", $value);
    }
}
