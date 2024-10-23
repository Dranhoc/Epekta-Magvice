<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostSaveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'abstract' => ['required'],
            'body' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
