<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;

class PageSaveRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required', (new Unique('pages', 'title'))->ignore($this->page)],
            'slug' => ['nullable'],
            'content' => ['nullable'],
            'template' => ['nullable'],
            'method' => ['nullable'],
            'seo_title' => ['nullable'],
            'seo_description' => ['nullable'],
            'seo_type' => ['nullable'],
        ];
    }
}
