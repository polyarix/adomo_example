<?php

namespace App\UseCase\Advert\Location;

use App\Entity\Location\City;

class CitiesService
{
    public function getCities()
    {
        return City::select('id', 'name', 'map_lat', 'map_long')->with(['districts'])->get();
    }
}
