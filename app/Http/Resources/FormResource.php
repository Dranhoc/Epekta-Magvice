<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormResource extends JsonResource
{
    public function withAutoLoadRelations(?string $includes = null): self
    {
        $this
            ->allowedIncludes(['steps', 'steps.sections', 'steps.sections.fields', 'steps.sections.fields.options', 'steps.sections.fields.rules', 'steps.sections.fields.rules.option', 'responses'])
            ->autoLoad($includes);

        return $this;
    }

    public function toArray($request): array
    {
        return parent::toArray($request) + [
            'id' => $this->id,
            'name' => $this->name,
            'steps' => FormStepCollection::make($this->whenLoaded('steps')),
            'responses' => FormResponseCollection::make($this->whenLoaded('responses')),
            'is_summable' => $this->is_summable,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
