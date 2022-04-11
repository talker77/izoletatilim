<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $guarded = [];
    protected $perPage = 10;

    const ROLE_SUPER_ADMIN = 1;
    const ROLE_STORE = 2; //Sisteme hizmetlerini yükleyenler
    const ROLE_STORE_WORKER = 3;
    const ROLE_COMPANY = 4; //  Sisteme api sağlayanlar
    const ROLE_CUSTOMER = 5; //  son kullanıcı

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Auth\Permission')->orderBy('name');
    }

    public function users()
    {
        return $this->hasMany('App\Models\Auth\User');
    }

    public static function listConstRolesWithId()
    {
        return [
            self::ROLE_SUPER_ADMIN => [self::ROLE_SUPER_ADMIN, "Süper Admin"],
            self::ROLE_STORE => [self::ROLE_STORE, "Mağaza"],
            self::ROLE_STORE_WORKER => [self::ROLE_STORE_WORKER, "Mağaza Çalışan"],
            self::ROLE_COMPANY => [self::ROLE_COMPANY, "Firma"],
            self::ROLE_CUSTOMER => [self::ROLE_CUSTOMER, "Son Kullanıcı"],
        ];
    }

    public static function roleLabelStatic($param)
    {
        $list = self::listConstRolesWithId();
        return isset($list[$param]) ? $list[$param][1] : 'Kullanıcı';
    }
}
