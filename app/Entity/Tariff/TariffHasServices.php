<?php

declare(strict_types=1);

namespace App\Entity\Tariff;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TariffHasServices
 *
 * @package App\Entity\Tariff
 */
class TariffHasServices extends BaseModel
{
    /** @var string */
    protected $table = 'tariff_has_services';

    /** @var array */
    protected $with = ['service'];

    /**
     * @return BelongsTo
     */
    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class, 'tariff_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
