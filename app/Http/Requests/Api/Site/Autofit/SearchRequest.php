<?php

namespace App\Http\Requests\Api\Site\Autofit;

use App\Entity\Contact\Contact;
use App\Entity\User\Executor\WorkData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'city' => 'required|exists:cities,id',
            'category' => 'required|exists:advert_categories,id',
            'district' => 'nullable|exists:city_districts,id',
            'tags' => 'nullable|array',
            'tags.*' => 'required|exists:category_tags,id',
            'executor_type' => 'nullable|' . Rule::in(array_keys(WorkData::getTeamTypes())),
            'price_from' => 'nullable|integer',
            'price_to' => 'nullable|integer',
            'with_reviews' => 'nullable|boolean',
        ];
    }
}
