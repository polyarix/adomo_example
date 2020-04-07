<?php

declare(strict_types=1);

namespace App\Entity\Tariff;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Service
 *
 * @package App\Entity\Tariff
 */
class Service extends BaseModel
{
    /** @var string */
    protected $table = 'tariff_services';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tariffs(): HasMany
    {
        return $this->hasMany(TariffHasServices::class, 'service_id', 'id');
    }
}
