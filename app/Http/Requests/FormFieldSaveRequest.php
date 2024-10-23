<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormFieldSaveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [''],
            'label' => ['required'],
            'type' => [''],
            'column' => [''],
            'placeholder' => [''],
            'tooltip' => [''],
            'has_multiple_choices' => [''],
            'is_required' => [''],
            'prefix' => '',
            'suffix' => '',
            'model_reference' => '',
            'is_and' => '',
            'is_shown' => '',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
