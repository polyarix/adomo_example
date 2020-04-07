<?php

namespace App\Http\Requests\Admin\Company\Work;

use App\Entity\User\Company\Portfolio\Work;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        return [
            'title' => 'required|min:5|max:255',
            'description' => 'required|min:5',
            'price' => 'nullable',
            'duration' => 'nullable',
            'preview_id' => 'nullable',
            'duration_type' => ['nullable', Rule::in(array_keys(Work::getDurationTypes()))],
            'company_id' => 'required|exists:companies,id',
            'user_id' => 'required|exists:users,id',
            'images' => 'nullable'
        ];
    }
}
