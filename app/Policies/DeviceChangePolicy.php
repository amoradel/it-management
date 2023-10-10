<?php

namespace App\Policies;

use App\Models\DeviceChange;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeviceChangePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_device::change');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DeviceChange $deviceChange): bool
    {
        return $user->can('view_device::change');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_device::change');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DeviceChange $deviceChange): bool
    {
        return $user->can('update_device::change');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DeviceChange $deviceChange): bool
    {
        return $user->can('delete_device::change');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_device::change');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, DeviceChange $deviceChange): bool
    {
        return $user->can('force_delete_device::change');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_device::change');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, DeviceChange $deviceChange): bool
    {
        return $user->can('restore_device::change');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_device::change');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, DeviceChange $deviceChange): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('{{ Reorder }}');
    }
}
