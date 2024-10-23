<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Publication;

/**
 * @mixin Publication
 */
class PostResource extends BaseResource
{
    public function withAutoLoadRelations(?string $includes = null): self
    {
        $this
            ->allowedIncludes(['illustration'])
            ->autoLoad($includes);

        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return parent::toArray($request) + [
            'id' => $this->id,
            'title' => $this->title,
            'abstract' => $this->abstract,
            'body' => $this->body,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
