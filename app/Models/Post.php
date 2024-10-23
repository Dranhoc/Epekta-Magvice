<?php

namespace App\Models;

use App\Models\Concerns\AllowedIncludeForModel;
use App\Models\Concerns\HasPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Post extends Model implements HasMedia
{
    use AllowedIncludeForModel;
    use HasPage;
    use HasTranslatableSlug;
    use HasTranslations;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'abstract',
        'body',
    ];

    protected $casts = [
        'title' => 'json',
        'abstract' => 'json',
        'body' => 'json',
        'slug' => 'json',
    ];

    protected array $translatable = [
        'title',
        'abstract',
        'body',
        'slug',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('illustration')
            ->acceptsMimeTypes(config('slym.media.mime-types.image'))
            ->singleFile();
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
    public function illustration(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'illustration');
    }
}
