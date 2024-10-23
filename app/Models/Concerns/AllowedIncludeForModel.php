<?php

namespace App\Models\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\Includes\IncludeInterface;

trait AllowedIncludeForModel
{
    /** @var \Illuminate\Support\Collection */
    protected $allowedIncludes;

    /** @var \Illuminate\Support\Collection */
    protected $includesToLoad;

    public function autoLoad(?string $includes = null)
    {
        $this->setIncludesToLoad(
            new Collection(
                explode(',', $includes)
            )
        );

        $relations = ['load' => [], 'loadCount' => []];
        $this->includesToLoad->filter()->each(function (AllowedInclude $include) use (&$relations) {
            $relationName = Str::beforeLast($include->getName(), 'Count');

            if ($relationName === $include->getName()) {

                if ($include instanceof \App\Support\SpatieQueryBuilder\AllowedIncludeForModel
                    && $include->getCallbackFn() !== null
                ) {
                    $relations['load'][$relationName] = $include->getCallbackFn();
                } else {
                    $relations['load'][] = $relationName;
                }

                return;
            }

            $relations['loadCount'][] = $relationName;
        });

        if (! empty($relations['load'])) {
            $this->load($relations['load']);
        }

        if (! empty($relations['loadCount'])) {
            $this->loadCount($relations['load']);
        }

        return $this;
    }

    public function allowedIncludes($includes): self
    {
        $includes = is_array($includes) ? $includes : func_get_args();

        $this->allowedIncludes = collect($includes)
            ->reject(function ($include) {
                return empty($include);
            })
            ->flatMap(function ($include): Collection {
                if ($include instanceof Collection) {
                    return $include;
                }

                if ($include instanceof IncludeInterface) {
                    return collect([$include]);
                }

                if (Str::endsWith($include, config('query-builder.count_suffix'))) {
                    return AllowedInclude::count($include);
                }

                return AllowedInclude::relationship($include);
            })
            ->unique(function (AllowedInclude $allowedInclude) {
                return $allowedInclude->getName();
            });

        return $this;
    }

    protected function setIncludesToLoad(Collection $includes): void
    {
        $this->includesToLoad = new Collection;

        $includes->each(function ($include) {
            $this->includesToLoad->add(
                $this->findInclude($include)
            );
        });
    }

    protected function findInclude(string $include): ?AllowedInclude
    {
        return $this->allowedIncludes
            ->first(function (AllowedInclude $included) use ($include) {
                return $included->isForInclude($include);
            });
    }
}
