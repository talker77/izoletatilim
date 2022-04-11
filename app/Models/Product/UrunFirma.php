<?php

namespace App\Models\Product;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UrunFirma extends Model
{
    protected $table = "firmalar";
    protected $guarded = [];
    const MODULE_NAME = 'product_company';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
