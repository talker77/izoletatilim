<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Package extends Model
{
    protected $guarded = ['id'];
    const  MODULE_NAME = 'package';


    /**
     * kullanıcı aktif paketi getirir.
     * @param User $user
     * @return mixed
     */
    public static function getUserActivePackageUser(User $user)
    {
        return PackageUser::with(['package:id,title'])->where(['user_id' => $user->id, 'is_payment' => true])
            ->whereDate('started_at', '<=', Carbon::now())
            ->whereDate('expired_at', '>=', Carbon::now())
            ->latest()->first();
    }

}
