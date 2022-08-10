<?php

namespace App\Policies\Admins;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminUserFrontendPolicy
{
    use HandlesAuthorization;

    public function list(Admin $user)
    {

        return $user->CheckPermissionAccess(config('permissions.access.admin-user_frontend-list'));
    }
    public function add(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.admin-user_frontend-add'));
    }
    public function edit(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.admin-user_frontend-edit'));
    }
    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.admin-user_frontend-delete'));
    }
    public function active(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.admin-user_frontend-active'));
    }
    public function transferPoint(Admin $user)
    {
      //  dd($user);
        return $user->CheckPermissionAccess(config('permissions.access.admin-user_frontend-transfer-point'));
    }
    public function nap(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.admin-user_frontend-nap'));
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
     * @param  \App\Models\Admin  $model
     * @return mixed
     */
    public function view(Admin $user, Admin $model)
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
     * @param  \App\Models\Admin  $model
     * @return mixed
     */
    public function update(Admin $user, Admin $model)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Admin  $model
     * @return mixed
     */
    // public function delete(Admin $user, Admin $model)
    // {

    // }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Admin  $model
     * @return mixed
     */
    public function restore(Admin $user, Admin $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Admin  $model
     * @return mixed
     */
    public function forceDelete(Admin $user, Admin $model)
    {
        //
    }
}
