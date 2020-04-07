<?php

namespace App\Http\Requests\Admin\Advert;

use App\Entity\Advert\Advert\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class RejectRequest extends FormRequest
{
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'status' => ['required', Rule::in([Order::STATUS_SPAM, Order::STATUS_REJECTED])],
            'reason' => 'nullable',
        ];
    }
}
