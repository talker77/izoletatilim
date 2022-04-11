<?php

namespace App\Http\Middleware\Panel;

use App\Models\Auth\Role;
use App\Models\Message;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PanelMW
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
        $user = Auth::guard('panel')->user();
        if ($user && Auth::guard('panel')->check() && $user->is_active && in_array($user->role_id, [Role::ROLE_STORE, Role::ROLE_CUSTOMER]) && $user->is_admin) {
            \View::share('loggedUser', $user);
            \View::share('unReadMessageCount', $this->unReadMessageCount($user));
            return $next($request);
        }
        auth('panel')->logout();
        return redirect(route('user.login'));
    }

    private function unReadMessageCount(User $user)
    {
        return Cache::remember(("user:message:count:" . $user->id),1, function () {
           return Message::where(['to_id' => loggedPanelUser()->id])
               ->whereNull('read_at')
               ->count();
        });
    }
}
