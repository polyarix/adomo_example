<?php

namespace App\Service\Main\Upload;

use Illuminate\Http\UploadedFile;

class SimpleImageUploader implements ImageUploader
{
    public function upload(UploadedFile $image, string $directory, ?int $maxWidth = null): UploadedImage
    {
        $name = uniqid();
        $extension = $image->clientExtension();

        $quality = config('cropper.quality', 60);

        if(!\Storage::exists("public/{$directory}")) {
            \Storage::makeDirectory("public/{$directory}");
        }

        $baseName = storage_path() . "/app/public/{$directory}/{$name}";

        if($maxWidth && ($imageData = \Image::make($image)) && $imageData->width() > $maxWidth && false) {
            $imageData->resize($maxWidth, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $imageData->save("{$baseName}.{$extension}", $quality);
        } else {
            $path = $image->storePubliclyAs("public/{$directory}", "{$name}.{$extension}");

            \Image::make(\Storage::disk('public')->path("{$directory}/{$name}.{$extension}"))
                ->save(null, config('services.image_resizer.quality'));
        }

        $this->crop($image, $directory, $name);

        return new UploadedImage("{$directory}/{$name}.{$extension}", "{$directory}/{$name}_crop.{$extension}");
    }

    public function crop(UploadedFile $image, string $directory, $name = null): UploadedImage
    {
        if(!$name) {
            $name = uniqid();
        }
        $extension = $image->clientExtension();
        $baseName = storage_path() . "/app/public/{$directory}/{$name}";

        $image = \Image::make($image)->resize(null, config('cropper.height'), function($constraint) {
            $constraint->aspectRatio();
        });
        $image->save("{$baseName}_crop.{$extension}", config('cropper.quality'));

        return new UploadedImage("{$directory}/{$name}.{$extension}", "{$directory}/{$name}_crop.{$extension}");
    }
}
