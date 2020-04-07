<?php

namespace App\Http\Requests\Api\Company\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|min:1|max:255',
            'slug' => 'nullable',
            'city_id' => 'required|exists:cities,id',
            'description' => 'required|min:3|max:255',
            'logo' => 'required',
            'workers_count' => 'nullable',
            'address' => 'required|min:3',
            'contacts' => 'nullable',
            'schedule' => 'nullable',
            'coords' => 'nullable|array',
            'categories' => 'required|array'
        ];
    }
}
