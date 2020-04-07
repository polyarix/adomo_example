<?php

declare(strict_types=1);

namespace App\Helpers\Factory\Common\Uploader;

class AttachmentMimeTypesFactory
{
    public static function getAllowedTypes(): array
    {
        return [
            'application/pdf', 'application/msword', 'application/omdoc+xml', 'application/pics-rules', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'image/png', 'image/jpeg', 'image/bmp', 'text/plain'
        ];
    }

    public static function getAllowedMimes()
    {
        return [
            'jpeg,bmp,png'
        ];
    }
}
