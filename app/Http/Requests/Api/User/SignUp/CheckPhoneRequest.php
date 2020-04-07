<?php

namespace App\Http\Requests\Api\User\SignUp;

use Illuminate\Foundation\Http\FormRequest;

class CheckPhoneRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = $this->user();

        return [
            'phone_number' => 'required|regex:/\+\d+\s\([0-9]{3}\)\s([0-9]{3})\s([0-9]{2})\s([0-9]{2})/|unique:users,phone,' . $user->id
        ];
    }
}
