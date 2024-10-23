<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FieldRuleResource extends JsonResource
{
    public function withAutoLoadRelations(?string $includes = null): self
    {
        $this
            ->allowedIncludes(['option'])
            ->autoLoad($includes);

        return $this;
    }

    public function toArray($request): array
    {
        return parent::toArray($request) + [
            'id' => $this->id,
            'operator' => $this->operator,
            'option' => FieldOptionResource::make($this->whenLoaded('option')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
