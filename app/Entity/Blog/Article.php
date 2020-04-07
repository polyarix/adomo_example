<?php

namespace App\Entity\Blog;

use App\Helpers\Models\ImageHandlerTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Sluggable;
use Backpack\CRUD\CrudTrait;

class Article extends Model
{
    const STORAGE_PATH = 'blog/articles';

    use CrudTrait, Sluggable, ImageHandlerTrait;

    protected $table = 'blog_articles';
    protected $fillable = ['title', 'content', 'slug', 'is_visible', 'breadcrumb_name', 'views', 'meta_title', 'meta_description', 'meta_keywords', 'seo_text', 'breadcrumb_name', 'image', 'crop'];

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

    public function toVisible()
    {
        return $this->update(['is_visible' => true]);
    }
    public function toHidden()
    {
        return $this->update(['is_visible' => false]);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_article_categories');
    }
    public function visibleCategories()
    {
        return $this->belongsToMany(Category::class, 'blog_article_categories')->where('is_visible', true);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->where('type', Category::TYPE_BLOG);
    }
    public function visibleComments()
    {
        return $this->hasMany(Comment::class)
            ->where('type', Category::TYPE_BLOG)
            ->where('status', Comment::STATUS_ACTIVE);
    }

    public function getMainCategory()
    {
        return $this->visibleCategories()->first();
    }

    public function getPreview()
    {
        return "/storage/{$this->image}";
    }
    public function getCrop()
    {
        return $this->crop ? "/storage/{$this->crop}" : null;
    }
    public function hasCrop(): bool
    {
        return !empty($this->crop);
    }

    public function getDescription()
    {
        return strip_tags(Str::words($this->content, 25));
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
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
