<?php

namespace App\Entity\Common;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use CrudTrait;

    const TYPE_COMMON = 'common';
    const TYPE_FAQ_PAGE = 'faq_page';
    const TYPE_ABOUT_PAGE = 'about_page';
    const TYPE_CONTACTS_PAGE = 'contacts_page';

    protected $table = 'slugs';
    protected $fillable = ['slug', 'url', 'type', 'meta'];
    public $timestamps = false;

    protected $casts = [
        'meta' => 'array',
    ];

    public function isFaq(): bool
    {
        return $this->type === self::TYPE_FAQ_PAGE;
    }
    public function isAbout(): bool
    {
        return $this->type === self::TYPE_ABOUT_PAGE;
    }
    public function isContacts(): bool
    {
        return $this->type === self::TYPE_CONTACTS_PAGE;
    }

    public function scopeCommon($query)
    {
        return $query->where('type', self::TYPE_COMMON);
    }
    public function scopeAboutPage($query)
    {
        return $query->where('type', self::TYPE_ABOUT_PAGE);
    }
    public function scopeContactsPage($query)
    {
        return $query->where('type', self::TYPE_CONTACTS_PAGE);
    }
    public function scopeFaqPage($query)
    {
        return $query->where('type', self::TYPE_FAQ_PAGE);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
