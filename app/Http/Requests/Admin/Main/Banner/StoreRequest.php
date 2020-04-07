<?php

namespace App\Http\Requests\Admin\Main\Banner;

use Illuminate\Http\Request;

class StoreRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'image' => 'required|image',
            'url' => 'required|url',
            'is_visible' => 'required|boolean',
        ];
    }
}
