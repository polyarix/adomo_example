<?php

namespace App\Entity\Blog;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Tag extends Model
{
    use CrudTrait, Sluggable;

    protected $table = 'category_tags';
    protected $fillable = ['name', 'slug'];
    public $timestamps = false;

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_categories_tags', 'tag_id', 'category_id');
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['slug', 'name'],
            ],
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
