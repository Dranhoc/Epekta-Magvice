<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageStoreRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'unique:pages,title'],
            'slug' => '',
            'content' => '',
            'template' => '',
            'method' => '',
            'seo_title' => '',
            'seo_description' => '',
            'seo_type' => '',
        ];
    }
}
