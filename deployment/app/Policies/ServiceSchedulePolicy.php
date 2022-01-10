<?php

namespace App\Policies;

use App\Models\Church;
use App\Models\ServiceSchedule;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceSchedulePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceSchedule  $serviceSchedule
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ServiceSchedule $serviceSchedule)
    {
        return $serviceSchedule->church->user_id === $user->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceSchedule  $serviceSchedule
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ServiceSchedule $serviceSchedule)
    {
        return $serviceSchedule->church->user_id === $user->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceSchedule  $serviceSchedule
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ServiceSchedule $serviceSchedule)
    {
        return $serviceSchedule->church->user_id === $user->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceSchedule  $serviceSchedule
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ServiceSchedule $serviceSchedule)
    {
        return $serviceSchedule->church->user_id === $user->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceSchedule  $serviceSchedule
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ServiceSchedule $serviceSchedule)
    {
        return $serviceSchedule->church->user_id === $user->id || $user->isAdmin();
    }
}
