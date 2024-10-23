<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ContentTypes;
use App\Models\Concerns\AllowedIncludeForModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Content extends BaseModel implements HasMedia, Sortable
{
    use AllowedIncludeForModel;
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;
    use SortableTrait;

    protected $fillable = ['name', 'title', 'sur_title', 'subtitle', 'content', 'picture_alt', 'type', 'source_file'];

    /** @var array<int, string> */
    protected array $translatable = ['title', 'sur_title', 'subtitle', 'content', 'picture_alt'];

    protected $casts = [
        'type' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function summary(): string
    {
        if ($this->type === ContentTypes::T->value) {
            return $this->alt('title');
        }

        if ($this->type === ContentTypes::IMAGE->value) {
            return '<img width="100px" src="'.$this->picture->getFullUrl().'" alt="'.$this->picture_alt.'" >';
        }

        return Str::limit($this->alt('content'), 250, '(...)');
    }

    /**
     * @return BelongsTo<Page, Content>
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function typeName(): null|int|string
    {
        return ContentTypes::label($this->type);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo<Model, Content>
     */
    public function contentable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return MorphOne<Media>
     */
    public function picture(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'picture');
    }

    public function pictureUrl(): string
    {
        return ($this->picture) ? $this->picture->getFullUrl() : '';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('picture')
            ->withResponsiveImages()
            ->acceptsMimeTypes(config('slym.media.mime-types.image'))
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('normal')
            ->withResponsiveImages()
            ->performOnCollections('picture');

        $this->addMediaConversion('webp')
            ->withResponsiveImages()
            ->performOnCollections('picture')
            ->format('webp');
    }
}
