<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceAppointment;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ServiceAppointmentController extends Controller
{
    use ResponseTrait;



    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Service $service)
    {
        $this->authorizeForUser(loggedPanelUser(), 'update', $service);

        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|min:1'
        ]);
        $oldActiveServiceAppointmentCount = $service->getActiveServiceAppointmentsCount();
        ServiceAppointment::updateOrCreate([
            'service_id' => $service->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ], [
            'price' => $validated['price'],
            'status' => activeStatus('status')
        ]);
        if ($service->getActiveServiceAppointmentsCount() and $oldActiveServiceAppointmentCount == 0 and $service->status !== Service::STATUS_PUBLISHED) {
            $service->update(['status' => Service::STATUS_PENDING_APPROVAL]);
        }

        return $this->success();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(ServiceAppointment $serviceAppointment)
    {
        $this->authorizeForUser(loggedPanelUser(), 'view', $serviceAppointment);
        return view('site.kullanici.services.partials.edit-service-appointment-modal', [
            'item' => $serviceAppointment
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ServiceAppointment $serviceAppointment)
    {
        $this->authorizeForUser(loggedPanelUser(), 'update', $serviceAppointment);
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|min:1'
        ]);
        $oldActiveServiceAppointmentCount = $serviceAppointment->service->getActiveServiceAppointmentsCount();
        $existsService = ServiceAppointment::where([
            'service_id' => $serviceAppointment->service_id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ])->where('id', '!=', $serviceAppointment->id)->first();

        if ($existsService) {
            $existsService->delete();
        }
        $serviceAppointment->update(array_merge($validated, [
            'status' => activeStatus('status')
        ]));

        if ($serviceAppointment->service->getActiveServiceAppointmentsCount() and $oldActiveServiceAppointmentCount == 0 and $serviceAppointment->service->status !== Service::STATUS_PUBLISHED) {
            $serviceAppointment->service->update(['status' => Service::STATUS_PENDING_APPROVAL]);
        }

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceAppointment $serviceAppointment)
    {
        $this->authorizeForUser(loggedPanelUser(), 'delete', $serviceAppointment);
    }
}
