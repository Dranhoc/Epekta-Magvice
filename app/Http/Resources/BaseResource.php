<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Content;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseResource extends JsonResource
{
    public function withAutoLoadRelations(?string $includes = null): self
    {
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
        if (method_exists($this->resource, 'getTranslations') === false) {
            return [];
        }

        if ($request->get('translatable', false) === false) {
            return [];
        }

        /** @var Content|Category|Setting|Page $model */
        $model = $this->resource;

        $translations = $model->getTranslations();

        $locales = config('slym.locales');

        foreach ($translations as $key => $translation) {
            foreach ($locales as $locale) {
                $translations[$key][$locale] = empty($translations[$key][$locale]) ? '' : $translations[$key][$locale];
            }
        }

        return [
            'translatable' => $translations,
        ];
    }
}
