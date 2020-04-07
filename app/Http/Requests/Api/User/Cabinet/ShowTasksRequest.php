<?php

namespace App\Http\Requests\Api\User\Cabinet;

use Illuminate\Foundation\Http\FormRequest;

class ShowTasksRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => 'nullable',
        ];
    }
}
