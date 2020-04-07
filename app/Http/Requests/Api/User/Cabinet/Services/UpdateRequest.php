<?php

namespace App\Http\Requests\Api\User\Cabinet\Services;

use App\Entity\Advert\Advert\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'categories' => 'required|array|min:1',
            'categories.*' => 'required|exists:advert_categories,id',
            'title' => 'required|min:1',
            'description' => 'required|min:1',
            'price_type' => ['required', Rule::in(array_keys(Order::getPriceTypes()))],
            'price' => 'nullable',
            'photos' => 'nullable',
            'photos.*' => 'exists:advert_photos,id',
            'tags' => 'nullable',
            'tags.*' => 'exists:category_tags,id',
        ];
    }
}
