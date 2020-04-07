<?php

namespace App\Http\Requests\Api\User\SignUp;

use Illuminate\Foundation\Http\FormRequest;

class UploadAvatarRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ];
    }
}
