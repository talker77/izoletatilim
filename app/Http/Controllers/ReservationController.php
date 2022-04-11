<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Service;
use App\Models\ServiceAppointment;
use App\Notifications\Reservation\PendingReservationRequestNotification;
use App\Notifications\Reservation\ReservationMailVerifiedNotification;
use App\Notifications\Reservation\VerifyReservationNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * iki tarih arası rezervasyon yap.
     * @param string $slug
     */
    public function makeReservation(Request $request, $serviceId)
    {
        $request->validate([
            'startDate' => 'required|date|after_or_equal:today',
            'endDate' => 'required|date|after:startDate',
        ]);

        $startDate = Carbon::parse($request->startDate);
        $endDate = Carbon::parse($request->endDate);
        $appointment = ServiceAppointment::checkAppointment($serviceId, $startDate, $endDate);

        if (!$appointment) {
            return back()->withErrors(__('lang.reservations.no_available_reservation_not_found_at_selected_times'));
        }

        $hasReservation = Reservation::checkHasReservation($appointment, $startDate, $endDate);
        if (! $hasReservation['canReserve']) {
            return back()->withErrors(__('lang.reservations.already_reserved_by_other_user', [
                'reserved_days' => $hasReservation['reservedDays']
            ]));
        }

        $reservation = Reservation::create([
            'user_id' => $request->user('panel')->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'price' => $appointment->price,
            'total_price' => $appointment->price * $startDate->diffInDays($endDate),
            'status' => Reservation::STATUS_EMAIL_ONAY_BEKLIYOR,
            'service_id' => $serviceId
        ]);

        $request->user('panel')->notify(new VerifyReservationNotification($reservation));

        success(__('lang.reservations.reservation_created_please_verify_email'));

        return back();
    }


    /**
     * kullanıcı oluşturduğu rezervasyon isteğiniz doğrulaması için kullanılır.
     * @param Reservation $reservation
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verify(Reservation $reservation)
    {
        $reservation->update([
            'verified_at' => Carbon::now(),
            'status' => Reservation::STATUS_ONAY_BEKLIYOR
        ]);
        $reservation->service->user->notify(new PendingReservationRequestNotification($reservation));
        $reservation->user->notify(new ReservationMailVerifiedNotification($reservation));

        success(__('panel.reservations.reservation_email_verified_please_wait_for_approve'));

        return redirect(route('user.reservations.index'));
    }


    /**
     * get reserved days
     *
     * @param Service $service
     */
    public function getReservedDays(Request $request, Service $service)
    {
        $validated = $request->validate(['month' => 'required|integer|min:0|max:12']);

        $startDate = Carbon::createFromFormat('m', $validated['month'])->startOfMonth();
        $endDate = Carbon::createFromFormat('m', $validated['month'])->endOfMonth();

        $appointment = new ServiceAppointment([
            'service_id' => $service->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return Reservation::checkHasReservation($appointment, $startDate, $endDate);
    }
}
