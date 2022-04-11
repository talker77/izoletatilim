<?php

namespace App\Http\Middleware;

use App\Models\Auth\Role;
use App\Models\SepetUrun;
use App\Models\Service;
use App\Models\ServiceComment;
use App\Models\Siparis;
use Closure;
use Illuminate\Support\Facades\View;

class AdminOrderCountMW
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $unReadCommentCount = ServiceComment::whereNull('read_at')
            ->when(!isSuperAdmin(), function ($query) {
                $query->whereHas('service', function ($q) {
                    $q->where('user_id', authAdminUserId());
                });
            })
            ->count();

        $servicePendingApprovalCount = \Cache::remember('admin:service:pending', 60 * 2, function () {
            return Service::where('status', Service::STATUS_PENDING_APPROVAL)->count();
        });

        View::share('unReadCommentCount', $unReadCommentCount);
        View::share('servicePendingApprovalCount', $servicePendingApprovalCount);

        return $next($request);
    }
}
