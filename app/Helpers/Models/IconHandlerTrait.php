<?php

namespace App\Helpers\Models;

/**
 * Trait for handling icons for entity
 * The trait is useful for entities when you need to set icon from admin panel
 *
 * for this, add to $fillable array new key - icon
 * and you should define constant STORAGE_ICON_PATH with directory name for storing icons
 */
trait IconHandlerTrait
{
    public function hasIcon(): bool
    {
        return !empty($this->icon);
    }

    public function getImage(): string
    {
        if(!$this->hasIcon()) {
            return 'storage/' . static::STORAGE_ICON_PATH . '/default.jpg';
        }

        return "storage/{$this->icon}";
    }

    public function setImageAttribute($value)
    {
        // if the image was erased
        if ($value == null) {
            // delete the image from disk
            \Storage::disk('public')->delete($this->icon);

            // set null in the database column
            $this->attributes['icon'] = null;
        }

        if (starts_with($value, 'data:image')) {
            $image = \Image::make($value)->encode('jpg', 90);
            $filename = uniqid('', true) . '.jpg';
            \Storage::disk('public')->put(static::STORAGE_ICON_PATH.'/'.$filename, $image->stream());
            $this->attributes['icon'] = $filename;
        } else {
            $this->uploadFileToDisk($value, 'icon', 'public', static::STORAGE_ICON_PATH);
        }
    }
}
