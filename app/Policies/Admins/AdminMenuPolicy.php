<?php

namespace App\Policies\Admins;

use App\Models\Menu;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminMenuPolicy
{
    use HandlesAuthorization;
    public function list(Admin $user)
    {

        return $user->CheckPermissionAccess(config('permissions.access.menu-list'));
    }
    public function add(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.menu-add'));
    }
    public function edit(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.menu-edit'));
    }
    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.menu-delete'));
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
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function view(Admin $user, Menu $menu)
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
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function update(Admin $user, Menu $menu)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    // public function delete(Admin $user, Menu $menu)
    // {

    // }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function restore(Admin $user, Menu $menu)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Menu  $menu
     * @return mixed
     */
    public function forceDelete(Admin $user, Menu $menu)
    {
        //
    }
}
