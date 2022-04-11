<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "cities";
    protected $guarded = [];
    public $timestamps = false;

    public function towns()
    {
        return $this->hasMany(Town::class, 'city', 'id');
    }
}
