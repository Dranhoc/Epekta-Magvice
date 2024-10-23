<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class BaseModel extends Model
{
    public function alt(string $key, string $default = ''): string
    {
        $value = strip_tags(html_entity_decode($this->{$key} ?? ''));

        if (empty($value)) {
            $value = $default;
        }

        return $value;
    }

    public function strLimit(string $key, int $limit = 100, string $end = ' (...)'): string
    {
        return Str::limit($this->alt($key), $limit, $end);
    }
}
