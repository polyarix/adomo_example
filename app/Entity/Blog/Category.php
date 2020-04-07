<?php

namespace App\Entity\Blog;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\User;
use App\Helpers\Models\ImageHandlerTrait;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalnoy\Nestedset\NodeTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Backpack\CRUD\CrudTrait;
use Kalnoy\Nestedset\NestedSet;

class Category extends Model
{
    const STORAGE_PATH = 'blog/category';

    const TYPE_BLOG = 'blog';
    const TYPE_COMPANY = 'company';

    use CrudTrait, Sluggable, ImageHandlerTrait;

    protected $table = 'blog_categories';
    protected $fillable = ['name', 'slug', 'breadcrumb_name', 'is_visible', 'meta_title', 'meta_description', 'meta_keywords', 'seo_text', 'image'];

    protected $image_attributes = ['image'];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function isVisible(): bool
    {
        return $this->is_visible === true;
    }
    public function isHidden(): bool
    {
        return $this->is_visible === false;
    }
    public function getBreadcrumbName()
    {
        if($name = $this->breadcrumb_name) {
            return $name;
        }

        return $this->name;
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'blog_article_categories');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_name',
            ],
        ];
    }

    public function toVisible()
    {
        return $this->update(['is_visible' => true]);
    }
    public function toHidden()
    {
        return $this->update(['is_visible' => false]);
    }

    public function hasImage(): bool
    {
        return !empty($this->image);
    }

    public function getImage(): string
    {
        if(!$this->hasImage()) {
            return 'storage/' . static::STORAGE_PATH . '/default.jpg';
        }

        return "storage/{$this->image}";
    }

    public function getRouteKey()
    {
        return $this->slug;
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
