<?php

namespace App\Policies;

use App\Models\Favori;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FavoritePolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can delete the favori.
     *
     * @param \App\User $user
     * @param \App\Models\Favori $favori
     * @return mixed
     */
    public function delete(User $user, Favori $favori)
    {
        return $favori->user_id == $user->id;
    }
}
