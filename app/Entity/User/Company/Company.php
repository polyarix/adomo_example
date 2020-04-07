<?php

namespace App\Entity\User\Company;

use App\Entity\Advert\Category;
use App\Entity\Location\City;
use App\Entity\User\Company\Portfolio\Work;
use App\Entity\User\User;
use App\Helpers\Models\ImageHandlerTrait;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 * @property mixed subscription_date_to
 * @property mixed subscription_option
 * @package App\Entity\User\Company
 */
class Company extends Model
{
    /**
     *
     */
    const PER_PAGE = 5;
    /**
     *
     */
    const STORAGE_PATH = 'companies';

    /**
     *
     */
    const ACCESS_GRANTED = 1;

    use CrudTrait, Sluggable, ImageHandlerTrait;

    /**
     * @var string
     */
    protected $table = 'companies';
    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'user_id', 'description', 'logo', 'cover', 'workers_count', 'city_id', 'subscription_date_to', 'subscription_option'];

    /**
     * @var array
     */
    protected $image_attributes = ['logo', 'cover'];

    /**
     * @return string
     */
    public function getPreview()
    {
        if(!empty($this->preview)) {
            return "/storage/{$this->preview->getPath()}";
        }

        return "/storage/{$this->logo}";
    }

    /**
     * @return string
     */
    public function getCrop()
    {
        if(!empty($this->preview)) {
            return "/storage/{$this->preview->getCrop()}";
        }

        return $this->cover ? "/storage/{$this->cover}" : '/images/company-bg.jpg';
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        if(!empty($this->logo)) {
            return "/storage/{$this->logo}";
        }

        return '/images/company-logo.png';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'company_categories', 'company_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contacts()
    {
        return $this->hasOne(Contact::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function works()
    {
        return $this->hasMany(Work::class);
    }

    /**
     * @return bool
     */
    public function hasFillContacts(): bool
    {
        return !empty($this->contacts);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isOwnedBy(User $user): bool
    {
        return $this->user->id === $user->id;
    }

    /**
     * @return string
     */
    public function getUserWithLink() {
        return '<a href="/admin/users/'. $this->user->id .'" target="_blank">'.$this->user->email.'</a>';
    }

    /**
     * @return mixed
     */
    public function getRouteKey()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Check company access for albums, articles, blog
     *
     * @return bool
     */
    public function checkAccessGrantedForSubscribe(): bool
    {
        if($this->subscription_option == self::ACCESS_GRANTED)
        {
            return true;
        }

        return (now() < $this->subscription_date_to) ?? true;
    }

    /**
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_name',
            ],
        ];
    }
}
