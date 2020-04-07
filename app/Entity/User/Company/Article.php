<?php

namespace App\Entity\User\Company;

use App\Entity\Blog\Category;
use App\Entity\Blog\Comment;
use App\Entity\User\User;
use App\Helpers\Models\ImageHandlerTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Sluggable;
use Backpack\CRUD\CrudTrait;

class Article extends Model
{
    const STORAGE_PATH = 'companies/blog';

    const PER_PAGE = 10;

    use CrudTrait, Sluggable, ImageHandlerTrait;

    protected $table = 'company_blog_articles';
    protected $fillable = ['title', 'content', 'slug', 'is_visible', 'views', 'meta_title', 'meta_description', 'meta_keywords', 'image', 'user_id', 'company_id'];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    protected $image_attributes = ['image'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'company_article_categories');
    }
    public function visibleCategories()
    {
        return $this->belongsToMany(Category::class, 'blog_article_categories')->where('is_visible', true);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->where('type', Category::TYPE_COMPANY);
    }
    public function visibleComments()
    {
        return $this->hasMany(Comment::class)
            ->where('type', Category::TYPE_COMPANY)
            ->where('status', Comment::STATUS_ACTIVE);
    }

    public function getMainCategory()
    {
        return $this->visibleCategories()->first();
    }

    public function getCrop()
    {
        return $this->crop ? "/storage/{$this->crop}" : null;
    }
    public function hasCrop(): bool
    {
        return !empty($this->crop);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function isVisible(): bool
    {
        return $this->is_visible === true;
    }
    public function isHidden(): bool
    {
        return $this->is_visible === false;
    }

    public function toVisible()
    {
        if($this->isVisible()) {
            throw new \DomainException('The article is already visible.');
        }
        return $this->update(['is_visible' => true]);
    }
    public function toHidden()
    {
        if(!$this->isVisible()) {
            throw new \DomainException('The article is already hidden.');
        }
        return $this->update(['is_visible' => false]);
    }

    public function hasImage(): bool
    {
        return !empty($this->image);
    }
    public function getPreview()
    {
        return "/storage/{$this->image}";
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

    public function getCompanyWithLink() {
        return '<a href="/admin/companies/'. $this->company->id .'" target="_blank">'.$this->company->name.'</a>';
    }
    public function getUserWithLink() {
        return '<a href="/admin/users/'. $this->user->id .'" target="_blank">'.$this->user->email.'</a>';
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
