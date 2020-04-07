<?php

namespace App\Http\Requests\Api\User\SignUp;

use Illuminate\Foundation\Http\FormRequest;

class CheckEmailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email'
        ];
    }
}
