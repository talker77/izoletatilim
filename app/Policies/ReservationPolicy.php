<?php

namespace App\Policies;

use App\Models\Reservation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any reservations.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isStore() && $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can view the reservation.
     *
     * @param \App\User $user
     * @param \App\Models\Reservation $reservation
     * @return mixed
     */
    public function view(User $user, Reservation $reservation)
    {
        return $this->basicPermissions($reservation, $user);
    }

    /**
     * Determine whether the user can create reservations.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isCustomer() or $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the reservation.
     *
     * @param \App\User $user
     * @param \App\Models\Reservation $reservation
     * @return mixed
     */
    public function update(User $user, Reservation $reservation)
    {
        if ($user->isCustomer()) {
            return $reservation->user_id == $user->id;
        }
        if ($user->isStore()) {
            return $user->id == $reservation->service->user_id;
        }
        return $user->id == $reservation->service->user_id or $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete the reservation.
     *
     * @param \App\User $user
     * @param \App\Models\Reservation $reservation
     * @return mixed
     */
    public function delete(User $user, Reservation $reservation)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the reservation.
     *
     * @param \App\User $user
     * @param \App\Models\Reservation $reservation
     * @return mixed
     */
    public function restore(User $user, Reservation $reservation)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the reservation.
     *
     * @param \App\User $user
     * @param \App\Models\Reservation $reservation
     * @return mixed
     */
    public function forceDelete(User $user, Reservation $reservation)
    {
        return $user->isSuperAdmin();
    }


    /**
     * Determine whether the user can approve the reservation.
     *
     * @param \App\User $user
     * @param \App\Models\Reservation $reservation
     * @return mixed
     */
    public function approve(User $user, Reservation $reservation)
    {
        if ($user->isStore()) {
            return $user->id == $reservation->service->user_id;
        }
        return false;
    }

    /**
     * Determine whether the user can reject the reservation.
     *
     * @param \App\User $user
     * @param \App\Models\Reservation $reservation
     * @return mixed
     */
    public function reject(User $user, Reservation $reservation)
    {
        if ($user->isStore()) {
            return $user->id == $reservation->service->user_id;
        }
        return false;
    }


    /**
     * Determine whether the user can cancel the reservation from client user.
     *
     * @param \App\User $user
     * @param \App\Models\Reservation $reservation
     * @return mixed
     */
    public function cancel(User $user, Reservation $reservation)
    {
        return $this->basicPermissions($reservation, $user);
    }

    private function basicPermissions(Reservation $reservation, User $user)
    {
        return $reservation->user_id == $user->id || $reservation->service->user_id == $user->id;
    }
}
