<?php

namespace App\Models;

use App\Utils\Concerns\Filterable;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    const PER_PAGE = 2;
    protected $perPage = 2;

//    protected $casts = [
//        'start_date' => 'date:Y-m-d'
//    ];

//    protected $dates = [
//        'start_date',
//        'end_date'
//    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service_company()
    {
        return $this->belongsTo(ServiceCompany::class);
    }
}
