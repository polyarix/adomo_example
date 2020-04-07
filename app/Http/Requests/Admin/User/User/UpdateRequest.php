<?php

namespace App\Http\Requests\Admin\User\User;

use App\Entity\User\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'phone_number' => 'required|regex:/\+\d+\s\([0-9]{3}\)\s([0-9]{3})\s([0-9]{2})\s([0-9]{2})/',
            'about' => 'nullable',
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'birth_date' => 'required|date_format:d-m-Y',
            'city' => 'required|exists:cities,id',
            'password' => 'nullable|min:6|confirmed',
            'sex' => 'nullable|numeric',
            'type' => 'required|' . Rule::in(array_keys(User::getTypes())),
            'role' => 'nullable|' . Rule::in(array_keys(User::getRoles())),
            'file' => 'nullable',
        ];
    }
}
