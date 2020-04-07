<?php

namespace App\Http\Requests\Api\User\Cabinet\WorkCategories;

use Illuminate\Foundation\Http\FormRequest;

class CategoryPriceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'required|exists:advert_categories,id',
            'price' => 'nullable|integer'
        ];
    }
}
