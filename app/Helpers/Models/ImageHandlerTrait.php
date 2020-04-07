<?php

namespace App\Helpers\Models;

/**
 * Trait for handling images (previews) for entity
 * The trait is useful for entities when you need to set preview from admin panel
 *
 * for this, add to $fillable array new key - image
 * and you should define constant STORAGE_PATH with directory name for storing images
 */
trait ImageHandlerTrait
{
    protected function handleImage($fieldName, $value, $path)
    {
        // if the image was erased
        if ($value == null) {
            // delete the image from disk
            \Storage::disk('public')->delete($this->$fieldName);

            // set null in the database column
            $this->attributes[$fieldName] = null;
            return;
        }

        if (starts_with($value, 'data:image')) {
            $image = \Image::make($value)->encode('jpg', config('services.image_resizer.quality'));
            $filename = uniqid('', true) . '.jpg';
            \Storage::disk('public')->put($path.'/'.$filename, $image->stream());
            $this->attributes[$fieldName] = $path.'/'.$filename;
        } elseif(!is_string($value)) {
            $this->uploadFileToDisk($value, $fieldName, 'public', $path);
            /// change image quality after uploading
            \Image::make(\Storage::disk('public')->path($this->{$fieldName}))->save(null, config('services.image_resizer.quality'));
        } else {
            $this->attributes[$fieldName] = $value;
        }
    }

    protected function isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    public function setAttribute($key, $value)
    {
        $keys = $this->isAssoc($this->image_attributes) ? array_keys($this->image_attributes) : $this->image_attributes;

        if(in_array($key, $keys)) {
            // if image_attributes - associative massive with key => path to save, take location from array, or else, take from constant
            $path = isset($this->image_attributes[$key]) ? $this->image_attributes[$key] : static::STORAGE_PATH;

            $this->handleImage($key, $value, $path);

            return;
        }
        parent::setAttribute($key, $value);
    }
}
