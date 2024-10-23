<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\FormResponseStatuses;
use App\Models\Concerns\AllowedIncludeForModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormResponse extends Model
{
    use AllowedIncludeForModel;
    use HasFactory;

    protected $fillable = [
        'sum',
        'with_newsletter',
    ];

    protected $casts = [
        //        'status' => FormResponseStatuses::class,
        //        'order_id' => 'integer',
        'with_newsletter' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected function withNewsletter(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => (bool) $value,
        );
    }

    public function answers(): hasMany
    {
        return $this->hasMany(ResponseAnswer::class);
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeUserName(Builder $query, $name): Builder
    {
        return $query->whereHas('user', function ($query) use ($name) {
            $query->where('firstname', 'like', '%'.$name.'%')
                ->orWhere('lastname', 'like', '%'.$name.'%');
        });
    }
}
