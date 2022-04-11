<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.packages.index',[
            'packages' => Package::all()
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
        $data = $this->validateRequest($request);
        $data['status'] = activeStatus('status');
        $package = Package::create($data);
        success();

        return redirect(route('admin.packages.edit', $package->id));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id = 0)
    {
        $item = $id != 0 ? Package::findOrFail($id) : new Package();

        return view('admin.packages.create', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Package $package
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Package $package)
    {
        $data = $this->validateRequest($request);
        $package->update($data);
        success();

        return redirect(route('admin.packages.edit', $package->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Package $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Package $type)
    {
        $type->delete();

        return $this->success([]);
    }


    private function validateRequest(Request $request)
    {
        return $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255',
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric|between:0,99999.99',
            'day' => 'required|numeric',
            'status' => 'nullable|boolean',
        ]);
    }
}
