<?php

namespace App\Policies\Admins;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminStorePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function list(Admin $user)
    {
       // dd($user);
        return $user->CheckPermissionAccess(config('permissions.access.store-list'));
    }
    public function input(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.store-input'));
    }
    public function output(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.store-output'));
    }
    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.store-delete'));
    }
}
