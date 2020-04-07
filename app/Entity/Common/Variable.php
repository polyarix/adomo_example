<?php

namespace App\Entity\Common;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    use CrudTrait;

    const TYPE_COMMON = 'common';
    const TYPE_FAQ_PAGE = 'faq_page';
    const TYPE_MAIN_PAGE = 'main_page';
    const TYPE_ABOUT_PAGE = 'about_page';
    const TYPE_CONTACTS_PAGE = 'contacts_page';

    protected $table = 'common_variables';
    protected $fillable = ['name', 'key', 'value', 'type'];

    public function scopeCommon($query)
    {
        return $query->where('type', self::TYPE_COMMON);
    }
    public function scopeMainPage($query)
    {
        return $query->where('type', self::TYPE_MAIN_PAGE);
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
}
