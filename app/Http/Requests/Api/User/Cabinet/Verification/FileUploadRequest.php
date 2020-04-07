<?php

namespace App\Http\Requests\Api\User\Cabinet\Verification;

use App\Entity\Advert\Advert\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FileUploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required|file|image',
        ];
    }
}
