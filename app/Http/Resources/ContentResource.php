<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Content;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Content
 */
class ContentResource extends JsonResource
{
    public function withAutoLoadRelations(?string $includes = null): self
    {
        $this
            ->allowedIncludes(['picture', 'page'])
            ->autoLoad($includes);

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return parent::toArray($request) + [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'content' => $this->content,
            'summary' => $this->summary(),
            'source_file' => $this->source_file,
            'type' => $this->type,
            'picture' => MediaResource::make($this->whenLoaded('picture')),
            'page_id' => $this->page_id,
            'page' => PageResource::make($this->whenLoaded('page')),
        ];
    }
}
