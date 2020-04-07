<?php

namespace App\Http\Requests\Api\User\SignUp;

use Illuminate\Foundation\Http\FormRequest;

class CheckCodeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required'
        ];
    }
}
