<?php

namespace App\Jobs;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteTimeOutReservationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // todo : test et
        Reservation::whereIn('status', [
            Reservation::STATUS_EMAIL_ONAY_BEKLIYOR,
            Reservation::STATUS_EMAIL_ONAYLANDI,
        ])
            ->whereDate('created_at', '<=', now()->subHour())
            ->update(['status' => Reservation::STATUS_SURE_DOLDU]);
    }
}
