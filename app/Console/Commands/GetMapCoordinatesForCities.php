<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Entity\Location\City;
use App\Service\Main\Location\CityCoordinatesDetectorInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class GetMapCoordinatesForCities
 *
 * @package App\Console\Commands
 */
class GetMapCoordinatesForCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'city:coordinates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates map coordinates for cities which doesn\'t have it';

    /** @var City[] */
    private $cities = [];

    /**
     * GetMapCoordinatesForCities constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setCities($this->getCitiesWithNullCoordinates());
    }

    /**
     * @param Collection $cities
     */
    private function setCities(Collection $cities): void
    {
        $this->cities = $cities;
    }

    /**
     * @return Collection City
     */
    private function getCitiesWithNullCoordinates(): Collection
    {
        return City::whereNull('map_lat')->orWhereNull('map_long')->get();
    }

    /**
     * @param CityCoordinatesDetectorInterface $detector
     */
    public function handle(CityCoordinatesDetectorInterface $detector)
    {
        foreach ($this->cities as $city) {
            $result = $detector->detect($city->name);

            $city->update([
                'map_lat' => $result->getLat(),
                'map_long' => $result->getLong(),
            ]);
        }
    }
}
