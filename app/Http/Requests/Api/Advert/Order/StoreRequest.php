<?php

namespace App\Http\Requests\Api\Advert\Order;

use App\Entity\Advert\Advert\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => 'required|min:5',
            'title' => 'required|min:5',
            'category' => 'required|exists:advert_categories,id',
            'city' => 'required|exists:cities,id',
            'address' => 'required|min:5',
            'comment' => 'nullable',
            'coords' => 'required|array|min:2|max:2',
            'date' => 'required|date_format:d-m-Y',
            'house_provision' => 'required|boolean',
            'material_provision' => 'required|boolean',
            'price_type' => 'required|' . Rule::in(array_keys(Order::getPriceTypes())),
            'price' => 'required_if:price_type,' . Order::PRICE_TYPE_SPECIFIC .'|nullable|numeric',
            'time_type' => 'required|' . Rule::in(array_keys(Order::getTimeTypes())),
            'photos' => 'nullable|array',
            'photos.*' => 'exists:advert_photos,id',
            'executor_id' => 'nullable|exists:users,id',
            'district' => 'nullable|exists:city_districts,id',
            'videos' => 'nullable|array',
            'tags' => 'nullable|array'
        ];
    }
}
