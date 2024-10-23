<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Setting;

/**
 * @mixin Setting
 */
class SettingResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return parent::toArray($request) + [
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}
