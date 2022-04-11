<?php

namespace App\Models;

use App\User;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

    const STATUS_EMAIL_ONAY_BEKLIYOR = 1; // son kullanıcı email onayı
    const STATUS_EMAIL_ONAYLANDI = 2; // son kullanıcı email onaylandı
    const STATUS_ONAY_BEKLIYOR = 3;
    const STATUS_ONAYLANDI = 4;
    const STATUS_RED = 5;
    const STATUS_IPTAL = 6;
    const STATUS_SURE_DOLDU = 7;


    protected $guarded = ['id'];

    protected $dates = ['start_date', 'end_date', 'verified_at'];


    protected $appends = ['status_text'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get status label
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function getStatusTextAttribute()
    {
        return __("lang.reservation.status." . $this->status);
    }

    /**
     * get day range start-end dates.
     * @return int
     */
    public function getDayCountAttribute()
    {
        return $this->start_date->diffInDays($this->end_date);
    }

    /**
     * appointmenta göre iki tarih arası bir kullanıcı tarafından rezerve edilmiş mi ? ve status = ONAYLANDI mı
     * @param ServiceAppointment $appointment
     * @param string $startDate rezervasyon tarih başlangıç
     * @param string $endDate rezervasyon bitiş tarihi
     * @param string $format
     * @return mixed
     */
    public static function checkHasReservation(ServiceAppointment $appointment, $startDate, $endDate, $format = 'd-m-Y')
    {
        $requestedDays = [];
        foreach (CarbonPeriod::create($startDate, $endDate) as $requestedDay) {
            $requestedDays[] = $requestedDay->format($format);
        }

        // todo : burada filtreleme yaparken status chekc etmek gerek rezervasyomıu iptal etmiş alilnit veya email onayında vs. olabilir bunların iptal edilmesi gerek.
        $hasAnyReservations = Reservation::where('start_date', '>=', $appointment->start_date)->where('end_date', '<=', $appointment->end_date)
            ->where('service_id', $appointment->service_id)->where('status', self::STATUS_ONAYLANDI)->get();

        // rezerve edilmiş günler
        $reservedDays = [];
        foreach ($hasAnyReservations as $reservation) {
            $days = CarbonPeriod::create($reservation->start_date, $reservation->end_date);
            foreach ($days as $day) {
                if (!in_array($day->format($format), $reservedDays)) {
                    $reservedDays[] = $day->format($format);
                }
            }
        }

        // rezerve edilmişlerin içinde kullanıcın istediklerini kontrol et
        $reservedDaysString = '';
        $canReserve = true;
        foreach ($requestedDays as $requestedDay) {
            if (in_array($requestedDay, $reservedDays)) {
                $reservedDaysString .= " $requestedDay - ";
                $canReserve = false;
            }
        }
        return [
            'canReserve' => $canReserve,
            'reservedDays' => $reservedDaysString,
            'reservedDaysArray' => $reservedDays
        ];
    }
}
