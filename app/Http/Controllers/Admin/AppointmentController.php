<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ServiceCompany;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.appointment.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.appointment.create', [
            'item' => new Appointment(),
            'service_companies' => ServiceCompany::with(['company'])->select(['id', 'title', 'company_id'])->orderBy('title')->get(),
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
        $data = $request->all();
        $data['status'] = activeStatus('status');
        $appointment = Appointment::create($data);
        success();

        return redirect(route('admin.appointments.edit', $appointment->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Appointment $appointment
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Appointment $appointment)
    {
        return view('admin.appointment.create', [
            'item' => $appointment,
            'service_companies' => ServiceCompany::with(['company'])->select(['id', 'title', 'company_id'])->orderBy('title')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Appointment $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Appointment $appointment)
    {
        $data = $request->all();
        $data['status'] = activeStatus('status');
        $appointment->update($data);
        success();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return $this->success();
    }
}
