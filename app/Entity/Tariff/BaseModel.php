<?php

declare(strict_types=1);

namespace App\Entity\Tariff;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 *
 * @package App\Entity\Tariff
 */
abstract class BaseModel extends Model
{
    use CrudTrait;

    /** @var array */
    protected $guarded = ['id'];

    /** @var bool */
    public $timestamps = false;
}
