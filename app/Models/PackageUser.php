<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PackageUser extends Model
{
    protected $guarded = ['id'];

    protected $dates = [
        'started_at',
        'expired_at'
    ];

    protected $casts = [
        'payment_info' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * paketin kaç günlük olduğunu getirir.
     * @return mixed
     */
    public function getRemainingDayAttribute()
    {
        return $this->expired_at->diffInDays(Carbon::now());
    }
}
