<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * @property-read ?string $name
 * @property-read ?string $title
 * @property-read ?string $slug
 */
trait HasPage
{
    public function getUriAttribute($value): string
    {
        if (empty($value)) {
            $value = html_entity_decode($this->slug ?? '');
        }

        if (empty($value)) {
            $value = Str::slug(html_entity_decode($this->name ?? ''));
        }

        if (empty($value)) {
            $value = Str::slug(html_entity_decode($this->title ?? ''));
        }

        return $value;
    }

    public function page()
    {
        return Cache::store('array')->rememberForever('page_model_'.static::class, function () {
            return Page::where('model', static::class)->firstOrNew();
        });
    }

    public function getUrl($locale = null, $withDomain = true): string
    {
        $locale = $locale ?? $this->getLocale();

        $route = $locale.'/';

        if ($this->page()->exists) {
            $route .= $this->page()->translate('slug', $locale).'/';
        }

        if (method_exists($this, 'customPage') && $this->customPage()) {
            $route .= $this->customPage()->getUrl($locale, false).'/';
        }

        $route .= $this->uri;

        if ($this->disableIdInUrl() === false) {
            $route .= '/'.$this->id;
        }

        if ($withDomain === false) {
            return $route;
        }

        return url($route);
    }

    protected function disableIdInUrl(): bool
    {
        if (property_exists($this, 'disableIdInUrl') === false) {
            return false;
        }

        return $this->disableIdInUrl;
    }

    public function scopeBySlug(Builder $query, string $slug, ?string $locale = null): void
    {
        $locale ??= app()->getLocale();

        $query->whereRaw("JSON_EXTRACT(slug, '$.{$locale}') = :slug", ['slug' => $slug]);
    }

    public function scopeByTitle(Builder $query, string $title, ?string $locale = null): void
    {
        $locale ??= app()->getLocale();

        $query->whereRaw("JSON_EXTRACT(title, '$.{$locale}') = :title", ['title' => $title]);
    }
}
