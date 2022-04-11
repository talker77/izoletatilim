<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceAttribute extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function type()
    {
        return $this->belongsTo(ServiceType::class);
    }
}
