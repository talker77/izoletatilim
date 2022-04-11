<?php namespace App\Repositories\Concrete\Eloquent;


use App\Models\Region\District;
use App\Models\Region\State;
use App\Repositories\Interfaces\CityTownInterface;

class ElCityTownDal extends BaseRepository implements CityTownInterface
{

    public function __construct(State $model)
    {
        parent::__construct($model);
    }

    public function all(array $filter = null, $columns = array('*'), $relations = null, $orderBy = 'id')
    {
        if ($relations) return State::with($relations)->where($filter)->orderBy('title')->get();

        return State::when(!is_null($filter), function ($query) use ($filter) {
            $query->where($filter);
        })->orderBy('title')->get();
    }


    public function getTownsByCityId($cityId)
    {
        return District::where(['state_id' => $cityId, 'active' => 1])->get();
    }

    public function getStatesByCountryID($countryId)
    {
        return State::where(['country_id' => $countryId, 'active' => 1])->orderBy('title')->get();
    }
}
