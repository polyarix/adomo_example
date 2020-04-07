<?php

namespace App\Http\Requests\Api\Company\Company;

use Illuminate\Foundation\Http\FormRequest;

class CoverRequest extends FormRequest
{
    public function rules()
    {
        return [
            'image' => 'required|image',
        ];
    }
}
