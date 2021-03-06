<?php

namespace App\Http\Requests\Admin\Blog\Category;

use App\Helpers\Services\Infrastructure\Seo\SeoHelper;
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
        return array_merge([
            'name' => 'required|min:5|max:255',
            'slug' => 'nullable|unique:blog_categories,slug',
            'is_visible' => 'nullable',
            'image' => 'nullable|image',
        ], SeoHelper::validationRules());
    }
}
