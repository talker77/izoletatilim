<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCompanyComment extends Model
{
    protected $guarded = ['id'];


    public function service_company()
    {
        return $this->belongsTo(ServiceCompany::class);
    }
}
