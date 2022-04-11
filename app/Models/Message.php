<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = ['id'];

    /**
     * mesaj göndeirlen kullanıcı
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function to()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * mesajı gönderen kullanıcı
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * service
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function related()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * giriş yapmış kullanıcıya göre gönderici olan taraf kullanıcısı
     */
    public function sender()
    {
        return loggedPanelUser()->id == $this->from_id
            ? $this->to
            : $this->from;
    }

    /**
     * giriş yapmış kullanıcıya göre alıcı olan taraf kullanıcısı
     */
    public function receiver()
    {
        return loggedPanelUser()->id == $this->from_id
            ? $this->from
            : $this->to;
    }

    /**
     * giriş yapmış kullanıcıya göre okunmamış mesaj sayısı
     * @return mixed
     */
    public function unReadCount(User $sender, User $receiver)
    {
        return self::where(['to_id' => $receiver->id,'from_id' => $sender->id])->whereNull('read_at')->count();
    }
}
