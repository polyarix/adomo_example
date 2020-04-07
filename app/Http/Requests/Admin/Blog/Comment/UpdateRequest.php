<?php

namespace App\Http\Requests\Admin\Blog\Comment;

use App\Entity\Blog\Comment;
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
            'text' => 'required|min:2',
            'user_id' => 'required|exists:users,id',
            'article_id' => 'required|exists:blog_articles,id',
            'status' => 'required|' . Rule::in(array_keys(Comment::getStatusesList())),
        ];
    }
}
