<?php

namespace App\Policies;

use App\Models\Auth\Role;
use App\Models\Service;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any services.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the service.
     *
     * @param \App\User $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function view(User $user, Service $service)
    {
        return $service->user_id === $user->id;
    }

    /**
     * Determine whether the user can create services.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, [Role::ROLE_SUPER_ADMIN, Role::ROLE_STORE]);
    }

    /**
     * Determine whether the user can update the service.
     *
     * @param \App\User $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function update(User $user, Service $service)
    {
        return $service->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the service.
     *
     * @param \App\User $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function delete(User $user, Service $service)
    {
        return $service->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the service.
     *
     * @param \App\User $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function restore(User $user, Service $service)
    {
        return $service->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the service.
     *
     * @param \App\User $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function forceDelete(User $user, Service $service)
    {
        return $service->user_id === $user->id;
    }
}
