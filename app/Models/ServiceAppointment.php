<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceAppointment extends Model
{
    protected $guarded = [];

    protected $dates = ['start_date', 'end_date'];

//    protected $casts = [
//        'start_date' => 'date:Y-m-d'
//    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
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
     * iki tarih arası rezervasyon kontrol eder
     * @param int $serviceId
     * @param string $startDate rezervasyon tarih başlangıç
     * @param string $endDate rezervasyon bitiş tarihi
     * @return mixed
     */
    public static function checkAppointment(int $serviceId, $startDate, $endDate)
    {
        return self::where(['service_id' => $serviceId, 'status' => 1])
            ->whereHas('service', function ($query) {
                $query->active();
            })
            ->whereDate('start_date', '<=', $startDate)
            ->whereDate('end_date', '>=', $endDate)
            ->orderBy('end_date')
            ->first();
    }
}
