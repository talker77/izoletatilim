<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PackageUser;
use App\Models\Product\UrunYorum;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\ServiceAppointment;
use App\Models\ServiceComment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TableController extends Controller
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function appointments(Service $service)
    {
        return Datatables::of(
            ServiceAppointment::where('service_id', $service->id)
        )->make();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function reservations(Request $request)
    {
        $user = loggedPanelUser();
        return Datatables::of(
            Reservation::with(['service:id,title,slug', 'user:name,surname,email,id'])
                ->when($user->isStore(), function ($query) use ($request) {
                    $query->whereHas('service', function ($query) {
                        $query->where('user_id', loggedPanelUser()->id);
                    })->when($request->get('serviceId'), function ($query) use ($request) {
                        $query->where('service_id', $request->get('serviceId'));
                    })->when($request->get('status'), function ($query) use ($request) {
                        $query->where('status', $request->get('status'));
                    });
                })
                ->when($user->isCustomer(), function ($query) use ($user) {
                    $query->where('reservations.user_id', $user->id);
                })
        )->make();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function comments(Request $request)
    {
        return Datatables::of(
            ServiceComment::with(['service', 'user'])->whereHas('service', function ($query) {
                $query->where('user_id', loggedPanelUser()->id);
            })
                ->when($request->get('serviceId'), function ($query) use ($request) {
                    $query->where('service_id', $request->get('serviceId'));
                })
        )->make();
    }

    /**
     * kullanıcının oluşturduğu paketler
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function packageTransactions(Request $request)
    {
        return Datatables::of(
            PackageUser::with(['package:id,title,price', 'user:name,surname,id,email'])
                ->where('user_id', loggedPanelUser()->id)
        )->make();
    }
}
