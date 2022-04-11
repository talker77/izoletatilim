<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceAttribute;
use App\Models\ServiceType;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ServiceAttributeController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.services.attributes.list');
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
        $data['show_menu'] = activeStatus('show_menu');
        $attribute = ServiceAttribute::create($data);
        success();

        return redirect(route('admin.services.attribute.edit', $attribute->id));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id = 0)
    {
        $item = $id != 0 ? ServiceAttribute::findOrFail($id) : new ServiceAttribute();

        return view('admin.services.attributes.create', [
            'item' => $item,
            'types' => ServiceType::all()->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ServiceAttribute $attribute
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, ServiceAttribute $attribute)
    {
        $data = $request->all();
        $data['status'] = activeStatus('status');
        $data['show_menu'] = activeStatus('show_menu');
        $attribute->update($data);
        success();

        return redirect(route('admin.services.attribute.edit', $attribute->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ServiceAttribute $serviceAttribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ServiceAttribute $serviceAttribute)
    {
        $serviceAttribute->delete();

        return $this->success([]);
    }

    /**
     * hizmet tipine göre özellikleri getirir.
     * @param ServiceType $serviceType
     * @return mixed
     */
    public function getAttributesByType(ServiceType $serviceType)
    {
        return response()->json([
            'results' => ServiceAttribute::where(['type_id' => $serviceType->id])->orderBy('title')->get()
        ]);
    }
}
