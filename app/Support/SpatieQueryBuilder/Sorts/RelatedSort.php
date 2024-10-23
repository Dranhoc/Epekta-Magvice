<?php

namespace App\Support\SpatieQueryBuilder\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\QueryBuilder\Sorts\Sort;

class RelatedSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        [$relationName, $columnName] = explode('.', $property) + [null, null];

        $relation = $query->getRelation($relationName);

        $columnName ??= 'name';

        if ($relation instanceof BelongsTo) {
            $subquery = $this->subQueryBelongsTo($relation, $columnName);
        } else {
            throw new \Exception('Not supported relation type.');
        }

        $query->orderBy($subquery, $descending ? 'desc' : 'asc');
    }

    protected function subQueryBelongsTo(BelongsTo $relation, string $columnName): Builder
    {
        $locale = app()->getLocale();

        return $relation
            ->getQuery()
            ->from($relation->getModel()->getTable().' as parent')
            ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(parent.{$columnName}, '$.{$locale}')) ")
            ->whereColumn($relation->getQualifiedForeignKeyName(), "parent.{$relation->getOwnerKeyName()}");
    }
}
