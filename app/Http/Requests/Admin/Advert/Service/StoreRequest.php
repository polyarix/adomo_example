<?php

namespace App\Http\Requests\Admin\Advert\Service;

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
            'categories' => 'required|array',
            'categories.*' => 'exists:advert_categories,id',
            //'city_id' => 'required|exists:cities,id',
            'user_id' => 'required|exists:users,id',
            'price_type' => 'required|' . Rule::in(array_keys(Order::getPriceTypes())),
            'status' => 'required|' . Rule::in(array_keys(Order::getStatusList())),
            'price' => 'nullable',
            //'photos' => 'nullable|array',
        ];
    }
}
