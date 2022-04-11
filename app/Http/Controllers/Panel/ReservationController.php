<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\ServiceAppointment;
use App\Notifications\Reservation\ReservationApproved;
use App\Notifications\Reservation\ReservationCancelledFromClientNotification;
use App\Notifications\Reservation\ReservationRejected;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{


    public function index()
    {
        return view('site.kullanici.reservations.index');
    }


    public function show(Reservation $reservation)
    {
        $this->authorizeForUser(loggedPanelUser(), 'view', $reservation);

        $reservation->load(['user', 'service']);

        return view('site.kullanici.reservations.show', [
            'item' => $reservation
        ]);
    }

    /**
     * rezervasyonun sağlayıcı tarafından onaylanmasını sağlar.
     */
    public function approve(Reservation $reservation)
    {
        $this->authorizeForUser(loggedPanelUser(), 'approve', $reservation);

        if ($reservation->status == Reservation::STATUS_ONAYLANDI) {
            return back()->withErrors(__('panel.already_verified'));
        }
        $reservation->update(['status' => Reservation::STATUS_ONAYLANDI]);
        $reservation->user->notify(new ReservationApproved($reservation));

        success();
        return back();
    }

    /**
     * rezervasyonun sağlayıcı tarafından reddilmesini sağlar.
     */
    public function reject(Reservation $reservation)
    {
        $this->authorizeForUser(loggedPanelUser(), 'reject', $reservation);

        if ($reservation->status == Reservation::STATUS_ONAYLANDI) {
            return back()->withErrors(__('panel.already_verified'));
        }
        $reservation->update(['status' => Reservation::STATUS_RED]);
        $reservation->user->notify(new ReservationRejected($reservation));

        success();
        return back();
    }

    /**
     * rezervasyonun son kullanıcı tarafından reddilmesini sağlar.
     */
    public function cancel(Reservation $reservation)
    {
        $this->authorizeForUser(loggedPanelUser(), 'cancel', $reservation);

        if ($reservation->status == Reservation::STATUS_IPTAL) {
            return back()->withErrors(__('panel.already_canceled'));
        }
        if ($reservation->status == Reservation::STATUS_ONAY_BEKLIYOR) {
            /**
             *  mağaza tarafından  onay bekleyen rezervasyon eğer son kullanıcı tarafından iptal edilirse mağazaya bildirim gider.
             */
            $reservation->service->user->notify(new ReservationCancelledFromClientNotification($reservation));
        }
        $reservation->update(['status' => Reservation::STATUS_IPTAL]);
        success();
        return back();
    }




}
