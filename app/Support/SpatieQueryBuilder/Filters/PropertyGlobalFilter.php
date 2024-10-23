<?php

declare(strict_types=1);

namespace App\Support\SpatieQueryBuilder\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

/**
 * @implements Filter<Model>
 */
class PropertyGlobalFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        /** @var string $jsonValue */
        $jsonValue = json_encode($value);

        $query->where(function (Builder $query) use ($value, $jsonValue) {
            $query->whereRaw('name LIKE ?', ['%'.$value.'%'])
                ->orWhereRaw("JSON_UNQUOTE(REGEXP_REPLACE(content, '<[^>]*>', '')) LIKE ?", ['%'.trim($jsonValue, '"').'%'])
                ->orWhereRaw("JSON_UNQUOTE(REGEXP_REPLACE(title, '<[^>]*>', '')) LIKE ?", ['%'.trim($jsonValue, '"').'%']);
        });
    }
}
