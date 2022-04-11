<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Auth\Role;
use App\Models\Product\UrunFirma;
use App\Models\Region\Country;
use App\Models\Region\District;
use App\Models\Region\State;
use App\Models\Service;
use App\Models\ServiceAppointment;
use App\Models\ServiceAttribute;
use App\Models\ServiceCompany;
use App\Models\ServiceImage;
use App\Models\ServiceType;
use App\Notifications\Service\ServiceApproved;
use App\Notifications\Service\ServiceRejected;
use App\Repositories\Traits\ImageUploadTrait;
use App\Repositories\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    use ImageUploadTrait;
    use ResponseTrait;

    public function __construct()
    {
        $this->authorizeResource(Service::class, 'service');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        \Cache::forget('admin:service:pending');
        return view('admin.services.list', [
            'companies' => UrunFirma::orderBy('title')->get(),
            'countries' => Country::orderBy('title')->get(),
            'types' => ServiceType::orderBy('title')->get(),
        ]);
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
        $validated['published_at'] = $request->has('published_at') ? Carbon::now() : null;
        if (!isSuperAdmin()) {
            $validated['user_id'] = authAdminUserId();
        }
        $validated['slug'] = createSlugByModelAndTitleByModel(Service::class, $validated['title'], 0);
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
        $service->load('images');
        return view('admin.services.create', [
            'item' => $service,
            'types' => ServiceType::orderBy('title')->get()->toArray(),
            'countries' => Country::orderBy('title')->get()->toArray(),
            'storeTypes' => Service::storeTypes(),
            'states' => State::where('country_id', $service->country_id)->get()->toArray(),
            'districts' => District::where('state_id', $service->state_id)->get()->toArray(),
            'attributes' => ServiceAttribute::orderBy('title')->where(['type_id' => $service->type_id])->get(),
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
        $validated['slug'] = createSlugByModelAndTitleByModel(Service::class, $validated['title'], $service->id);
        $validated['published_at'] = $request->has('published_at') ? Carbon::now() : null;
        $service->update($validated);
        $service->attributes()->sync($request->get("attributes"));
        success();

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), $service->title, "public/services", $service->image, Service::MODULE_NAME);
            $this->uploadThumbImage($request->file('image'), $imagePath, 'public/services/thumb', $service->image, 'service_image_thumb');
            $service->update(['image' => $imagePath]);
        }

        $this->uploadImages($request, $service);

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

    public function deleteImage(ServiceImage $image)
    {
        $image_path = 'public/service-gallery/' . $image->title;
        $image_path_minify = 'public/service-gallery-thumb/' . $image->title;
        if (\Storage::exists($image_path)) {
            \Storage::delete($image_path);
        }
        if (\Storage::exists($image_path_minify)) {
            \Storage::delete($image_path_minify);
        }
        $image->delete();
        return $this->success();
    }


    private function validateRequest(Request $request)
    {
        $data = [];
        if (isSuperAdmin()) {
            $data['point'] = 'nullable|numeric|max:5|min:0';
        }
        return $request->validate(array_merge($data, [
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255',
            'point' => 'nullable|numeric|max:10|min:0',
            'country_id' => 'required|numeric',
            'state_id' => 'nullable|numeric',
            'district_id' => 'nullable|numeric',
            'status' => 'nullable|numeric',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable',
            'store_type' => 'numeric|nullable',
//            'redirect_to' => 'string|nullable',
            'type_id' => 'nullable|numeric',
            'person' => 'required|numeric|min:1|max:255',
        ]));
    }


    /**
     * @param Request $request
     * @param Service $entry
     */
    private function uploadImages(Request $request, Service $entry)
    {
        if ($request->hasFile('imageGallery')) {
            foreach (request()->file("imageGallery") as $index => $file) {
                if ($index < 10) {
                    $uploadPath = $this->uploadImage($file, $entry->title, "public/service-gallery/", null, ServiceImage::MODULE_NAME);
                    ServiceImage::create(['service_id' => $entry->id, 'title' => $uploadPath]);
                } else {
                    error("Servise ait en fazla 10 adet resim yükleyebilirsiniz");
                    break;
                }
            }
        }
    }


    /**
     * @param Service $service
     * @return mixed
     * @throws \Exception
     */
    public function appointments(Service $service)
    {
        if ($service->store_type == Service:: STORE_TYPE_LOCAL) {
            return Datatables::of(
                ServiceAppointment::where('service_id', $service->id)
            )->make();
        }
        return Datatables::of(
            Appointment::with(['service_company.company'])->whereHas('service_company', function ($query) use ($service) {
                $query->where('service_id', $service->id);
            })
        )->make();
    }

    public function createStoreAppointment(Request $request, Service $service)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|min:0'
        ]);

        ServiceAppointment::updateOrCreate([
            'service_id' => $service->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ], [
            'price' => $validated['price'],
            'status' => activeStatus('status')
        ]);
        success();

        return back();
    }

    public function updateStoreAppointment(Request $request, ServiceAppointment $serviceAppointment)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|min:0'
        ]);

        $existsService = ServiceAppointment::where([
            'service_id' => $serviceAppointment->service_id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ])->where('id', '!=', $serviceAppointment->id)->first();

        if ($existsService) {
            $existsService->delete();
        }
        $serviceAppointment->update([
            'price' => $validated['price'],
            'status' => activeStatus('status')
        ]);

        success();

        return back();
    }

    public function appointmentDetail(ServiceAppointment $serviceAppointment)
    {
        return view('admin.services.partials.edit-service-appointment-modal', [
            'item' => $serviceAppointment
        ]);
    }

    public function deleteStoreAppointment(ServiceAppointment $serviceAppointment)
    {
        $serviceAppointment->delete();
        return $this->success();
    }

    /**
     * approve service
     * @param Service $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveService(Service $service)
    {
        $service->user->notify(new ServiceApproved($service));
        $service->update(['status' => Service::STATUS_PUBLISHED, 'published_at' => Carbon::now()]);
        success();

        return back();
    }

    /**
     * approve service
     * @param Service $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectService(Service $service)
    {
        $service->user->notify(new ServiceRejected($service));
        $service->update(['status' => Service::STATUS_REJECTED, 'published_at' => null]);
        success();

        return back();
    }
}
