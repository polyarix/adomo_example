<?php

declare(strict_types=1);

namespace App\Entity\Location;

use Backpack\CRUD\CrudTrait;
use Backpack\CRUD\ModelTraits\SpatieTranslatable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Region
 *
 * @package App\Entity\Location
 */
class Region extends Model
{
    use CrudTrait, Sluggable;

    /** @var array */
    protected $fillable = ['name', 'slug', 'city_id'];

    /** @var bool */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function city(): hasMany
    {
        return $this->hasMany(City::class);
    }

    /** @return array */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['slug', 'name'],
            ],
        ];
    }
}
