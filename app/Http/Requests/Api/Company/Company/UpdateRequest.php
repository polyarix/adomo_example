<?php

namespace App\Http\Requests\Api\Company\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'workers_count' => 'required|numeric',
        ];
    }
}
