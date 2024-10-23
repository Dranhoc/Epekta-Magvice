<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormStepResource extends JsonResource
{
    public function withAutoLoadRelations(?string $includes = null): self
    {
        $this
            ->allowedIncludes(['sections', 'sections.fields'])
            ->autoLoad($includes);

        return $this;
    }

    public function toArray($request): array
    {
        return parent::toArray($request) + [
            'id' => $this->id,
            'name' => $this->name,
            'sections' => FormSectionCollection::make($this->whenLoaded('sections')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
