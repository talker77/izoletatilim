<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
