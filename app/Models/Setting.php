<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Setting extends BaseModel
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['key', 'value'];

    /** @var array<int, string> */
    protected array $translatable = ['value'];

    protected $casts = [
        'value' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
