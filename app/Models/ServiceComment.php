<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ServiceComment extends Model
{
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
