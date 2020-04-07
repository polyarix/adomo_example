<?php

namespace App\Http\Requests\Api\Advert\Task;

use App\Entity\User\Executor\WorkData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'price' => 'nullable|array',
            'price.from' => 'nullable|numeric',
            'price.to' => 'nullable|numeric',
            'category' => 'nullable|exists:advert_categories,id',
            'city' => 'nullable|exists:cities,id',
            'district' => 'nullable|exists:city_districts,id',
            'date' => 'nullable|date|date_format:d-m-Y',
            'page' => 'required|numeric',
            'active_only' => 'nullable|boolean',
        ];
    }
}
