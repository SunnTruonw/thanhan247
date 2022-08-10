<?php

namespace App\Policies\Admins;

use App\Models\Galaxy;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminGalaxyPolicy
{
    use HandlesAuthorization;

    public function list(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.galaxy-list'));
    }
    public function add(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.galaxy-add'));
    }
    public function edit(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.galaxy-edit'));
    }
    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.galaxy-delete'));
    }

}
