<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\AllowedIncludeForModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Mcamara\LaravelLocalization\Interfaces\LocalizedUrlRoutable;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

/**
 * @property-read string $slug
 */
class Page extends BaseModel implements HasMedia, LocalizedUrlRoutable
{
    use AllowedIncludeForModel;
    use HasFactory;
    use HasTranslatableSlug;
    use HasTranslations;
    use InteractsWithMedia;

    /** @var array<int, string> */
    protected array $translatable = ['title', 'content', 'slug', 'seo_title', 'seo_description'];

    protected $fillable = ['title', 'content', 'slug', 'template', 'seo_title', 'seo_description', 'seo_type', 'seo_image', 'method'];

    protected $casts = [
        'slug' => 'json',
        'title' => 'json',
        'content' => 'json',
        'seo_title' => 'json',
        'seo_description' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getUrl(?string $locale = null, bool $withDomain = true): string
    {
        $locale = $locale ?? $this->getLocale();

        $route = $locale.'/';

        $slug = $this->translate('slug', $locale);

        if ($slug === 'home') {
            $slug = '';
        }

        $route .= $slug;

        if ($withDomain === false) {
            return $route;
        }

        return url($route);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null): self
    {
        if (is_numeric($value) && (! request()->is('api/*') && ! request()->is('*/api/*'))) {
            abort(401);
        }

        return $this->where($this->getRouteKeyName().'->'.app()->getLocale(), $value)->orWhere('id', $value)->firstOrFail();
    }

    /**
     * @param  ?string  $locale
     */
    public function getLocalizedRouteKey($locale): mixed
    {
        /** @var string $localeString */
        $localeString = $locale;

        return $this->getTranslation('slug', $localeString, true);
    }

    /**
     * @return HasMany<Content>
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('seo_image')
            ->acceptsMimeTypes(config('slym.media.mime-types.image'))
            ->singleFile();

        $this->addMediaCollection('slider')
            ->acceptsMimeTypes(config('slym.media.mime-types.file'));
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('base')
            ->withResponsiveImages()
            ->fit(Fit::Max, 1920, 1080);
    }

    /**
     * @return MorphOne<Media>
     */
    public function seo_image(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'seo_image');
    }

    /**
     * @return MorphMany<Media>
     */
    public function slider(): MorphMany
    {
        return $this->morphMany(Media::class, 'model')->where('collection_name', 'slider')->orderBy('order_column');
    }

    public function form(): belongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function scopeWhereTranslatedSlug(Builder $query, string $slug, $locale = null): void
    {
        $locale ??= $this->getLocale();

        $slug = str_replace('/', '%', $slug);

        $query->whereRaw("JSON_EXTRACT(slug, '$.$locale') LIKE '\"$slug\"'");
    }
}
