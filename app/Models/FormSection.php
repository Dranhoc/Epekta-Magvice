<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\AllowedIncludeForModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class FormSection extends Model
{
    use AllowedIncludeForModel;
    use HasFactory;
    use HasTranslations;

    protected $table = 'form_sections';

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'name' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected array $translatable = [
        'name',
    ];

    public function fields(): hasMany
    {
        return $this->hasMany(FormField::class)->orderBy('order_column');
    }
}
