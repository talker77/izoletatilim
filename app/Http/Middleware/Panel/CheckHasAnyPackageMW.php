<?php

namespace App\Http\Middleware\Panel;

use App\Models\Package;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckHasAnyPackageMW
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
        if (!$user) {
            abort(403, "Kullanıcı bulunamadı");
        }
        $userActivePackage = Package::getUserActivePackageUser($user);
        if (!$userActivePackage and !Route::is(['user.packages.*', 'panel.tables.package-transactions']) and $user->isStore()) {
            error('Herhangi bir paketiniz bulunmuyor. Sistemi aktif bir şekilde kullanmak için lütfen paket satın alınız.');
            if ($user->active_package_id) {
                $user->update(['active_package_id' => null]);
            }

            return redirect(route('user.packages.index'));
        }

        return $next($request);
    }
}
