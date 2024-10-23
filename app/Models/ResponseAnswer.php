<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ResponseAnswer extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'locale',
        'value',
        'price',
    ];

    protected $casts = [
        'price' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function field(): belongsTo
    {
        return $this->belongsTo(FormField::class, 'form_field_id');
    }

    public function option(): belongsTo
    {
        return $this->belongsTo(FieldOption::class, 'field_option_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('file')
            ->singleFile();
    }

    public function file(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'file');
    }
}
