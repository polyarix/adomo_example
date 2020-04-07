<?php

namespace App\Entity\Common;

use App\Helpers\Models\ImageHandlerTrait;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use CrudTrait, ImageHandlerTrait;

    const TYPE_CATEGORY_PAGE = 'category';

    const STORAGE_PATH = 'banners';

    protected $table = 'banners';
    protected $fillable = ['name', 'image', 'url', 'is_visible', 'type'];

    protected $image_attributes = ['image'];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function toVisible()
    {
        return $this->update(['is_visible' => true]);
    }
    public function toHidden()
    {
        return $this->update(['is_visible' => false]);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }
    public function scopeHidden($query)
    {
        return $query->where('is_visible', false);
    }
    public function scopeCategory($query)
    {
        return $query->where('type', self::TYPE_CATEGORY_PAGE);
    }

    public function getPath()
    {
        return "/storage/{$this->image}";
    }

    public function isVisible(): bool
    {
        return $this->is_visible === true;
    }
    public function isHidden(): bool
    {
        return $this->is_visible === false;
    }
}
