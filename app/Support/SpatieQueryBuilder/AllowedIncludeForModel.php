<?php

namespace App\Support\SpatieQueryBuilder;

use Closure;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\Includes\IncludedCallback;

class AllowedIncludeForModel extends AllowedInclude
{
    protected ?Closure $callbackFn = null;

    public function getCallbackFn(): ?Closure
    {
        return $this->callbackFn;
    }

    public function setCallbackFn(Closure $callback): static
    {
        $this->callbackFn = $callback;

        return $this;
    }

    public static function callback(string $name, Closure $callback, ?string $internalName = null): Collection
    {
        return collect([
            (new self($name, new IncludedCallback($callback), $internalName))->setCallbackFn($callback),
        ]);
    }
}
