<?php

namespace App\Http\Requests\Api\User\Cabinet\Verification;

use App\Entity\Advert\Advert\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FileRemoveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:user_verification_documents,id',
        ];
    }
}
