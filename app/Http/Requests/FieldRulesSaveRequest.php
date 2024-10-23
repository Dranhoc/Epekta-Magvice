<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FieldRulesSaveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'operator' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
