<?php

namespace App\Http\Requests\Admin\Main\Slider;

use Illuminate\Http\Request;

class UpdateRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{

    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'title' => 'required|min:2|max:255',
            'image' => 'nullable|image',
            'sort_num' => 'nullable',
            'is_visible' => 'required|boolean',
        ];
    }
}
