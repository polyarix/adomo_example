<?php

namespace App\Http\Requests\Api\User\Cabinet\Verification;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'passport_series' => 'required|min:10|max:10',
            'registration' => 'required|min:5',
            'criminal_record' => 'required|boolean',
        ];
    }
}
