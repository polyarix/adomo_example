<?php

namespace App\Entity\Common;

use App\Helpers\Models\ImageHandlerTrait;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use CrudTrait, ImageHandlerTrait;

    const TYPE_MAIN_PAGE = 'main';

    const STORAGE_PATH = 'sliders';

    const DEFAULT_DELAY = 3;

    protected $table = 'sliders';
    protected $fillable = ['name', 'title', 'image', /*'sort_num',*/ 'depth', 'lft', 'rgt', 'parent_id', 'is_visible', 'type', 'delay', 'buttons_disabled', 'url'];

    protected $image_attributes = ['image'];

    protected $casts = [
        'is_visible' => 'boolean',
        'buttons_disabled' => 'boolean',
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
    public function scopeMain($query)
    {
        return $query->where('type', self::TYPE_MAIN_PAGE);
    }

    public function getPath()
    {
        return "/storage/{$this->image}";
    }

    public function getDelay(): int
    {
        return ($this->delay ?? self::DEFAULT_DELAY) * 1000;
    }

    public function isButtonsDisabled(): bool
    {
        return $this->buttons_disabled === true;
    }
    public function isButtonsEnabled(): bool
    {
        return !$this->isButtonsDisabled();
    }

    public function hasUrl(): bool
    {
        return !empty($this->url);
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
