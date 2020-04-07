<?php

namespace App\Http\Requests\Api\User\Profile\Portfolio;

use Illuminate\Foundation\Http\FormRequest;

class ShowAlbumsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'page' => 'required|numeric',
        ];
    }
}
