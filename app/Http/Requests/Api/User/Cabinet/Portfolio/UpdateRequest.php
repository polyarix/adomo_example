<?php

namespace App\Http\Requests\Api\User\Cabinet\Portfolio;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3',
            'photos' => 'required|array',
            'photos.*' => 'exists:user_portfolio_album_photos,id',
        ];
    }
}
