<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\AllowedIncludeForModel;
use App\Models\Concerns\HasPage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Form extends Model implements HasMedia
{
    use AllowedIncludeForModel;
    use HasFactory;
    use HasPage;
    use HasTranslatableSlug;
    use HasTranslations;
    use InteractsWithMedia;

    protected array $translatable = ['name', 'slug'];

    protected $fillable = [
        'name',
        'slug',
        'is_summable',
    ];

    protected $casts = [
        'name' => 'json',
        'slug' => 'json',
        'is_summable' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function steps(): hasMany
    {
        return $this->hasMany(FormStep::class);
    }

    public function responses(): hasMany
    {
        return $this->hasMany(FormResponse::class);
    }

    public function export(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'export');
    }

    public function exportUrl(): string
    {
        return ($this->export) ? $this->export->getFullUrl() : '';
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('export')
            ->useDisk('private')
            ->singleFile();
    }
}
