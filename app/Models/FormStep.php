<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\AllowedIncludeForModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class FormStep extends Model
{
    use AllowedIncludeForModel;
    use HasFactory;
    use HasTranslations;

    protected $table = 'form_steps';

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

    public function sections(): hasMany
    {
        return $this->hasMany(FormSection::class);
    }
}
