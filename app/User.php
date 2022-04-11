<?php

namespace App;

use App\Models\Auth\Role;
use App\Models\Favori;
use App\Models\KullaniciAdres;
use App\Models\Product\UrunFirma;
use App\Models\Reservation;
use App\Models\Service;
use App\Notifications\PasswordReset;
use App\Utils\Concerns\Models\UserNotifications;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements HasLocalePreference
{
    use Notifiable;
    use UserNotifications;
    use CanResetPassword;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $hidden = [
        'password', 'activation_code',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function company()
    {
        return $this->hasOne(UrunFirma::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(KullaniciAdres::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoice_addresses()
    {
        return $this->hasMany(KullaniciAdres::class, 'user_id', 'id')->where('type', KullaniciAdres::TYPE_INVOICE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function default_address()
    {
        return $this->belongsTo(KullaniciAdres::class, 'default_address_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorites()
    {
        return $this->hasMany(Favori::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function default_invoice_address()
    {
        return $this->belongsTo(KullaniciAdres::class, 'default_invoice_address_id', 'id');
    }


    /**
     * get full name
     * @return string
     */
    public function getFullNameAttribute()
    {
        return ($this->isStore() and $this->nickname)
            ? $this->nickname
            : "{$this->name} {$this->surname}";
    }

    /**
     * @return mixed
     */
    public function getLocaleIyzicoAttribute()
    {
        return $this->locale == 'tr' ? 'tr' : 'en';
    }

    /**
     * Get the user's preferred locale.
     *
     * @return string
     */
    public function preferredLocale()
    {
        return $this->locale;
    }

    /**
     * parola sıfırlama isteği gönderir
     * @param $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }

    /**
     * kullanıcı store mu ?
     * @return bool
     */
    public function isStore()
    {
        return $this->role_id == Role::ROLE_STORE;
    }

    /**
     * kullanıcı store mu ?
     * @return bool
     */
    public function isCustomer()
    {
        return $this->role_id == Role::ROLE_CUSTOMER;
    }

    /**
     * kullanıcı store mu ?
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->role_id == Role::ROLE_SUPER_ADMIN;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
