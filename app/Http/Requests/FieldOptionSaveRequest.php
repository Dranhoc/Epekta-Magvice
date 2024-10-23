<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FieldOptionSaveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'value' => ['required'],
            'price' => '',
            'amount' => '',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
