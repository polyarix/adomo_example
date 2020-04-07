<?php

namespace App\Http\Requests\Api\Advert\Order;

use App\Entity\Advert\Advert\Photo;
use Illuminate\Foundation\Http\FormRequest;

class PhotoUploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required|image|max:' . Photo::MAX_UPLOAD_SIZE,
        ];
    }
}
