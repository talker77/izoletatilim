<?php

namespace App\Http\Controllers;

use App\Models\Region\Country;
use App\Models\Region\Location;
use App\Models\Region\Region;
use App\Models\Region\State;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request, Region $region = null)
    {
        $regions = Region::where(['country_id' => Country::TURKEY])->orderBy('title')->get();
        $locations = Location::where('status', 1)
            ->when($region, function ($q) use ($region) {
                $q->whereHas('state', function ($query) use ($region) {
                    $query->where('region_id', $region->id);
                });
            })
            ->latest()->paginate();

        $states = State::when($region, function ($q) use ($region) {
            $q->where('region_id', $region->id);
        })
        ->orderBy('title')->paginate();

        return view('site.main.locations', [
            'regions' => $regions,
            'locations' => $locations,
            'states' => $states
        ]);
    }

    public function region(Region $region)
    {

    }
}
