<?php

namespace App\Policies\Admins;

use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminTransactionPolicy
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
      //  dd(config('permissions.access.transaction-list'));
     // $p=new Permission();
     // dd($p->where('key_code',config('permissions.access.transaction-list'))->get());
      //  dd( $user->CheckPermissionAccess(config('permissions.access.transaction-list')));
        return $user->CheckPermissionAccess(config('permissions.access.transaction-list'));
    }
    public function status(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.transaction-status'));
    }

    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.transaction-delete'));
    }
}
