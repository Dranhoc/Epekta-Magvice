<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\AllowedIncludeForModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class FieldOption extends Model implements Sortable
{
    use AllowedIncludeForModel;
    use HasFactory;
    use HasTranslations;
    use SortableTrait;

    protected $table = 'field_options';

    protected $fillable = [
        'label',
        'price',
        'amount',
    ];

    protected $casts = [
        'label' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected array $translatable = [
        'label',
    ];

    public function rules(): hasMany
    {
        return $this->hasMany(FieldRule::class);
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(FormField::class);
    }

    public function answers(): hasMany
    {
        return $this->hasMany(ResponseAnswer::class);
    }

    public function getTakenAttribute()
    {
        return 0;
    }
}
