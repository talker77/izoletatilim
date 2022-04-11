<?php

namespace App\Policies\Service;

use App\Models\ServiceAppointment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceAppointmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the service appointment.
     *
     * @param \App\User $user
     * @param \App\Models\ServiceAppointment $serviceAppointment
     * @return mixed
     */
    public function view(User $user, ServiceAppointment $serviceAppointment)
    {
        return (bool) $serviceAppointment->service->user_id == $user->id;
    }

    /**
     * Determine whether the user can create service appointments.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the service appointment.
     *
     * @param \App\User $user
     * @param \App\Models\ServiceAppointment $serviceAppointment
     * @return mixed
     */
    public function update(User $user, ServiceAppointment $serviceAppointment)
    {
        return (bool) $serviceAppointment->service->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the service appointment.
     *
     * @param \App\User $user
     * @param \App\Models\ServiceAppointment $serviceAppointment
     * @return mixed
     */
    public function delete(User $user, ServiceAppointment $serviceAppointment)
    {
        return (bool) $serviceAppointment->service->user_id == $user->id;
    }
}
