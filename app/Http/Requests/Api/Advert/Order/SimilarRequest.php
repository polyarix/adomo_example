<?php

namespace App\Http\Requests\Api\Advert\Order;

use App\Entity\Advert\Advert\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SimilarRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'required|exists:advert_categories,id',
            'except_id' => 'nullable',
            'page' => 'required',
        ];
    }
}
