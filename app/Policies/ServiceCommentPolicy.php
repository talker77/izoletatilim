<?php

namespace App\Policies;

use App\Models\Auth\Role;
use App\Models\ServiceComment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceCommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any service comments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return in_array($user->role_id, [Role::ROLE_SUPER_ADMIN, Role::ROLE_STORE]);
    }

    /**
     * Determine whether the user can view the service comment.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ServiceComment  $serviceComment
     * @return mixed
     */
    public function view(User $user, ServiceComment $serviceComment)
    {
        return $serviceComment->service->user_id == $user->id;
    }

    /**
     * Determine whether the user can create service comments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, [Role::ROLE_SUPER_ADMIN, Role::ROLE_STORE]);
    }

    /**
     * Determine whether the user can update the service comment.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ServiceComment  $serviceComment
     * @return mixed
     */
    public function update(User $user, ServiceComment $serviceComment)
    {
        return $serviceComment->service->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the service comment.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ServiceComment  $serviceComment
     * @return mixed
     */
    public function delete(User $user, ServiceComment $serviceComment)
    {
        return $user->role_id == Role::ROLE_SUPER_ADMIN;
    }

    /**
     * Determine whether the user can restore the service comment.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ServiceComment  $serviceComment
     * @return mixed
     */
    public function restore(User $user, ServiceComment $serviceComment)
    {
        return $user->role_id == Role::ROLE_SUPER_ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the service comment.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ServiceComment  $serviceComment
     * @return mixed
     */
    public function forceDelete(User $user, ServiceComment $serviceComment)
    {
        return $user->role_id == Role::ROLE_SUPER_ADMIN;
    }
}
