<?php

namespace App\Support\SpatieQueryBuilder\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\Filters\Filter;

readonly class GlobalFilter implements Filter
{
    public function __construct(protected array $fields) {}

    public function __invoke(Builder $query, $values, string $property): void
    {
        $values = Arr::wrap($values);

        $query->where(function (Builder $query) use ($values) {

            foreach ($values as $value) {
                if (empty($value) || $value === 'null') {
                    continue;
                }

                $query->orWhere(function (Builder $query) use ($value) {
                    foreach ($this->fields as $key => $field) {

                        $valueSlugify = Str::slug($value);

                        if (is_array($field)) {
                            $query->orWhereHas($key, function ($query) use ($field, $value) {
                                $query->where(function ($query) use ($field, $value) {
                                    foreach ($field as $subField) {
                                        //$query->orWhere($subField, 'LIKE', "%{$value}%");
                                        $query->orWhereRaw("`{$subField}` COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$value}%"]);
                                    }
                                });
                            });

                            continue;
                        }

                        if (class_exists($field)) {
                            foreach ($field::toArray() as $idStatus => $labelStatus) {
                                if (Str::slug($labelStatus) === $valueSlugify) {
                                    $query->orWhere($key, $idStatus);
                                    break;
                                }
                            }

                            continue;
                        }

                        $query->orWhereRaw("`{$field}` COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$value}%"]);
                        // $query->orWhere($field, 'LIKE', "%{$value}%");
                    }
                });
            }
        });
    }
}
