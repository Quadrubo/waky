<?php

namespace App\Policies;

use App\Models\Computer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComputerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view_any_computer');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Computer $computer)
    {
        return $user->can('view_computer');
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_computer');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Computer $computer)
    {
        return $user->can('update_computer');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Computer $computer)
    {
        return $user->can('delete_computer');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Computer $computer)
    {
        return $user->can('restore_computer');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Computer $computer)
    {
        return $user->can('force_delete_computer');
    }

    public function wake(User $user, Computer $computer)
    {
        // TODO
        return $user->can('wake_computer');
    }

    public function use(User $user, Computer $computer)
    {
        // TODO
        return $user->can('use_computer');
    }

    public function shutdown(User $user, Computer $computer)
    {
        // TODO
        return $user->can('shutdown_computer');
    }

    public function forceShutdown(User $user, Computer $computer)
    {
        return $user->can('force_shutdown_computer');
    }
}
