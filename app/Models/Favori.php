<?php

namespace App\Models;

use App\Models\Product\Urun;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    protected $table = "favoriler";
    protected $guarded = [];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
