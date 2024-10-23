<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactSendRequest extends FormRequest
{
    public function rules()
    {
        return [
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['required'],
            'speciality' => ['nullable'],
            'phone' => ['nullable'],
            'subject' => ['required'],
            'body' => ['required'],
            'withNewsletter' => ['nullable'],
        ];
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();

        return $url->previous().'#contact-form';
    }

    public function messages(): array
    {
        return [
            'firstname.required' => 'Le champ prénom est obligatoire',
            'lastname.required' => 'Le champ nom est obligatoire',
            'email.required' => 'Le champ email est obligatoire',
            'subject.required' => 'Le champ sujet est obligatoire',
            'body.required' => 'Le champ message est obligatoire',
        ];
    }
}
