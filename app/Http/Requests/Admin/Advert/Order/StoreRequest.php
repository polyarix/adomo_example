<?php

namespace App\Http\Requests\Admin\Advert\Order;

use App\Entity\Advert\Advert\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'description' => 'required|min:5',
            'title' => 'required|min:5',
            'category_id' => 'required|exists:advert_categories,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|min:5',
            //'beginning_date' => 'required|date_format:d-m-Y',
            'house_provision' => 'required|boolean',
            'materials_provision' => 'required|boolean',
            'price_type' => 'required|' . Rule::in(array_keys(Order::getPriceTypes())),
            'price' => 'nullable',
            'time_type' => 'required|' . Rule::in(array_keys(Order::getTimeTypes())),
            //'photos' => 'nullable|array',
        ];
    }
}
