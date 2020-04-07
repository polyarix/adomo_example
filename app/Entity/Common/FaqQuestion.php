<?php

namespace App\Entity\Common;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class FaqQuestion extends Model
{
    use CrudTrait;

    protected $table = 'faq_questions';
    protected $fillable = ['title', 'text', 'group_title', 'group', 'depth', 'lft', 'rgt'];

    public $timestamps = false;
}
