<?php

namespace App\Entity\User\Portfolio;

use App\Entity\Advert\Tag;
use App\Entity\User\Portfolio\Album;
use App\Entity\User\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Backpack\CRUD\Tests\Unit\CrudTrait\BaseCrudTraitTest;
use Backpack\CRUD\CrudTrait;
use Kalnoy\Nestedset\NestedSet;

class Photo extends Model
{
    const MAX_ALLOWED_WIDTH = 1000; // 1000 px (if greater - going to be resized)

    protected $table = 'user_portfolio_album_photos';
    protected $fillable = ['path', 'crop', 'album_id'];

    const UPDATED_AT = null;
    const CREATED_AT = 'created_at';

    public function getPath()
    {
        return "/storage/{$this->path}";
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function hasCrop(): bool
    {
        return !empty($this->crop);
    }

    public function getCrop()
    {
        if(!$this->hasCrop()) {
            return $this->getPath();
        }

        return "/storage/{$this->crop}";
    }
}
