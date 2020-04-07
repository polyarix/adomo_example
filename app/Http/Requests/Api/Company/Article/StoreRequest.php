<?php

namespace App\Http\Requests\Api\Company\Article;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:5',
            'categories' => 'required|array',
            'categories.*' => 'exists:blog_categories,id',
            'preview' => 'required|image',
        ];
    }
}
