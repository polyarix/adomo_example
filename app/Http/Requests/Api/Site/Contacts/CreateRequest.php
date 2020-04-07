<?php

namespace App\Http\Requests\Api\Site\Contacts;

use App\Entity\Contact\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|min:2',
            'phone' => ['required_if:type,' . Contact::TYPE_REQUEST, 'regex:/\+\d+\s\([0-9]{3}\)\s([0-9]{3})\s([0-9]{2})\s([0-9]{2})/'],
            'text' => 'required|min:10',
            'email' => 'required|email',
            'type' => ['required', Rule::in(array_keys(Contact::getTypesList()))]
        ];

        if(config('recaptcha-v3.enable')) {
            $rules[config('recaptcha-v3.input_name', 'g-recaptcha-response')] = 'required|recaptcha:contacts';
        }

        return $rules;
    }
}
