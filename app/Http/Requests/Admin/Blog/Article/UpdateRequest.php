<?php

namespace App\Http\Requests\Admin\Blog\Article;

use App\Helpers\Services\Infrastructure\Seo\SeoHelper;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:3',
            'slug' => 'nullable|unique:blog_articles,slug,' . $this->id . ',id',
            'is_visible' => 'nullable',
            'image' => 'nullable|image',
        ], SeoHelper::validationRules());
    }
}
