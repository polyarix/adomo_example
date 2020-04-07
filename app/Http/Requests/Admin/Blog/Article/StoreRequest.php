<?php

namespace App\Http\Requests\Admin\Blog\Article;

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
            'content' => 'required|min:3',
            'slug' => 'nullable|unique:blog_articles,slug',
            'is_visible' => 'nullable',
            'image' => 'nullable|image',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:255',
            'meta_keywords' => 'nullable|max:255',
            'seo_text' => 'nullable',
        ];
    }
}
