<?php

namespace App\Http\Requests\Api\Advert\Order;

use Illuminate\Foundation\Http\FormRequest;

class RecommendedRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category' => 'required|exists:advert_categories,id',
        ];
    }
}
