<?php

namespace App\Http\Requests\Api\User\Cabinet\Conversation;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subject' => 'required|min:1|max:255',
            'message' => 'required|min:1|max:2048',
            'company' => 'required|exists:companies,id'
        ];
    }
}
