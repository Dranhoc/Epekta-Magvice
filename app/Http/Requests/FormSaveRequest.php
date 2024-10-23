<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormSaveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'name.fr' => ['required'],
            'is_summable' => '',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
