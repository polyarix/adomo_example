<?php

namespace App\Http\Requests\Api\Blog\Comment;

use App\Entity\Contact\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'text' => 'required|min:2',
        ];
    }
}
