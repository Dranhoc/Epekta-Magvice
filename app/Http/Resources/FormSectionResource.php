<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormSectionResource extends JsonResource
{
    public function withAutoLoadRelations(?string $includes = null): self
    {
        $this
            ->allowedIncludes(['fields'])
            ->autoLoad($includes);

        return $this;
    }

    public function toArray($request): array
    {
        return parent::toArray($request) + [
            'id' => $this->id,
            'name' => $this->name,
            'form_step_id' => $this->form_step_id,
            'test' => 'test',
            'fields' => FormFieldCollection::make($this->whenLoaded('fields')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
