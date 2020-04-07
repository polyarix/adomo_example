<?php

namespace App\Http\Requests\Api\User\SignUp;

use Illuminate\Foundation\Http\FormRequest;

class FillProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'about' => 'required',
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'birth_date' => 'required|date_format:d-m-Y',
            'city' => 'required|exists:cities,id',
            'password' => 'required|min:6|confirmed',
            'sex' => 'required|numeric',
        ];
    }
}
