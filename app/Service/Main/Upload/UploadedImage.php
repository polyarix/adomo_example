<?php

namespace App\Service\Main\Upload;

class UploadedImage
{
    public $path;
    public $crop;

    public function __construct($path, $crop = null)
    {
        $this->path = $path;
        $this->crop = $crop;
    }

    public function hasCrop(): bool
    {
        return !!$this->crop;
    }
}
