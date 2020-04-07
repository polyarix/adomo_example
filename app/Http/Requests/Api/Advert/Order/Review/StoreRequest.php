<?php

namespace App\Http\Requests\Api\Advert\Order\Review;

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
            'grade' => 'nullable|numeric|digits_between:1,5',
            'professionalism' => 'nullable|numeric|digits_between:1,5',
            'punctuality' => 'nullable|numeric|digits_between:1,5',
            'quality' => 'nullable|numeric|digits_between:1,5',
            'recommended' => 'nullable|boolean',
            'text' => 'required|min:3',
        ];
    }
}
