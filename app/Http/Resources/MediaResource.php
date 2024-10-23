<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @mixin Media
 */
class MediaResource extends BaseResource
{
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
            'order_column' => $this->order_column,
            'uuid' => $this->uuid,
            'name' => $this->file_name,
            'size' => $this->size,
            'type' => $this->mime_type,
            'url' => $this->hasGeneratedConversion('base') ? $this->getUrl('base') : $this->getUrl(),
            'customProperties' => $this->custom_properties,
            'responsiveUrls' => $this->hasResponsiveImages('base') ? $this->getResponsiveImageUrls('base') : $this->getResponsiveImageUrls(),
        ];
    }
}
