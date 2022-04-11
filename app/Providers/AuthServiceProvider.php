<?php

namespace App\Providers;

use App\Models\Auth\Role;
use App\Models\Favori;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\ServiceAppointment;
use App\Models\ServiceComment;
use App\Policies\FavoritePolicy;
use App\Policies\ReservationPolicy;
use App\Policies\Service\ServiceAppointmentPolicy;
use App\Policies\ServiceCommentPolicy;
use App\Policies\ServicePolicy;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Service::class => ServicePolicy::class,
        Reservation::class => ReservationPolicy::class,
        ServiceComment::class => ServiceCommentPolicy::class,
        Favori::class => FavoritePolicy::class,
        ServiceAppointment::class => ServiceAppointmentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user) {
            if ($user->isSuperADmin()) {
                return true;
            }
        });

        Gate::define('edit-address', function (User $user, \App\Models\KullaniciAdres $address) {
            return $user->id == $address->user_id;
        });

        Gate::define('edit-order', function (User $user, \App\Models\Siparis $order) {
            return $user->id == $order->basket->user_id;
        });

        Gate::define('edit-service', function (User $user, \App\Models\Siparis $order) {
            return $user->id == $order->basket->user_id;
        });
    }
}
