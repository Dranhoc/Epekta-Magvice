<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Page;

/**
 * @mixin Page
 */
class PageResource extends BaseResource
{
    public function withAutoLoadRelations(?string $includes = null): self
    {
        $this
            ->allowedIncludes(['slider', 'seo_image'])
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
            'content' => $this->content,
            'slug' => $this->slug,
            'template' => $this->template,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'seo_type' => $this->seo_type,
            'seo_image' => MediaResource::make($this->whenLoaded('seo_image')),
            'method' => $this->method,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'slider' => MediaCollection::make($this->whenLoaded('slider')),
            'url' => $this->getUrl(),
        ];
    }
}
