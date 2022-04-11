<?php

namespace App\Models;

use App\Models\Product\UrunFirma;
use Illuminate\Database\Eloquent\Model;

class PackageCompany extends Model
{
    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo(UrunFirma::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
