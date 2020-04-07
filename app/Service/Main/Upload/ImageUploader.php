<?php

namespace App\Service\Main\Upload;

use Illuminate\Http\UploadedFile;

interface ImageUploader
{
    public function upload(UploadedFile $file, string $dir, ?int $maxWidth = null): UploadedImage;
    public function crop(UploadedFile $file, string $dir): UploadedImage;
}
