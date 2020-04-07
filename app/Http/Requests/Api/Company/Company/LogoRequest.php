<?php

namespace App\Http\Requests\Api\Company\Company;

use Illuminate\Foundation\Http\FormRequest;

class LogoRequest extends FormRequest
{
    public function rules()
    {
        return [
            'logo' => 'required|image',
        ];
    }
}
