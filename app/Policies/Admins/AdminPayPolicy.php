<?php

namespace App\Policies\Admins;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPayPolicy
{
    use HandlesAuthorization;

    public function list(Admin $user)
    {
      //  dd(config('permissions.access.pay-list'));
        return $user->CheckPermissionAccess(config('permissions.access.pay-list'));
    }
    public function add(Admin $user)
    {

        return $user->CheckPermissionAccess(config('permissions.access.pay-add'));
    }
    public function edit(Admin $user){
        return $user->CheckPermissionAccess(config('permissions.access.pay-edit'));
    }
    public function payUpdateDrawPoint(Admin $user){
      //  dd(config('permissions.access.pay-update-draw-point'));
        return $user->CheckPermissionAccess(config('permissions.access.pay-update-draw-point'));
    }
    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.pay-delete'));
    }
    public function exportExcel(Admin $user)
    {
     //   dd($user->CheckPermissionAccess(config('permissions.access.pay-export-excel')));
        return $user->CheckPermissionAccess(config('permissions.access.pay-export-excel'));
    }
}
