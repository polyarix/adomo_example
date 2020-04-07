<?php

declare(strict_types=1);

namespace App\Entity\Tariff;

/**
 * Class Tariff
 *
 * @package App\Entity\Tariff
 */
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Tariff
 *
 * @package App\Entity\Tariff
 */
class Tariff extends BaseModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(TariffHasServices::class, 'tariff_id', 'id');
    }
}
