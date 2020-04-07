<?php

namespace App\Http\Requests\Api\User\SignUp;

use App\Entity\User\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckDataRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'email' => 'required|email',
            'type' => ['required', Rule::in(array_keys(User::getTypes()))],
            'first_name' => 'required|min:2'
            //'phone' => 'required|min:16|max:16',
        ];

        if(config('recaptcha-v3.enable')) {
            $rules[config('recaptcha-v3.input_name', 'g-recaptcha-response')] = 'required|recaptcha:register';
        }

        return $rules;
    }
}
