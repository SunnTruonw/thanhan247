<?php

namespace App\Policies\Admins;

use App\Models\Role;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminRolePolicy
{
    use HandlesAuthorization;

    public function list(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.role-list'));
    }
    public function add(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.role-add'));
    }
    public function edit(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.role-edit'));
    }
    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.role-delete'));
    }




    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function viewAny(Admin $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function view(Admin $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function create(Admin $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function update(Admin $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    // public function delete(Admin $user, Role $role)
    // {

    // }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function restore(User $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function forceDelete(Admin $user, Role $role)
    {
        //
    }
}
