<?php

namespace App\Http\Requests\Admin\Main\Config\Faq;

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
            'title' => 'required|min:2',
            'text' => 'required|min:10',
            'group_title' => 'nullable',
            'group' => 'nullable',
        ];
    }
}
