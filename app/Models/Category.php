<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\AllowedIncludeForModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Category extends BaseModel implements Sortable
{
    use AllowedIncludeForModel;
    use HasFactory;
    use HasTranslatableSlug;
    use HasTranslations;
    use SortableTrait;

    protected $fillable = ['name', 'slug'];

    /** @var array<int, string> */
    protected array $translatable = [
        'name',
        'slug',
    ];

    protected $casts = [
        'name' => 'json',
        'slug' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * @return BelongsTo<Category, Category>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'category_id');
    }

    /**
     * @param  Builder<Category>  $query
     * @return Builder<Category>
     */
    public function scopeParentCategory(Builder $query): Builder
    {
        return $query->where('category_id', null);
    }

    /**
     * @return HasMany<Category>
     */
    public function categories(): hasMany
    {
        return $this->hasMany(Category::class);
    }
}
