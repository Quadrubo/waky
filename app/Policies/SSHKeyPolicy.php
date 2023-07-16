<?php

namespace App\Policies;

use App\Models\SSHKey;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SSHKeyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view_any_ssh_key');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SSHKey $ssh_key)
    {
        return $user->can('view_ssh_key');
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_ssh_key');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SSHKey $ssh_key)
    {
        return $user->can('update_ssh_key');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SSHKey $ssh_key)
    {
        return $user->can('delete_ssh_key');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SSHKey $ssh_key)
    {
        return $user->can('restore_ssh_key');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SSHKey $ssh_key)
    {
        return $user->can('force_delete_ssh_key');
    }
}
