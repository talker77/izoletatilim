<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Imports\ServiceImport;
use App\Models\Region\Country;
use App\Models\Region\District;
use App\Models\Region\State;
use App\Models\Service;
use App\Models\ServiceAttribute;
use App\Models\ServiceImage;
use App\Models\ServiceType;
use App\Repositories\Traits\ImageUploadTrait;
use App\Repositories\Traits\ResponseTrait;
use App\Utils\Concerns\Models\ServiceImageConcern;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ServiceController extends Controller
{
    use ResponseTrait;
    use ImageUploadTrait;
    use ServiceImageConcern;

    public function index(Request $request)
    {
        $services = Service::with(['country', 'state', 'district'])->where(['user_id' => loggedPanelUser()->id])
            ->when($request->get('type'), function ($query) use ($request) {
                $query->where('type_id', $request->get('type'));
            })
            ->latest()->paginate(12);

        return view('site.kullanici.services.index', [
            'services' => $services,
            'types' => ServiceType::all(),
        ]);
    }

    public function create(Request $request)
    {
        return view('site.kullanici.services.detail', array_merge($this->initialData(), [
            'item' => new Service(),
            'attributes' => ServiceAttribute::orderBy('title')->get(),
            'states' => State::where(['country_id' => old('country_id', Country::TURKEY)])->get()->toArray(),
            'districts' => District::where(['state_id' => old('state_id', "Istanbul")])->get()->toArray()
        ]));
    }


    public function edit(Request $request, Service $service)
    {
        $this->authorizeForUser(loggedPanelUser(), 'view', $service);

        return view('site.kullanici.services.detail', array_merge($this->initialData(), [
            'item' => $service,
            'states' => State::where(['country_id' => $service->country_id])->orderBy('title')->get()->toArray(),
            'districts' => District::where(['state_id' => $service->state_id])->orderBy('title')->get()->toArray(),
            'attributes' => ServiceAttribute::orderBy('title')->where(['type_id' => $service->type_id])->get(),
            'selected' => [
                'attributes' => $service->attributes->pluck('id')->toArray('id')
            ]
        ]));
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
        $this->authorizeForUser(loggedPanelUser(), 'update', $service);
        $validated = $this->validateRequest($request);
        $validated['slug'] = createSlugByModelAndTitleByModel(Service::class, $validated['title'], $service->id);
        $validated['published_at'] = $request->has('published_at') ? Carbon::now() : null;
        $activeServiceAppointmentCount = $service->getActiveServiceAppointmentsCount();
        if (in_array($service->status, [Service::STATUS_REJECTED, Service::STATUS_PASSIVE, Service::STATUS_PUBLISHED, Service::STATUS_REQUIRE_ACTIVE_APPOINTMENT]) and $activeServiceAppointmentCount > 0) {
            $validated['status'] = Service::STATUS_PENDING_APPROVAL;
        }
        if ($activeServiceAppointmentCount == 0) {
            $validated['status'] = Service::STATUS_REQUIRE_ACTIVE_APPOINTMENT;
        }
        $service->update($validated);
        $service->attributes()->sync($request->get("attributes"));
        success();

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), $service->title, "public/services", $service->image, Service::MODULE_NAME);
            $this->uploadThumbImage($request->file('image'), $imagePath, 'public/services/thumb', $service->image, 'service_thumb');
            $service->update(['image' => $imagePath]);
        }

        $this->uploadImages($request, $service);

        return redirect(route('user.services.edit', $service->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorizeForUser(loggedPanelUser(), 'create', Service::class);

        $validated = $this->validateRequest($request);
        $validated['published_at'] = $request->has('published_at') ? Carbon::now() : null;
        $validated['status'] = Service::STATUS_REQUIRE_ACTIVE_APPOINTMENT;
        $validated['user_id'] = $request->user('panel')->id;
        $validated['slug'] = createSlugByModelAndTitleByModel(Service::class, $validated['title'], 0);
        $validated['store_type'] = Service::STORE_TYPE_LOCAL;
        $service = Service::create($validated);
        $service->attributes()->attach($request->get("attributes"));


        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), $service->title, "public/services", $service->image, Service::MODULE_NAME);
            $this->uploadThumbImage($request->file('image'), $imagePath, 'public/services/thumb', $service->image, 'service_thumb');
            $service->update(['image' => $imagePath]);
        }
        $this->uploadImages($request, $service);
        success();

        return redirect(route('user.services.edit', $service->id));
    }


    /**
     * Delete image gallery item
     * @param ServiceImage $image
     * @return mixed
     * @throws \Exception
     */
    public function deleteImage(ServiceImage $image)
    {
        $this->authorizeForUser(loggedPanelUser(), 'update', $image->service);
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

    /**
     *  excel ile toplu hizmet ekleme
     * @param Request $request
     */
    public function import(Request $request)
    {
        try {
            $request->validate([
                'services' => 'required|mimes:xlsx'
            ]);
            Excel::import(new ServiceImport(loggedPanelUser()), $request->file('services'), null, \Maatwebsite\Excel\Excel::XLSX);
            success();
            return back();
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }


    private function validateRequest(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|max:255',
            'point' => 'nullable|numeric|max:10|min:0',
            'state_id' => 'required|numeric',
            'district_id' => 'required|numeric',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|max:2000|string',
//            'short_description' => 'nullable',
            'type_id' => 'nullable|numeric',
            'person' => 'required|numeric|min:0|max:255',

        ]);
        $validated['country_id'] = Country::TURKEY;

        return $validated;
    }

    /**
     * @param Request $request
     * @param Service $entry
     */
    private function uploadImages(Request $request, Service $entry)
    {
        $this->authorizeForUser(loggedPanelUser(), 'update', $entry);
        if ($request->hasFile('imageGallery')) {
            foreach ($request->file("imageGallery") as $file) {
                $uploadedImageCount = ServiceImage::where(['service_id' => $entry->id])->count();
                if ($uploadedImageCount < config('admin.max_service_image_count')) {
                    $uploadPath = $this->uploadImage($file, $entry->title, "public/service-gallery/", null, ServiceImage::MODULE_NAME);
                    ServiceImage::create(['service_id' => $entry->id, 'title' => $uploadPath]);
                } else {
                    error("İlana ait en fazla " . config('admin.max_service_image_count') . " adet fotoğraf yükleyebilirsiniz");
                    break;
                }
            }
        }
    }

    private function initialData()
    {
        return [
            'countries' => Country::orderBy('title')->get()->toArray(),
            'types' => ServiceType::get(),
        ];
    }
}
