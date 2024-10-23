<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormFieldResource extends JsonResource
{
    public function withAutoLoadRelations(?string $includes = null): self
    {
        $this
            ->allowedIncludes(['options', 'rules', 'rules.option'])
            ->autoLoad($includes);

        return $this;
    }

    public function toArray($request): array
    {
        return parent::toArray($request) + [
            'id' => $this->id,
            'name' => $this->name,
            'label' => $this->label,
            'type' => $this->type,
            'is_required' => $this->is_required,
            'has_multiple_choices' => $this->has_multiple_choices,
            'prefix' => $this->prefix,
            'suffix' => $this->suffix,
            'model_reference' => $this->model_reference,
            'is_and' => $this->is_and,
            'is_shown' => $this->is_shown,
            'with_label' => $this->with_label,
            'options' => FormSectionCollection::make($this->whenLoaded('options')),
            'rules' => FormSectionCollection::make($this->whenLoaded('rules')),
            'form_section_id' => $this->form_section_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
