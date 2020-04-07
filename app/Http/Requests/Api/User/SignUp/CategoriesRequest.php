<?php

namespace App\Http\Requests\Api\User\SignUp;

use App\Entity\User\Executor\WorkData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoriesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:advert_categories,id',
            'prices' => 'nullable|array',
            'prices.*' => 'required|integer',
        ];
    }
}
