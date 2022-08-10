<?php

namespace App\Policies\Admins;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminViewPolicy
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
    public function phongVien(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.view-phong-vien'));
    }
    public function bienTap(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.view-bien-tap'));
    }
    public function thuKy(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.view-thu-ky'));
    }
    public function phoTong(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.view-pho-tong'));
    }
    public function tongBienTap(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.view-tong-bien-tap'));
    }
}
