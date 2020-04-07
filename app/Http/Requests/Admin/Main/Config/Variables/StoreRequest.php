<?php

namespace App\Http\Requests\Admin\Main\Config\Variables;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'name' => 'required|min:2',
            'key' => 'required|min:1',
            'value' => 'nullable',
        ];
    }
}
