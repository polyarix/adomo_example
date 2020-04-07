<?php

namespace App\Http\Requests\Api\Advert\Task;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequestRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:advert_orders,id',
            'message' => 'nullable',
        ];
    }
}
