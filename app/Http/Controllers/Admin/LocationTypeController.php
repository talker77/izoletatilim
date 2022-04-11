<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LocationType;
use App\Models\ServiceType;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;

class LocationTypeController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.locations.types.list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $serviceType = LocationType::create($data);
        success();

        return redirect(route('admin.locations.type.edit', $serviceType->id));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id = 0)
    {
        $item = $id != 0 ? LocationType::findOrFail($id) : new LocationType();

        return view('admin.locations.types.create', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param LocationType $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, LocationType $type)
    {
        $data = $request->all();
        $type->update($data);
        success();

        return redirect(route('admin.locations.type.edit', $type->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param LocationType $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LocationType $type)
    {
        $type->delete();

        return $this->success([]);
    }
}
