<?php

namespace App\Http\Requests\Api\User\Cabinet\Conversation;

use App\Entity\User\Conversation\Attachment;
use App\Helpers\Factory\Common\Uploader\AttachmentMimeTypesFactory;
use Illuminate\Foundation\Http\FormRequest;

class AttachmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'attachment' => 'required|file|max:' . Attachment::MAX_UPLOAD_SIZE . '|mimetypes:' . implode(',', AttachmentMimeTypesFactory::getAllowedTypes()),
        ];
    }
}
