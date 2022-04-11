<?php

namespace App\Http\Controllers;

use App\Http\Filters\ServiceFilter;
use App\Models\Appointment;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\ServiceAppointment;
use App\Models\ServiceAttribute;
use App\Repositories\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param ServiceFilter $filter
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, ServiceFilter $filter)
    {
        $startDate = Carbon::parse($request->startDate);
        $endDate = Carbon::parse($request->endDate);

        $data = Service::with(['country:id,title', 'state:id,title', 'attributes:id,title,icon'
            , 'service_appointments' => function ($query) use ($startDate, $endDate) {
                $query->whereDate('start_date', '<=', $startDate)
                    ->where('status', 1)
                    ->whereDate('end_date', '>=', $endDate)->latest();
            }

        ])->withCount('active_comments')
            ->where(['services.status' => Service::STATUS_PUBLISHED, 'store_type' => Service::STORE_TYPE_LOCAL])
            ->whereNotNull('published_at')
            ->latest()
            ->filter($filter);


        return view('site.service.index', [
            'minPrice' => 0,//$data->min('price'),
            'maxPrice' => 10000,//$data->max('price'),
            'count' => $data->count(),
            'data' => $data->paginate(),
            'attributes' => ServiceAttribute::select(['id', 'title', 'icon'])->where(['status' => true, 'show_menu' => true])->orderBy('order')->get()
        ]);
    }


    /**
     * @param Request $request
     * @param ServiceFilter $filter
     * @return array|string
     */
    public function filter(Request $request, ServiceFilter $filter)
    {
        $startDate = Carbon::parse($request->startDate);
        $endDate = Carbon::parse($request->endDate);

        $data = Service::with(['country:id,title', 'state:id,title', 'attributes:id,title,icon'
            , 'service_appointments' => function ($query) use ($startDate, $endDate) {
                $query->whereDate('start_date', '=', $startDate)
                    ->where('status', 1)
                    ->whereDate('end_date', '>=', $endDate)->latest();
            }

        ])->withCount('active_comments')
            ->where(['services.status' => Service::STATUS_PUBLISHED, 'store_type' => Service::STORE_TYPE_LOCAL])
            ->whereNotNull('published_at')
            ->filter($filter);

        return response()->json([
            'count' => $data->count(),
            'html' => view('site.service.partials.pagination_data', ['data' => $data->paginate()])->render(),
        ]);
    }

    /**
     * LocalService  detail
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request, string $slug)
    {
        $startDate = Carbon::parse($request->startDate);
        $endDate =  $request->endDate ? Carbon::parse($request->endDate) : Carbon::now()->addDay();

        $service = Service::with(['images', 'user', 'last_active_comments'])->withCount('active_comments')->where(['slug' => $slug])
            ->active()->local()
            ->firstOrFail();

        $this->syncViewCount($service);

        $similarServices = Service::with('district:id,title')->where(['state_id' => $service->state_id])
            ->where('id', '!=', $service->id)
            ->active()->local()
            ->latest()->take(3)->get();

        $appointment = ServiceAppointment::checkAppointment($service->id, $startDate, $endDate);

        return view('site.service.detail', [
            'item' => $service,
            'similarServices' => $similarServices,
            'appointment' => $appointment,
            'days' => $appointment ? $startDate->diffInDays($endDate) : 0,
            'totalPrice' => $appointment ? $appointment->price * $startDate->diffInDays($endDate) : 0
        ]);
    }

    /**
     * @param Request $request
     * @param $serviceID
     * @param ServiceFilter $filter
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function serviceItemDetail(Request $request, $serviceID)
    {
        $startDate = Carbon::parse($request->startDate);
        $endDate = Carbon::parse($request->endDate);

        $item = Service::with(['images', 'last_active_company_comments'])
            ->where(['status' => 1, 'id' => $serviceID, 'store_type' => Service::STORE_TYPE_EXTERNAL])
            ->firstOrFail();

        $appointments = Appointment::with('service_company')
            ->whereDate('start_date', '=', $startDate)
            ->whereDate('end_date', '>=', $endDate)
            ->whereIn('service_company_id', $item->service_companies->pluck('id')->toArray())
            ->get();

        return view('site.service.partials.service-list-item-detail', [
            'item' => $item,
            'appointments' => $appointments
        ]);
    }

    /**
     * @param string $slug
     */
    public function gallery(string $slug)
    {
        $service = Service::with(['images'])->where(['slug' => $slug])->active()->local()->firstOrFail();

        return view('site.service.partials.popup-gallery', [
            'item' => $service
        ]);
    }

    /**
     * iki tarih arası rezervasyon durumunu kontrol et
     * @param string $slug
     */
    public function checkAppointment(Request $request, $serviceId)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ]);
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $appointment = ServiceAppointment::checkAppointment($serviceId, $startDate, $endDate);

        if (!$appointment) {
            abort(404);
        }

        $hasReservation = Reservation::checkHasReservation($appointment, $startDate, $endDate);
        if (!$hasReservation['canReserve']) {
            return $this->error(__('lang.reservations.already_reserved_by_other_user', [
                'reserved_days' => $hasReservation['reservedDays']
            ]));
        }


        return $this->success([
            'appointment' => $appointment,
            'dayCount' => $endDate->diffInDays($startDate),
            'subTotal' => $endDate->diffInDays($startDate) * $appointment->price
        ]);
    }

    /**
     * hizmet görüntülenme sayısını günceller.
     * @param Service $service
     */
    private function syncViewCount(Service $service)
    {
        $key = "service:{$service->id}:" . \request()->ip();
        Cache::remember($key, 10 * 60, function () use ($service) {
            return $service->increment('view_count');
        });
    }

    /**
     * @param int $serviceId
     */
    public function createComment(Request $request, $serviceId)
    {
        $validated = $request->validate([
            'message' => 'required|max:255'
        ]);
        $service = Service::active()->where('id', $serviceId)->firstOrFail();
        $serviceUserCommentCount = $service->comments()->where('user_id', loggedPanelUser()->id)->count();
        if ($serviceUserCommentCount) {
            error('Bu gönderiye zaten bir yorum yaptın');
            return back();
        }
        $service->comments()->create(array_merge($validated, [
            'user_id' => loggedPanelUser()->id
        ]));

        success('Yorum eklendi yönetici onayından sonra yorumunuz burada gözükecektir.');
        return back();
    }


}
