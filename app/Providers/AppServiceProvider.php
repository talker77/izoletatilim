<?php

namespace App\Providers;

use App\User;
use App\Listeners\LoggingListener;
use App\Models\Auth\Role;
use App\Models\Ayar;
use App\Models\Kategori;
use App\Models\Siparis;
use App\Models\Product\Urun;
use App\Observers\OrderObserver;
use App\Observers\UrunObserver;
use App\Repositories\Concrete\ElBaseRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['site.*'], function ($view) {
            $site = Ayar::getCache();
            $user = \Auth::user();
            $view->with(compact('site', 'user'));
        });
        View::composer(['admin.*'], function ($view) {
            $unreadCommentsCount = 0;
            $lastUnreadComments = [];
            $menus = $this->_getAdminMenus();
            $languages = Ayar::activeLanguages();
            $adUser = \Auth::user('admin');

            $view->with(compact('lastUnreadComments', 'unreadCommentsCount', 'menus', 'languages', 'adUser'));
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LoggingListener::class);


        $this->app->singleton(ElBaseRepository::class, function ($app, $parameters) {
            return new ElBaseRepository($parameters['model']);
        });
    }

    private function _getAdminMenus()
    {
        try {
            $menus = config('admin.menus');
            $roleId = auth()->guard('admin')->user()->role_id;
            $role = Role::where('id', $roleId)->first();
            if ($role) {
                $userPermissions = $role->permissions;
                if ($userPermissions ) { // && $role->id != Role::ROLE_SUPER_ADMIN
                    $userPermissions = $role->permissions->pluck('name');
                    foreach ($menus as $index => $header) {
                        foreach ($header as $k => $head) {
                            if ($k != 'title') {
                                if (!$userPermissions->contains($head['permission'])) {
                                    unset($menus[$index][$k]);
                                } elseif (isset($head['subs'])) {
                                    foreach ($head['subs'] as $hsubKey => $hsub) {
                                        $permissionName = $menus[$index][$k]['subs'][$hsubKey]['permission'];
                                        if (!$userPermissions->contains($permissionName)) {
                                            unset($menus[$index][$k]['subs'][$hsubKey]);
                                        }
//                                        dump($menus[$index][$k]['subs'][$hsubKey]['permission']);
//                                        unset($menus[$index][$k][$hsubKey]);
                                    }
                                }

                            }
                        }
                    }
                }
                return $menus;
            }
        } catch (\Exception $exception) {
            return null;
        }
    }
}
