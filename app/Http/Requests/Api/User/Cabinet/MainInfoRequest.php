<?php

namespace App\Http\Requests\Api\User\Cabinet;

use Illuminate\Foundation\Http\FormRequest;

class MainInfoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'about' => 'required|min:1',
            'brigade_size' => 'nullable',
            'city' => 'nullable|exists:cities,id',
            'districts' => 'nullable|array',
            'districts.*' => 'exists:city_districts,id',
        ];
    }
}
