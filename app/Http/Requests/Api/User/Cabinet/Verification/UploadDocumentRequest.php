<?php

namespace App\Http\Requests\Api\User\Cabinet\Verification;

use App\Entity\User\Verification\Document;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required|file|image|max:' . Document::MAX_UPLOAD_SIZE,
            'type' => ['required', Rule::in(array_keys(Document::getTypesList()))]
        ];
    }
}
