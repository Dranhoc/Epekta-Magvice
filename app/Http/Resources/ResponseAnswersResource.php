<?php

namespace App\Http\Resources;

class ResponseAnswersResource extends BaseResource
{
    public function withAutoLoadRelations(?string $includes = null): self
    {
        $this
            ->allowedIncludes(['file'])
            ->autoLoad($includes);

        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return parent::toArray($request) + [
            'id' => $this->id,
            'file' => MediaResource::make($this->whenLoaded('file')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
