<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LocationType;
use App\Models\Region\Country;
use App\Models\Region\District;
use App\Models\Region\Location;
use App\Models\Region\State;
use App\Repositories\Traits\ImageUploadTrait;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    use ResponseTrait;
    use ImageUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.locations.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.locations.create', [
            'item' => new Location(),
            'types' => LocationType::orderBy('title')->get()->toArray(),
            'countries' => Country::orderBy('title')->get()->toArray(),
            'states' => [],
            'districts' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $validated['status'] = activeStatus('status');
        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : createSlugByModelAndTitleByModel(Location::class, $validated['title'], 0);
        $location = Location::create($validated);
        success();

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), $location->title, "public/locations", $location->image, Location::MODULE_NAME);
            $location->update(['image' => $imagePath]);
        }

        return redirect(route('admin.locations.edit', $location->id));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Region\Location $location
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Location $location)
    {
        return view('admin.locations.create', [
            'item' => $location,
            'types' => LocationType::orderBy('title')->get()->toArray(),
            'countries' => Country::orderBy('title')->get()->toArray(),
            'states' => State::where('country_id', $location->country_id)->get()->toArray(),
            'districts' => District::where('state_id', $location->state_id)->get()->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Region\Location $location
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Location $location)
    {
        $validated = $this->validateRequest($request);
        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : createSlugByModelAndTitleByModel(Location::class, $validated['title'], 0);
        $validated['status'] = activeStatus('status');
        $location->update($validated);
        success();

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), $location->title, "public/locations", $location->image, Location::MODULE_NAME);
            $location->update(['image' => $imagePath]);
        }

        return redirect(route('admin.locations.edit', $location->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Location $location
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Location $location)
    {
        $location->delete();
        return $this->success([]);
    }


    private function validateRequest(Request $request)
    {
        return $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255',
            'country_id' => 'required|numeric',
            'state_id' => 'nullable|numeric',
            'district_id' => 'nullable|numeric',
            'status' => 'nullable|boolean',
            'type_id' => 'nullable|numeric',
            'description' => 'nullable|string|max:255',
        ]);
    }
}
