<?php

namespace App\Http\Requests\Api\User\SignUp;

use App\Entity\User\Executor\WorkData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WorkDataRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'legal_type' => ['required', Rule::in(array_keys(WorkData::getLegalTypes()))],
            'team_type' => ['required', Rule::in(array_keys(WorkData::getTeamTypes()))],
            'brigade_size' => 'required_if:team_type,' . WorkData::TYPE_BRIGADE,
            'about' => 'nullable',
            'city_id' => 'required|exists:cities,id',
            'company_name' => 'required',
        ];
    }
}
