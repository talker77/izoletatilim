<?php

namespace App\Jobs;

use App\Models\PackageUser;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class CheckCompanyPackageJob
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
        $packageUsers = PackageUser::where(['is_payment' => true])
            ->whereDate('expired_at', '<=', Carbon::now())
            ->whereDate('expired_at', '>=', Carbon::now()->subDays(2))
            ->whereHas('user', function ($query) {
                $query->whereNotNull('active_package_id');
            })
            ->get();


        foreach ($packageUsers as $packageUser) {
            $packageUser->user->update([
                'active_package_id' => null
            ]);
        }
    }
}
