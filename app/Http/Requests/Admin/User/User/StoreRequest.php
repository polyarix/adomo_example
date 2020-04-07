<?php

namespace App\Http\Requests\Admin\User\User;

use App\Entity\User\User;
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
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|regex:/\+\d+\s\([0-9]{3}\)\s([0-9]{3})\s([0-9]{2})\s([0-9]{2})/|unique:users,phone_number',
            'about' => 'nullable',
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'birth_date' => 'nullable|date_format:d-m-Y',
            'city' => 'required|exists:cities,id',
            'password' => 'required|min:6|confirmed',
            'sex' => 'nullable|numeric',
            'type' => 'required|' . Rule::in(array_keys(User::getTypes())),
            'role' => 'nullable|' . Rule::in(array_keys(User::getRoles())),
            'file' => 'nullable',
        ];
    }
}
