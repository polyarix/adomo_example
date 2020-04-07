<?php

namespace App\Entity\User\Company;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'company_contacts';
    protected $fillable = ['address', 'contacts', 'schedule', 'map_lat', 'map_long'];

    public $timestamps = false;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function hasMapCoordinates(): bool
    {
        return !empty($this->map_lat) && !empty($this->map_long);
    }
    public function getCoordinates(): array
    {
        return [$this->map_lat, $this->map_long];
    }
}
