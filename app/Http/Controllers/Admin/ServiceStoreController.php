<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Region\District;
use App\Models\Region\State;
use App\Models\Service;
use App\Models\ServiceAttribute;
use App\Models\ServiceType;
use App\Repositories\Traits\ImageUploadTrait;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceStoreController extends Controller
{
    use ImageUploadTrait;
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.services.store.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.services.create', [
            'item' => new Service(),
            'types' => ServiceType::orderBy('title')->get()->toArray(),
            'countries' => Country::orderBy('title')->get()->toArray(),
            'storeTypes' => Service::storeTypes(),
            'attributes' => ServiceAttribute::orderBy('title')->get(),
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
        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : createSlugByModelAndTitleByModel(Service::class, $validated['title'], 0);
        $service = Service::create($validated);
        $service->attributes()->attach($request->get("attributes"));
        success();

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), $service->title, "public/services", $service->image, Service::MODULE_NAME);
            $service->update(['image' => $imagePath]);
        }

        return redirect(route('admin.services.edit', $service->id));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Service $service
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Service $service)
    {
        return view('admin.services.create', [
            'item' => $service,
            'types' => ServiceType::orderBy('title')->get()->toArray(),
            'countries' => Country::orderBy('title')->get()->toArray(),
            'storeTypes' => Service::storeTypes(),
            'states' => State::where('country_id', $service->country_id)->get()->toArray(),
            'districts' => District::where('state_id', $service->state_id)->get()->toArray(),
            'attributes' => ServiceAttribute::orderBy('title')->get(),
            'selected' => [
                'attributes' => $service->attributes->pluck('id')->toArray('id')
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Service $service)
    {
        $validated = $this->validateRequest($request);
        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : createSlugByModelAndTitleByModel(Service::class, $validated['title'], 0);
        $validated['status'] = activeStatus('status');
        $service->update($validated);
        $service->attributes()->sync($request->get("attributes"));
        success();

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), $service->title, "public/services", $service->image, Service::MODULE_NAME);
            $service->update(['image' => $imagePath]);
        }

        return redirect(route('admin.services.edit', $service->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return $this->success([]);
    }


    private function validateRequest(Request $request)
    {
        return $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255',
            'point' => 'nullable|numeric|max:5|min:0',
            'country_id' => 'required|numeric',
            'state_id' => 'nullable|numeric',
            'district_id' => 'nullable|numeric',
            'status' => 'nullable|boolean',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable',
            'store_type' => 'numeric|nullable',
//            'redirect_to' => 'string|nullable',
            'type_id' => 'nullable|numeric',
        ]);
    }
}
