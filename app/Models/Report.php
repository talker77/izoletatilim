<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    const TYPE_SERVICE = 1;
    const TYPE_SERVICE_COMPANY = 2;

    protected $appends = ['type_label'];

    protected $guarded = ['id'];


    public static function listStatusWithId()
    {
        return [
            // index => [id,label,can_editable]
            self::TYPE_SERVICE => [self::TYPE_SERVICE, __('admin.navbar.local_service')],
            self::TYPE_SERVICE_COMPANY => [self::TYPE_SERVICE_COMPANY, __('admin.navbar.company_service')],
        ];
    }

    public function getTypeLabelAttribute()
    {
        return isset(self::listStatusWithId()[$this->type])
            ? self::listStatusWithId()[$this->type][1] : "-";
    }
}
