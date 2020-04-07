<?php

namespace App\Entity\Location;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class District extends Model
{
    use CrudTrait, Sluggable;

    const TYPE_ORDER = 'order';
    const TYPE_SERVICE = 'service';
    const TYPE_USER = 'user';

    protected $table = 'city_districts';
    protected $fillable = ['name', 'slug', 'city_id'];

    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['slug', 'name'],
            ],
        ];
    }
}
