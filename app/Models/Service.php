<?php

namespace App\Models;

use App\Models\Region\District;
use App\Models\Region\State;
use App\User;
use App\Utils\Concerns\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use Filterable;
    use SoftDeletes;

    /**
     *  Mağaza tipleri local veya yönlendirme
     * STORE_TYPE_LOCAL = airbnb tarzı kullanıcıların yüklediği
     * STORE_TYPE_EXTERNAL = api ile iletişim kurulan firmalar,oteller
     */
    const STORE_TYPE_LOCAL = 1;
    const STORE_TYPE_EXTERNAL = 2;

    /**
     * servislerin status kodları
     */
    const STATUS_PASSIVE = 1;
    const STATUS_PENDING_APPROVAL = 2;
    const STATUS_PUBLISHED = 3;
    const STATUS_REJECTED = 4;
    const STATUS_REQUIRE_ACTIVE_APPOINTMENT = 5;


    const PER_PAGE = 2;
    protected $perPage = 2;


    protected $guarded = ['id'];
    const MODULE_NAME = 'service';

    protected $dates = [
        'published_at'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function service_companies()
    {
        return $this->hasMany(ServiceCompany::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ServiceType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ServiceImage::class)->orderByDesc('id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(ServiceComment::class)->orderByDesc('id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function active_comments()
    {
        return $this->hasMany(ServiceComment::class)->orderByDesc('id')->where('status', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function last_active_comments()
    {
        return $this->hasMany(ServiceComment::class)->orderByDesc('id')->where('status', 1)->take(10);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function company_comments()
    {
        return $this->hasMany(ServiceCompanyComment::class)->orderByDesc('id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function active_company_comments()
    {
        return $this->hasMany(ServiceCompanyComment::class)->orderByDesc('id')->where('status', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function last_active_company_comments()
    {
        return $this->hasMany(ServiceCompanyComment::class)->orderByDesc('id')->where('status', 1)->take(5);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributes()
    {
        return $this->belongsToMany(ServiceAttribute::class, 'service_attribute');
    }

    /**
     * yerel hizmete bağlı randevular
     */
    public function service_appointments()
    {
        return $this->hasMany(ServiceAppointment::class);
    }

    /**
     * aktif olan hizmetler
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED)->whereNotNull('published_at');
    }

    /**
     * yerel olan hizmetler
     */
    public function scopeLocal($query)
    {
        return $query->where('store_type', self::STORE_TYPE_LOCAL);
    }


    /**
     * @return array[]
     */
    public static function storeTypes(): array
    {
        return [
            self::STORE_TYPE_LOCAL => [self::STORE_TYPE_LOCAL, "Yerel Hizmet"],
            self::STORE_TYPE_EXTERNAL => [self::STORE_TYPE_EXTERNAL, "Harici Link"],
        ];
    }


    /**
     * @return float|int
     */
    public function getStarPercentAttribute()
    {
        return $this->point * 10;
    }

    /**
     * @return float|int
     */
    public function getStarAttribute()
    {
        return round($this->point / 2, 1);
    }


    /**
     * İl ilçe text getir.
     * @return string
     */
    public function getLocationTextAttribute()
    {
        return ($this->district ? $this->district->title : '') . '/' . ($this->state ? $this->state->title : '');
    }

    /**
     * Rezervasyonlar için ortalama fiyat bilgisi.
     * @return mixed
     */
    public function getAvgPriceAttribute()
    {
        return $this->service_appointments()->avg('price');
    }

    /**
     * başlık yuvvarlanmış
     * @return mixed
     */
    public function roundedTitle($precision = 10)
    {
        return str_limit($this->title, $precision);
    }

    /**
     * service'e ait appointment sayısını gönder.
     * @param Service $service
     * @return int
     */
    public function getActiveServiceAppointmentsCount(): int
    {
        return $this->service_appointments()
            ->whereDate('end_date', '>=', now())
            ->where('status', true)
            ->count();
    }
}
