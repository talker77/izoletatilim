<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceType;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.services.types.list');
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
        $data['status'] = activeStatus('status');
        $data['slug'] = createSlugByModelAndTitleByModel(ServiceType::class, $request->title, 0);
        $serviceType = ServiceType::create($data);
        success();

        return redirect(route('admin.services.type.edit', $serviceType->id));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id = 0)
    {
        $item = $id != 0 ? ServiceType::findOrFail($id) : new ServiceType();
        $parents = ServiceType::orderBy('title')->get()->toArray();

        return view('admin.services.types.create', compact('item', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ServiceType $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, ServiceType $type)
    {
        $data = $request->all();
        $data['status'] = activeStatus('status');
        $data['slug'] = createSlugByModelAndTitleByModel(ServiceType::class, $request->title, $type->id);
        $type->update($data);
        success();

        return redirect(route('admin.services.type.edit', $type->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ServiceType $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ServiceType $type)
    {
        $type->delete();

        return $this->success([]);
    }
}
