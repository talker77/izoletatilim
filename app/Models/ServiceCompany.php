<?php

namespace App\Models;

use App\Models\Product\UrunFirma;
use App\Utils\Concerns\Filterable;
use Illuminate\Database\Eloquent\Model;

class ServiceCompany extends Model
{
    use  Filterable;

    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(UrunFirma::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
