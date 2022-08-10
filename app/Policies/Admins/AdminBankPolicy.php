<?php

namespace App\Policies\Admins;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminBankPolicy
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
        return $user->CheckPermissionAccess(config('permissions.access.bank-list'));
    }
    public function add(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.bank-add'));
    }
    public function edit(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.bank-edit'));
    }
    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.bank-delete'));
    }
}
