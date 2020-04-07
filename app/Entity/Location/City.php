<?php

declare(strict_types=1);

namespace App\Entity\Location;

use AlexeyMezenin\LaravelRussianSlugs\SlugsTrait;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class City
 *
 * @package App\Entity\Location
 */
class City extends Model
{
    use CrudTrait, SlugsTrait;

    /** @var string */
    protected $table = 'cities';

    /** @var array */
    protected $fillable = ['name', 'region_id', 'slug', 'map_lat', 'map_long'];

    /** @var string */
    protected $slugFrom = 'name';

    /** @return HasMany */
    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }

    /** @return BelongsTo */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /** @return array */
    public function getCoordinates(): array
    {
        return [$this->map_lat, $this->map_long];
    }

    /** @return array */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }
}
