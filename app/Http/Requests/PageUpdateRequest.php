<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Unique;

class PageUpdateRequest extends FormRequest
{
    /**
     * @return array<string, array<int, Password|Unique|string>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'unique:pages,title,'.$this->page->id],
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
