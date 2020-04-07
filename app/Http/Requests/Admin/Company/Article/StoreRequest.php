<?php

namespace App\Http\Requests\Admin\Company\Article;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:5',
            'slug' => 'nullable',
            'company_id' => 'required|exists:companies,id',
            'image' => 'nullable',
            'is_visible' => 'nullable',
        ];
    }
}
