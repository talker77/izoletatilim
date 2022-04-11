<?php

namespace App\Http\Controllers;

use App\Models\Region\District;
use App\Models\Region\Location;
use App\Models\Region\State;
use App\Models\Service;
use Illuminate\Http\Request;

class AramaController extends Controller
{

    public function search(Request $request)
    {
        $query = $request->get('term');
        $services = Service::where('title', 'like', "%$query%")->take(10)->get()->toArray();

        $states = State::with('country')->where('title', 'like', "%$query%")->take(10)->get()->map(function ($item) {
            $item['search_type'] = 'state';
            return $item;
        })->toArray();

        $districts = District::with('state')->where('title', 'like', "%$query%")->take(10)->get()->map(function ($item) {
            $item['search_type'] = 'district';
            return $item;
        })->toArray();

        $locations = Location::where('title', 'like', "%$query%")->take(10)->get()->map(function ($item) {
            $item['search_type'] = 'location';
            return $item;
        })->toArray();

        $items = array_merge( $states, $districts, $locations);

        return response()->json($items);
    }
}
