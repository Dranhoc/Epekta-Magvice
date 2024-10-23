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

class FormField extends Model implements Sortable
{
    use AllowedIncludeForModel;
    use HasFactory;
    use HasTranslations;
    use SortableTrait;

    protected $table = 'form_fields';

    protected $fillable = [
        'name',
        'label',
        'type',
        'placeholder',
        'column',
        'tooltip',
        'is_required',
        'has_multiple_choices',
        'prefix',
        'suffix',
        'is_and',
        'is_shown',
        'with_label',
        'model_reference',
    ];

    protected $casts = [
        'label' => 'json',
        'placeholder' => 'json',
        'tooltip' => 'json',
        'is_required' => 'boolean',
        'has_multiple_choices' => 'boolean',
        'is_and' => 'boolean',
        'is_shown' => 'boolean',
        'with_label' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected array $translatable = [
        'label',
        'tooltip',
        'placeholder',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(FieldOption::class)->orderBy('order_column');
    }

    public function rules(): HasMany
    {
        return $this->hasMany(FieldRule::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(FormSection::class, 'form_section_id');
    }
}
