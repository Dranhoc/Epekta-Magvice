<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormResponseResource extends JsonResource
{
    public function withAutoLoadRelations(?string $includes = null): self
    {
        $this
            ->allowedIncludes(['answers', 'answers.file', 'user', 'form', 'form.steps', 'form.steps.sections', 'form.steps.sections.fields', 'form.steps.sections.fields.options', 'form.steps.sections.fields.rules', 'form.steps.sections.fields.rules.option'])
            ->autoLoad($includes);

        return $this;
    }

    public function toArray($request): array
    {
        return parent::toArray($request) + [
            'id' => $this->id,
            'sum' => $this->sum,
            'order_id' => $this->order_id,
            'form' => FormResource::make($this->whenLoaded('form')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'answers' => ResponseAnswersCollection::make($this->whenLoaded('answers')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
