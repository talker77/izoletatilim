<?php namespace App\Repositories\Interfaces;

interface CityTownInterface
{
    public function getStatesByCountryID($countryId);

    public function getTownsByCityId($cityId);
}
